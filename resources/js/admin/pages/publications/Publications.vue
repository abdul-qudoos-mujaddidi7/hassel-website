<template>
    <CreatePublication v-if="PublicationsRepository.createDialog" />
    <div :dir="dir">
        <!-- Page Header -->
        <Header pageTitle='Publications Management' />
        <v-divider :thickness="1" class="border-opacity-100" />
        
        <!-- Main Content Card -->
        <div class="content-card">
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
                        v-model="PublicationsRepository.publicationsSearch"
                        @input="handleSearch"
                    ></v-text-field>
                </div>
                <div class="btn flex">
                    <v-select
                        v-model="selectedStatus"
                        :items="PublicationsRepository.statusOptions"
                        item-value="value"
                        item-title="label"
                        variant="outlined"
                        density="compact"
                        :label="$t('status')"
                        class="mr-2"
                        style="min-width: 120px;"
                        @update:model-value="handleFilter"
                    ></v-select>
                    <v-select
                        v-model="selectedFileType"
                        :items="PublicationsRepository.fileTypeOptions"
                        item-value="value"
                        item-title="label"
                        variant="outlined"
                        density="compact"
                        :label="$t('file_type')"
                        class="mr-4"
                        style="min-width: 150px;"
                        @update:model-value="handleFilter"
                    ></v-select>
                    <v-btn variant="outlined" color="primary" class="px-6">
                        {{ t("filter") }}
                    </v-btn>
                    &nbsp;
                    <v-btn
                        @click="CreateDialogShow"
                        class="create-btn-gradient px-6"
                        :text="$t('create')"
                    >
                        <v-icon>mdi-plus</v-icon>
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
                                    v-model:items-per-page="PublicationsRepository.itemsPerPage"
                                    :headers="headers"
                                    :items-length="PublicationsRepository.totalItems"
                                    :items="PublicationsRepository.publications"
                                    :loading="PublicationsRepository.loading"
                                    @update:options="handleTableUpdate"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <!-- Title Column -->
                                    <template v-slot:item.title="{ item }">
                                        <td class="py-2 pl-4">
                                            <div class="d-flex align-center">
                                                <v-icon
                                                    :icon="getFileIcon(item.file_type)"
                                                    size="24"
                                                    class="mr-3"
                                                    :color="getFileColor(item.file_type)"
                                                ></v-icon>
                                                <div>
                                                    <div class="font-weight-medium">{{ item.title }}</div>
                                                    <div class="text-caption text-grey">{{ item.description?.substring(0, 50) }}...</div>
                                                </div>
                                            </div>
                                        </td>
                                    </template>

                                    <!-- File Type Column -->
                                    <template v-slot:item.file_type="{ item }">
                                        <td class="py-2 pl-4">
                                            <v-chip
                                                :color="getFileTypeColor(item.file_type)"
                                                size="small"
                                                variant="flat"
                                            >
                                                {{ PublicationsRepository.getFileTypeLabel(item.file_type) }}
                                            </v-chip>
                                        </td>
                                    </template>

                                    <!-- Status Column -->
                                    <template v-slot:item.status="{ item }">
                                        <td class="py-2 pl-4">
                                            <v-chip
                                                :color="getStatusColor(item.status)"
                                                size="small"
                                                variant="flat"
                                            >
                                                {{ PublicationsRepository.getStatusLabel(item.status) }}
                                            </v-chip>
                                        </td>
                                    </template>

                                    <!-- File Path Column -->
                                    <template v-slot:item.file_path="{ item }">
                                        <td class="py-2 pl-4">
                                            <div v-if="item.file_path" class="d-flex align-center">
                                                <v-icon icon="mdi-file" size="16" class="mr-2"></v-icon>
                                                <span class="text-caption">{{ getFileName(item.file_path) }}</span>
                                            </div>
                                            <span v-else class="text-grey">No file</span>
                                        </td>
                                    </template>

                                    <!-- Published Date Column -->
                                    <template v-slot:item.published_at="{ item }">
                                        <td class="py-2 pl-4">
                                            <span>{{ PublicationsRepository.formatDate(item.published_at) }}</span>
                                        </td>
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
                                                        v-if="item.file_path"
                                                        @click="downloadFile(item)"
                                                        class="cursor-pointer d-flex gap-3 pb-3"
                                                    >
                                                        <v-icon color="blue">mdi-download</v-icon>
                                                        Download
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
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import Header from '../../components/Header.vue';
import CreatePublication from "./CreatePublication.vue"; 
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { usePublicationsRepository } from "../../stores/PublicationsRepository";
import { useAuthRepository } from "../../../stores/Auth.js";

const AuthRepository = useAuthRepository();
const PublicationsRepository = usePublicationsRepository();

const dir = computed(() => {
    return ["fa", "pa"].includes(locale.value) ? "rtl" : "ltr";
});

const selectedStatus = ref('');
const selectedFileType = ref('');

// Search handling with debounce
let searchTimeout;
const handleSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        PublicationsRepository.fetchPublications({
            page: 1,
            itemsPerPage: PublicationsRepository.itemsPerPage,
            status: selectedStatus.value,
            fileType: selectedFileType.value
        });
    }, 500);
};

// Filter handler
const handleFilter = () => {
    PublicationsRepository.fetchPublications({
        page: 1,
        itemsPerPage: PublicationsRepository.itemsPerPage,
        status: selectedStatus.value,
        fileType: selectedFileType.value
    });
};

// Table update handler
const handleTableUpdate = (options) => {
    PublicationsRepository.fetchPublications({
        page: options.page,
        itemsPerPage: options.itemsPerPage,
        status: selectedStatus.value,
        fileType: selectedFileType.value
    });
};

// Bulk delete functionality
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        PublicationsRepository.bulkDeletePublications(selectedIds.value);
        selectedIds.value = [];
    }
};

// Dialog management
const CreateDialogShow = () => {
    PublicationsRepository.resetCurrentPublication();
    PublicationsRepository.isEditMode = false;
    PublicationsRepository.createDialog = true;
};

const edit = (item) => {
    PublicationsRepository.isEditMode = true;
    PublicationsRepository.currentPublication = { ...item };
    PublicationsRepository.createDialog = true;
};

const deleteItem = async (item) => {
    await PublicationsRepository.deletePublication(item.id);
};

const downloadFile = (item) => {
    if (item.file_path) {
        window.open(item.file_path, '_blank');
    }
};

// Helper functions
const getFileIcon = (fileType) => {
    const iconMap = {
        'pdf': 'mdi-file-pdf-box',
        'doc': 'mdi-file-word-box',
        'docx': 'mdi-file-word-box',
        'xls': 'mdi-file-excel-box',
        'xlsx': 'mdi-file-excel-box',
        'ppt': 'mdi-file-powerpoint-box',
        'pptx': 'mdi-file-powerpoint-box',
        'txt': 'mdi-file-document-outline',
        'other': 'mdi-file-outline'
    };
    return iconMap[fileType] || 'mdi-file-outline';
};

const getFileColor = (fileType) => {
    const colorMap = {
        'pdf': 'red',
        'doc': 'blue',
        'docx': 'blue',
        'xls': 'green',
        'xlsx': 'green',
        'ppt': 'orange',
        'pptx': 'orange',
        'txt': 'grey',
        'other': 'grey'
    };
    return colorMap[fileType] || 'grey';
};

const getFileTypeColor = (fileType) => {
    const colorMap = {
        'pdf': 'red',
        'doc': 'blue',
        'docx': 'blue',
        'xls': 'green',
        'xlsx': 'green',
        'ppt': 'orange',
        'pptx': 'orange',
        'txt': 'grey',
        'other': 'grey'
    };
    return colorMap[fileType] || 'primary';
};

const getStatusColor = (status) => {
    switch (status) {
        case 'published': return 'success';
        case 'draft': return 'warning';
        case 'archived': return 'grey';
        default: return 'primary';
    }
};

const getFileName = (filePath) => {
    return filePath.split('/').pop();
};

// Table headers
const headers = computed(() => [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: t("title"), key: "title", align: "start", sortable: true },
    { title: t("file_type"), key: "file_type", align: "center", sortable: true },
    { title: t("status"), key: "status", align: "center", sortable: true },
    { title: t("file_path"), key: "file_path", align: "center", sortable: false },
    { title: t("published_date"), key: "published_at", align: "center", sortable: true },
    { title: t("action"), key: "action", align: "center", sortable: false },
]);

// Load data on mount
onMounted(() => {
    PublicationsRepository.fetchPublications({
        page: 1,
        itemsPerPage: PublicationsRepository.itemsPerPage,
    });
});
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

