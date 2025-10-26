import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "../../../axios.js";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export let useSeedSupplyProgramsRepository = defineStore(
    "SeedSupplyProgramsRepository",
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

                // Seed Supply Programs data
                seedSupplyPrograms: reactive([]),
                seedSupplyProgramsSearch: ref(""),
                currentSeedSupplyProgram: reactive({}),

                // Status options for dropdowns
                statusOptions: reactive([
                    { value: "draft", label: "Draft" },
                    { value: "published", label: "Published" },
                    { value: "ongoing", label: "Ongoing" },
                    { value: "completed", label: "Completed" },
                    { value: "cancelled", label: "Cancelled" },
                ]),

                // Input type options
                inputTypeOptions: reactive([
                    { value: "seeds", label: "Seeds" },
                    { value: "fertilizers", label: "Fertilizers" },
                    { value: "pesticides", label: "Pesticides" },
                    { value: "tools", label: "Tools" },
                    { value: "equipment", label: "Equipment" },
                    { value: "machinery", label: "Machinery" },
                ]),

                // Quality grade options
                qualityGradeOptions: reactive([
                    { value: "premium", label: "Premium" },
                    { value: "standard", label: "Standard" },
                    { value: "basic", label: "Basic" },
                    { value: "certified", label: "Certified" },
                    { value: "organic", label: "Organic" },
                ]),

                // Availability options
                availabilityOptions: reactive([
                    { value: "In Stock", label: "In Stock" },
                    { value: "Limited", label: "Limited" },
                    { value: "Out of Stock", label: "Out of Stock" },
                    { value: "Pre-order", label: "Pre-order" },
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

            // Fetch all seed supply programs with pagination
            async fetchSeedSupplyPrograms({
                page = 1,
                itemsPerPage = 5,
                status = "",
            }) {
                this.loading = true;
                try {
                    const params = new URLSearchParams({
                        page: page,
                        perPage: itemsPerPage,
                        search: this.seedSupplyProgramsSearch,
                    });

                    if (status) {
                        params.append("status", status);
                    }

                    const response = await axios.get(
                        `seed-supply-programs?${params}`
                    );

                    console.log("API Response:", response.data);

                    if (response.data.success) {
                        this.seedSupplyPrograms = response.data.data || [];
                        this.totalItems = response.data.meta?.total || 0;
                    } else {
                        this.seedSupplyPrograms = [];
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

                    this.seedSupplyPrograms = [];
                    this.totalItems = 0;
                    this.loading = false;

                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to fetch seed supply programs";
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

            // Fetch single seed supply program by ID
            async fetchSeedSupplyProgram(id) {
                this.loading = true;
                try {
                    const response = await axios.get(`seed-supply-programs/${id}`, {
                        params: { include_translations: 1 },
                    });
                    this.currentSeedSupplyProgram = response.data.data;
                    this.loading = false;
                } catch (err) {
                    console.error(err);
                    this.loading = false;
                    toast.error("Failed to fetch seed supply program", {
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

            // Create new seed supply program
            async createSeedSupplyProgram(formData) {
                try {
                    const response = await axios.post(
                        "seed-supply-programs",
                        formData
                    );
                    this.createDialog = false;
                    toast.success("Seed supply program created successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchSeedSupplyPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to create seed supply program. Please try again.";
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

            // Update existing seed supply program
            async updateSeedSupplyProgram(id, formData) {
                try {
                    const response = await axios.put(
                        `seed-supply-programs/${id}`,
                        formData
                    );
                    this.createDialog = false;
                    this.isEditMode = false;
                    toast.success("Seed supply program updated successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchSeedSupplyPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to update seed supply program. Please try again.";
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

            // Delete seed supply program
            async deleteSeedSupplyProgram(id) {
                try {
                    await axios.delete(`seed-supply-programs/${id}`);
                    toast.success("Seed supply program deleted successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchSeedSupplyPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to delete seed supply program. Please try again.";
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

            // Bulk delete seed supply programs
            async bulkDeleteSeedSupplyPrograms(ids) {
                try {
                    const deletePromises = ids.map((id) =>
                        axios.delete(`seed-supply-programs/${id}`)
                    );
                    await Promise.all(deletePromises);

                    toast.success(
                        `${ids.length} seed supply programs deleted successfully!`,
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
                    this.fetchSeedSupplyPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    toast.error(
                        "Failed to delete selected seed supply programs. Please try again.",
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
                        `seed-supply-programs/${id}/toggle-status`
                    );
                    toast.success(
                        "Seed supply program status updated successfully!",
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
                    this.fetchSeedSupplyPrograms({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to update seed supply program status. Please try again.";
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

            // Get published seed supply programs
            async getPublishedSeedSupplyPrograms({ page = 1, itemsPerPage = 10 }) {
                try {
                    const params = new URLSearchParams({
                        page: page,
                        perPage: itemsPerPage,
                        search: this.seedSupplyProgramsSearch,
                    });

                    const response = await axios.get(
                        `seed-supply-programs/published?${params}`
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

            // Reset current seed supply program
            resetCurrentSeedSupplyProgram() {
                this.currentSeedSupplyProgram = {
                    id: null,
                    name: "",
                    slug: "",
                    description: "",
                    short_description: "",
                    input_type: "seeds",
                    target_crops: [],
                    quality_grade: "standard",
                    price_range: "",
                    availability: "In Stock",
                    shelf_life: "",
                    distribution_centers: [],
                    usage_instructions: "",
                    technical_specifications: "",
                    supplier: "",
                    contact_info: "",
                    cover_image: "",
                    thumbnail_image: "",
                    status: "draft",
                };
            },
        },
    }
);
