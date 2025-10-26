<template>
    <CreateAgriTechToolTranslatable v-if="AgriTechToolsRepository.createDialog" />
    <div :dir="dir" >
        <!-- Page Header -->
        <Header :pageTitle="$t('agri_tech_tools_management')" />
        <v-divider :thickness="1" class="border-opacity-100" />
        
        <!-- Main Content Card -->
       
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
                        v-model="AgriTechToolsRepository.agriTechToolsSearch"
                        @input="handleSearch"
                    ></v-text-field>
                </div>
                <div class="btn flex">

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
                                    v-model:items-per-page="AgriTechToolsRepository.itemsPerPage"
                                    :headers="headers"
                                    :items-length="AgriTechToolsRepository.totalItems"
                                    :items="AgriTechToolsRepository.agriTechTools"
                                    :loading="AgriTechToolsRepository.loading"
                                    @update:options="handleTableUpdate"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <!-- No data slot -->
                                    <template v-slot:no-data>
                                        <div class="text-center pa-4">
                                            {{ $t('no_data_available') }}
                                        </div>
                                    </template>
                                    <!-- Name Column -->
                                    <template v-slot:item.name="{ item }">
                                        <td class="py-2 pl-4">
                                            <div class="d-flex align-center">
                                                <v-avatar
                                                    v-if="item.cover_image"
                                                    size="40"
                                                    class="mr-3"
                                                >
                                                    <v-img :src="item.cover_image" :alt="item.name"></v-img>
                                                </v-avatar>
                                                <div>
                                                    <div class="font-weight-medium">{{ item.name }}</div>
                                                    <div class="text-caption text-grey">{{ item.category }}</div>
                                                </div>
                                            </div>
                                        </td>
                                    </template>

                                    <!-- Category Column -->
                                    <template v-slot:item.category="{ item }">
                                        <td class="py-2 pl-4">
                                            <v-chip
                                                color="primary"
                                                size="small"
                                                variant="outlined"
                                            >
                                                {{ getCategoryLabel(item.category) }}
                                            </v-chip>
                                        </td>
                                    </template>

                                    <!-- Technology Level Column -->
                                    <template v-slot:item.technology_level="{ item }">
                                        <td class="py-2 pl-4">
                                            <v-chip
                                                :color="getTechnologyLevelColor(item.technology_level)"
                                                size="small"
                                                variant="flat"
                                            >
                                                {{ getTechnologyLevelLabel(item.technology_level) }}
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
                                                {{ AgriTechToolsRepository.getStatusLabel(item.status) }}
                                            </v-chip>
                                        </td>
                                    </template>

                                    <!-- Availability Column -->
                                    <template v-slot:item.availability="{ item }">
                                        <td class="py-2 pl-4">
                                            <v-chip
                                                :color="getAvailabilityColor(item.availability)"
                                                size="small"
                                                variant="flat"
                                            >
                                                {{ getAvailabilityLabel(item.availability) }}
                                            </v-chip>
                                        </td>
                                    </template>

                                    <!-- Price Range Column -->
                                    <template v-slot:item.price_range="{ item }">
                                        <td class="py-2 pl-4">
                                            <span>{{ item.price_range || 'N/A' }}</span>
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
import { ref, computed, onMounted } from "vue";
import Header from '../../components/Header.vue';
import CreateAgriTechToolTranslatable from "./CreateAgriTechToolTranslatable.vue"; 
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { useAgriTechToolsRepository } from "../../stores/AgriTechToolsRepository";
import { useAuthRepository } from "../../../stores/Auth.js";

const AuthRepository = useAuthRepository();
const AgriTechToolsRepository = useAgriTechToolsRepository();

const dir = computed(() => {
    return ["fa", "pa"].includes(locale.value) ? "rtl" : "ltr";
});

const selectedStatus = ref('');

// Search handling with debounce
let searchTimeout;
const handleSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        AgriTechToolsRepository.fetchAgriTechTools({
            page: 1,
            itemsPerPage: AgriTechToolsRepository.itemsPerPage,
            status: selectedStatus.value
        });
    }, 500);
};

// Status filter handler
const handleStatusFilter = () => {
    AgriTechToolsRepository.fetchAgriTechTools({
        page: 1,
        itemsPerPage: AgriTechToolsRepository.itemsPerPage,
        status: selectedStatus.value
    });
};

// Table update handler
const handleTableUpdate = (options) => {
    AgriTechToolsRepository.fetchAgriTechTools({
        page: options.page,
        itemsPerPage: options.itemsPerPage,
        status: selectedStatus.value
    });
};

// Bulk delete functionality
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        AgriTechToolsRepository.bulkDeleteAgriTechTools(selectedIds.value);
        selectedIds.value = [];
    }
};

// Dialog management
const CreateDialogShow = () => {
    AgriTechToolsRepository.resetCurrentAgriTechTool();
    AgriTechToolsRepository.isEditMode = false;
    AgriTechToolsRepository.createDialog = true;
};

const edit = (item) => {
    AgriTechToolsRepository.isEditMode = true;
    AgriTechToolsRepository.currentAgriTechTool = { ...item };
    AgriTechToolsRepository.createDialog = true;
};

const deleteItem = async (item) => {
    await AgriTechToolsRepository.deleteAgriTechTool(item.id);
};

const toggleStatus = async (item) => {
    await AgriTechToolsRepository.toggleStatus(item.id);
};

// Helper function to get status color
const getStatusColor = (status) => {
    switch (status) {
        case 'published': return 'success';
        case 'draft': return 'warning';
        case 'available': return 'success';
        case 'unavailable': return 'error';
        case 'maintenance': return 'warning';
        default: return 'primary';
    }
};

// Helper function to get availability color
const getAvailabilityColor = (availability) => {
    switch (availability) {
        case 'available': return 'success';
        case 'limited': return 'warning';
        case 'unavailable': return 'error';
        case 'coming_soon': return 'info';
        default: return 'primary';
    }
};

// Helper function to get technology level color
const getTechnologyLevelColor = (level) => {
    switch (level) {
        case 'basic': return 'success';
        case 'intermediate': return 'warning';
        case 'advanced': return 'orange';
        case 'cutting_edge': return 'error';
        default: return 'primary';
    }
};

// Helper function to get category label
const getCategoryLabel = (category) => {
    const categoryOption = AgriTechToolsRepository.categoryOptions.find(
        (c) => c.value === category
    );
    return categoryOption ? categoryOption.label : category;
};

// Helper function to get technology level label
const getTechnologyLevelLabel = (level) => {
    const levelOption = AgriTechToolsRepository.technologyLevelOptions.find(
        (l) => l.value === level
    );
    return levelOption ? levelOption.label : level;
};

// Helper function to get availability label
const getAvailabilityLabel = (availability) => {
    const availabilityOption = AgriTechToolsRepository.availabilityOptions.find(
        (a) => a.value === availability
    );
    return availabilityOption ? availabilityOption.label : availability;
};

// Table headers
const headers = computed(() => [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: t("name"), key: "name", align: "start", sortable: true },
    { title: t("category"), key: "category", align: "center", sortable: true },
    { title: t("technology_level"), key: "technology_level", align: "center", sortable: true },
    { title: t("status"), key: "status", align: "center", sortable: true },
    { title: t("availability"), key: "availability", align: "center", sortable: true },
    { title: t("price_range"), key: "price_range", align: "center", sortable: true },
    { title: t("action"), key: "action", align: "center", sortable: false },
]);

// Load data on mount
onMounted(() => {
    AgriTechToolsRepository.fetchAgriTechTools({
        page: 1,
        itemsPerPage: AgriTechToolsRepository.itemsPerPage,
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
