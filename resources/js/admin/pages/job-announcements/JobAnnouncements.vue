<template>
    <CreateJobAnnouncement v-if="JobAnnouncementRepository.createDialog" />
    <div :dir="dir" >
        <!-- Page Header -->
        <Header :pageTitle="$t('job_announcements_management')" />
        <v-divider :thickness="1" class="border-opacity-100" />
        
        
            <!-- Search and Actions Section -->
            <div class="btn-search pt-12 pb-6">
                <div class="text-field w-25">
                    <v-text-field
                        color="primary"
                        density="compact"
                        variant="outlined"
                        :label="$t('search')"
                        append-inner-icon="mdi-magnify"
                        hide-details
                        v-model="JobAnnouncementRepository.jobSearch"
                        @input="handleSearch"
                    ></v-text-field>
                </div>
                <div class="flex">
                    <v-btn class="action-btn-success">
                        {{ t("filter") }}
                    </v-btn>
                    &nbsp;
                    <v-btn
                        @click.stop="CreateDialogShow"
                        variant="flat"
                        class="action-btn-success"
                    >
                        {{ t("create") }}
                    </v-btn>
                </div>
            </div>
            
            <!-- Data Table Section -->
            <div class="table-section">
                <v-app>
                    <v-main class="main">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    :dir="dir"
                                    theme="cursor-pointer"
                                    v-model:items-per-page="JobAnnouncementRepository.itemsPerPage"
                                    :headers="headers"
                                    :items-length="JobAnnouncementRepository.totalItems"
                                    :items="JobAnnouncementRepository.jobs"
                                    :loading="JobAnnouncementRepository.loading"
                                    @update:options="handleTableUpdate"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <!-- Title Column -->
                                    <template v-slot:item.title="{ item }">
                                        <div class="py-2 pl-4 d-flex align-center">
                                            <div>
                                                <div class="font-weight-medium">{{ item.title }}</div>
                                                <div class="text-caption text-grey">{{ item.location }}</div>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Status Column -->
                                    <template v-slot:item.status="{ item }">
                                        <div class="py-2 pl-4">
                                            <v-chip
                                                :color="getStatusColor(item.status)"
                                                size="small"
                                                variant="flat"
                                            >
                                                {{ JobAnnouncementRepository.getStatusLabel(item.status) }}
                                            </v-chip>
                                        </div>
                                    </template>

                                    <!-- Deadline Column -->
                                    <template v-slot:item.deadline="{ item }">
                                        <div class="py-2 pl-4">
                                            <div class="text-caption">
                                                {{ formatDate(item.deadline) }}
                                            </div>
                                            <div v-if="item.days_remaining > 0" class="text-caption text-success">
                                                {{ item.days_remaining }} days left
                                            </div>
                                            <div v-else class="text-caption text-error">
                                                Expired
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Checkbox for selecting rows -->
                                    <template v-slot:item.checkbox="{ item }">
                                        <v-checkbox
                                            :value="item.id"
                                            v-model="selectedIds"
                                            class="w-6 d-flex"
                                        ></v-checkbox>
                                    </template>

                                    <!-- Actions Column -->
                                    <template v-slot:item.action="{ item }">
                                        <v-menu>
                                            <template v-slot:activator="{ props }">
                                                <v-btn
                                                    icon="mdi-dots-vertical"
                                                    v-bind="props"
                                                    variant="text"
                                                ></v-btn>
                                            </template>
                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title
                                                        @click="edit(item)"
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                    >
                                                        <v-icon color="tealColor">mdi-square-edit-outline</v-icon>
                                                        {{ $t("edit") }}
                                                    </v-list-item-title>

                                                    <v-list-item-title
                                                        @click="toggleStatus(item)"
                                                        class="cursor-pointer d-flex gap-3 pb-3"
                                                    >
                                                        <v-icon :color="item.status === 'open' ? 'orange' : 'green'">
                                                            {{ item.status === 'open' ? 'mdi-eye-off' : 'mdi-eye' }}
                                                        </v-icon>
                                                        {{ item.status === 'open' ? 'Close' : 'Open' }}
                                                    </v-list-item-title>

                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="deleteItem(item)"
                                                    >
                                                        <v-icon color="error">mdi-delete-outline</v-icon>
                                                        {{ $t("delete") }}
                                                    </v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </template>
                                </v-data-table-server>
                                
                                <!-- Bulk Delete Button -->
                                <v-btn
                                    class="header-button"
                                    v-if="selectedIds.length > 0"
                                    @click="sendSelectedIds"
                                    color="#B71C1C"
                                    flat
                                    inset
                                    :text="`Delete ${selectedIds.length} selected`"
                                >
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-main>
                </v-app>
            </div>
        
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import Header from '../../components/Header.vue';
import CreateJobAnnouncement from "./CreateJobAnnouncement.vue"; 
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { useJobAnnouncementRepository } from "../../stores/JobAnnouncementRepository.js";
import { useAuthRepository } from "../../../stores/Auth.js";

const AuthRepository = useAuthRepository();
const JobAnnouncementRepository = useJobAnnouncementRepository();

const dir = computed(() => {
    return ["fa", "ps"].includes(locale.value) ? "rtl" : "ltr";
});

const selectedStatus = ref('');

// Search handling with debounce
let searchTimeout;
const handleSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        JobAnnouncementRepository.fetchJobs({
            page: 1,
            itemsPerPage: JobAnnouncementRepository.itemsPerPage,
            status: selectedStatus.value
        });
    }, 500);
};

// Status filter handler
const handleStatusFilter = () => {
    JobAnnouncementRepository.fetchJobs({
        page: 1,
        itemsPerPage: JobAnnouncementRepository.itemsPerPage,
        status: selectedStatus.value
    });
};

// Table update handler
const handleTableUpdate = (options) => {
    JobAnnouncementRepository.fetchJobs({
        page: options.page,
        itemsPerPage: options.itemsPerPage,
        status: selectedStatus.value
    });
};

// Bulk delete functionality
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        JobAnnouncementRepository.bulkDeleteJobs(selectedIds.value);
        selectedIds.value = [];
    }
};

// Dialog management
const CreateDialogShow = () => {
    JobAnnouncementRepository.resetCurrentJob();
    JobAnnouncementRepository.isEditMode = false;
    JobAnnouncementRepository.createDialog = true;
};

const edit = (item) => {
    JobAnnouncementRepository.isEditMode = true;
    JobAnnouncementRepository.currentJob = { ...item };
    JobAnnouncementRepository.createDialog = true;
};

const deleteItem = async (item) => {
    await JobAnnouncementRepository.deleteJob(item.id);
};

const toggleStatus = async (item) => {
    await JobAnnouncementRepository.toggleStatus(item.id);
};

// Helper function to get status color
const getStatusColor = (status) => {
    switch (status) {
        case 'open': return 'success';
        case 'draft': return 'warning';
        case 'closed': return 'error';
        case 'archived': return 'grey';
        default: return 'primary';
    }
};

// Helper function to format date
const formatDate = (date) => {
    return new Date(date).toLocaleDateString();
};

// Table headers
const headers = computed(() => [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: t("title"), key: "title", align: "start", sortable: true },
    { title: t("status"), key: "status", align: "center", sortable: true },
    { title: t("deadline"), key: "deadline", align: "center", sortable: true },
    { title: t("created_date"), key: "created_at", align: "center", sortable: true },
    { title: t("action"), key: "action", align: "center", sortable: false },
]);


</script>

<style scoped>
/* Admin Page Container */
.admin-page-container {
    min-height: 100vh;
    background-color: #555 !important;
}

/* Page Header */
.page-header {
    margin-bottom: 24px;
}

/* Content Card */
.content-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Search and Actions Section */
.search-actions-section {
    padding: 24px 32px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
}

.search-actions-section .text-field {
    flex: 1;
    max-width: 400px;
}

.search-actions-section .btn {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Table Section */
.table-section {
    padding: 0;
}

.v-data-table-server {
    position: relative;
}

.header-button {
    position: absolute;
    top: 0.7rem;
    left: 0.7rem;
    z-index: 1;
}

/* Responsive Design */
@media (max-width: 768px) {
    .search-actions-section {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
    }
    
    .search-actions-section .text-field {
        max-width: 100%;
    }
    
    .search-actions-section .btn {
        justify-content: center;
    }
}
</style>