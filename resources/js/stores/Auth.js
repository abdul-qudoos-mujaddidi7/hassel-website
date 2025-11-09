import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "../../axios.js";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export const useAuthRepository = defineStore("authRepository", {
    state: () => ({
        user: {},            // reactive object
        loading: false,
        error: null,
        isAuthenticated: false,
        createDialog: ref(false),
        isEditMode: ref(false),
        search: ref(""),
    }),
    actions: {
        async login(credentials) {
            this.loading = true;
            this.error = null;

            try {
                // 1. Login request (use admin API route)
                const response = await axios.post("login", credentials);

                const { user, token, role } = response.data;

                // Save state
                this.user = user;
                this.isAuthenticated = true;

                // Save to sessionStorage
                sessionStorage.setItem("token", token);
                sessionStorage.setItem("user", JSON.stringify(user));
                sessionStorage.setItem("role", JSON.stringify(role));

                // Set token for axios
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${token}`;

                toast.success("Login successful!", {
                    position: "top-right",
                    autoClose: 500,
                });

                setTimeout(() => {
                    // Redirect to admin panel
                    window.location.replace("/admin-zaki");
                }, 1000);
            } catch (error) {
                toast.error("Login failed! Please check your credentials.", {
                    position: "top-right",
                    autoClose: 500,
                });

                this.error = error.response
                    ? error.response.data.message
                    : "An error occurred!";
            } finally {
                this.loading = false;
            }
        },

        async logout() {
            this.error = null;
            try {
                await axios.post("logout");

                // Clear storage
                sessionStorage.clear();
                this.user = {};
                this.role = null;
                this.isAuthenticated = false;

                toast.success("Logout successful!", {
                    position: "top-right",
                    autoClose: 500,
                });

                setTimeout(() => {
                    // Redirect to admin login
                    window.location.href = "/admin-zaki/login";
                }, 500);
            } catch (error) {
                toast.error("Logout failed! Please try again.", {
                    position: "top-right",
                    autoClose: 500,
                });

                this.error = error.response
                    ? error.response.data.message
                    : "An error occurred!";
            } finally {
                this.loading = false;
            }
        },

        loadFromSession() {
            const storedUser = sessionStorage.getItem("user");
            const storedRole = sessionStorage.getItem("role");
            const storedToken = sessionStorage.getItem("token");

            if (storedUser && storedToken) {
                Object.assign(this.user, JSON.parse(storedUser));
                this.isAuthenticated = true;
                
                // Set token for axios
                axios.defaults.headers.common["Authorization"] = `Bearer ${storedToken}`;
            }
            if (storedRole) this.role = JSON.parse(storedRole);
        }
    },
});
