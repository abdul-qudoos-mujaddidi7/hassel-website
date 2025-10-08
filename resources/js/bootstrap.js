import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
}

// Append/normalize ?lang to all API requests (public/admin)
try {
    axios.interceptors.request.use((config) => {
        // Only append to same-origin API requests
        const isApi =
            (config.url || "").startsWith("/api") ||
            (config.baseURL || "").includes("/api");
        if (isApi) {
            // Start with a clean param bag and copy only defined values
            const params = new URLSearchParams();
            const original = config.params || {};
            Object.keys(original).forEach((key) => {
                const value = original[key];
                if (
                    value !== undefined &&
                    value !== null &&
                    !(typeof value === "string" && value.trim() === "")
                ) {
                    params.set(key, value);
                }
            });
            // Determine if this is an admin API call
            const url = String(config.url || "");
            const base = String(config.baseURL || "");
            const isAdminApi =
                url.includes("/api/admin") ||
                base.includes("/api/admin") ||
                (typeof window !== "undefined" && window.location.pathname.startsWith("/admin"));

            // Decide language source with precedence:
            // 1) Explicit lang in request params (respect caller)
            // 2) Admin preference for admin APIs
            // 3) Website preference for public APIs (fallback to legacy 'locale')
            let raw = params.get("lang");
            if (!raw) {
                raw = isAdminApi
                    ? (localStorage.getItem("admin_preferred_language") ||
                       sessionStorage.getItem("admin_preferred_language") ||
                       "en")
                    : (localStorage.getItem("preferred_language") ||
                       localStorage.getItem("locale") ||
                       "en");
            }
            const map = {
                farsi: "fa",
                fa: "fa",
                pashto: "ps",
                ps: "ps",
                english: "en",
                en: "en",
            };
            const current = map[String(raw).toLowerCase()] || "en";
            // ensure single lang param (override any previous)
            params.set("lang", current);
            config.params = Object.fromEntries(params.entries());
            // header for consistency
            config.headers = config.headers || {};
            config.headers["Accept-Language"] = current;
        }
        return config;
    });
} catch (_) {
    // no-op
}
