<template>
    <div v-if="isLoading" class="page-transition-overlay">
        <LoadingSpinner
            type="fullpage"
            size="large"
            message="Loading page..."
            sub-message="Please wait while we prepare the content"
        />
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import LoadingSpinner from "./LoadingSpinner.vue";

const route = useRoute();
const isLoading = ref(false);

// Watch for route changes
watch(
    route,
    (to, from) => {
        if (to.path !== from.path) {
            isLoading.value = true;

            // Simulate loading time (you can adjust this)
            setTimeout(() => {
                isLoading.value = false;
            }, 300);
        }
    },
    { immediate: false }
);
</script>

<style scoped>
.page-transition-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(4px);
    transition: opacity 0.3s ease;
}
</style>
