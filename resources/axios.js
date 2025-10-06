import axios from "axios";

// Set default base URL
axios.defaults.baseURL = "http://127.0.0.1:8000/api/admin";

// Request interceptor to add token to headers
axios.interceptors.request.use(
    (config) => {
        const token = sessionStorage.getItem("token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        // Append lang to admin API as well for consistency
        try {
            const isApi =
                (config.url || "").startsWith("/api") ||
                (config.baseURL || "").includes("/api");
            if (isApi) {
                const params = new URLSearchParams(config.params || {});
                const current =
                    localStorage.getItem("preferred_language") || "en";
                if (!params.has("lang")) {
                    params.set("lang", current);
                    config.params = Object.fromEntries(params.entries());
                }
            }
        } catch (_) {}
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

export default axios;
