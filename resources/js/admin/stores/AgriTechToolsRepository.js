import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "../../../axios.js";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export let useAgriTechToolsRepository = defineStore(
    "AgriTechToolsRepository",
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

                // Agri-Tech Tools data
                agriTechTools: reactive([]),
                agriTechToolsSearch: ref(""),
                currentAgriTechTool: reactive({}),

                // Status options for dropdowns
                statusOptions: reactive([
                    { value: "draft", label: "Draft" },
                    { value: "published", label: "Published" },
                    { value: "available", label: "Available" },
                    { value: "unavailable", label: "Unavailable" },
                    { value: "maintenance", label: "Maintenance" },
                ]),

                // Tool type options
                toolTypeOptions: reactive([
                    { value: "mobile_app", label: "Mobile App" },
                    { value: "web_platform", label: "Web Platform" },
                    { value: "hardware", label: "Hardware" },
                    { value: "software", label: "Software" },
                    { value: "sensor", label: "Sensor" },
                ]),

                // Technology level options
                technologyLevelOptions: reactive([
                    { value: "basic", label: "Basic" },
                    { value: "intermediate", label: "Intermediate" },
                    { value: "advanced", label: "Advanced" },
                    { value: "cutting_edge", label: "Cutting Edge" },
                ]),

                // Availability options
                availabilityOptions: reactive([
                    { value: "available", label: "Available" },
                    { value: "limited", label: "Limited" },
                    { value: "unavailable", label: "Unavailable" },
                    { value: "coming_soon", label: "Coming Soon" },
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

            // Fetch all agri-tech tools with pagination
            async fetchAgriTechTools({
                page = 1,
                itemsPerPage = 5,
                status = "",
            }) {
                this.loading = true;
                try {
                    const params = new URLSearchParams({
                        page: page,
                        perPage: itemsPerPage,
                        search: this.agriTechToolsSearch,
                    });

                    if (status) {
                        params.append("status", status);
                    }

                    const response = await axios.get(
                        `agri-tech-tools?${params}`
                    );

                    console.log("API Response:", response.data);

                    if (response.data.success) {
                        this.agriTechTools = response.data.data || [];
                        this.totalItems = response.data.meta?.total || 0;
                    } else {
                        this.agriTechTools = [];
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

                    this.agriTechTools = [];
                    this.totalItems = 0;
                    this.loading = false;

                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to fetch agri-tech tools";
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

            // Fetch single agri-tech tool by ID
            async fetchAgriTechTool(id) {
                this.loading = true;
                try {
                    const response = await axios.get(`agri-tech-tools/${id}`, {
                        params: { include_translations: 1 },
                    });
                    this.currentAgriTechTool = response.data.data;
                    this.loading = false;
                } catch (err) {
                    console.error(err);
                    this.loading = false;
                    toast.error("Failed to fetch agri-tech tool", {
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

            // Create new agri-tech tool
            async createAgriTechTool(formData) {
                try {
                    const response = await axios.post(
                        "agri-tech-tools",
                        formData
                    );
                    this.createDialog = false;
                    toast.success("Agri-tech tool created successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchAgriTechTools({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to create agri-tech tool. Please try again.";
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

            // Update existing agri-tech tool
            async updateAgriTechTool(id, formData) {
                try {
                    const response = await axios.put(
                        `agri-tech-tools/${id}`,
                        formData
                    );
                    this.createDialog = false;
                    this.isEditMode = false;
                    toast.success("Agri-tech tool updated successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchAgriTechTools({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to update agri-tech tool. Please try again.";
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

            // Delete agri-tech tool
            async deleteAgriTechTool(id) {
                try {
                    await axios.delete(`agri-tech-tools/${id}`);
                    toast.success("Agri-tech tool deleted successfully!", {
                        position: "top-right",
                        autoClose: 3000,
                        hideProgressBar: false,
                        closeOnClick: true,
                        pauseOnHover: true,
                        draggable: true,
                        progress: undefined,
                    });

                    // Refresh the list
                    this.fetchAgriTechTools({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to delete agri-tech tool. Please try again.";
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

            // Bulk delete agri-tech tools
            async bulkDeleteAgriTechTools(ids) {
                try {
                    const deletePromises = ids.map((id) =>
                        axios.delete(`agri-tech-tools/${id}`)
                    );
                    await Promise.all(deletePromises);

                    toast.success(
                        `${ids.length} agri-tech tools deleted successfully!`,
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
                    this.fetchAgriTechTools({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    toast.error(
                        "Failed to delete selected agri-tech tools. Please try again.",
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
                        `agri-tech-tools/${id}/toggle-status`
                    );
                    toast.success(
                        "Agri-tech tool status updated successfully!",
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
                    this.fetchAgriTechTools({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    console.error(err);
                    const errorMessage =
                        err.response?.data?.message ||
                        "Failed to update agri-tech tool status. Please try again.";
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

            // Get published agri-tech tools
            async getPublishedAgriTechTools({ page = 1, itemsPerPage = 10 }) {
                try {
                    const params = new URLSearchParams({
                        page: page,
                        perPage: itemsPerPage,
                        search: this.agriTechToolsSearch,
                    });

                    const response = await axios.get(
                        `agri-tech-tools/published?${params}`
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

            // Reset current agri-tech tool
            resetCurrentAgriTechTool() {
                this.currentAgriTechTool = {
                    id: null,
                    name: "",
                    slug: "",
                    description: "",
                    short_description: "",
                    category: "sensors",
                    technology_level: "basic",
                    features: "",
                    specifications: "",
                    usage_instructions: "",
                    maintenance_requirements: "",
                    availability: "available",
                    price_range: "",
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
