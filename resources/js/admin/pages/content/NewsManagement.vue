<template>
  <CRUDTable
    title="News Management"
    description="Manage news articles and announcements"
    item-name="News Article"
    endpoint="news"
    :headers="headers"
    :items="adminStore.news"
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
              label="Title"
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
            <v-text-field
              v-model="formData.author"
              label="Author"
              variant="outlined"
            />
          </v-col>
        </v-row>

        <v-textarea
          v-model="formData.excerpt"
          label="Excerpt"
          variant="outlined"
          rows="3"
          hint="Brief description of the article"
        />

        <v-textarea
          v-model="formData.content"
          label="Content"
          variant="outlined"
          rows="10"
          required
          :rules="[v => !!v || 'Content is required']"
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.featured_image"
              label="Featured Image URL"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.tags"
              label="Tags (comma separated)"
              variant="outlined"
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.featured"
              label="Featured Article"
              color="primary"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.published"
              label="Published"
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
            {{ item.excerpt }}
          </p>
        </div>
      </div>
    </template>

    <template #item.author="{ item }">
      <div class="text-sm text-gray-900">{{ item.author || 'N/A' }}</div>
    </template>

    <template #item.featured="{ item }">
      <v-chip
        :color="item.featured ? 'green' : 'gray'"
        size="small"
      >
        {{ item.featured ? 'Yes' : 'No' }}
      </v-chip>
    </template>

    <template #item.tags="{ item }">
      <div class="flex flex-wrap gap-1">
        <v-chip
          v-for="tag in (item.tags || '').split(',').filter(t => t.trim())"
          :key="tag"
          size="x-small"
          color="blue"
          variant="outlined"
        >
          {{ tag.trim() }}
        </v-chip>
      </div>
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
  { title: 'Author', key: 'author', sortable: true },
  { title: 'Status', key: 'status', sortable: true },
  { title: 'Featured', key: 'featured', sortable: true },
  { title: 'Tags', key: 'tags', sortable: false },
  { title: 'Created', key: 'created_at', sortable: true },
  { title: 'Actions', key: 'actions', sortable: false }
];

const statusOptions = [
  { title: 'Draft', value: 'draft' },
  { title: 'Published', value: 'published' },
  { title: 'Archived', value: 'archived' }
];

const typeOptions = [
  { title: 'News', value: 'news' },
  { title: 'Announcement', value: 'announcement' },
  { title: 'Update', value: 'update' }
];

const fetchData = async () => {
  await adminStore.fetchNews();
};

onMounted(() => {
  fetchData();
});
</script>

<style scoped>
/* Additional styles if needed */
</style>
