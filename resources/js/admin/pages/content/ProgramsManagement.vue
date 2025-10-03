<template>
  <CRUDTable
    title="Programs Management"
    description="Manage all programs and initiatives"
    item-name="Program"
    endpoint="programs"
    :headers="headers"
    :items="adminStore.programs"
    :status-options="statusOptions"
    :type-options="typeOptions"
    @refresh="fetchData"
  >
    <!-- Custom form slot -->
    <template #form="{ formData, isEditing }">
      <div class="space-y-4">
        <v-row>
          <v-col cols="12" md="8">
            <v-text-field
              v-model="formData.title"
              label="Program Title"
              :rules="[v => !!v || 'Title is required']"
              required
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="4">
            <v-select
              v-model="formData.status"
              :items="statusOptions"
              label="Status"
              variant="outlined"
              required
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.slug"
              label="Slug"
              variant="outlined"
              hint="Leave empty to auto-generate from title"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              v-model="formData.type"
              :items="typeOptions"
              label="Program Type"
              variant="outlined"
              required
            />
          </v-col>
        </v-row>

        <v-textarea
          v-model="formData.description"
          label="Description"
          variant="outlined"
          rows="4"
          required
          :rules="[v => !!v || 'Description is required']"
        />

        <v-textarea
          v-model="formData.objectives"
          label="Objectives"
          variant="outlined"
          rows="3"
          hint="List the main objectives of this program"
        />

        <v-textarea
          v-model="formData.eligibility"
          label="Eligibility Criteria"
          variant="outlined"
          rows="3"
          hint="Who is eligible for this program"
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.duration"
              label="Duration"
              variant="outlined"
              hint="e.g., 6 months, 1 year"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.location"
              label="Location"
              variant="outlined"
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.contact_person"
              label="Contact Person"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.contact_email"
              label="Contact Email"
              variant="outlined"
              type="email"
            />
          </v-col>
        </v-row>

        <v-text-field
          v-model="formData.featured_image"
          label="Featured Image URL"
          variant="outlined"
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.is_active"
              label="Active Program"
              color="primary"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.featured"
              label="Featured Program"
              color="primary"
            />
          </v-col>
        </v-row>
      </div>
    </template>

    <!-- Custom table slots -->
    <template #item.title="{ item }">
      <div class="flex items-center space-x-3">
        <div v-if="item.featured_image" class="flex-shrink-0">
          <img
            :src="item.featured_image"
            :alt="item.title"
            class="w-12 h-12 rounded object-cover"
          />
        </div>
        <div class="min-w-0 flex-1">
          <p class="text-sm font-medium text-gray-900 truncate">
            {{ item.title }}
          </p>
          <p class="text-xs text-gray-500 truncate">
            {{ item.description }}
          </p>
        </div>
      </div>
    </template>

    <template #item.type="{ item }">
      <v-chip
        :color="getTypeColor(item.type)"
        size="small"
      >
        {{ item.type }}
      </v-chip>
    </template>

    <template #item.duration="{ item }">
      <div class="text-sm text-gray-900">{{ item.duration || 'N/A' }}</div>
    </template>

    <template #item.location="{ item }">
      <div class="text-sm text-gray-900">{{ item.location || 'N/A' }}</div>
    </template>

    <template #item.is_active="{ item }">
      <v-chip
        :color="item.is_active ? 'green' : 'red'"
        size="small"
      >
        {{ item.is_active ? 'Active' : 'Inactive' }}
      </v-chip>
    </template>
  </CRUDTable>
</template>

<script setup>
import { onMounted } from 'vue';
import { useAdminStore } from '../../stores/AdminStore.js';
import CRUDTable from '../../components/CRUDTable.vue';

const adminStore = useAdminStore();

const headers = [
  { title: 'Title', key: 'title', sortable: true },
  { title: 'Type', key: 'type', sortable: true },
  { title: 'Status', key: 'status', sortable: true },
  { title: 'Duration', key: 'duration', sortable: true },
  { title: 'Location', key: 'location', sortable: true },
  { title: 'Active', key: 'is_active', sortable: true },
  { title: 'Created', key: 'created_at', sortable: true },
  { title: 'Actions', key: 'actions', sortable: false }
];

const statusOptions = [
  { title: 'Draft', value: 'draft' },
  { title: 'Active', value: 'active' },
  { title: 'Completed', value: 'completed' },
  { title: 'Archived', value: 'archived' }
];

const typeOptions = [
  { title: 'Training Program', value: 'training' },
  { title: 'Market Access', value: 'market_access' },
  { title: 'Smart Farming', value: 'smart_farming' },
  { title: 'Seed Supply', value: 'seed_supply' },
  { title: 'Community Program', value: 'community' },
  { title: 'Environmental Project', value: 'environmental' }
];

const getTypeColor = (type) => {
  const colors = {
    training: 'blue',
    market_access: 'green',
    smart_farming: 'orange',
    seed_supply: 'purple',
    community: 'pink',
    environmental: 'teal'
  };
  return colors[type] || 'gray';
};

const fetchData = async () => {
  await adminStore.fetchPrograms();
};

onMounted(() => {
  fetchData();
});
</script>

<style scoped>
/* Additional styles if needed */
</style>
