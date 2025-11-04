<template>
    <div :dir="dir">
        <!-- Page Header -->
        <Header :pageTitle="$t('contacts_management')" />
        <v-divider :thickness="1" class="border-opacity-100" />
        
        <!-- Search and Filters Section -->
        <div class="btn-search pt-12 pb-6">
            <div class="text-field w-25">
                <v-text-field
                    color="primary"
                    density="compact"
                    variant="outlined"
                    :label="$t('search')"
                    append-inner-icon="mdi-magnify"
                    hide-details
                    v-model="ContactsRepository.contactSearch"
                    @input="handleSearch"
                ></v-text-field>
            </div>
            <div class="flex gap-2">
                <v-select
                    v-model="selectedStatus"
                    :items="statusOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :label="$t('status')"
                    class="text-field"
                    @update:model-value="handleStatusFilter"
                ></v-select>
                <v-select
                    v-model="selectedSubject"
                    :items="subjectOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :label="$t('subject')"
                    class="text-field"
                    @update:model-value="handleSubjectFilter"
                ></v-select>
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
                                v-model:items-per-page="ContactsRepository.itemsPerPage"
                                :headers="headers"
                                :items-length="ContactsRepository.totalItems"
                                :items="ContactsRepository.contacts"
                                :loading="ContactsRepository.loading"
                                @update:options="handleTableUpdate"
                                hover
                                class="w-100 mx-auto"
                            >
                                <!-- Name Column -->
                                <template v-slot:item.name="{ item }">
                                    <div class="py-2 pl-4 d-flex align-center">
                                        <div>
                                            <div class="font-weight-medium">{{ item.name }}</div>
                                            <div class="text-caption text-grey">{{ item.email }}</div>
                                        </div>
                                    </div>
                                </template>

                                <!-- Subject Column -->
                                <template v-slot:item.subject="{ item }">
                                    <div class="py-2 pl-4">
                                        <v-chip
                                            size="small"
                                            variant="outlined"
                                            color="primary"
                                        >
                                            {{ ContactsRepository.getSubjectLabel(item.subject, t) }}
                                        </v-chip>
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
                                            {{ ContactsRepository.getStatusLabel(item.status, t) }}
                                        </v-chip>
                                    </div>
                                </template>

                                <!-- Message Preview Column -->
                                <template v-slot:item.message="{ item }">
                                    <div class="py-2 pl-4">
                                        <div class="text-caption text-truncate" style="max-width: 300px;">
                                            {{ item.message?.substring(0, 80) }}{{ item.message?.length > 80 ? '...' : '' }}
                                        </div>
                                    </div>
                                </template>

                                <!-- Date Column -->
                                <template v-slot:item.created_at="{ item }">
                                    <div class="py-2 pl-4">
                                        <div class="text-caption">
                                            {{ formatDate(item.created_at) }}
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
                                                    @click="viewContact(item)"
                                                    class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                >
                                                    <v-icon color="primary">mdi-eye</v-icon>
                                                    {{ $t("view") }}
                                                </v-list-item-title>

                                                <v-list-item-title
                                                    v-if="item.status === 'new'"
                                                    @click="markAsRead(item)"
                                                    class="cursor-pointer d-flex gap-3 pb-3"
                                                >
                                                    <v-icon color="info">mdi-email-mark-as-unread</v-icon>
                                                    {{ $t("mark_as_read") }}
                                                </v-list-item-title>

                                                <v-list-item-title
                                                    v-if="item.status !== 'replied'"
                                                    @click="markAsReplied(item)"
                                                    class="cursor-pointer d-flex gap-3 pb-3"
                                                >
                                                    <v-icon color="success">mdi-reply</v-icon>
                                                    {{ $t("mark_as_replied") }}
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
                                :text="t('delete_selected', { count: selectedIds.length })"
                            >
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-main>
            </v-app>
        </div>
    </div>

    <!-- Contact Detail Dialog -->
    <v-dialog v-model="showContactDialog" max-width="800" persistent>
        <v-card v-if="selectedContact">
            <v-card-title class="d-flex justify-space-between align-center">
                <span>{{ $t("contact_details") }}</span>
                <v-btn icon="mdi-close" variant="text" @click="showContactDialog = false"></v-btn>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text class="pt-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-grey-darken-1">{{ $t("name") }}</label>
                        <p class="text-body-1">{{ selectedContact.name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-grey-darken-1">{{ $t("email") }}</label>
                        <p class="text-body-1">
                            <a :href="`mailto:${selectedContact.email}`" class="text-primary">
                                {{ selectedContact.email }}
                            </a>
                        </p>
                    </div>
                    <div v-if="selectedContact.phone">
                        <label class="text-sm font-medium text-grey-darken-1">{{ $t("phone") }}</label>
                        <p class="text-body-1">
                            <a :href="`tel:${selectedContact.phone}`" class="text-primary">
                                {{ selectedContact.phone }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-grey-darken-1">{{ $t("subject") }}</label>
                        <p class="text-body-1">
                            <v-chip size="small" variant="outlined" color="primary">
                                {{ ContactsRepository.getSubjectLabel(selectedContact.subject, t) }}
                            </v-chip>
                        </p>
                    </div>
                    <div v-if="selectedContact.job_title">
                        <label class="text-sm font-medium text-grey-darken-1">{{ $t("job_title") }}</label>
                        <p class="text-body-1">{{ selectedContact.job_title }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-grey-darken-1">{{ $t("message") }}</label>
                        <p class="text-body-1">{{ selectedContact.message }}</p>
                    </div>
                    <div v-if="selectedContact.cover_letter">
                        <label class="text-sm font-medium text-grey-darken-1">{{ $t("cover_letter") }}</label>
                        <p class="text-body-1">{{ selectedContact.cover_letter }}</p>
                    </div>
                    <div v-if="selectedContact.cv_file_path">
                        <label class="text-sm font-medium text-grey-darken-1">{{ $t("cv_resume") }}</label>
                        <p class="text-body-1">
                            <a :href="`/storage/${selectedContact.cv_file_path}`" target="_blank" class="text-primary">
                                {{ $t("download_cv") }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-grey-darken-1">{{ $t("status") }}</label>
                        <p class="text-body-1">
                            <v-chip
                                :color="getStatusColor(selectedContact.status)"
                                size="small"
                                variant="flat"
                            >
                                {{ ContactsRepository.getStatusLabel(selectedContact.status, t) }}
                            </v-chip>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-grey-darken-1">{{ $t("submitted_at") }}</label>
                        <p class="text-body-1">{{ formatDate(selectedContact.created_at) }}</p>
                    </div>
                </div>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="selectedContact.status === 'new'"
                    @click="markAsRead(selectedContact)"
                    color="info"
                >
                    {{ $t("mark_as_read") }}
                </v-btn>
                <v-btn
                    v-if="selectedContact.status !== 'replied'"
                    @click="markAsReplied(selectedContact)"
                    color="success"
                >
                    {{ $t("mark_as_replied") }}
                </v-btn>
                <v-btn
                    @click="showContactDialog = false"
                    variant="outlined"
                >
                    {{ $t("close") }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import Header from '../../components/Header.vue';
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
import { useContactsRepository } from "../../stores/ContactsRepository.js";
import { useAuthRepository } from "../../../stores/Auth.js";

const AuthRepository = useAuthRepository();
const ContactsRepository = useContactsRepository();

const dir = computed(() => {
    return ["fa", "ps"].includes(locale.value) ? "rtl" : "ltr";
});

const selectedStatus = ref('');
const selectedSubject = ref('');
const showContactDialog = ref(false);
const selectedContact = ref(null);

// Computed status options with translations
const statusOptions = computed(() => {
    return ContactsRepository.statusOptionsBase.map(option => ({
        value: option.value,
        label: t(option.labelKey)
    }));
});

// Computed subject options with translations
const subjectOptions = computed(() => {
    return ContactsRepository.subjectOptionsBase.map(option => ({
        value: option.value,
        label: t(option.labelKey)
    }));
});

// Initialize on mount
onMounted(() => {
    ContactsRepository.fetchContacts({
        page: 1,
        itemsPerPage: ContactsRepository.itemsPerPage,
        status: selectedStatus.value,
        type: selectedSubject.value,
    });
});

// Search handling with debounce
let searchTimeout;
const handleSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        ContactsRepository.fetchContacts({
            page: 1,
            itemsPerPage: ContactsRepository.itemsPerPage,
            status: selectedStatus.value,
            subject: selectedSubject.value,
        });
    }, 500);
};

// Status filter handler
const handleStatusFilter = () => {
    ContactsRepository.fetchContacts({
        page: 1,
        itemsPerPage: ContactsRepository.itemsPerPage,
        status: selectedStatus.value,
        type: selectedSubject.value,
    });
};

// Subject filter handler
const handleSubjectFilter = () => {
    ContactsRepository.fetchContacts({
        page: 1,
        itemsPerPage: ContactsRepository.itemsPerPage,
        status: selectedStatus.value,
        type: selectedSubject.value,
    });
};

// Table update handler
const handleTableUpdate = (options) => {
    ContactsRepository.fetchContacts({
        page: options.page,
        itemsPerPage: options.itemsPerPage,
        status: selectedStatus.value,
        type: selectedSubject.value,
    });
};

// Bulk delete functionality
const selectedIds = ref([]);
const sendSelectedIds = () => {
    if (selectedIds.value.length > 0 && confirm(t('confirm_delete_contacts', { count: selectedIds.value.length }))) {
        ContactsRepository.bulkDeleteContacts(selectedIds.value);
        selectedIds.value = [];
    }
};

// View contact details
const viewContact = async (item) => {
    await ContactsRepository.getContact(item.id);
    selectedContact.value = ContactsRepository.currentContact;
    showContactDialog.value = true;
};

const markAsRead = async (item) => {
    await ContactsRepository.markAsRead(item.id);
    if (showContactDialog.value && selectedContact.value?.id === item.id) {
        selectedContact.value.status = 'read';
    }
};

const markAsReplied = async (item) => {
    await ContactsRepository.markAsReplied(item.id);
    if (showContactDialog.value && selectedContact.value?.id === item.id) {
        selectedContact.value.status = 'replied';
    }
};

const deleteItem = async (item) => {
    if (confirm(t('confirm_delete_contact'))) {
        await ContactsRepository.deleteContact(item.id);
        if (showContactDialog.value && selectedContact.value?.id === item.id) {
            showContactDialog.value = false;
            selectedContact.value = null;
        }
    }
};

// Helper function to get status color
const getStatusColor = (status) => {
    switch (status) {
        case 'new': return 'error';
        case 'read': return 'warning';
        case 'replied': return 'success';
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
    { title: t("name"), key: "name", align: "start", sortable: false },
    { title: t("subject"), key: "subject", align: "start", sortable: false },
    { title: t("status"), key: "status", align: "start", sortable: false },
    { title: t("message"), key: "message", align: "start", sortable: false },
    { title: t("created_at"), key: "created_at", align: "start", sortable: false },
    { title: t("action"), key: "action", align: "end", sortable: false },
]);
</script>

<style scoped>
.space-y-4 > * + * {
    margin-top: 1rem;
}
</style>

