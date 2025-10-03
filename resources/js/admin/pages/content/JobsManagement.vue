<template>
  <CRUDTable
    title="Job Announcements Management"
    description="Manage job announcements and career opportunities"
    item-name="Job Announcement"
    endpoint="jobs"
    :headers="headers"
    :items="adminStore.jobs"
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
              label="Job Title"
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
              label="Job Type"
              variant="outlined"
              required
            />
          </v-col>
        </v-row>

        <v-textarea
          v-model="formData.description"
          label="Job Description"
          variant="outlined"
          rows="4"
          required
        />

        <v-textarea
          v-model="formData.requirements"
          label="Requirements"
          variant="outlined"
          rows="3"
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.location"
              label="Location"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.department"
              label="Department"
              variant="outlined"
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.salary_range"
              label="Salary Range"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.experience_level"
              label="Experience Level"
              variant="outlined"
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.application_deadline"
              label="Application Deadline"
              type="date"
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
              label="Active Job"
              color="primary"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.featured"
              label="Featured Job"
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

    <template #item.location="{ item }">
      <div class="text-sm text-gray-900">{{ item.location || 'N/A' }}</div>
    </template>

    <template #item.salary_range="{ item }">
      <div class="text-sm text-gray-900">{{ item.salary_range || 'N/A' }}</div>
    </template>

    <template #item.application_deadline="{ item }">
      <div class="text-sm text-gray-900">{{ formatDate(item.application_deadline) }}</div>
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
  { title: 'Location', key: 'location', sortable: true },
  { title: 'Salary Range', key: 'salary_range', sortable: true },
  { title: 'Deadline', key: 'application_deadline', sortable: true },
  { title: 'Status', key: 'status', sortable: true },
  { title: 'Created', key: 'created_at', sortable: true },
  { title: 'Actions', key: 'actions', sortable: false }
];

const statusOptions = [
  { title: 'Draft', value: 'draft' },
  { title: 'Active', value: 'active' },
  { title: 'Closed', value: 'closed' },
  { title: 'Archived', value: 'archived' }
];

const typeOptions = [
  { title: 'Full-time', value: 'full_time' },
  { title: 'Part-time', value: 'part_time' },
  { title: 'Contract', value: 'contract' },
  { title: 'Internship', value: 'internship' }
];

const getTypeColor = (type) => {
  const colors = {
    full_time: 'green',
    part_time: 'blue',
    contract: 'orange',
    internship: 'purple'
  };
  return colors[type] || 'gray';
};

const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  return new Date(dateString).toLocaleDateString();
};

const fetchData = async () => {
  await adminStore.fetchJobs();
};

onMounted(() => {
  fetchData();
});
</script>
