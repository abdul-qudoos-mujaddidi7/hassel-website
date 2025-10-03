<template>
  <div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
      <h2 class="text-2xl font-bold text-gray-900 mb-4">System Settings</h2>
      <p class="text-gray-600">Manage system-wide settings and configurations.</p>
    </div>

    <!-- General Settings -->
    <v-card class="p-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">General Settings</h3>
      <v-form @submit.prevent="saveGeneralSettings">
        <div class="space-y-4">
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="settings.siteName"
                label="Site Name"
                variant="outlined"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="settings.siteEmail"
                label="Site Email"
                variant="outlined"
                type="email"
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="settings.contactPhone"
                label="Contact Phone"
                variant="outlined"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="settings.contactAddress"
                label="Contact Address"
                variant="outlined"
              />
            </v-col>
          </v-row>

          <v-textarea
            v-model="settings.siteDescription"
            label="Site Description"
            variant="outlined"
            rows="3"
          />

          <v-btn
            type="submit"
            color="primary"
            :loading="loading"
          >
            Save General Settings
          </v-btn>
        </div>
      </v-form>
    </v-card>

    <!-- Email Settings -->
    <v-card class="p-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Email Settings</h3>
      <v-form @submit.prevent="saveEmailSettings">
        <div class="space-y-4">
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="settings.mailHost"
                label="Mail Host"
                variant="outlined"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="settings.mailPort"
                label="Mail Port"
                variant="outlined"
                type="number"
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="settings.mailUsername"
                label="Mail Username"
                variant="outlined"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="settings.mailPassword"
                label="Mail Password"
                variant="outlined"
                type="password"
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="6">
              <v-select
                v-model="settings.mailEncryption"
                :items="encryptionOptions"
                label="Mail Encryption"
                variant="outlined"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="settings.mailFromAddress"
                label="From Address"
                variant="outlined"
                type="email"
              />
            </v-col>
          </v-row>

          <v-btn
            type="submit"
            color="primary"
            :loading="loading"
          >
            Save Email Settings
          </v-btn>
        </div>
      </v-form>
    </v-card>

    <!-- Security Settings -->
    <v-card class="p-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Security Settings</h3>
      <v-form @submit.prevent="saveSecuritySettings">
        <div class="space-y-4">
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="settings.sessionLifetime"
                label="Session Lifetime (minutes)"
                variant="outlined"
                type="number"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="settings.maxLoginAttempts"
                label="Max Login Attempts"
                variant="outlined"
                type="number"
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="6">
              <v-checkbox
                v-model="settings.requireEmailVerification"
                label="Require Email Verification"
                color="primary"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-checkbox
                v-model="settings.enableTwoFactor"
                label="Enable Two-Factor Authentication"
                color="primary"
              />
            </v-col>
          </v-row>

          <v-btn
            type="submit"
            color="primary"
            :loading="loading"
          >
            Save Security Settings
          </v-btn>
        </div>
      </v-form>
    </v-card>

    <!-- Cache Management -->
    <v-card class="p-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Cache Management</h3>
      <div class="space-y-4">
        <p class="text-sm text-gray-600">
          Clear various caches to improve performance and ensure fresh content.
        </p>
        
        <div class="flex space-x-4">
          <v-btn
            color="orange"
            variant="outlined"
            @click="clearCache('all')"
            :loading="loading"
          >
            Clear All Cache
          </v-btn>
          
          <v-btn
            color="blue"
            variant="outlined"
            @click="clearCache('views')"
            :loading="loading"
          >
            Clear View Cache
          </v-btn>
          
          <v-btn
            color="green"
            variant="outlined"
            @click="clearCache('routes')"
            :loading="loading"
          >
            Clear Route Cache
          </v-btn>
          
          <v-btn
            color="purple"
            variant="outlined"
            @click="clearCache('config')"
            :loading="loading"
          >
            Clear Config Cache
          </v-btn>
        </div>
      </div>
    </v-card>

    <!-- System Information -->
    <v-card class="p-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-2">
          <p class="text-sm text-gray-600">Laravel Version</p>
          <p class="text-sm font-medium text-gray-900">{{ systemInfo.laravelVersion }}</p>
        </div>
        
        <div class="space-y-2">
          <p class="text-sm text-gray-600">PHP Version</p>
          <p class="text-sm font-medium text-gray-900">{{ systemInfo.phpVersion }}</p>
        </div>
        
        <div class="space-y-2">
          <p class="text-sm text-gray-600">Database</p>
          <p class="text-sm font-medium text-gray-900">{{ systemInfo.database }}</p>
        </div>
        
        <div class="space-y-2">
          <p class="text-sm text-gray-600">Server</p>
          <p class="text-sm font-medium text-gray-900">{{ systemInfo.server }}</p>
        </div>
      </div>
    </v-card>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useAdminStore } from '../../stores/AdminStore.js';
import { toast } from 'vue3-toastify';

const adminStore = useAdminStore();
const loading = ref(false);

const settings = ref({
  siteName: '',
  siteEmail: '',
  contactPhone: '',
  contactAddress: '',
  siteDescription: '',
  mailHost: '',
  mailPort: 587,
  mailUsername: '',
  mailPassword: '',
  mailEncryption: 'tls',
  mailFromAddress: '',
  sessionLifetime: 120,
  maxLoginAttempts: 5,
  requireEmailVerification: false,
  enableTwoFactor: false
});

const systemInfo = ref({
  laravelVersion: 'Laravel 10.x',
  phpVersion: 'PHP 8.1+',
  database: 'MySQL/SQLite',
  server: 'Apache/Nginx'
});

const encryptionOptions = [
  { title: 'TLS', value: 'tls' },
  { title: 'SSL', value: 'ssl' },
  { title: 'None', value: '' }
];

const saveGeneralSettings = async () => {
  loading.value = true;
  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 1000));
    toast.success('General settings saved successfully!');
  } catch (error) {
    toast.error('Failed to save general settings');
  } finally {
    loading.value = false;
  }
};

const saveEmailSettings = async () => {
  loading.value = true;
  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 1000));
    toast.success('Email settings saved successfully!');
  } catch (error) {
    toast.error('Failed to save email settings');
  } finally {
    loading.value = false;
  }
};

const saveSecuritySettings = async () => {
  loading.value = true;
  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 1000));
    toast.success('Security settings saved successfully!');
  } catch (error) {
    toast.error('Failed to save security settings');
  } finally {
    loading.value = false;
  }
};

const clearCache = async (type) => {
  loading.value = true;
  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 1000));
    toast.success(`${type} cache cleared successfully!`);
  } catch (error) {
    toast.error(`Failed to clear ${type} cache`);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  // Load settings from API
  // This would typically fetch from the backend
});
</script>
