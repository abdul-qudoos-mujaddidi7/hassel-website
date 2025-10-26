import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "../../../axios.js";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export let useSmartFarmingProgramsRepository = defineStore(
    "SmartFarmingProgramsRepository",
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

                // Smart Farming Programs data
                smartFarmingPrograms: reactive([]),
                smartFarmingProgramsSearch: ref(""),
                currentSmartFarmingProgram: reactive({}),

                // Status options for dropdowns
                statusOptions: reactive([
                    { value: "draft", label: "Draft" },
                    { value: "published", label: "Published" },
                    { value: "ongoing", label: "Ongoing" },
                    { value: "completed", label: "Completed" },
                    { value: "cancelled", label: "Cancelled" },
                ]),

                // Farming type options
                farmingTypeOptions: reactive([
                    { value: "organic", label: "Organic" },
                    { value: "precision", label: "Precision" },
                    { value: "sustainable", label: "Sustainable" },
                    { value: "hydroponic", label: "Hydroponic" },
                    { value: "vertical", label: "Vertical" },
                    { value: "greenhouse", label: "Greenhouse" },
                ]),

                // Target crops options
                targetCropsOptions: reactive([
                    { value: "wheat", label: "Wheat" },
                    { value: "rice", label: "Rice" },
                    { value: "corn", label: "Corn" },
                    { value: "vegetables", label: "Vegetables" },
                    { value: "fruits", label: "Fruits" },
                    { value: "herbs", label: "Herbs" },
                    { value: "legumes", label: "Legumes" },
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

            // Fetch all smart farming programs with pagination
            async fetchSmartFarmingPrograms({
                page = 1,
                itemsPerPage = 5,
                status = "",
            }) {
                this.loading = true;
                try {
                    const params = new URLSearchParams({
                        page: page,
                        perPage: itemsPerPage,
                        search: this.smartFarmingProgramsSearch,
                    });

                    if (status) {
                        params.append("status", status);
                    }

                    const response = await axios.get(
                        `smart-farming-programs?${params}`
                    );

                    console.log("API Response:", response.data);

                    if (response.data.success) {
                        this.smartFarmingPrograms = response.data.data || [];
                        this.totalItems = response.data.meta?.total || 0;
                    } else {
                        this.smartFarmingPrograms = [];
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

                    this.smartFarmingPrograms = [];
                    this.totalItems = 0;
                    this.loading = false;

                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to fetch smart farming programs";
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

            // Fetch single smart farming program by ID
            async fetchSmartFarmingProgram(id) {
                this.loading = true;
                try {
                    const response = await axios.get(`smart-farming-programs/${id}`, {
                        params: { include_translations: 1 },
                    });
                    this.currentSmartFarmingProgram = response.data.data;
                    this.loading = false;
                } catch (err) {
                    console.error(err);
                    this.loading = false;
                    toast.error("Failed to fetch smart farming program", {
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

            // Create new smart farming program
            async createSmartFarmingProgram(formData) {
                try {
                    const response = await axios.post(
                        "smart-farming-programs",
                        formData
                    );
                    this.createDialog = false;
                    toast.success("Smart farming program created successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchSmartFarmingPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to create smart farming program. Please try again.";
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

            // Update existing smart farming program
            async updateSmartFarmingProgram(id, formData) {
                try {
                    const response = await axios.put(
                        `smart-farming-programs/${id}`,
                        formData
                    );
                    this.createDialog = false;
                    this.isEditMode = false;
                    toast.success("Smart farming program updated successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchSmartFarmingPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to update smart farming program. Please try again.";
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

            // Delete smart farming program
            async deleteSmartFarmingProgram(id) {
                try {
                    await axios.delete(`smart-farming-programs/${id}`);
                    toast.success("Smart farming program deleted successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchSmartFarmingPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to delete smart farming program. Please try again.";
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

            // Bulk delete smart farming programs
            async bulkDeleteSmartFarmingPrograms(ids) {
                try {
                    const deletePromises = ids.map((id) =>
                        axios.delete(`smart-farming-programs/${id}`)
                    );
                    await Promise.all(deletePromises);

                    toast.success(
                        `${ids.length} smart farming programs deleted successfully!`,
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
                    this.fetchSmartFarmingPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    toast.error(
                        "Failed to delete selected smart farming programs. Please try again.",
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
                        `smart-farming-programs/${id}/toggle-status`
                    );
                    toast.success(
                        "Smart farming program status updated successfully!",
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
                    this.fetchSmartFarmingPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to update smart farming program status. Please try again.";
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

            // Get published smart farming programs
            async getPublishedSmartFarmingPrograms({ page = 1, itemsPerPage = 10 }) {
                try {
                    const params = new URLSearchParams({
                        page: page,
                        perPage: itemsPerPage,
                        search: this.smartFarmingProgramsSearch,
                    });

                    const response = await axios.get(
                        `smart-farming-programs/published?${params}`
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

            // Reset current smart farming program
            resetCurrentSmartFarmingProgram() {
                this.currentSmartFarmingProgram = {
                    id: null,
                    name: "",
                    slug: "",
                    description: "",
                    short_description: "",
                    farming_type: "organic",
                    target_crops: [],
                    sustainability_level: null,
                    implementation_guide: "",
                    sustainability_impact: "",
                    duration: "",
                    location: "",
                    application_deadline: null,
                    cover_image: "",
                    thumbnail_image: "",
                    status: "draft",
                };
            },
        },
    }
);
