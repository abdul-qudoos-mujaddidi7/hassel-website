<template>
  <div class="main-layout">
    <!-- Main Website Header -->
    <Header />
    
    <!-- Main Content -->
    <main>
      <router-view />
    </main>
    
    <!-- Main Website Footer -->
    <Footer />
  </div>
</template>

<script setup>
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
</script>

<style scoped>
.main-layout {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

main {
  flex: 1;
}
</style>
