<template>
  <v-app>
    <router-view />
  </v-app>
</template>

<script setup>
import { onMounted } from 'vue';
import { useAuthRepository } from '../stores/Auth.js';

const authStore = useAuthRepository();

onMounted(() => {
  // Load user session on app start
  authStore.loadFromSession();
});
</script>

<style scoped>
/* Admin app specific styles */
</style>
