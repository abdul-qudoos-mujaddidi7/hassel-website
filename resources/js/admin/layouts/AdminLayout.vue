<template>
    <v-layout>
        <v-navigation-drawer
            v-model="drawer"
            :rail="rail"
            permanent
            floating
            :location="dir"
            class="sideBar"
        >
            <sidebar :dir="isRtl ? 'rtl' : 'ltr'" />
        </v-navigation-drawer>

        <v-main class="d-flex flex-col" style="min-height: 300px">
            <v-card
                variant="flat"
                elevation="1"
                :style="vCardStyle"
                :class="[
                    'd-flex flex-col py-4 px-4',
                    isRtl ? 'mr-4' : 'ml-4'
                ]"
            >
                <router-view></router-view>
            </v-card>
        </v-main>
    </v-layout>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import Sidebar from "../components/Sidebar.vue";
import Header from "../components/Header.vue";

const route = useRoute();
const { locale } = useI18n();

// Drawer and rail state
const drawer = ref(true);
const rail = ref(false);

const isRtl = ref(['fa', 'ps'].includes(locale.value));
watch(locale, (newLocale) => {
    isRtl.value = ['fa', 'ps'].includes(newLocale);
});

const dir = computed(() => (isRtl.value ? 'right' : 'left'));

// Dynamic card styling based on route
const vCardStyle = computed(() => {
    console.log(route.path);
    return route.path === "/admin"
        ? "background-color:#fafafa"
        : "background-color:white";
});
</script>

<style scoped>
/* Admin Layout - Full Height */


/* Navigation Drawer - Full Height */
.sideBar {
  
    min-height: 100vh !important;
    max-height: 100vh !important;
    overflow-y: auto;
}

/* Main Content Area */
.v-main {
    background-color: #fafafa !important; /* Light gray surface */
    min-height: 100vh !important;
    overflow-y: auto;
   
}



/* Scrollable content with visible scrollbars */
.scrollable-content {
    max-height: 80vh;
    overflow-y: auto;
    /* direction: ltr; */
}

.scrollable-content::-webkit-scrollbar {
    width: 8px;
}

.scrollable-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.scrollable-content::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.scrollable-content::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}


</style>
