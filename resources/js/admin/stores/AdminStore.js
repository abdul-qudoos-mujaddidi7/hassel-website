import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import axios from "../../../axios.js";
import { toast } from "vue3-toastify";

export const useAdminStore = defineStore("admin", {
    state: () => ({
        // Dashboard stats
        stats: reactive({
            totalUsers: 0,
            totalPrograms: 0,
            totalNews: 0,
            totalContacts: 0,
            totalRegistrations: 0,
            recentActivity: []
        }),
        
        // Loading states
        loading: ref(false),
        error: ref(null),
        
        // Data lists
        news: ref([]),
        programs: ref([]),
        trainingPrograms: ref([]),
        agriTechTools: ref([]),
        marketAccessPrograms: ref([]),
        smartFarmingPrograms: ref([]),
        seedSupplyPrograms: ref([]),
        communityPrograms: ref([]),
        environmentalProjects: ref([]),
        publications: ref([]),
        successStories: ref([]),
        galleries: ref([]),
        jobs: ref([]),
        users: ref([]),
        contacts: ref([]),
        registrations: ref([]),
        
        // Pagination
        pagination: reactive({
            currentPage: 1,
            totalPages: 1,
            perPage: 10,
            total: 0
        }),
        
        // Search and filters
        search: ref(""),
        filters: reactive({
            status: null,
            type: null,
            dateFrom: null,
            dateTo: null
        }),
        
        // Form states
        formData: reactive({}),
        isEditing: ref(false),
        selectedItem: ref(null)
    }),
    
    actions: {
        // Dashboard actions
        async fetchDashboardStats() {
            this.loading = true;
            try {
                const response = await axios.get("/api/admin/dashboard/stats");
                Object.assign(this.stats, response.data);
            } catch (error) {
                this.handleError(error, "Failed to fetch dashboard statistics");
            } finally {
                this.loading = false;
            }
        },
        
        // Generic CRUD actions
        async fetchData(endpoint, dataKey) {
            this.loading = true;
            try {
                const params = {
                    page: this.pagination.currentPage,
                    per_page: this.pagination.perPage,
                    search: this.search,
                    ...this.filters
                };
                
                const response = await axios.get(`/api/admin/${endpoint}`, { params });
                
                this[dataKey] = response.data.data;
                this.pagination.total = response.data.total;
                this.pagination.totalPages = response.data.last_page;
            } catch (error) {
                this.handleError(error, `Failed to fetch ${endpoint}`);
            } finally {
                this.loading = false;
            }
        },
        
        async createItem(endpoint, data) {
            this.loading = true;
            try {
                const response = await axios.post(`/api/admin/${endpoint}`, data);
                toast.success("Item created successfully!");
                return response.data;
            } catch (error) {
                this.handleError(error, "Failed to create item");
                throw error;
            } finally {
                this.loading = false;
            }
        },
        
        async updateItem(endpoint, id, data) {
            this.loading = true;
            try {
                const response = await axios.put(`/api/admin/${endpoint}/${id}`, data);
                toast.success("Item updated successfully!");
                return response.data;
            } catch (error) {
                this.handleError(error, "Failed to update item");
                throw error;
            } finally {
                this.loading = false;
            }
        },
        
        async deleteItem(endpoint, id) {
            this.loading = true;
            try {
                await axios.delete(`/api/admin/${endpoint}/${id}`);
                toast.success("Item deleted successfully!");
            } catch (error) {
                this.handleError(error, "Failed to delete item");
                throw error;
            } finally {
                this.loading = false;
            }
        },
        
        // Specific data fetching methods
        async fetchNews() {
            await this.fetchData("news", "news");
        },
        
        async fetchPrograms() {
            await this.fetchData("programs", "programs");
        },
        
        async fetchTrainingPrograms() {
            await this.fetchData("training-programs", "trainingPrograms");
        },
        
        async fetchAgriTechTools() {
            await this.fetchData("agri-tech-tools", "agriTechTools");
        },
        
        async fetchMarketAccessPrograms() {
            await this.fetchData("market-access-programs", "marketAccessPrograms");
        },
        
        async fetchSmartFarmingPrograms() {
            await this.fetchData("smart-farming-programs", "smartFarmingPrograms");
        },
        
        async fetchSeedSupplyPrograms() {
            await this.fetchData("seed-supply-programs", "seedSupplyPrograms");
        },
        
        async fetchCommunityPrograms() {
            await this.fetchData("community-programs", "communityPrograms");
        },
        
        async fetchEnvironmentalProjects() {
            await this.fetchData("environmental-projects", "environmentalProjects");
        },
        
        async fetchPublications() {
            await this.fetchData("publications", "publications");
        },
        
        async fetchSuccessStories() {
            await this.fetchData("success-stories", "successStories");
        },
        
        async fetchGalleries() {
            await this.fetchData("galleries", "galleries");
        },
        
        async fetchJobs() {
            await this.fetchData("jobs", "jobs");
        },
        
        async fetchUsers() {
            await this.fetchData("users", "users");
        },
        
        async fetchContacts() {
            await this.fetchData("contacts", "contacts");
        },
        
        async fetchRegistrations() {
            await this.fetchData("registrations", "registrations");
        },
        
        // Utility methods
        setSearch(search) {
            this.search = search;
            this.pagination.currentPage = 1;
        },
        
        setFilters(filters) {
            Object.assign(this.filters, filters);
            this.pagination.currentPage = 1;
        },
        
        setPagination(page) {
            this.pagination.currentPage = page;
        },
        
        setPerPage(perPage) {
            this.pagination.perPage = perPage;
            this.pagination.currentPage = 1;
        },
        
        resetFilters() {
            this.search = "";
            Object.keys(this.filters).forEach(key => {
                this.filters[key] = null;
            });
            this.pagination.currentPage = 1;
        },
        
        setFormData(data) {
            Object.assign(this.formData, data);
        },
        
        resetFormData() {
            Object.keys(this.formData).forEach(key => {
                delete this.formData[key];
            });
        },
        
        setEditing(editing, item = null) {
            this.isEditing = editing;
            this.selectedItem = item;
            if (item) {
                this.setFormData(item);
            } else {
                this.resetFormData();
            }
        },
        
        handleError(error, message) {
            this.error = error.response?.data?.message || message;
            toast.error(this.error);
            console.error(error);
        },
        
        clearError() {
            this.error = null;
        }
    },
    
    getters: {
        isLoading: (state) => state.loading,
        hasError: (state) => !!state.error,
        currentPage: (state) => state.pagination.currentPage,
        totalPages: (state) => state.pagination.totalPages,
        hasNextPage: (state) => state.pagination.currentPage < state.pagination.totalPages,
        hasPrevPage: (state) => state.pagination.currentPage > 1,
        totalItems: (state) => state.pagination.total
    }
});
