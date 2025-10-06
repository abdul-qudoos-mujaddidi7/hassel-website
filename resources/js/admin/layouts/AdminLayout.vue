<template>
    <v-layout class="admin-layout">
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

        <v-main class="d-flex flex-col">
            <v-card
                variant="flat"
                :style="vCardStyle"
                class="main-content-card"
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
import Sidebar from "../components/Sidebar.vue";
import Header from "../components/Header.vue";

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
/* Admin Layout - Full Height */
.admin-layout {
    height: 100vh !important;
    min-height: 100vh !important;
    max-height: 100vh !important;
    overflow: hidden;
}

/* Navigation Drawer - Full Height */
.sideBar {
    height: 100vh !important;
    min-height: 100vh !important;
    max-height: 100vh !important;
}

/* Main Content Area */
.v-main {
    background-color: #f8fafc !important; /* Light gray surface */
    height: 100vh !important;
    min-height: 100vh !important;
    max-height: 100vh !important;
    overflow: hidden;
}

/* Main Content Card */
.main-content-card {
    height: 100vh !important;
    min-height: 100vh !important;
    max-height: 100vh !important;
    margin: 0 !important;
    border-radius: 0 !important;
    overflow-y: auto;
    padding: 1rem;
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
