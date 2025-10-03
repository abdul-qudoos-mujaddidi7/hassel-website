<template>
  <CRUDTable
    title="Agri-Tech Tools Management"
    description="Manage agricultural technology tools and resources"
    item-name="Agri-Tech Tool"
    endpoint="agri-tech-tools"
    :headers="headers"
    :items="adminStore.agriTechTools"
    :status-options="statusOptions"
    :type-options="typeOptions"
    @refresh="fetchData"
  >
    <template #form="{ formData, isEditing }">
      <div class="space-y-4">
        <v-row>
          <v-col cols="12" md="8">
            <v-text-field
              v-model="formData.title"
              label="Tool Title"
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
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              v-model="formData.type"
              :items="typeOptions"
              label="Tool Type"
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
        />

        <v-textarea
          v-model="formData.features"
          label="Key Features"
          variant="outlined"
          rows="3"
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.platform"
              label="Platform"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.developer"
              label="Developer/Company"
              variant="outlined"
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.website_url"
              label="Website URL"
              variant="outlined"
              type="url"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.download_url"
              label="Download URL"
              variant="outlined"
              type="url"
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
              v-model="formData.is_free"
              label="Free Tool"
              color="primary"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.featured"
              label="Featured Tool"
              color="primary"
            />
          </v-col>
        </v-row>
      </div>
    </template>

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

    <template #item.platform="{ item }">
      <div class="text-sm text-gray-900">{{ item.platform || 'N/A' }}</div>
    </template>

    <template #item.is_free="{ item }">
      <v-chip
        :color="item.is_free ? 'green' : 'blue'"
        size="small"
      >
        {{ item.is_free ? 'Free' : 'Paid' }}
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
  { title: 'Platform', key: 'platform', sortable: true },
  { title: 'Developer', key: 'developer', sortable: true },
  { title: 'Free/Paid', key: 'is_free', sortable: true },
  { title: 'Status', key: 'status', sortable: true },
  { title: 'Created', key: 'created_at', sortable: true },
  { title: 'Actions', key: 'actions', sortable: false }
];

const statusOptions = [
  { title: 'Draft', value: 'draft' },
  { title: 'Active', value: 'active' },
  { title: 'Archived', value: 'archived' }
];

const typeOptions = [
  { title: 'Mobile App', value: 'mobile_app' },
  { title: 'Web Application', value: 'web_app' },
  { title: 'Desktop Software', value: 'desktop' },
  { title: 'Hardware Tool', value: 'hardware' },
  { title: 'API Service', value: 'api' }
];

const getTypeColor = (type) => {
  const colors = {
    mobile_app: 'blue',
    web_app: 'green',
    desktop: 'orange',
    hardware: 'purple',
    api: 'pink'
  };
  return colors[type] || 'gray';
};

const fetchData = async () => {
  await adminStore.fetchAgriTechTools();
};

onMounted(() => {
  fetchData();
});
</script>
