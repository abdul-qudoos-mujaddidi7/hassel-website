<template>
    <CreateNews v-if="NewsRepository.createDialog" />
    <div :dir="dir" >
        <!-- Page Header -->
        <Header :pageTitle='$t("news_management")' />
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
                        v-model="NewsRepository.newsSearch"
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
                                    v-model:items-per-page="NewsRepository.itemsPerPage"
                                    :headers="headers"
                                    :items-length="NewsRepository.totalItems"
                                    :items="NewsRepository.news"
                                    :loading="NewsRepository.loading"
                                    @update:options="handleTableUpdate"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <!-- Title Column -->
                                    <template v-slot:item.title="{ item }">
                                        <div class="py-2 pl-4 d-flex align-center">
                                            <v-avatar
                                                v-if="item.featured_image"
                                                size="40"
                                                class="mr-3"
                                            >
                                                <v-img :src="item.featured_image" :alt="item.title"></v-img>
                                            </v-avatar>
                                            <div>
                                                <div class="font-weight-medium">{{ item.title }}</div>
                                                <div class="text-caption text-grey">{{ item.excerpt }}</div>
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
                                                {{ NewsRepository.getStatusLabel(item.status, t) }}
                                            </v-chip>
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
                                                        <v-icon :color="item.status === 'published' ? 'orange' : 'green'">
                                                            {{ item.status === 'published' ? 'mdi-eye-off' : 'mdi-eye' }}
                                                        </v-icon>
                                                        {{ item.status === 'published' ? 'Unpublish' : 'Publish' }}
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
import CreateNews from "./CreateNews.vue"; 
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { useNewsRepository } from "../../stores/NewsRepository";
import { useAuthRepository } from "../../../stores/Auth.js";

const AuthRepository = useAuthRepository();
const NewsRepository = useNewsRepository();

const dir = computed(() => {
    return ["fa", "ps"].includes(locale.value) ? "rtl" : "ltr";
});

const selectedStatus = ref('');

// Search handling with debounce
let searchTimeout;
const handleSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        NewsRepository.fetchNews({
            page: 1,
            itemsPerPage: NewsRepository.itemsPerPage,
            status: selectedStatus.value
        });
    }, 500);
};

// Status filter handler
const handleStatusFilter = () => {
    NewsRepository.fetchNews({
        page: 1,
        itemsPerPage: NewsRepository.itemsPerPage,
        status: selectedStatus.value
    });
};

// Table update handler
const handleTableUpdate = (options) => {
    NewsRepository.fetchNews({
        page: options.page,
        itemsPerPage: options.itemsPerPage,
        status: selectedStatus.value
    });
};

// Bulk delete functionality
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        NewsRepository.bulkDeleteNews(selectedIds.value);
        selectedIds.value = [];
    }
};

// Dialog management
const CreateDialogShow = () => {
    NewsRepository.resetCurrentNews();
    NewsRepository.isEditMode = false;
    NewsRepository.createDialog = true;
};

const edit = (item) => {
    NewsRepository.isEditMode = true;
    NewsRepository.currentNews = { ...item };
    NewsRepository.createDialog = true;
};

const deleteItem = async (item) => {
    await NewsRepository.deleteNews(item.id);
};

const toggleStatus = async (item) => {
    await NewsRepository.toggleStatus(item.id);
};

// Helper function to get status color
const getStatusColor = (status) => {
    switch (status) {
        case 'published': return 'success';
        case 'draft': return 'warning';
        case 'archived': return 'grey';
        default: return 'primary';
    }
};

// Helper function to get translation coverage color
const getTranslationCoverageColor = (coverage) => {
    if (coverage === 100) return 'success';
    if (coverage >= 50) return 'warning';
    return 'error';
};

// Table headers
const headers = computed(() => [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: t("title"), key: "title", align: "start", sortable: true },
    { title: t("status"), key: "status", align: "center", sortable: true },
    { title: t("published_date"), key: "published_at", align: "center", sortable: true },
    { title: t("action"), key: "action", align: "center", sortable: false },
]);

// Load data on mount
onMounted(() => {
    NewsRepository.fetchNews({
        page: 1,
        itemsPerPage: NewsRepository.itemsPerPage,
    });
});

// Refetch list when UI language changes (globe menu)
watch(() => locale.value, () => {
    NewsRepository.fetchNews({
        page: 1,
        itemsPerPage: NewsRepository.itemsPerPage,
        status: selectedStatus.value,
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
