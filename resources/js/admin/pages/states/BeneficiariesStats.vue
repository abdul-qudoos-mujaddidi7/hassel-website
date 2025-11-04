<template>
    <CreateBeneficiariesStats v-if="BeneficiariesRepository.createDialog" />
    <div :dir="dir">
        <Header :pageTitle="$t('beneficiaries_stats_management')" />
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
                        v-model="
                            BeneficiariesRepository.beneficiariesStatsSearch
                        "
                        @input="handleSearch"
                    ></v-text-field>
                </div>
                <div class="flex">
                    <v-btn class="action-btn-success" >
                        {{ t("filter") }}
                    </v-btn>
                    &nbsp;
                    <v-btn
                        @click="CreateDialogShow"
                        class="create-btn-gradient"
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
                                        <v-chip
                                            :color="
                                                getStatTypeColor(
                                                    item.stat_type
                                                )
                                            "
                                            variant="flat"
                                            size="small"
                                        >
                                            {{
                                                BeneficiariesRepository.getStatTypeLabel(
                                                    item.stat_type,
                                                    t
                                                )
                                            }}
                                        </v-chip>
                                    </template>

                                    <!-- Value Column -->
                                    <template v-slot:item.value="{ item }">
                                        <span
                                            class="font-weight-bold text-h6 value-cell"
                                            :class="dir === 'rtl' ? 'text-left' : 'text-right'"
                                        >
                                            {{
                                                BeneficiariesRepository.formatNumber(
                                                    item.value
                                                )
                                            }}
                                        </span>
                                    </template>

                                    <!-- Year Column -->
                                    <template v-slot:item.year="{ item }">
                                        <v-chip
                                            color="primary"
                                            variant="outlined"
                                            size="small"
                                        >
                                            {{ item.year }}
                                        </v-chip>
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
                                                        <v-icon color="primary">mdi-square-edit-outline</v-icon>
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
    return ["fa", "ps"].includes(locale.value) ? "rtl" : "ltr";
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

// Table headers
const headers = computed(() => [
    { title: "", key: "checkbox", align: "start", sortable: false, width: "50px" },
    {
        title: t("stat_type"),
        key: "stat_type",
        align: "start",
        sortable: true,
        width: "180px",
    },
    { title: t("value"), key: "value", align: "end", sortable: true, width: "150px" },
    {
        title: t("description"),
        key: "description",
        align: "start",
        sortable: false,
        width: "400px",
    },
    { title: t("year"), key: "year", align: "start", sortable: true, width: "120px" },
    { title: t("action"), key: "action", align: "center", sortable: false, width: "100px" },
]);

// Get color for stat type chip
const getStatTypeColor = (statType) => {
    const colors = {
        farmers: "green",
        women: "pink",
        youth: "blue",
        total: "primary",
    };
    return colors[statType] || "grey";
};
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

/* Column alignment styles */
.v-data-table-server :deep(.v-data-table__td) {
    vertical-align: middle;
}

.v-data-table-server :deep(.v-data-table__th) {
    vertical-align: middle;
}

/* Ensure proper alignment for RTL/LTR */
.v-data-table-server :deep(.v-data-table__td) {
    padding: 12px 16px;
    vertical-align: middle;
}

/* Value column - ensure proper alignment */
.v-data-table-server :deep(.value-cell) {
    display: block;
    width: 100%;
    text-align: right;
}

[dir="rtl"] .v-data-table-server :deep(.value-cell) {
    text-align: left;
}

/* Value column header and cells alignment */
.v-data-table-server :deep(thead th),
.v-data-table-server :deep(tbody td) {
    text-align: inherit;
}

/* Value column (3rd column) - right align with spacing */
.v-data-table-server :deep(thead th:nth-of-type(3)),
.v-data-table-server :deep(tbody td:nth-of-type(3)) {
    text-align: right !important;
    padding-right: 60px !important;
    padding-left: 16px !important;
    width: 150px !important;
    min-width: 150px !important;
    max-width: 150px !important;
}

[dir="rtl"] .v-data-table-server :deep(thead th:nth-of-type(3)),
[dir="rtl"] .v-data-table-server :deep(tbody td:nth-of-type(3)) {
    text-align: left !important;
    padding-left: 60px !important;
    padding-right: 16px !important;
}

/* Description column (4th column) - add left padding for spacing */
.v-data-table-server :deep(thead th:nth-of-type(4)),
.v-data-table-server :deep(tbody td:nth-of-type(4)) {
    padding-left: 60px !important;
    padding-right: 16px !important;
    min-width: 400px !important;
    width: auto !important;
}

[dir="rtl"] .v-data-table-server :deep(thead th:nth-of-type(4)),
[dir="rtl"] .v-data-table-server :deep(tbody td:nth-of-type(4)) {
    padding-right: 60px !important;
    padding-left: 16px !important;
}

/* Ensure table cells have proper spacing */
.v-data-table-server :deep(tbody td) {
    padding: 12px 16px;
}

/* Add extra spacing specifically between value and description columns */
.v-data-table-server :deep(tbody tr td:nth-of-type(3)) {
    padding-right: 80px !important;
    border-right: none !important;
}

[dir="rtl"] .v-data-table-server :deep(tbody tr td:nth-of-type(3)) {
    padding-left: 80px !important;
    padding-right: 16px !important;
    border-left: none !important;
}

.v-data-table-server :deep(tbody tr td:nth-of-type(4)) {
    padding-left: 80px !important;
    border-left: none !important;
}

[dir="rtl"] .v-data-table-server :deep(tbody tr td:nth-of-type(4)) {
    padding-right: 80px !important;
    padding-left: 16px !important;
    border-right: none !important;
}

.header-button {
    position: absolute;
    top: 0.7rem;
    left: 0.7rem;
    z-index: 1;
}

/* Ensure action column is visible */
.v-data-table-server :deep(thead th:nth-of-type(6)),
.v-data-table-server :deep(tbody td:nth-of-type(6)) {
    width: 100px !important;
    min-width: 100px !important;
    padding: 12px 16px !important;
    text-align: center !important;
}

/* Make sure action button is visible */
.v-data-table-server :deep(tbody td:nth-of-type(6) .v-btn) {
    opacity: 1 !important;
    visibility: visible !important;
    display: inline-flex !important;
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
