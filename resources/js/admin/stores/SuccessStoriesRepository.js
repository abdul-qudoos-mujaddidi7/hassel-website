import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "../../../axios.js";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export let useSuccessStoriesRepository = defineStore(
    "SuccessStoriesRepository",
    {
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

                // Success Stories data
                successStories: reactive([]),
                successStoriesSearch: ref(""),
                currentSuccessStory: reactive({}),

                // Status options for dropdowns
                statusOptions: reactive([
                    { value: "draft", label: "Draft" },
                    { value: "published", label: "Published" },
                    { value: "archived", label: "Archived" },
                ]),
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

            // Fetch all success stories with pagination
            async fetchSuccessStories({
                page = 1,
                itemsPerPage = 5,
                status = "",
            }) {
                this.loading = true;
                try {
                    const params = new URLSearchParams({
                        page: page,
                        perPage: itemsPerPage,
                        search: this.successStoriesSearch,
                    });

                    if (status) {
                        params.append("status", status);
                    }

                    const response = await axios.get(
                        `success-stories?${params}`
                    );

                    console.log("API Response:", response.data);

                    if (response.data.success) {
                        this.successStories = response.data.data || [];
                        this.totalItems = response.data.meta?.total || 0;
                    } else {
                        this.successStories = [];
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

                    this.successStories = [];
                    this.totalItems = 0;
                    this.loading = false;

                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to fetch success stories";
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

            // Fetch single success story by ID
            async fetchSuccessStory(id) {
                this.loading = true;
                try {
                    const response = await axios.get(`success-stories/${id}`, {
                        params: { include_translations: 1 },
                    });
                    this.currentSuccessStory = response.data.data;
                    this.loading = false;
                } catch (err) {
                    console.error(err);
                    this.loading = false;
                    toast.error("Failed to fetch success story", {
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

            // Create new success story
            async createSuccessStory(formData) {
                try {
                    const response = await axios.post(
                        "success-stories",
                        formData
                    );
                    this.createDialog = false;
                    toast.success("Success story created successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchSuccessStories({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to create success story. Please try again.";
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

            // Update existing success story
            async updateSuccessStory(id, formData) {
                try {
                    const response = await axios.put(
                        `success-stories/${id}`,
                        formData
                    );
                    this.createDialog = false;
                    this.isEditMode = false;
                    toast.success("Success story updated successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchSuccessStories({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to update success story. Please try again.";
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

            // Delete success story
            async deleteSuccessStory(id) {
                try {
                    await axios.delete(`success-stories/${id}`);
                    toast.success("Success story deleted successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchSuccessStories({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to delete success story. Please try again.";
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

            // Bulk delete success stories
            async bulkDeleteSuccessStories(ids) {
                try {
                    const deletePromises = ids.map((id) =>
                        axios.delete(`success-stories/${id}`)
                    );
                    await Promise.all(deletePromises);

                    toast.success(
                        `${ids.length} success stories deleted successfully!`,
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
                    this.fetchSuccessStories({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    toast.error(
                        "Failed to delete selected success stories. Please try again.",
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
                    const response = await axios.post(
                        `success-stories/${id}/toggle-status`
                    );
                    toast.success(
                        "Success story status updated successfully!",
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
                    this.fetchSuccessStories({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to update success story status. Please try again.";
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

            // Get published success stories
            async getPublishedSuccessStories({ page = 1, itemsPerPage = 10 }) {
                try {
                    const params = new URLSearchParams({
                        page: page,
                        perPage: itemsPerPage,
                        search: this.successStoriesSearch,
                    });

                    const response = await axios.get(
                        `success-stories/published?${params}`
                    );
                    return response.data;
                } catch (err) {
                    console.error(err);
                    return { success: false, data: [], meta: { total: 0 } };
                }
            },

            // Helper method to get status label
            getStatusLabel(status) {
                const statusOption = this.statusOptions.find(
                    (s) => s.value === status
                );
                return statusOption ? statusOption.label : status;
            },

            // Helper method to format date
            formatDate(date) {
                if (!date) return "";
                return new Date(date).toLocaleDateString();
            },

            // Reset current success story
            resetCurrentSuccessStory() {
                this.currentSuccessStory = {
                    id: null,
                    title: "",
                    slug: "",
                    content: "",
                    featured_image: "",
                    author_name: "",
                    author_title: "",
                    location: "",
                    status: "draft",
                    published_at: null,
                };
            },
        },
    }
);
