<template>
  <header class="admin-header">
    <div class="admin-header__content">
      <div class="admin-header__brand">
        <h1>Admin Dashboard</h1>
      </div>
      
      <div class="admin-header__user">
        <span v-if="user" class="admin-header__welcome">
          Welcome, {{ user.name || user.email }}
        </span>
        <button 
          @click="handleLogout" 
          class="admin-header__logout"
          :disabled="loading"
        >
          {{ loading ? 'Signing out...' : 'Logout' }}
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { useAuth } from '../../composables/useAuth.js';

const { user, loading, logout } = useAuth();

const handleLogout = async () => {
  await logout();
};
</script>

<style scoped>
.admin-header {
  background: #1f2937;
  color: white;
  padding: 1rem 2rem;
  border-bottom: 1px solid #374151;
}

.admin-header__content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
}

.admin-header__brand h1 {
  margin: 0;
  font-size: 1.5rem;
  font-weight: 600;
}

.admin-header__user {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.admin-header__welcome {
  color: #d1d5db;
}

.admin-header__logout {
  background: #dc2626;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  cursor: pointer;
  font-size: 0.875rem;
  transition: background-color 0.2s;
}

.admin-header__logout:hover:not(:disabled) {
  background: #b91c1c;
}

.admin-header__logout:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
