<template>
    <PageLoader
        :is-loading="isLoading"
        :message="getLoadingMessage()"
        :sub-message="getSubMessage()"
    />
</template>

<script setup>
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import PageLoader from "./PageLoader.vue";

const route = useRoute();
const isLoading = ref(false);

// Watch for route changes
watch(
    route,
    (to, from) => {
        if (to.path !== from.path) {
            isLoading.value = true;

            // Simulate loading time (you can adjust this)
            // In a real app, you might want to wait for actual data loading
            setTimeout(() => {
                isLoading.value = false;
            }, 500); // Slightly longer to see the beautiful loader
        }
    },
    { immediate: false }
);

// Get loading message based on route
const getLoadingMessage = () => {
    const routeMessages = {
        '/': 'Loading home page...',
        '/our-work': 'Loading our work...',
        '/training-programs': 'Loading training programs...',
        '/agri-tech': 'Loading agricultural technology...',
        '/market-access': 'Loading market access programs...',
        '/smart-farming': 'Loading smart farming solutions...',
        '/seed-supply': 'Loading seed supply information...',
        '/community-programs': 'Loading community programs...',
        '/environmental-projects': 'Loading environmental projects...',
        '/resources': 'Loading resources...',
        '/careers': 'Loading career opportunities...',
        '/contact': 'Loading contact information...',
    };
    
    return routeMessages[route.path] || 'Loading page...';
};

const getSubMessage = () => {
    const routeSubMessages = {
        '/': 'Discovering agricultural solutions...',
        '/our-work': 'Exploring our impact...',
        '/training-programs': 'Preparing educational content...',
        '/agri-tech': 'Loading innovative tools...',
        '/market-access': 'Accessing market opportunities...',
        '/smart-farming': 'Connecting to smart solutions...',
        '/seed-supply': 'Preparing seed information...',
        '/community-programs': 'Loading community initiatives...',
        '/environmental-projects': 'Accessing environmental data...',
        '/resources': 'Gathering resources...',
        '/careers': 'Preparing career information...',
        '/contact': 'Loading contact details...',
    };
    
    return routeSubMessages[route.path] || 'Please wait while we prepare the content';
};
</script>

<style scoped>
/* Styles are now handled by PageLoader component */
</style>
