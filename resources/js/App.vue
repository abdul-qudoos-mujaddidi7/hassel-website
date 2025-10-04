<template>
    <!-- Header Component -->
    <Header />

    <!-- Main Content -->
    <main>
        <router-view v-slot="{ Component, route }">
            <transition name="page" mode="out-in">
                <component :is="Component" :key="route.path" />
            </transition>
        </router-view>
    </main>

    <!-- Footer Component -->
    <Footer />

    <!-- Page Transition Loading -->
    <PageTransition />
</template>

<script setup>
import { onMounted } from "vue";
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import PageTransition from "./components/PageTransition.vue";
import { useI18n } from "./composables/useI18n.js";

const { init, isRTL } = useI18n();

// Initialize i18n on app mount
onMounted(async () => {
    await init();

    // Apply RTL direction only for specific languages
    // Don't change the entire document direction as it breaks layout
    const body = document.body;
    if (isRTL.value) {
        body.classList.add("rtl");
        body.classList.remove("ltr");
    } else {
        body.classList.add("ltr");
        body.classList.remove("rtl");
    }
});
</script>

<style>
/* Page transition animations */
.page-enter-active,
.page-leave-active {
    transition: all 0.3s ease;
}

.page-enter-from {
    opacity: 0;
    transform: translateY(20px);
}

.page-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}

.page-enter-to,
.page-leave-from {
    opacity: 1;
    transform: translateY(0);
}

/* RTL Support - Only apply to specific elements, not the entire page */
.rtl .text-right {
    text-align: right;
}

.rtl .text-left {
    text-align: right;
}

.rtl .ml-2 {
    margin-left: 0;
    margin-right: 0.5rem;
}

.rtl .mr-2 {
    margin-right: 0;
    margin-left: 0.5rem;
}

/* Keep the main layout intact */
body {
    direction: ltr;
}

/* Only specific RTL elements */
.rtl .rtl-text {
    direction: rtl;
    text-align: right;
}
</style>
