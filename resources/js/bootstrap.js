import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
}

// Append ?lang to all API requests
try {
    axios.interceptors.request.use((config) => {
        // Only append to same-origin API requests
        const isApi =
            (config.url || "").startsWith("/api") ||
            (config.baseURL || "").includes("/api");
        if (isApi) {
            const params = new URLSearchParams(config.params || {});
            const current = localStorage.getItem("preferred_language") || "en";
            if (!params.has("lang")) {
                params.set("lang", current);
                config.params = Object.fromEntries(params.entries());
            }
        }
        return config;
    });
} catch (_) {
    // no-op
}

// Ensure native fetch() also appends ?lang for /api requests
try {
    const originalFetch = window.fetch?.bind(window);
    if (typeof originalFetch === "function") {
        window.fetch = async (input, init) => {
            try {
                let urlString =
                    typeof input === "string" ? input : input?.url || "";
                if (urlString.startsWith("/api")) {
                    const url = new URL(urlString, window.location.origin);
                    const current =
                        localStorage.getItem("preferred_language") || "en";
                    if (!url.searchParams.has("lang")) {
                        url.searchParams.set("lang", current);
                    }
                    urlString = url.toString();
                }
                return await originalFetch(urlString, init);
            } catch {
                return await originalFetch(input, init);
            }
        };
    }
} catch (_) {
    // no-op
}
