import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "../../../axios.js";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export let useContactsRepository = defineStore("ContactsRepository", {
    state() {
        return {
            router: useRouter(),
            search: ref(""),
            loadingTable: ref(true),
            loading: ref(true),
            totalItems: ref(0),
            selectedItems: ref([]),
            itemsPerPage: ref(15),

            // Contacts data
            contacts: reactive([]),
            contactSearch: ref(""),
            currentContact: reactive({}),

            // Status options for dropdowns
            statusOptions: reactive([
                { value: "", label: "All Status" },
                { value: "new", label: "New" },
                { value: "read", label: "Read" },
                { value: "replied", label: "Replied" },
                { value: "archived", label: "Archived" },
            ]),

            // Subject/Type options
            subjectOptions: reactive([
                { value: "", label: "All Types" },
                { value: "job_application", label: "Job Application" },
                { value: "general_inquiry", label: "General Inquiry" },
                { value: "project_discussion", label: "Project Discussion" },
                { value: "technical_support", label: "Technical Support" },
                { value: "partnership", label: "Partnership" },
                { value: "media_inquiry", label: "Media Inquiry" },
                { value: "other", label: "Other" },
            ]),
        };
    },
    actions: {
        getStatusLabel(status) {
            const option = this.statusOptions.find(opt => opt.value === status);
            return option ? option.label : status;
        },

        getSubjectLabel(subject) {
            const option = this.subjectOptions.find(opt => opt.value === subject);
            return option ? option.label : subject;
        },

        // Fetch all contacts with pagination
        async fetchContacts({ page = 1, itemsPerPage = 15, status = "", subject = "" }) {
            this.loading = true;
            try {
                const params = {
                    page,
                    perPage: itemsPerPage,
                    search: this.contactSearch,
                    status,
                    subject,
                };

                const response = await axios.get("contacts", {
                    params,
                });

                if (response.data.success) {
                    this.contacts = response.data.data;
                    this.totalItems = response.data.meta.total;
                } else {
                    toast.error("Failed to fetch contacts");
                }
            } catch (error) {
                console.error("Error fetching contacts:", error);
                toast.error("Error fetching contacts");
            } finally {
                this.loading = false;
            }
        },

        // Get single contact
        async getContact(id) {
            this.loading = true;
            try {
                const response = await axios.get(`contacts/${id}`);

                if (response.data.success) {
                    this.currentContact = response.data.data;
                    return response.data.data;
                } else {
                    toast.error("Failed to fetch contact");
                }
            } catch (error) {
                console.error("Error fetching contact:", error);
                toast.error("Error fetching contact");
            } finally {
                this.loading = false;
            }
        },

        // Update contact status
        async updateContactStatus(id, status) {
            try {
                const response = await axios.patch(`contacts/${id}`, { status });

                if (response.data.success) {
                    toast.success("Contact updated successfully");
                    this.fetchContacts({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                    return response.data.data;
                } else {
                    toast.error("Failed to update contact");
                }
            } catch (error) {
                console.error("Error updating contact:", error);
                if (error.response?.data?.message) {
                    toast.error(error.response.data.message);
                } else {
                    toast.error("Error updating contact");
                }
            }
        },

        // Mark as read
        async markAsRead(id) {
            try {
                const response = await axios.patch(`contacts/${id}/mark-as-read`);

                if (response.data.success) {
                    toast.success("Contact marked as read");
                    this.fetchContacts({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                    return response.data.data;
                } else {
                    toast.error("Failed to mark contact as read");
                }
            } catch (error) {
                console.error("Error marking contact as read:", error);
                toast.error("Error marking contact as read");
            }
        },

        // Mark as replied
        async markAsReplied(id) {
            try {
                const response = await axios.patch(`contacts/${id}/mark-as-replied`);

                if (response.data.success) {
                    toast.success("Contact marked as replied");
                    this.fetchContacts({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                    return response.data.data;
                } else {
                    toast.error("Failed to mark contact as replied");
                }
            } catch (error) {
                console.error("Error marking contact as replied:", error);
                toast.error("Error marking contact as replied");
            }
        },

        // Delete contact
        async deleteContact(id) {
            try {
                const response = await axios.delete(`contacts/${id}`);

                if (response.data.success) {
                    toast.success("Contact deleted successfully");
                    this.fetchContacts({
                        page: 1,
                        itemsPerPage: this.itemsPerPage,
                    });
                } else {
                    toast.error("Failed to delete contact");
                }
            } catch (error) {
                console.error("Error deleting contact:", error);
                if (error.response?.data?.message) {
                    toast.error(error.response.data.message);
                } else {
                    toast.error("Error deleting contact");
                }
            }
        },

        // Bulk delete contacts
        async bulkDeleteContacts(ids) {
            try {
                const deletePromises = ids.map(id => axios.delete(`contacts/${id}`));
                await Promise.all(deletePromises);
                
                toast.success(`${ids.length} contact(s) deleted successfully`);
                this.fetchContacts({
                    page: 1,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error("Error bulk deleting contacts:", error);
                toast.error("Error deleting contacts");
            }
        },

        // Reset current contact
        resetCurrentContact() {
            this.currentContact = {};
        },
    },
});

