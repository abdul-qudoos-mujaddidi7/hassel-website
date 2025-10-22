<template>
    <PageLoader
        :is-loading="isLoading"
        :message="getLoadingMessage"
        :sub-message="getSubMessage"
    />
</template>

<script setup>
import { ref, watch, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import PageLoader from "./PageLoader.vue";
import { useI18n } from "../composables/useI18n.js";

const route = useRoute();
const router = useRouter();
const isLoading = ref(false);
const { t, currentLanguage } = useI18n();

// Wait for i18n to be ready
const isI18nReady = ref(false);

// Watch for language changes to ensure i18n is working
watch(currentLanguage, (newLang) => {
    console.log('Language changed to:', newLang);
    isI18nReady.value = true;
}, { immediate: true });

// Debug function to manually test the loader
const testLoader = () => {
    console.log('Testing loader manually');
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        console.log('Manual test loader hidden');
    }, 2000);
};

// Expose test function globally for debugging
if (typeof window !== 'undefined') {
    window.testLoader = testLoader;
}

// Watch for route changes using a more reliable approach
let isNavigating = false;

// Watch for route changes
watch(
    () => route.path,
    (newPath, oldPath) => {
        // Only show loader if we're actually changing routes and not on initial load
        if (oldPath && newPath !== oldPath && !isNavigating) {
            console.log('Route change detected:', oldPath, '->', newPath);
            isNavigating = true;
            isLoading.value = true;

            // Simulate loading time (you can adjust this)
            // In a real app, you might want to wait for actual data loading
            setTimeout(() => {
                isLoading.value = false;
                isNavigating = false;
                console.log('Loader hidden');
            }, 800); // Faster loader for better UX
        }
    },
    { immediate: false }
);

// Add router navigation guards for more reliable loader triggering
onMounted(() => {
    // Before each route change
    router.beforeEach((to, from, next) => {
        console.log('Router beforeEach:', from.path, '->', to.path);
        if (from.path !== to.path && !isNavigating) {
            isNavigating = true;
            isLoading.value = true;
        }
        next();
    });

    // After each route change
    router.afterEach((to, from) => {
        console.log('Router afterEach:', from.path, '->', to.path);
        if (from.path !== to.path && isNavigating) {
            // Add a small delay to ensure the loader is visible
            setTimeout(() => {
                isLoading.value = false;
                isNavigating = false;
                console.log('Loader hidden via router guard');
            }, 300);
        }
    });

    // Fallback: Listen for popstate events (browser back/forward)
    window.addEventListener('popstate', () => {
        console.log('Popstate event detected');
        if (!isNavigating) {
            isNavigating = true;
            isLoading.value = true;
            setTimeout(() => {
                isLoading.value = false;
                isNavigating = false;
                console.log('Loader hidden via popstate');
            }, 300);
        }
    });
});

// Get loading message based on route - using computed for reactivity
const getLoadingMessage = computed(() => {
    try {
        console.log('Current language:', currentLanguage.value);
        console.log('i18n ready:', isI18nReady.value);
        
        // If i18n is not ready, use fallback
        if (!isI18nReady.value) {
            console.log('i18n not ready, using fallback');
            const fallbackMessages = {
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
            return fallbackMessages[route.path] || 'Loading page...';
        }
        
        // Test if t function is working
        const testTranslation = t('loader.home');
        console.log('Test translation result:', testTranslation);
        console.log('Translation key test:', testTranslation === 'loader.home');
        
        // If translation returns the key itself, i18n isn't working
        if (testTranslation === 'loader.home') {
            console.warn('i18n not working, using fallback messages');
            const fallbackMessages = {
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
            return fallbackMessages[route.path] || 'Loading page...';
        }
        
        const routeMessages = {
            '/': t('loader.home'),
            '/our-work': t('loader.our_work'),
            '/training-programs': t('loader.training_programs'),
            '/agri-tech': t('loader.agri_tech'),
            '/market-access': t('loader.market_access'),
            '/smart-farming': t('loader.smart_farming'),
            '/seed-supply': t('loader.seed_supply'),
            '/community-programs': t('loader.community_programs'),
            '/environmental-projects': t('loader.environmental_projects'),
            '/resources': t('loader.resources'),
            '/careers': t('loader.careers'),
            '/contact': t('loader.contact'),
        };
        
        const message = routeMessages[route.path] || t('loader.default');
        console.log('Loading message for', route.path, ':', message);
        return message;
    } catch (error) {
        console.error('Error getting loading message:', error);
        return 'Loading page...';
    }
});

const getSubMessage = computed(() => {
    try {
        // If i18n is not ready, use fallback
        if (!isI18nReady.value) {
            console.log('i18n not ready for sub-messages, using fallback');
            const fallbackSubMessages = {
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
            return fallbackSubMessages[route.path] || 'Please wait while we prepare the content';
        }
        
        // Test if t function is working
        const testTranslation = t('loader.sub_home');
        
        // If translation returns the key itself, i18n isn't working
        if (testTranslation === 'loader.sub_home') {
            console.warn('i18n not working for sub-messages, using fallback');
            const fallbackSubMessages = {
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
            return fallbackSubMessages[route.path] || 'Please wait while we prepare the content';
        }
        
        const routeSubMessages = {
            '/': t('loader.sub_home'),
            '/our-work': t('loader.sub_our_work'),
            '/training-programs': t('loader.sub_training_programs'),
            '/agri-tech': t('loader.sub_agri_tech'),
            '/market-access': t('loader.sub_market_access'),
            '/smart-farming': t('loader.sub_smart_farming'),
            '/seed-supply': t('loader.sub_seed_supply'),
            '/community-programs': t('loader.sub_community_programs'),
            '/environmental-projects': t('loader.sub_environmental_projects'),
            '/resources': t('loader.sub_resources'),
            '/careers': t('loader.sub_careers'),
            '/contact': t('loader.sub_contact'),
        };
        
        const message = routeSubMessages[route.path] || t('loader.sub_default');
        console.log('Sub message for', route.path, ':', message);
        return message;
    } catch (error) {
        console.error('Error getting sub message:', error);
        return 'Please wait while we prepare the content';
    }
});
</script>

<style scoped>
/* Styles are now handled by PageLoader component */
</style>
