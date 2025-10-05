<template>
    <CreateBeneficiariesStats v-if="BeneficiariesRepository.createDialog" />
    <div :dir="dir">
        <!-- Page Header -->
        <Header pageTitle='Beneficiaries Statistics' />
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
                        v-model="BeneficiariesRepository.beneficiariesStatsSearch"
                        @input="handleSearch"
                    ></v-text-field>
                </div>
                <div class="flex">
                    <v-btn variant="outlined" class="create-btn-gradient px-6">
                        {{ t("filter") }}
                    </v-btn>
                    &nbsp;
                    
                        <v-btn
                            @click="CreateDialogShow"
                            class="create-btn-gradient px-6"
                            :text="$t('create')"
                        >
                            
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
                                    v-model:items-per-page="BeneficiariesRepository.itemsPerPage"
                                    :headers="headers"
                                    :items-length="BeneficiariesRepository.totalItems"
                                    :items="BeneficiariesRepository.beneficiariesStats"
                                    :loading="BeneficiariesRepository.loading"
                                    @update:options="handleTableUpdate"
                                    hover
                                    class="w-100 mx-auto"
                                >
                                    <!-- Stat Type Column -->
                                    <template v-slot:item.stat_type="{ item }">
                                        <td class="py-2 pl-4">
                                            <span >
                                                {{ BeneficiariesRepository.getStatTypeLabel(item.stat_type) }}
                                            </span>
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

        <!-- Data Table Section -->
        <div class="table-section">
            <v-app>
                <v-main class="main">
                    <v-row>
                        <v-col>
                            <v-data-table-server
                                :dir="dir"
                                theme="cursor-pointer"
                                v-model:items-per-page="
                                    BeneficiariesRepository.itemsPerPage
                                "
                                :headers="headers"
                                :items-length="
                                    BeneficiariesRepository.totalItems
                                "
                                :items="
                                    BeneficiariesRepository.beneficiariesStats
                                "
                                :loading="BeneficiariesRepository.loading"
                                @update:options="handleTableUpdate"
                                hover
                                class="w-100 mx-auto"
                            >
                                <!-- Stat Type Column -->
                                <template v-slot:item.stat_type="{ item }">
                                    <td class="py-2 pl-4">
                                        <v-chip
                                            :color="
                                                getStatTypeColor(item.stat_type)
                                            "
                                            variant="flat"
                                            size="small"
                                        >
                                            {{
                                                BeneficiariesRepository.getStatTypeLabel(
                                                    item.stat_type
                                                )
                                            }}
                                        </v-chip>
                                    </td>
                                </template>

                                <!-- Value Column -->
                                <template v-slot:item.value="{ item }">
                                    <td class="py-2 pl-4">
                                        <span class="font-weight-bold text-h6">
                                            {{
                                                BeneficiariesRepository.formatNumber(
                                                    item.value
                                                )
                                            }}
                                        </span>
                                    </td>
                                </template>

                                <!-- Year Column -->
                                <template v-slot:item.year="{ item }">
                                    <td class="py-2 pl-4">
                                        <v-chip
                                            color="primary"
                                            variant="outlined"
                                            size="small"
                                        >
                                            {{ item.year }}
                                        </v-chip>
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
                                                    v-if="
                                                        AuthRepository.permissions &&
                                                        AuthRepository.permissions.includes(
                                                            'editBeneficiariesStats'
                                                        )
                                                    "
                                                    @click="edit(item)"
                                                    class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                >
                                                    <v-icon color="primary"
                                                        >mdi-square-edit-outline</v-icon
                                                    >
                                                    {{ $t("edit") }}
                                                </v-list-item-title>

                                                <v-list-item-title
                                                    v-if="
                                                        AuthRepository.permissions &&
                                                        AuthRepository.permissions.includes(
                                                            'deleteBeneficiariesStats'
                                                        )
                                                    "
                                                    class="cursor-pointer d-flex gap-3"
                                                    @click="deleteItem(item)"
                                                >
                                                    <v-icon color="error"
                                                        >mdi-delete-outline</v-icon
                                                    >
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
import Header from "../../components/Header.vue";
import CreateBeneficiariesStats from "./CreateBeneficiariesStats.vue";
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { useBeneficiariesRepository } from "../../stores/BeneficiariesRepository";
import { useAuthRepository } from "../../../stores/Auth.js";

const AuthRepository = useAuthRepository();
const BeneficiariesRepository = useBeneficiariesRepository();

const dir = computed(() => {
    return ["fa", "pa"].includes(locale.value) ? "rtl" : "ltr";
});

// Search handling with debounce
let searchTimeout;
const handleSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        BeneficiariesRepository.fetchBeneficiariesStats({
            page: 1,
            itemsPerPage: BeneficiariesRepository.itemsPerPage,
        });
    }, 500);
};

// Table update handler
const handleTableUpdate = (options) => {
    BeneficiariesRepository.fetchBeneficiariesStats({
        page: options.page,
        itemsPerPage: options.itemsPerPage,
    });
};

// Bulk delete functionality
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0) {
        BeneficiariesRepository.bulkDeleteBeneficiariesStats(selectedIds.value);
        selectedIds.value = [];
    }
};

// Dialog management
const CreateDialogShow = () => {
    BeneficiariesRepository.resetCurrentStat();
    BeneficiariesRepository.isEditMode = false;
    BeneficiariesRepository.createDialog = true;
};

const edit = (item) => {
    BeneficiariesRepository.isEditMode = true;
    BeneficiariesRepository.currentStat = { ...item };
    BeneficiariesRepository.createDialog = true;
};

const deleteItem = async (item) => {
    {
        await BeneficiariesRepository.deleteBeneficiariesStat(item.id);
    }
};

<<<<<<< HEAD
// Helper function to get stat type color - using consistent brand color
const getStatTypeColor = (statType) => {
    // Use primary brand color for all stat types for consistency
    return "primary";
};
=======
>>>>>>> ffc98f5e5ba858bdfb1bf23473d47f498ce04cf3

// Table headers
const headers = computed(() => [
    { title: "", key: "checkbox", align: "start", sortable: false },
    {
        title: t("stat_type"),
        key: "stat_type",
        align: "center",
        sortable: true,
    },
    { title: t("value"), key: "value", align: "center", sortable: true },
    {
        title: t("description"),
        key: "description",
        align: "start",
        sortable: false,
    },
    { title: t("year"), key: "year", align: "center", sortable: true },
<<<<<<< HEAD
    {
        title: t("created_at"),
        key: "created_at",
        align: "center",
        sortable: true,
    },
=======
>>>>>>> ffc98f5e5ba858bdfb1bf23473d47f498ce04cf3
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
