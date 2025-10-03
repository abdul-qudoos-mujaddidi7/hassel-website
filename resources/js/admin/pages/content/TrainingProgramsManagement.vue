<template>
  <CRUDTable
    title="Training Programs Management"
    description="Manage training programs and courses"
    item-name="Training Program"
    endpoint="training-programs"
    :headers="headers"
    :items="adminStore.trainingPrograms"
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
        />

        <v-textarea
          v-model="formData.objectives"
          label="Learning Objectives"
          variant="outlined"
          rows="3"
        />

        <v-row>
          <v-col cols="12" md="4">
            <v-text-field
              v-model="formData.duration"
              label="Duration"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field
              v-model="formData.max_participants"
              label="Max Participants"
              variant="outlined"
              type="number"
            />
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field
              v-model="formData.cost"
              label="Cost"
              variant="outlined"
            />
          </v-col>
        </v-row>

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
              v-model="formData.instructor"
              label="Instructor"
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
              v-model="formData.is_active"
              label="Active Program"
              color="primary"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.registration_open"
              label="Registration Open"
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

    <template #item.duration="{ item }">
      <div class="text-sm text-gray-900">{{ item.duration || 'N/A' }}</div>
    </template>

    <template #item.cost="{ item }">
      <div class="text-sm text-gray-900">{{ item.cost || 'Free' }}</div>
    </template>

    <template #item.registration_open="{ item }">
      <v-chip
        :color="item.registration_open ? 'green' : 'red'"
        size="small"
      >
        {{ item.registration_open ? 'Open' : 'Closed' }}
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
  { title: 'Cost', key: 'cost', sortable: true },
  { title: 'Registration', key: 'registration_open', sortable: true },
  { title: 'Created', key: 'created_at', sortable: true },
  { title: 'Actions', key: 'actions', sortable: false }
];

const statusOptions = [
  { title: 'Draft', value: 'draft' },
  { title: 'Active', value: 'active' },
  { title: 'Completed', value: 'completed' },
  { title: 'Cancelled', value: 'cancelled' }
];

const typeOptions = [
  { title: 'Workshop', value: 'workshop' },
  { title: 'Course', value: 'course' },
  { title: 'Seminar', value: 'seminar' },
  { title: 'Training', value: 'training' }
];

const getTypeColor = (type) => {
  const colors = {
    workshop: 'blue',
    course: 'green',
    seminar: 'orange',
    training: 'purple'
  };
  return colors[type] || 'gray';
};

const fetchData = async () => {
  await adminStore.fetchTrainingPrograms();
};

onMounted(() => {
  fetchData();
});
</script>
