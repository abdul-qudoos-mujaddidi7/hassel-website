import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "../../../axios.js";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export let useNewsRepository = defineStore("NewsRepository", {
    state() {
        return {
            isEditMode: ref(false),
            router: useRouter(),
            search: ref(""),
            loadingTable: ref(true),
            loading: ref(true),
            totalItems: ref(0),
            selectedItems: ref([]),
            itemsPerPage: ref(5),
            createDialog: ref(false),

            // News data
            news: reactive([]),
            newsSearch: ref(""),
            currentNews: reactive({}),

            // Status options for dropdowns - will be computed with translations
            statusOptionsBase: [
                { value: "draft", labelKey: "status.draft" },
                { value: "published", labelKey: "status.published" },
                { value: "archived", labelKey: "status.archived" },
            ],
        };
    },
    actions: {
        setEditMode(editMode) {
            this.isEditMode = editMode;
        },

        getTodaysDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, "0");
            const day = String(today.getDate()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        },

        // Fetch all news with pagination
        async fetchNews({ page = 1, itemsPerPage = 5, status = "" }) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: itemsPerPage,
                    search: this.newsSearch,
                });

                if (status) {
                    params.append("status", status);
                }

                // Axios interceptor will append the current lang automatically
                const response = await axios.get(`news?${params}`);

                console.log("API Response:", response.data);

                if (response.data.success) {
                    this.news = response.data.data || [];
                    this.totalItems = response.data.meta?.total || 0;
                } else {
                    this.news = [];
                    this.totalItems = 0;
                    toast.error(
                        response.data.message || "Failed to fetch data",
                        {
                            position: "top-right",
                            autoClose: 3000,
                        }
                    );
                }

                this.loading = false;
            } catch (err) {
                console.error("API Error:", err);
                console.error("Error Response:", err.response?.data);

                this.news = [];
                this.totalItems = 0;
                this.loading = false;

                const errorMessage =
                    err.response?.data?.message ||
                    "Failed to fetch news articles";
                toast.error(errorMessage, {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
            }
        },

        // Fetch single news by ID
        async fetchNewsItem(id) {
            this.loading = true;
            try {
                const response = await axios.get(`news/${id}`, {
                    params: { include_translations: 1 },
                });
                this.currentNews = response.data.data;
                this.loading = false;
            } catch (err) {
                console.error(err);
                this.loading = false;
                toast.error("Failed to fetch news article", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
            }
        },

        // Create new news article
        async createNews(formData) {
            try {
                // Axios automatically sets Content-Type for FormData, don't override it
                const response = await axios.post("news", formData);
                this.createDialog = false;
                toast.success("News article created successfully!", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });

                // Refresh the list
                this.fetchNews({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                const errorMessage =
                    err.response?.data?.message ||
                    "Failed to create news article. Please try again.";
                toast.error(errorMessage, {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
            }
        },

        // Update existing news article
        async updateNews(id, formData) {
            try {
                // The route is POST to news/{news} which calls updateNews method
                // Axios automatically sets Content-Type for FormData
                const response = await axios.post(`news/${id}`, formData);
                this.createDialog = false;
                this.isEditMode = false;
                toast.success("News article updated successfully!", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });

                // Refresh the list
                this.fetchNews({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                const errorMessage =
                    err.response?.data?.message ||
                    "Failed to update news article. Please try again.";
                toast.error(errorMessage, {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
            }
        },

        // Delete news article
        async deleteNews(id) {
            try {
                await axios.delete(`news/${id}`);
                toast.success("News article deleted successfully!", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });

                // Refresh the list
                this.fetchNews({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                const errorMessage =
                    err.response?.data?.message ||
                    "Failed to delete news article. Please try again.";
                toast.error(errorMessage, {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
            }
        },

        // Bulk delete news articles
        async bulkDeleteNews(ids) {
            try {
                const deletePromises = ids.map((id) =>
                    axios.delete(`news/${id}`)
                );
                await Promise.all(deletePromises);

                toast.success(
                    `${ids.length} news articles deleted successfully!`,
                    {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    }
                );

                // Refresh the list
                this.fetchNews({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                toast.error(
                    "Failed to delete selected news articles. Please try again.",
                    {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    }
                );
            }
        },

        // Toggle publish status
        async toggleStatus(id) {
            try {
                const response = await axios.post(`news/${id}/toggle-status`);
                toast.success("News article status updated successfully!", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });

                // Refresh the list
                this.fetchNews({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                const errorMessage =
                    err.response?.data?.message ||
                    "Failed to update news article status. Please try again.";
                toast.error(errorMessage, {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
            }
        },

        // Get published news
        async getPublishedNews({ page = 1, itemsPerPage = 10 }) {
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: itemsPerPage,
                    search: this.newsSearch,
                });

                const response = await axios.get(`news/published?${params}`);
                return response.data;
            } catch (err) {
                console.error(err);
                return { success: false, data: [], meta: { total: 0 } };
            }
        },

        // Helper method to get status label (requires i18n instance to be passed)
        getStatusLabel(status, t) {
            const translate = t || ((key) => key);
            const statusOption = this.statusOptionsBase.find(
                (s) => s.value === status
            );
            return statusOption ? translate(statusOption.labelKey) : status;
        },

        // Helper method to format date
        formatDate(date) {
            if (!date) return "";
            return new Date(date).toLocaleDateString();
        },

        // Reset current news
        resetCurrentNews() {
            this.currentNews = {
                id: null,
                title: "",
                slug: "",
                excerpt: "",
                content: "",
                featured_image: "",
                status: "draft",
                published_at: null,
            };
        },
    },
});
