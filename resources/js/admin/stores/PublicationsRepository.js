import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "../../../axios.js";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export let usePublicationsRepository = defineStore("PublicationsRepository", {
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
            
            // Publications data
            publications: reactive([]),
            publicationsSearch: ref(""),
            currentPublication: reactive({}),
            
            // Status options for dropdowns
            statusOptions: reactive([
                { value: 'draft', label: 'Draft' },
                { value: 'published', label: 'Published' },
                { value: 'archived', label: 'Archived' }
            ]),

            // File type options
            fileTypeOptions: reactive([
                { value: 'pdf', label: 'PDF Document' },
                { value: 'doc', label: 'Word Document' },
                { value: 'docx', label: 'Word Document (DOCX)' },
                { value: 'xls', label: 'Excel Spreadsheet' },
                { value: 'xlsx', label: 'Excel Spreadsheet (XLSX)' },
                { value: 'ppt', label: 'PowerPoint Presentation' },
                { value: 'pptx', label: 'PowerPoint Presentation (PPTX)' },
                { value: 'txt', label: 'Text File' },
                { value: 'other', label: 'Other' }
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
        
        // Fetch all publications with pagination
        async fetchPublications({ page = 1, itemsPerPage = 5, status = '', fileType = '' }) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: itemsPerPage,
                    search: this.publicationsSearch
                });
                
                if (status) {
                    params.append('status', status);
                }
                
                if (fileType) {
                    params.append('file_type', fileType);
                }
                
                const response = await axios.get(`publications?${params}`);
                
                console.log('API Response:', response.data);
                
                if (response.data.success) {
                    this.publications = response.data.data || [];
                    this.totalItems = response.data.meta?.total || 0;
                } else {
                    this.publications = [];
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
                
                this.publications = [];
                this.totalItems = 0;
                this.loading = false;
                
                const errorMessage = err.response?.data?.message || "Failed to fetch publications";
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
        
        // Fetch single publication by ID
        async fetchPublication(id) {
            this.loading = true;
            try {
                const response = await axios.get(`publications/${id}`);
                this.currentPublication = response.data.data;
                this.loading = false;
            } catch (err) {
                console.error(err);
                this.loading = false;
                toast.error("Failed to fetch publication", {
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
        
        // Create new publication
        async createPublication(formData) {
            try {
                const response = await axios.post("publications", formData);
                this.createDialog = false;
                toast.success("Publication created successfully!", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
                
                // Refresh the list
                this.fetchPublications({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                const errorMessage = err.response?.data?.message || "Failed to create publication. Please try again.";
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
        
        // Update existing publication
        async updatePublication(id, formData) {
            try {
                const response = await axios.put(`publications/${id}`, formData);
                this.createDialog = false;
                this.isEditMode = false;
                toast.success("Publication updated successfully!", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
                
                // Refresh the list
                this.fetchPublications({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                const errorMessage = err.response?.data?.message || "Failed to update publication. Please try again.";
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
        
        // Delete publication
        async deletePublication(id) {
            try {
                await axios.delete(`publications/${id}`);
                toast.success("Publication deleted successfully!", {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
                
                // Refresh the list
                this.fetchPublications({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                const errorMessage = err.response?.data?.message || "Failed to delete publication. Please try again.";
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
        
        // Bulk delete publications
        async bulkDeletePublications(ids) {
            try {
                const deletePromises = ids.map(id => axios.delete(`publications/${id}`));
                await Promise.all(deletePromises);
                
                toast.success(`${ids.length} publications deleted successfully!`, {
                    position: "top-right",
                    autoClose: 3000,
                    hideProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                });
                
                // Refresh the list
                this.fetchPublications({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error(err);
                toast.error("Failed to delete selected publications. Please try again.", {
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
        
        // Get published publications
        async getPublishedPublications({ page = 1, itemsPerPage = 10 }) {
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: itemsPerPage,
                    search: this.publicationsSearch
                });
                
                const response = await axios.get(`publications/published?${params}`);
                return response.data;
            } catch (err) {
                console.error(err);
                return { success: false, data: [], meta: { total: 0 } };
            }
        },
        
        // Get publications by file type
        async getPublicationsByFileType(fileType, { page = 1, itemsPerPage = 10 }) {
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: itemsPerPage
                });
                
                const response = await axios.get(`publications/by-file-type/${fileType}?${params}`);
                return response.data;
            } catch (err) {
                console.error(err);
                return { success: false, data: [], meta: { total: 0 } };
            }
        },
        
        // Get publication statistics
        async getPublicationStatistics() {
            try {
                const response = await axios.get("publications/statistics");
                return response.data.data;
            } catch (err) {
                console.error(err);
                return {};
            }
        },
        
        // Helper method to get status label
        getStatusLabel(status) {
            const statusOption = this.statusOptions.find(s => s.value === status);
            return statusOption ? statusOption.label : status;
        },
        
        // Helper method to get file type label
        getFileTypeLabel(type) {
            const typeOption = this.fileTypeOptions.find(t => t.value === type);
            return typeOption ? typeOption.label : type;
        },
        
        // Helper method to format date
        formatDate(date) {
            if (!date) return '';
            return new Date(date).toLocaleDateString();
        },
        
        // Helper method to get file extension
        getFileExtension(filePath) {
            if (!filePath) return '';
            return filePath.split('.').pop().toLowerCase();
        },
        
        // Reset current publication
        resetCurrentPublication() {
            this.currentPublication = {
                id: null,
                title: '',
                slug: '',
                description: '',
                file_path: '',
                file_type: '',
                status: 'draft',
                published_at: null
            };
        }
    },
});

