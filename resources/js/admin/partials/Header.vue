<template>
  <header class="admin-header">
    <div class="admin-header__inner">
      <div class="admin-header__greeting">
        <p class="admin-header__greeting-label">Welcome back</p>
        <h1 class="admin-header__greeting-name">
          {{ user?.name ?? 'Administrator' }}
        </h1>
      </div>

      <div class="admin-header__actions">
        <div class="admin-header__date">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M8.25 3v1.5M15.75 3v1.5m-10.5 3h13.5M4.5 21h15a1.5 1.5 0 0 0 1.5-1.5V7.5a1.5 1.5 0 0 0-1.5-1.5h-15A1.5 1.5 0 0 0 3 7.5V19.5A1.5 1.5 0 0 0 4.5 21z" />
          </svg>
          <span>{{ formattedDate }}</span>
        </div>

        <button class="admin-header__notifications">
          <span class="admin-header__notifications-dot" />
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M6 8.25a6 6 0 0 1 12 0v4.125c0 .414.168.81.466 1.094l1.602 1.539a.75.75 0 0 1-.518 1.29H4.45a.75.75 0 0 1-.518-1.29l1.602-1.539a1.5 1.5 0 0 0 .466-1.094V8.25M9 18.75a3 3 0 0 0 6 0" />
          </svg>
        </button>

        <div class="admin-header__account">
          <div class="admin-header__avatar">
            {{ avatarInitials }}
          </div>
          <div class="admin-header__account-meta">
            <p class="admin-header__account-name">{{ user?.name ?? 'Mount Agro Admin' }}</p>
            <p class="admin-header__account-email">{{ user?.email ?? 'admin@mountagro.af' }}</p>
          </div>
          <button class="admin-header__logout" type="button" @click="handleLogout">
            Sign out
          </button>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue';
import axios from 'axios';
import useAdminUser from '../stores/useAdminUser';

const { user } = useAdminUser();

const formattedDate = new Intl.DateTimeFormat('en', {
  weekday: 'short',
  day: 'numeric',
  month: 'short',
  year: 'numeric',
}).format(new Date());

const avatarInitials = computed(() => {
  if (!user.value?.name) return 'MA';

  return user.value.name
    .split(' ')
    .map((word) => word[0]?.toUpperCase())
    .slice(0, 2)
    .join('');
});

const handleLogout = async () => {
  try {
    await axios.post('/admin/logout');
  } catch (error) {
    console.error('Logout failed', error);
  } finally {
    window.location.href = '/admin/login';
  }
};
</script>

