<template>
  <CRUDTable
    title="Publications Management"
    description="Manage publications and documents"
    item-name="Publication"
    endpoint="publications"
    :headers="headers"
    :items="adminStore.publications"
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
              label="Publication Title"
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
              label="Publication Type"
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

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.author"
              label="Author"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.publisher"
              label="Publisher"
              variant="outlined"
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.publication_date"
              label="Publication Date"
              type="date"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.language"
              label="Language"
              variant="outlined"
            />
          </v-col>
        </v-row>

        <v-text-field
          v-model="formData.file_url"
          label="File URL"
          variant="outlined"
        />

        <v-text-field
          v-model="formData.featured_image"
          label="Featured Image URL"
          variant="outlined"
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.is_public"
              label="Public Publication"
              color="primary"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.featured"
              label="Featured Publication"
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

    <template #item.author="{ item }">
      <div class="text-sm text-gray-900">{{ item.author || 'N/A' }}</div>
    </template>

    <template #item.publication_date="{ item }">
      <div class="text-sm text-gray-900">{{ formatDate(item.publication_date) }}</div>
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
  { title: 'Author', key: 'author', sortable: true },
  { title: 'Publication Date', key: 'publication_date', sortable: true },
  { title: 'Language', key: 'language', sortable: true },
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
  { title: 'Research Paper', value: 'research_paper' },
  { title: 'Report', value: 'report' },
  { title: 'Guide', value: 'guide' },
  { title: 'Manual', value: 'manual' },
  { title: 'Brochure', value: 'brochure' }
];

const getTypeColor = (type) => {
  const colors = {
    research_paper: 'blue',
    report: 'green',
    guide: 'orange',
    manual: 'purple',
    brochure: 'pink'
  };
  return colors[type] || 'gray';
};

const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  return new Date(dateString).toLocaleDateString();
};

const fetchData = async () => {
  await adminStore.fetchPublications();
};

onMounted(() => {
  fetchData();
});
</script>
