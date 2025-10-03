<template>
  <CRUDTable
    title="Program Registrations Management"
    description="Manage program registrations and applications"
    item-name="Registration"
    endpoint="registrations"
    :headers="headers"
    :items="adminStore.registrations"
    :status-options="statusOptions"
    :type-options="programTypeOptions"
    @refresh="fetchData"
  >
    <template #form="{ formData, isEditing }">
      <div class="space-y-4">
        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.name"
              label="Full Name"
              :rules="[v => !!v || 'Name is required']"
              required
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.email"
              label="Email"
              :rules="[v => !!v || 'Email is required', v => /.+@.+\..+/.test(v) || 'Email must be valid']"
              required
              variant="outlined"
              type="email"
            />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.phone"
              label="Phone Number"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
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
              v-model="formData.program_name"
              label="Program Name"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              v-model="formData.program_type"
              :items="programTypeOptions"
              label="Program Type"
              variant="outlined"
            />
          </v-col>
        </v-row>

        <v-textarea
          v-model="formData.motivation"
          label="Motivation/Interest"
          variant="outlined"
          rows="4"
        />

        <v-textarea
          v-model="formData.experience"
          label="Relevant Experience"
          variant="outlined"
          rows="3"
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.organization"
              label="Organization"
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

        <v-textarea
          v-model="formData.admin_notes"
          label="Admin Notes"
          variant="outlined"
          rows="3"
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.registration_date"
              label="Registration Date"
              type="date"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.preferred_contact_method"
              label="Preferred Contact Method"
              variant="outlined"
            />
          </v-col>
        </v-row>
      </div>
    </template>

    <template #item.name="{ item }">
      <div class="min-w-0 flex-1">
        <p class="text-sm font-medium text-gray-900 truncate">
          {{ item.name }}
        </p>
        <p class="text-xs text-gray-500 truncate">
          {{ item.email }}
        </p>
      </div>
    </template>

    <template #item.program_name="{ item }">
      <div class="text-sm text-gray-900 truncate max-w-xs">
        {{ item.program_name || 'N/A' }}
      </div>
    </template>

    <template #item.program_type="{ item }">
      <v-chip
        :color="getProgramTypeColor(item.program_type)"
        size="small"
      >
        {{ item.program_type || 'N/A' }}
      </v-chip>
    </template>

    <template #item.status="{ item }">
      <v-chip
        :color="getStatusColor(item.status)"
        size="small"
      >
        {{ item.status }}
      </v-chip>
    </template>

    <template #item.registration_date="{ item }">
      <div class="text-sm text-gray-900">{{ formatDate(item.registration_date) }}</div>
    </template>
  </CRUDTable>
</template>

<script setup>
import { onMounted } from 'vue';
import { useAdminStore } from '../../stores/AdminStore.js';
import CRUDTable from '../../components/CRUDTable.vue';

const adminStore = useAdminStore();

const headers = [
  { title: 'Registrant', key: 'name', sortable: true },
  { title: 'Program', key: 'program_name', sortable: true },
  { title: 'Type', key: 'program_type', sortable: true },
  { title: 'Status', key: 'status', sortable: true },
  { title: 'Registration Date', key: 'registration_date', sortable: true },
  { title: 'Location', key: 'location', sortable: true },
  { title: 'Created', key: 'created_at', sortable: true },
  { title: 'Actions', key: 'actions', sortable: false }
];

const statusOptions = [
  { title: 'Pending', value: 'pending' },
  { title: 'Approved', value: 'approved' },
  { title: 'Rejected', value: 'rejected' },
  { title: 'Waitlisted', value: 'waitlisted' },
  { title: 'Completed', value: 'completed' }
];

const programTypeOptions = [
  { title: 'Training Program', value: 'training' },
  { title: 'Market Access', value: 'market_access' },
  { title: 'Smart Farming', value: 'smart_farming' },
  { title: 'Seed Supply', value: 'seed_supply' },
  { title: 'Community Program', value: 'community' },
  { title: 'Environmental Project', value: 'environmental' }
];

const getProgramTypeColor = (type) => {
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

const getStatusColor = (status) => {
  const colors = {
    pending: 'yellow',
    approved: 'green',
    rejected: 'red',
    waitlisted: 'orange',
    completed: 'blue'
  };
  return colors[status] || 'gray';
};

const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  return new Date(dateString).toLocaleDateString();
};

const fetchData = async () => {
  await adminStore.fetchRegistrations();
};

onMounted(() => {
  fetchData();
});
</script>
