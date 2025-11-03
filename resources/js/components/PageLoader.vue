<template>
    <Transition name="loader-fade">
        <div
            v-if="isLoading"
            class="page-loader-overlay"
            :style="{ zIndex: 9999 }"
        >
            <div
                class="flex-col gap-6 w-full flex items-center justify-center px-4"
            >
                <!-- Enhanced Double Spinner Loader with pulsing effect -->
                <div class="relative">
                    <div
                        class="w-20 h-20 border-4 border-transparent text-brand-primary text-4xl animate-spin flex items-center justify-center border-t-brand-primary rounded-full shadow-lg"
                    >
                        <div
                            class="w-16 h-16 border-4 border-transparent text-brand-secondary text-2xl animate-spin flex items-center justify-center border-t-brand-secondary rounded-full"
                        ></div>
                    </div>
                    <!-- Pulsing circle effect -->
                    <div
                        class="absolute inset-0 w-20 h-20 rounded-full border-2 border-brand-primary/30 animate-ping"
                    ></div>
                </div>

                <!-- Loading Text with animation -->
                <div class="text-center space-y-3 max-w-md">
                    <div class="space-y-2">
                        <p
                            class="text-xl font-bold text-gray-900 animate-pulse"
                            v-if="message"
                        >
                            {{ message }}
                        </p>
                        <p
                            class="text-sm text-gray-600 leading-relaxed"
                            v-if="subMessage"
                        >
                            {{ subMessage }}
                        </p>
                    </div>

                    <!-- Animated dots indicator -->
                    <div class="flex justify-center gap-1 pt-2">
                        <span
                            class="w-2 h-2 bg-brand-primary rounded-full animate-bounce"
                            style="animation-delay: 0s"
                        ></span>
                        <span
                            class="w-2 h-2 bg-brand-secondary rounded-full animate-bounce"
                            style="animation-delay: 0.2s"
                        ></span>
                        <span
                            class="w-2 h-2 bg-brand-primary rounded-full animate-bounce"
                            style="animation-delay: 0.4s"
                        ></span>
                    </div>
                </div>

                <!-- Optional Progress Indicator -->
                <div
                    v-if="showProgress"
                    class="w-64 bg-gray-200 rounded-full h-2 overflow-hidden shadow-inner"
                >
                    <div
                        class="bg-gradient-to-r from-brand-secondary via-brand-primary to-brand-secondary h-2 rounded-full transition-all duration-300 relative"
                        :style="{ width: progress + '%' }"
                    >
                        <div
                            class="absolute inset-0 bg-white/30 animate-shimmer"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
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
watch(
    () => props.isLoading,
    (newValue) => {
        console.log("PageLoader isLoading changed:", newValue);
        if (newValue) {
            console.log("PageLoader showing with message:", props.message);
        }
    }
);
</script>

<style scoped>
.page-loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Transition animations */
.loader-fade-enter-active,
.loader-fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.loader-fade-enter-from {
    opacity: 0;
    transform: scale(0.95);
}

.loader-fade-leave-to {
    opacity: 0;
    transform: scale(1.05);
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

@keyframes ping {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    75%,
    100% {
        transform: scale(1.5);
        opacity: 0;
    }
}

@keyframes shimmer {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

.animate-ping {
    animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
}

.animate-shimmer {
    animation: shimmer 1.5s ease-in-out infinite;
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
    --tw-gradient-from: var(--brand-secondary, #375f1f)
        var(--tw-gradient-from-position);
}

.to-brand-primary {
    --tw-gradient-to: var(--brand-primary, #134124)
        var(--tw-gradient-to-position);
}

/* Bounce animation for dots */
@keyframes bounce {
    0%,
    100% {
        transform: translateY(0);
        opacity: 1;
    }
    50% {
        transform: translateY(-10px);
        opacity: 0.7;
    }
}

.animate-bounce {
    animation: bounce 1.4s ease-in-out infinite;
}
</style>
