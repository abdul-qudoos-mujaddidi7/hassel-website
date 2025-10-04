<template>
  <CRUDTable
    title="Success Stories Management"
    description="Manage success stories and case studies"
    item-name="Success Story"
    endpoint="success-stories"
    :headers="headers"
    :items="adminStore.successStories"
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
              label="Story Title"
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
              label="Story Type"
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
          v-model="formData.content"
          label="Story Content"
          variant="outlined"
          rows="8"
          required
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.person_name"
              label="Person Name"
              variant="outlined"
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

        <v-text-field
          v-model="formData.featured_image"
          label="Featured Image URL"
          variant="outlined"
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.is_public"
              label="Public Story"
              color="primary"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.featured"
              label="Featured Story"
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

    <template #item.person_name="{ item }">
      <div class="text-sm text-gray-900">{{ item.person_name || 'N/A' }}</div>
    </template>

    <template #item.location="{ item }">
      <div class="text-sm text-gray-900">{{ item.location || 'N/A' }}</div>
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
  { title: 'Person', key: 'person_name', sortable: true },
  { title: 'Location', key: 'location', sortable: true },
  { title: 'Status', key: 'status', sortable: true },
  { title: 'Created', key: 'created_at', sortable: true },
  { title: 'Actions', key: 'actions', sortable: false }
];

const statusOptions = [
  { title: 'Draft', value: 'draft' },
  { title: 'Published', value: 'published' },
  { title: 'Archived', value: 'archived' }
];

const typeOptions = [
  { title: 'Farmer Success', value: 'farmer_success' },
  { title: 'Program Impact', value: 'program_impact' },
  { title: 'Innovation', value: 'innovation' },
  { title: 'Community Impact', value: 'community_impact' }
];

const getTypeColor = (type) => {
  const colors = {
    farmer_success: 'green',
    program_impact: 'blue',
    innovation: 'orange',
    community_impact: 'purple'
  };
  return colors[type] || 'gray';
};

const fetchData = async () => {
  await adminStore.fetchSuccessStories();
};

onMounted(() => {
  fetchData();
});
</script>
