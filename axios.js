import axios from "axios";

// Set default base URL
axios.defaults.baseURL = "http://127.0.0.1:8000/api/admin";

// Request interceptor to add token and language to headers/params
axios.interceptors.request.use(
    (config) => {
        const token = sessionStorage.getItem("token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        // Language params/headers are handled globally in resources/js/bootstrap.js
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

export default axios;
