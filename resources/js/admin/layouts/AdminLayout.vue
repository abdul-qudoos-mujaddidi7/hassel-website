<template>
    <v-layout class="rounded rounded-md">
        <v-navigation-drawer
            v-model="drawer"
            :rail="rail"
            permanent
            floating
            :location="dir"
            class="sideBar bg-lightSectionBg"
        >
            <sidebar :dir="isRtl ? 'rtl' : 'ltr'" />
        </v-navigation-drawer>

        <v-main class="d-flex flex-col" style="min-height: 300px">
            <v-card
                variant="flat"
                
                :style="vCardStyle"
                class="min-h-screen d-flex flex-col m-4 ml-4 py-4 px-4 rounded-xl"
            >
                <router-view></router-view>
            </v-card>
        </v-main>
    </v-layout>
</template>

<script setup>
import { ref, computed } from "vue";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import Sidebar from '../components/Sidebar.vue'
import Header from '../components/Header.vue'

const route = useRoute();
const { locale } = useI18n();

// Drawer and rail state
const drawer = ref(true);
const rail = ref(false);

// Direction for RTL support
const dir = computed(() => {
    if (locale.value === "fa") {
        return "right"; // Reverse the order for Farsi
    }
    return "left";
});

// Dynamic card styling based on route
const vCardStyle = computed(() => {
    console.log(route.path);
    return route.path === "/admin/dashboard"
        ? "background-color:#f8f8f8"
        : "background-color:white";
});
</script>

<style scoped>
/* Apply #555 background to the main layout */

/* Ensure the main content area has #555 background */
.v-main {
    background-color: rgb(248,248,248) !important;
    overflow: hidden;
}

/* Apply #555 to the content card */
.v-card {
    overflow: hidden;
}

/* Hide all scrollbars */
.scrollable-content {
    max-height: 80vh;
    overflow-y: auto;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* Internet Explorer 10+ */
}

.scrollable-content::-webkit-scrollbar {
    display: none; /* WebKit browsers */
}
</style>
