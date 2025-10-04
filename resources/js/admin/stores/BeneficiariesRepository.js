import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "../../../axios.js";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export let useBeneficiariesRepository = defineStore("BeneficiariesRepository", {
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
            
            // Statistics data
            beneficiariesStats: reactive([]),
            beneficiariesStatsSearch: ref(""),
            currentStat: reactive({}),
            
            // Stat types for dropdowns
            statTypes: reactive([
                { value: 'beneficiaries', label: 'Beneficiaries' },
                { value: 'total_beneficiaries', label: 'Total Beneficiaries' },
                { value: 'male_beneficiaries', label: 'Male Beneficiaries' },
                { value: 'female_beneficiaries', label: 'Female Beneficiaries' },
                { value: 'programs_completed', label: 'Programs Completed' },
                { value: 'provinces_reached', label: 'Provinces Reached' },
                { value: 'cooperatives_formed', label: 'Cooperatives Formed' },
                { value: 'projects', label: 'Projects' },
                { value: 'staff', label: 'Staff' },
                { value: 'partners', label: 'Partners' }
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
        
        // Fetch all beneficiaries stats with pagination
        async fetchBeneficiariesStats({ page = 1, itemsPerPage = 5 }) {
            this.loading = true;
            try {
                const response = await axios.get(
                    `beneficiaries-stats?page=${page}&perPage=${itemsPerPage}&search=${this.beneficiariesStatsSearch}`
                );
                
                console.log('API Response:', response.data); // Debug log
                
                // Handle different response structures
                if (response.data.success) {
                    this.beneficiariesStats = response.data.data || [];
                    this.totalItems = response.data.meta?.total || 0;
                } else {
                    // Handle error response
                    this.beneficiariesStats = [];
                    this.totalItems = 0;
                    toast.error(response.data.message || "Failed to fetch data", {
                        position: "top-right",
                        autoClose: 3000,
                    });
                }
                
                this.loading = false;
            } catch (err) {
                console.error('API Error:', err);
                console.error('Error Response:', err.response?.data);
                
                this.beneficiariesStats = [];
                this.totalItems = 0;
                this.loading = false;
                
                const errorMessage = err.response?.data?.message || "Failed to fetch beneficiaries statistics";
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
        
        // Fetch single stat by ID
        async fetchBeneficiariesStat(id) {
            this.loading = true;
            try {
                const response = await axios.get(`admin/beneficiaries-stats/${id}`);
                this.currentStat = response.data.data;
                this.loading = false;
            } catch (err) {
                console.error(err);
                this.loading = false;
                toast.error("Failed to fetch beneficiaries stat", {
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
        
        // Create new beneficiaries stat
        async createBeneficiariesStat(formData) {
            try {
                const response = await axios.post("admin/beneficiaries-stats", formData);
                this.createDialog = false;
                toast.success("Beneficiaries stat created successfully!", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
                
                // Refresh the list
                this.fetchBeneficiariesStats({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                const errorMessage = err.response?.data?.message || "Failed to create beneficiaries stat. Please try again.";
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
        
        // Update existing beneficiaries stat
        async updateBeneficiariesStat(id, formData) {
            try {
                const response = await axios.put(`admin/beneficiaries-stats/${id}`, formData);
                this.createDialog = false;
                this.isEditMode = false;
                toast.success("Beneficiaries stat updated successfully!", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
                
                // Refresh the list
                this.fetchBeneficiariesStats({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                const errorMessage = err.response?.data?.message || "Failed to update beneficiaries stat. Please try again.";
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
        
        // Delete beneficiaries stat
        async deleteBeneficiariesStat(id) {
            try {
                await axios.delete(`admin/beneficiaries-stats/${id}`);
                toast.success("Beneficiaries stat deleted successfully!", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
                
                // Refresh the list
                this.fetchBeneficiariesStats({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                const errorMessage = err.response?.data?.message || "Failed to delete beneficiaries stat. Please try again.";
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
        
        // Bulk delete beneficiaries stats
        async bulkDeleteBeneficiariesStats(ids) {
            try {
                const deletePromises = ids.map(id => axios.delete(`admin/beneficiaries-stats/${id}`));
                await Promise.all(deletePromises);
                
                toast.success(`${ids.length} beneficiaries stats deleted successfully!`, {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
                
                // Refresh the list
                this.fetchBeneficiariesStats({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                toast.error("Failed to delete selected beneficiaries stats. Please try again.", {
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
        
        // Get statistics summary
        async getStatsSummary() {
            try {
                const response = await axios.get("admin/beneficiaries-stats-summary");
                return response.data.data;
            } catch (err) {
                console.error(err);
                return [];
            }
        },
        
        // Helper method to get stat type label
        getStatTypeLabel(statType) {
            const stat = this.statTypes.find(s => s.value === statType);
            return stat ? stat.label : statType;
        },
        
        // Helper method to format numbers
        formatNumber(number) {
            return new Intl.NumberFormat().format(number);
        },
        
        // Reset current stat
        resetCurrentStat() {
            this.currentStat = {
                id: null,
                stat_type: '',
                value: 0,
                description: '',
                year: new Date().getFullYear()
            };
        }
    },
});