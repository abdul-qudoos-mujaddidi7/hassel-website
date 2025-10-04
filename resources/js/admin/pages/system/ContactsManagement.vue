<template>
  <CRUDTable
    title="Contacts Management"
    description="Manage contact form submissions and inquiries"
    item-name="Contact"
    endpoint="contacts"
    :headers="headers"
    :items="adminStore.contacts"
    :status-options="statusOptions"
    :type-options="typeOptions"
    @refresh="fetchData"
  >
    <template #form="{ formData, isEditing }">
      <div class="space-y-4">
        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.name"
              label="Name"
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
              v-model="formData.subject"
              label="Subject"
              variant="outlined"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              v-model="formData.type"
              :items="typeOptions"
              label="Inquiry Type"
              variant="outlined"
            />
          </v-col>
        </v-row>

        <v-textarea
          v-model="formData.message"
          label="Message"
          variant="outlined"
          rows="6"
          required
        />

        <v-textarea
          v-model="formData.admin_notes"
          label="Admin Notes"
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

    <template #item.subject="{ item }">
      <div class="text-sm text-gray-900 truncate max-w-xs">
        {{ item.subject || 'No subject' }}
      </div>
    </template>

    <template #item.message="{ item }">
      <div class="text-sm text-gray-900 truncate max-w-xs">
        {{ item.message }}
      </div>
    </template>

    <template #item.type="{ item }">
      <v-chip
        :color="getTypeColor(item.type)"
        size="small"
      >
        {{ item.type || 'General' }}
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
  </CRUDTable>
</template>

<script setup>
import { onMounted } from 'vue';
import { useAdminStore } from '../../stores/AdminStore.js';
import CRUDTable from '../../components/CRUDTable.vue';

const adminStore = useAdminStore();

const headers = [
  { title: 'Contact', key: 'name', sortable: true },
  { title: 'Subject', key: 'subject', sortable: true },
  { title: 'Message', key: 'message', sortable: false },
  { title: 'Type', key: 'type', sortable: true },
  { title: 'Status', key: 'status', sortable: true },
  { title: 'Created', key: 'created_at', sortable: true },
  { title: 'Actions', key: 'actions', sortable: false }
];

const statusOptions = [
  { title: 'New', value: 'new' },
  { title: 'Read', value: 'read' },
  { title: 'Replied', value: 'replied' },
  { title: 'Closed', value: 'closed' }
];

const typeOptions = [
  { title: 'General Inquiry', value: 'general' },
  { title: 'Program Information', value: 'program' },
  { title: 'Partnership', value: 'partnership' },
  { title: 'Support', value: 'support' },
  { title: 'Feedback', value: 'feedback' }
];

const getTypeColor = (type) => {
  const colors = {
    general: 'blue',
    program: 'green',
    partnership: 'purple',
    support: 'orange',
    feedback: 'pink'
  };
  return colors[type] || 'gray';
};

const getStatusColor = (status) => {
  const colors = {
    new: 'blue',
    read: 'green',
    replied: 'orange',
    closed: 'gray'
  };
  return colors[status] || 'gray';
};

const fetchData = async () => {
  await adminStore.fetchContacts();
};

onMounted(() => {
  fetchData();
});
</script>
