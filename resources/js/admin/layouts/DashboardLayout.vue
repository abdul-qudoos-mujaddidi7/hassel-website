<template>
  <div class="admin-layout">
    <Sidebar />
    <div class="admin-layout__content">
      <Header />
      <main class="admin-layout__main">
        <RouterView />
      </main>
    </div>
  </div>
</template>

<script setup>
import Header from '../partials/Header.vue';
import Sidebar from '../partials/Sidebar.vue';
</script>




