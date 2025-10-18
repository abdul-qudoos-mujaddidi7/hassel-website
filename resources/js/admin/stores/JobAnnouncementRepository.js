import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "../../../axios.js";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export let useJobAnnouncementRepository = defineStore("JobAnnouncementRepository", {
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

            // Job announcements data
            jobs: reactive([]),
            jobSearch: ref(""),
            currentJob: reactive({}),

            // Status options for dropdowns
            statusOptions: reactive([
                { value: "draft", label: "Draft" },
                { value: "open", label: "Open" },
                { value: "closed", label: "Closed" },
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

        // Fetch all job announcements with pagination
        async fetchJobs({ page = 1, itemsPerPage = 5, status = "" }) {
            this.loading = true;
            try {
                const params = {
                    page,
                    perPage: itemsPerPage,
                    search: this.jobSearch,
                    status,
                };

                const response = await axios.get("job-announcements", {
                    params,
                });

                if (response.data.success) {
                    this.jobs = response.data.data;
                    this.totalItems = response.data.meta.total;
                } else {
                    toast.error("Failed to fetch job announcements");
                }
            } catch (error) {
                console.error("Error fetching job announcements:", error);
                toast.error("Error fetching job announcements");
            } finally {
                this.loading = false;
            }
        },

        // Create new job announcement
        async createJob(jobData) {
            try {
                const response = await axios.post("job-announcements", jobData);
                
                if (response.data.success) {
                    toast.success("Job announcement created successfully");
                    this.createDialog = false;
                    this.resetCurrentJob();
                    this.fetchJobs({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                    return response.data.data;
                } else {
                    toast.error("Failed to create job announcement");
                }
            } catch (error) {
                console.error("Error creating job announcement:", error);
                if (error.response?.data?.message) {
                    toast.error(error.response.data.message);
                } else {
                    toast.error("Error creating job announcement");
                }
            }
        },

        // Update job announcement
        async updateJob(jobId, jobData) {
            try {
                const response = await axios.put(`/api/admin/job-announcements/${jobId}`, jobData);
                
                if (response.data.success) {
                    toast.success("Job announcement updated successfully");
                    this.createDialog = false;
                    this.resetCurrentJob();
                    this.fetchJobs({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                    return response.data.data;
                } else {
                    toast.error("Failed to update job announcement");
                }
            } catch (error) {
                console.error("Error updating job announcement:", error);
                if (error.response?.data?.message) {
                    toast.error(error.response.data.message);
                } else {
                    toast.error("Error updating job announcement");
                }
            }
        },

        // Delete job announcement
        async deleteJob(jobId) {
            try {
                const response = await axios.delete(`/api/admin/job-announcements/${jobId}`);
                
                if (response.data.success) {
                    toast.success("Job announcement deleted successfully");
                    this.fetchJobs({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } else {
                    toast.error("Failed to delete job announcement");
                }
            } catch (error) {
                console.error("Error deleting job announcement:", error);
                if (error.response?.data?.message) {
                    toast.error(error.response.data.message);
                } else {
                    toast.error("Error deleting job announcement");
                }
            }
        },

        // Bulk delete job announcements
        async bulkDeleteJobs(jobIds) {
            try {
                const response = await axios.post("/api/admin/job-announcements/bulk-delete", {
                    ids: jobIds
                });
                
                if (response.data.success) {
                    toast.success(`${jobIds.length} job announcements deleted successfully`);
                    this.fetchJobs({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } else {
                    toast.error("Failed to delete job announcements");
                }
            } catch (error) {
                console.error("Error bulk deleting job announcements:", error);
                if (error.response?.data?.message) {
                    toast.error(error.response.data.message);
                } else {
                    toast.error("Error deleting job announcements");
                }
            }
        },

        // Toggle job announcement status
        async toggleStatus(jobId) {
            try {
                const response = await axios.patch(`/api/admin/job-announcements/${jobId}/toggle-status`);
                
                if (response.data.success) {
                    toast.success("Job announcement status updated successfully");
                    this.fetchJobs({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } else {
                    toast.error("Failed to update job announcement status");
                }
            } catch (error) {
                console.error("Error toggling job announcement status:", error);
                if (error.response?.data?.message) {
                    toast.error(error.response.data.message);
                } else {
                    toast.error("Error updating job announcement status");
                }
            }
        },

        // Get single job announcement
        async getJob(jobId) {
            try {
                const response = await axios.get(`/api/admin/job-announcements/${jobId}`);
                
                if (response.data.success) {
                    return response.data.data;
                } else {
                    toast.error("Failed to fetch job announcement");
                }
            } catch (error) {
                console.error("Error fetching job announcement:", error);
                if (error.response?.data?.message) {
                    toast.error(error.response.data.message);
                } else {
                    toast.error("Error fetching job announcement");
                }
            }
        },

        // Reset current job data
        resetCurrentJob() {
            this.currentJob = {
                title: "",
                slug: "",
                description: "",
                requirements: "",
                location: "",
                salary_range: "",
                deadline: this.getTodaysDate(),
                status: "draft",
                farsi_translations: {
                    title: "",
                    location: "",
                    description: "",
                    requirements: ""
                },
                pashto_translations: {
                    title: "",
                    location: "",
                    description: "",
                    requirements: ""
                },
            };
        },

        // Get status label
        getStatusLabel(status) {
            const option = this.statusOptions.find(opt => opt.value === status);
            return option ? option.label : status;
        },

        // Get status color
        getStatusColor(status) {
            const colors = {
                draft: 'warning',
                open: 'success',
                closed: 'error',
                archived: 'grey'
            };
            return colors[status] || 'primary';
        },
    },
});

// Export default instance for backward compatibility
export default useJobAnnouncementRepository();