<template>
  <CRUDTable
    title="Users Management"
    description="Manage system users and administrators"
    item-name="User"
    endpoint="users"
    :headers="headers"
    :items="adminStore.users"
    :status-options="statusOptions"
    :type-options="roleOptions"
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
              v-model="formData.role"
              :items="roleOptions"
              label="Role"
              variant="outlined"
              required
            />
          </v-col>
        </v-row>

        <v-row v-if="!isEditing">
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.password"
              label="Password"
              :rules="[v => !!v || 'Password is required', v => (v && v.length >= 6) || 'Password must be at least 6 characters']"
              required
              variant="outlined"
              type="password"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.password_confirmation"
              label="Confirm Password"
              :rules="[v => !!v || 'Password confirmation is required', v => v === formData.password || 'Passwords do not match']"
              required
              variant="outlined"
              type="password"
            />
          </v-col>
        </v-row>

        <v-textarea
          v-model="formData.bio"
          label="Bio"
          variant="outlined"
          rows="3"
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="formData.position"
              label="Position"
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

        <v-text-field
          v-model="formData.avatar"
          label="Avatar URL"
          variant="outlined"
        />

        <v-row>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.is_active"
              label="Active User"
              color="primary"
            />
          </v-col>
          <v-col cols="12" md="6">
            <v-checkbox
              v-model="formData.email_verified"
              label="Email Verified"
              color="primary"
            />
          </v-col>
        </v-row>
      </div>
    </template>

    <template #item.name="{ item }">
      <div class="flex items-center space-x-3">
        <div v-if="item.avatar" class="flex-shrink-0">
          <img
            :src="item.avatar"
            :alt="item.name"
            class="w-10 h-10 rounded-full object-cover"
          />
        </div>
        <div class="min-w-0 flex-1">
          <p class="text-sm font-medium text-gray-900 truncate">
            {{ item.name }}
          </p>
          <p class="text-xs text-gray-500 truncate">
            {{ item.email }}
          </p>
        </div>
      </div>
    </template>

    <template #item.role="{ item }">
      <v-chip
        :color="getRoleColor(item.role)"
        size="small"
      >
        {{ item.role }}
      </v-chip>
    </template>

    <template #item.is_active="{ item }">
      <v-chip
        :color="item.is_active ? 'green' : 'red'"
        size="small"
      >
        {{ item.is_active ? 'Active' : 'Inactive' }}
      </v-chip>
    </template>

    <template #item.email_verified="{ item }">
      <v-chip
        :color="item.email_verified ? 'green' : 'orange'"
        size="small"
      >
        {{ item.email_verified ? 'Verified' : 'Unverified' }}
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
  { title: 'User', key: 'name', sortable: true },
  { title: 'Role', key: 'role', sortable: true },
  { title: 'Position', key: 'position', sortable: true },
  { title: 'Department', key: 'department', sortable: true },
  { title: 'Status', key: 'is_active', sortable: true },
  { title: 'Verified', key: 'email_verified', sortable: true },
  { title: 'Created', key: 'created_at', sortable: true },
  { title: 'Actions', key: 'actions', sortable: false }
];

const statusOptions = [
  { title: 'Active', value: 'active' },
  { title: 'Inactive', value: 'inactive' },
  { title: 'Suspended', value: 'suspended' }
];

const roleOptions = [
  { title: 'Admin', value: 'admin' },
  { title: 'Editor', value: 'editor' },
  { title: 'Author', value: 'author' },
  { title: 'Viewer', value: 'viewer' }
];

const getRoleColor = (role) => {
  const colors = {
    admin: 'red',
    editor: 'blue',
    author: 'green',
    viewer: 'gray'
  };
  return colors[role] || 'gray';
};

const fetchData = async () => {
  await adminStore.fetchUsers();
};

onMounted(() => {
  fetchData();
});
</script>
