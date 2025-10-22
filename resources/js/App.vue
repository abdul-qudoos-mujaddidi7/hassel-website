<template>
    <!-- Header Component -->
    <Header />

    <!-- Main Content -->
    <main>
        <router-view v-slot="{ Component, route }">
            <transition name="page" mode="out-in">
                <component :is="Component" :key="route.path + '::' + currentLanguage" />
            </transition>
        </router-view>
    </main>

    <!-- Footer Component -->
    <Footer />

    <!-- Page Transition Loading -->
    <PageTransition />
    
    
</template>

<script setup>
import { onMounted, watch, onBeforeUnmount } from "vue";
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import PageTransition from "./components/PageTransition.vue";
import { useI18n } from "./composables/useI18n.js";

const { init, isRTL, currentLanguage } = useI18n();

function applyDirection() {
    const html = document.documentElement;
    const body = document.body;
    const dir = isRTL.value ? "rtl" : "ltr";
    const lang = currentLanguage.value;
    
    html.setAttribute("dir", dir);
    html.setAttribute("lang", lang);
    body.classList.toggle("rtl", isRTL.value);
    body.classList.toggle("ltr", !isRTL.value);
}

// Initialize i18n then apply direction
onMounted(async () => {
    await init();
    applyDirection();
    // Also react to runtime language changes (from language switcher)
    window.addEventListener("language:changed", applyDirection);
});

watch(() => isRTL.value, applyDirection);

onBeforeUnmount(() => {
    window.removeEventListener("language:changed", applyDirection);
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

/* RTL Support is now handled in app.css with comprehensive utilities */
</style>
