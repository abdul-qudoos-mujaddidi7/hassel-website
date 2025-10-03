<template>
  <aside class="admin-sidebar" :class="{ 'admin-sidebar--open': isMobileOpen }">
    <div class="admin-sidebar__brand">
      <RouterLink to="/">
        <div class="admin-sidebar__logo">MA</div>
        <div class="admin-sidebar__brand-meta">
          <p class="admin-sidebar__brand-label">Mount Agro</p>
          <p class="admin-sidebar__brand-title">Admin Console</p>
        </div>
      </RouterLink>
    </div>

    <nav class="admin-sidebar__nav">
      <SidebarHeader>Overview</SidebarHeader>
      <SidebarLink
        icon="dashboard"
        :to="{ name: 'admin.dashboard' }"
        label="Dashboard"
      />
      <SidebarLink
        icon="analytics"
        :to="{ name: 'admin.analytics' }"
        label="Analytics"
      />

      <SidebarHeader>Content</SidebarHeader>
      <SidebarLink icon="news" to="#" label="News & Articles" />
      <SidebarLink icon="gallery" to="#" label="Galleries" />
      <SidebarLink icon="documents" to="#" label="Publications" />

      <SidebarHeader>Programs</SidebarHeader>
      <SidebarLink icon="training" to="#" label="Training Programs" />
      <SidebarLink icon="tools" to="#" label="Agri-Tech Tools" />
      <SidebarLink icon="market" to="#" label="Market Access" />

      <SidebarHeader>Engagement</SidebarHeader>
      <SidebarLink icon="inbox" to="#" label="Contact Requests" />
      <SidebarLink icon="users" to="#" label="Program Registrations" />
    </nav>

    <div class="admin-sidebar__support">
      <p>Need assistance?</p>
      <p>support@mountagro.af</p>
      <a href="mailto:support@mountagro.af">Contact Support</a>
    </div>
  </aside>
</template>

<script setup>
import { ref } from 'vue';
import SidebarLink from '../ui/SidebarLink.vue';
import SidebarHeader from '../ui/SidebarHeader.vue';

const isMobileOpen = ref(false);
</script>




