<template>
        <!-- Header Component -->
        <Header />

        <!-- Main Content -->
        <main>
            <router-view />
        </main>

        <!-- Footer Component -->
        <Footer />
 
</template>

<script setup>
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
</script>
