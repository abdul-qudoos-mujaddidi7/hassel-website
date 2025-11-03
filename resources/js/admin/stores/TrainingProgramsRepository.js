import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "../../../axios.js";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export let useTrainingProgramsRepository = defineStore(
    "TrainingProgramsRepository",
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

                // Training Programs data
                trainingPrograms: reactive([]),
                trainingProgramsSearch: ref(""),
                currentTrainingProgram: reactive({}),

                // Status options for dropdowns
                statusOptions: reactive([
                    { value: "draft", label: "Draft" },
                    { value: "published", label: "Published" },
                    { value: "ongoing", label: "Ongoing" },
                    { value: "completed", label: "Completed" },
                    { value: "cancelled", label: "Cancelled" },
                ]),

                // Program type options
                programTypeOptions: reactive([
                    { value: "workshop", label: "Workshop" },
                    { value: "seminar", label: "Seminar" },
                    { value: "course", label: "Course" },
                    { value: "training", label: "Training" },
                    { value: "certification", label: "Certification" },
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

            // Fetch all training programs with pagination
            async fetchTrainingPrograms({
                page = 1,
                itemsPerPage = 5,
                status = "",
            }) {
                this.loading = true;
                try {
                    const params = new URLSearchParams({
                        page: page,
                        perPage: itemsPerPage,
                        search: this.trainingProgramsSearch,
                    });

                    if (status) {
                        params.append("status", status);
                    }

                    const response = await axios.get(
                        `training-programs?${params}`
                    );

                    console.log("API Response:", response.data);

                    if (response.data.success) {
                        this.trainingPrograms = response.data.data || [];
                        this.totalItems = response.data.meta?.total || 0;
                    } else {
                        this.trainingPrograms = [];
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

                    this.trainingPrograms = [];
                    this.totalItems = 0;
                    this.loading = false;

                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to fetch training programs";
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

            // Fetch single training program by ID
            async fetchTrainingProgram(id) {
                this.loading = true;
                try {
                    const response = await axios.get(`training-programs/${id}`, {
                        params: { include_translations: 1 },
                    });
                    this.currentTrainingProgram = response.data.data;
                    this.loading = false;
                } catch (err) {
                    console.error(err);
                    this.loading = false;
                    toast.error("Failed to fetch training program", {
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

            // Create new training program
            async createTrainingProgram(formData) {
                try {
                    const response = await axios.post(
                        "training-programs",
                        formData
                    );
                    this.createDialog = false;
                    toast.success("Training program created successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchTrainingPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to create training program. Please try again.";
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

            // Update existing training program
            async updateTrainingProgram(id, formData) {
                try {
                    // Use POST with _method=PUT for file uploads (FormData)
                    const response = await axios.post(
                        `training-programs/${id}`,
                        formData,
                        {
                            headers: {
                                '_method': 'PUT'
                            }
                        }
                    );
                    this.createDialog = false;
                    this.isEditMode = false;
                    toast.success("Training program updated successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchTrainingPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                    
                    // Return response so component can access updated data
                    return response;
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to update training program. Please try again.";
                    toast.error(errorMessage, {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });
                    throw err;
                }
            },

            // Delete training program
            async deleteTrainingProgram(id) {
                try {
                    await axios.delete(`training-programs/${id}`);
                    toast.success("Training program deleted successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchTrainingPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to delete training program. Please try again.";
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

            // Bulk delete training programs
            async bulkDeleteTrainingPrograms(ids) {
                try {
                    const deletePromises = ids.map((id) =>
                        axios.delete(`training-programs/${id}`)
                    );
                    await Promise.all(deletePromises);

                    toast.success(
                        `${ids.length} training programs deleted successfully!`,
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
                    this.fetchTrainingPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    toast.error(
                        "Failed to delete selected training programs. Please try again.",
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
                        `training-programs/${id}/toggle-status`
                    );
                    toast.success(
                        "Training program status updated successfully!",
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
                    this.fetchTrainingPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to update training program status. Please try again.";
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

            // Get published training programs
            async getPublishedTrainingPrograms({ page = 1, itemsPerPage = 10 }) {
                try {
                    const params = new URLSearchParams({
                        page: page,
                        perPage: itemsPerPage,
                        search: this.trainingProgramsSearch,
                    });

                    const response = await axios.get(
                        `training-programs/published?${params}`
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

            // Reset current training program
            resetCurrentTrainingProgram() {
                this.currentTrainingProgram = {
                    id: null,
                    title: "",
                    slug: "",
                    description: "",
                    cover_image: "",
                    thumbnail_image: "",
                    program_type: "workshop",
                    duration: "",
                    location: "",
                    instructor: "",
                    max_participants: null,
                    start_date: null,
                    end_date: null,
                    status: "draft",
                };
            },
        },
    }
);