<template>
    <div v-if="isLoading" class="page-loader-overlay" :style="{ zIndex: 9999 }">
        <div class="flex-col gap-6 w-full flex items-center justify-center">
            <!-- Double Spinner Loader -->
            <div
                class="w-20 h-20 border-4 border-transparent text-brand-primary text-4xl animate-spin flex items-center justify-center border-t-brand-primary rounded-full"
            >
                <div
                    class="w-16 h-16 border-4 border-transparent text-brand-secondary text-2xl animate-spin flex items-center justify-center border-t-brand-secondary rounded-full"
                ></div>
            </div>
            
            <!-- Loading Text -->
            <div class="text-center space-y-2">
                <p class="text-lg font-semibold text-gray-800" v-if="message">
                    {{ message }}
                </p>
                <p class="text-sm text-gray-600" v-if="subMessage">
                    {{ subMessage }}
                </p>
            </div>
            
            <!-- Optional Progress Indicator -->
            <div v-if="showProgress" class="w-64 bg-gray-200 rounded-full h-1">
                <div 
                    class="bg-gradient-to-r from-brand-secondary to-brand-primary h-1 rounded-full transition-all duration-300"
                    :style="{ width: progress + '%' }"
                ></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, watch } from "vue";

const props = defineProps({
    isLoading: {
        type: Boolean,
        default: false,
    },
    message: {
        type: String,
        default: "Loading page...",
    },
    subMessage: {
        type: String,
        default: "Please wait while we prepare the content",
    },
    showProgress: {
        type: Boolean,
        default: false,
    },
    progress: {
        type: Number,
        default: 0,
        validator: (value) => value >= 0 && value <= 100,
    },
});

// Debug: Watch for isLoading changes
watch(() => props.isLoading, (newValue) => {
    console.log('PageLoader isLoading changed:', newValue);
    if (newValue) {
        console.log('PageLoader showing with message:', props.message);
    }
});
</script>

<style scoped>
.page-loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.3s ease;
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Custom animation for the double spinner */
@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Ensure the inner spinner rotates in the opposite direction for a more dynamic effect */
.w-16.h-16.animate-spin {
    animation: spin 0.8s linear infinite reverse;
}

/* Ensure brand colors are properly applied with fallbacks */
.text-brand-primary {
    color: var(--brand-primary, #134124) !important;
}

.text-brand-secondary {
    color: var(--brand-secondary, #375f1f) !important;
}

.border-t-brand-primary {
    border-top-color: var(--brand-primary, #134124) !important;
}

.border-t-brand-secondary {
    border-top-color: var(--brand-secondary, #375f1f) !important;
}

.from-brand-secondary {
    --tw-gradient-from: var(--brand-secondary, #375f1f) var(--tw-gradient-from-position);
}

.to-brand-primary {
    --tw-gradient-to: var(--brand-primary, #134124) var(--tw-gradient-to-position);
}
</style>
