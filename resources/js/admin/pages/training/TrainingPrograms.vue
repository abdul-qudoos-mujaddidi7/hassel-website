<template>
    <CreateTrainingProgram v-if="TrainingProgramsRepository.createDialog" />
    <div :dir="dir">
        <!-- Page Header -->
        <Header pageTitle='Training Programs Management' />
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
                        v-model="TrainingProgramsRepository.trainingProgramsSearch"
                        @input="handleSearch"
                    ></v-text-field>
                </div>
                <div class="btn flex">
                    <v-select
                        v-model="selectedStatus"
                        :items="TrainingProgramsRepository.statusOptions"
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
                        v-model="selectedProgramType"
                        :items="TrainingProgramsRepository.programTypeOptions"
                        item-value="value"
                        item-title="label"
                        variant="outlined"
                        density="compact"
                        :label="$t('program_type')"
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
                                    v-model:items-per-page="TrainingProgramsRepository.itemsPerPage"
                                    :headers="headers"
                                    :items-length="TrainingProgramsRepository.totalItems"
                                    :items="TrainingProgramsRepository.trainingPrograms"
                                    :loading="TrainingProgramsRepository.loading"
                                    @update:options="handleTableUpdate"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <!-- Title Column -->
                                    <template v-slot:item.title="{ item }">
                                        <td class="py-2 pl-4">
                                            <div class="d-flex align-center">
                                                <v-avatar
                                                    v-if="item.thumbnail_image"
                                                    size="40"
                                                    class="mr-3"
                                                >
                                                    <v-img :src="item.thumbnail_image" :alt="item.title"></v-img>
                                                </v-avatar>
                                                <div>
                                                    <div class="font-weight-medium">{{ item.title }}</div>
                                                    <div class="text-caption text-grey">{{ item.location }}</div>
                                                </div>
                                            </div>
                                        </td>
                                    </template>

                                    <!-- Program Type Column -->
                                    <template v-slot:item.program_type="{ item }">
                                        <td class="py-2 pl-4">
                                            <v-chip
                                                color="primary"
                                                size="small"
                                                variant="outlined"
                                            >
                                                {{ TrainingProgramsRepository.getProgramTypeLabel(item.program_type) }}
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
                                                {{ TrainingProgramsRepository.getStatusLabel(item.status) }}
                                            </v-chip>
                                        </td>
                                    </template>

                                    <!-- Date Range Column -->
                                    <template v-slot:item.date_range="{ item }">
                                        <td class="py-2 pl-4">
                                            <div class="text-caption">
                                                <div><strong>Start:</strong> {{ TrainingProgramsRepository.formatDate(item.start_date) }}</div>
                                                <div><strong>End:</strong> {{ TrainingProgramsRepository.formatDate(item.end_date) }}</div>
                                            </div>
                                        </td>
                                    </template>

                                    <!-- Participants Column -->
                                    <template v-slot:item.participants="{ item }">
                                        <td class="py-2 pl-4">
                                            <div class="text-caption">
                                                <div v-if="item.max_participants">
                                                    {{ item.registrations?.length || 0 }} / {{ item.max_participants }}
                                                </div>
                                                <div v-else>
                                                    {{ item.registrations?.length || 0 }} / Unlimited
                                                </div>
                                            </div>
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
                                                        @click="viewRegistrations(item)"
                                                        class="cursor-pointer d-flex gap-3 pb-3"
                                                    >
                                                        <v-icon color="blue">mdi-account-group</v-icon>
                                                        View Registrations
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
import CreateTrainingProgram from "./CreateTrainingProgram.vue"; 
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { useTrainingProgramsRepository } from "../../stores/TrainingProgramsRepository";
import { useAuthRepository } from "../../../stores/Auth.js";

const AuthRepository = useAuthRepository();
const TrainingProgramsRepository = useTrainingProgramsRepository();

const dir = computed(() => {
    return ["fa", "pa"].includes(locale.value) ? "rtl" : "ltr";
});

const selectedStatus = ref('');
const selectedProgramType = ref('');

// Search handling with debounce
let searchTimeout;
const handleSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        TrainingProgramsRepository.fetchTrainingPrograms({
            page: 1,
            itemsPerPage: TrainingProgramsRepository.itemsPerPage,
            status: selectedStatus.value,
            programType: selectedProgramType.value
        });
    }, 500);
};

// Filter handler
const handleFilter = () => {
    TrainingProgramsRepository.fetchTrainingPrograms({
        page: 1,
        itemsPerPage: TrainingProgramsRepository.itemsPerPage,
        status: selectedStatus.value,
        programType: selectedProgramType.value
    });
};

// Table update handler
const handleTableUpdate = (options) => {
    TrainingProgramsRepository.fetchTrainingPrograms({
        page: options.page,
        itemsPerPage: options.itemsPerPage,
        status: selectedStatus.value,
        programType: selectedProgramType.value
    });
};

// Bulk delete functionality
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        TrainingProgramsRepository.bulkDeleteTrainingPrograms(selectedIds.value);
        selectedIds.value = [];
    }
};

// Dialog management
const CreateDialogShow = () => {
    TrainingProgramsRepository.resetCurrentProgram();
    TrainingProgramsRepository.isEditMode = false;
    TrainingProgramsRepository.createDialog = true;
};

const edit = (item) => {
    TrainingProgramsRepository.isEditMode = true;
    TrainingProgramsRepository.currentProgram = { ...item };
    TrainingProgramsRepository.createDialog = true;
};

const deleteItem = async (item) => {
    await TrainingProgramsRepository.deleteTrainingProgram(item.id);
};

const viewRegistrations = (item) => {
    // Navigate to registrations page or open modal
    console.log('View registrations for:', item.id);
};

// Helper function to get status color
const getStatusColor = (status) => {
    switch (status) {
        case 'published': return 'success';
        case 'ongoing': return 'info';
        case 'completed': return 'success';
        case 'draft': return 'warning';
        case 'cancelled': return 'error';
        default: return 'primary';
    }
};

// Table headers
const headers = computed(() => [
    { title: "", key: "checkbox", align: "start", sortable: false },
    { title: t("title"), key: "title", align: "start", sortable: true },
    { title: t("program_type"), key: "program_type", align: "center", sortable: true },
    { title: t("status"), key: "status", align: "center", sortable: true },
    { title: t("date_range"), key: "date_range", align: "center", sortable: true },
    { title: t("participants"), key: "participants", align: "center", sortable: false },
    { title: t("action"), key: "action", align: "center", sortable: false },
]);

// Load data on mount
onMounted(() => {
    TrainingProgramsRepository.fetchTrainingPrograms({
        page: 1,
        itemsPerPage: TrainingProgramsRepository.itemsPerPage,
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

