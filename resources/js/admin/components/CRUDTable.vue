<template>
  <div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ title }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ description }}</p>
      </div>
      <div class="mt-4 sm:mt-0">
        <v-btn
          color="primary"
          @click="openCreateDialog"
          prepend-icon="mdi-plus"
        >
          Add {{ itemName }}
        </v-btn>
      </div>
    </div>

    <!-- Filters and Search -->
    <v-card class="p-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <v-text-field
          v-model="searchQuery"
          label="Search"
          prepend-inner-icon="mdi-magnify"
          variant="outlined"
          density="compact"
          @input="handleSearch"
          clearable
        />
        
        <v-select
          v-model="statusFilter"
          :items="statusOptions"
          label="Status"
          variant="outlined"
          density="compact"
          clearable
          @update:model-value="handleFilter"
        />
        
        <v-select
          v-model="typeFilter"
          :items="typeOptions"
          label="Type"
          variant="outlined"
          density="compact"
          clearable
          @update:model-value="handleFilter"
        />
        
        <v-btn
          variant="outlined"
          @click="resetFilters"
          prepend-icon="mdi-refresh"
        >
          Reset
        </v-btn>
      </div>
    </v-card>

    <!-- Data Table -->
    <v-card>
      <v-data-table
        :headers="headers"
        :items="items"
        :loading="loading"
        :items-per-page="pagination.perPage"
        :page="pagination.currentPage"
        :server-items-length="pagination.total"
        @update:page="handlePageChange"
        @update:items-per-page="handlePerPageChange"
        class="admin-table"
      >
        <!-- Custom slots for specific columns -->
        <template v-for="slot in Object.keys($slots)" :key="slot" #[slot]="props">
          <slot :name="slot" v-bind="props"></slot>
        </template>

        <!-- Actions column -->
        <template #item.actions="{ item }">
          <div class="flex space-x-2">
            <v-btn
              icon
              size="small"
              variant="text"
              @click="editItem(item)"
            >
              <v-icon>mdi-pencil</v-icon>
            </v-btn>
            
            <v-btn
              icon
              size="small"
              variant="text"
              color="error"
              @click="deleteItem(item)"
            >
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </div>
        </template>

        <!-- Status column -->
        <template #item.status="{ item }">
          <v-chip
            :color="getStatusColor(item.status)"
            size="small"
          >
            {{ item.status }}
          </v-chip>
        </template>

        <!-- Date columns -->
        <template #item.created_at="{ item }">
          {{ formatDate(item.created_at) }}
        </template>

        <template #item.updated_at="{ item }">
          {{ formatDate(item.updated_at) }}
        </template>
      </v-data-table>
    </v-card>

    <!-- Create/Edit Dialog -->
    <v-dialog v-model="dialog" max-width="800px" persistent>
      <v-card>
        <v-card-title>
          <span class="text-h5">{{ isEditing ? 'Edit' : 'Create' }} {{ itemName }}</span>
        </v-card-title>
        
        <v-card-text>
          <v-form ref="formRef" v-model="formValid">
            <slot name="form" :form-data="formData" :is-editing="isEditing"></slot>
          </v-form>
        </v-card-text>
        
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="grey"
            variant="text"
            @click="closeDialog"
          >
            Cancel
          </v-btn>
          <v-btn
            color="primary"
            :loading="loading"
            :disabled="!formValid"
            @click="saveItem"
          >
            {{ isEditing ? 'Update' : 'Create' }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Delete Confirmation Dialog -->
    <v-dialog v-model="deleteDialog" max-width="400px">
      <v-card>
        <v-card-title class="text-h5">Confirm Delete</v-card-title>
        <v-card-text>
          Are you sure you want to delete this {{ itemName.toLowerCase() }}? This action cannot be undone.
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="grey"
            variant="text"
            @click="deleteDialog = false"
          >
            Cancel
          </v-btn>
          <v-btn
            color="error"
            :loading="loading"
            @click="confirmDelete"
          >
            Delete
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { useAdminStore } from '../stores/AdminStore.js';

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  description: {
    type: String,
    default: ''
  },
  itemName: {
    type: String,
    required: true
  },
  endpoint: {
    type: String,
    required: true
  },
  headers: {
    type: Array,
    required: true
  },
  items: {
    type: Array,
    default: () => []
  },
  statusOptions: {
    type: Array,
    default: () => []
  },
  typeOptions: {
    type: Array,
    default: () => []
  },
  formFields: {
    type: Array,
    default: () => []
  }
});

const emit = defineEmits(['refresh', 'item-created', 'item-updated', 'item-deleted']);

const adminStore = useAdminStore();
const formRef = ref(null);
const formValid = ref(false);
const dialog = ref(false);
const deleteDialog = ref(false);
const isEditing = ref(false);
const selectedItem = ref(null);
const searchQuery = ref('');
const statusFilter = ref(null);
const typeFilter = ref(null);

const formData = ref({});
const loading = computed(() => adminStore.loading);
const pagination = computed(() => adminStore.pagination);

const handleSearch = () => {
  adminStore.setSearch(searchQuery.value);
  fetchData();
};

const handleFilter = () => {
  adminStore.setFilters({
    status: statusFilter.value,
    type: typeFilter.value
  });
  fetchData();
};

const resetFilters = () => {
  searchQuery.value = '';
  statusFilter.value = null;
  typeFilter.value = null;
  adminStore.resetFilters();
  fetchData();
};

const handlePageChange = (page) => {
  adminStore.setPagination(page);
  fetchData();
};

const handlePerPageChange = (perPage) => {
  adminStore.setPerPage(perPage);
  fetchData();
};

const fetchData = async () => {
  await adminStore.fetchData(props.endpoint, props.endpoint.replace('-', ''));
};

const openCreateDialog = () => {
  isEditing.value = false;
  selectedItem.value = null;
  formData.value = {};
  dialog.value = true;
};

const editItem = (item) => {
  isEditing.value = true;
  selectedItem.value = item;
  formData.value = { ...item };
  dialog.value = true;
};

const saveItem = async () => {
  if (!formValid.value) return;
  
  try {
    if (isEditing.value) {
      await adminStore.updateItem(props.endpoint, selectedItem.value.id, formData.value);
      emit('item-updated', selectedItem.value);
    } else {
      await adminStore.createItem(props.endpoint, formData.value);
      emit('item-created');
    }
    
    closeDialog();
    fetchData();
    emit('refresh');
  } catch (error) {
    console.error('Error saving item:', error);
  }
};

const deleteItem = (item) => {
  selectedItem.value = item;
  deleteDialog.value = true;
};

const confirmDelete = async () => {
  try {
    await adminStore.deleteItem(props.endpoint, selectedItem.value.id);
    emit('item-deleted', selectedItem.value);
    deleteDialog.value = false;
    fetchData();
    emit('refresh');
  } catch (error) {
    console.error('Error deleting item:', error);
  }
};

const closeDialog = () => {
  dialog.value = false;
  isEditing.value = false;
  selectedItem.value = null;
  formData.value = {};
  if (formRef.value) {
    formRef.value.reset();
  }
};

const getStatusColor = (status) => {
  const colors = {
    active: 'green',
    published: 'green',
    inactive: 'red',
    draft: 'yellow',
    pending: 'orange',
    read: 'green',
    unread: 'blue'
  };
  return colors[status] || 'gray';
};

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString();
};

// Watch for changes in admin store data
watch(() => adminStore[props.endpoint.replace('-', '')], (newData) => {
  emit('refresh');
}, { deep: true });
</script>

<style scoped>
.admin-table {
  @apply bg-white rounded-lg shadow-sm;
}
</style>
