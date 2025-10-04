<template>
    <div class="loading-container" :class="containerClass">
        <!-- Full Page Loading -->
        <div
            v-if="type === 'fullpage'"
            class="fixed inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center"
        >
            <div class="text-center">
                <div class="loading-spinner mb-4" :class="sizeClass"></div>
                <p class="text-lg font-medium text-gray-700" v-if="message">
                    {{ message }}
                </p>
                <p class="text-sm text-gray-500" v-if="subMessage">
                    {{ subMessage }}
                </p>
            </div>
        </div>

        <!-- Inline Loading -->
        <div
            v-else-if="type === 'inline'"
            class="flex items-center justify-center p-8"
            :class="containerClass"
        >
            <div class="text-center">
                <div class="loading-spinner mb-3" :class="sizeClass"></div>
                <p class="text-sm font-medium text-gray-600" v-if="message">
                    {{ message }}
                </p>
            </div>
        </div>

        <!-- Button Loading -->
        <div
            v-else-if="type === 'button'"
            class="inline-flex items-center"
            :class="containerClass"
        >
            <div class="loading-spinner mr-2" :class="sizeClass"></div>
            <span v-if="message">{{ message }}</span>
        </div>

        <!-- Card Loading -->
        <div
            v-else-if="type === 'card'"
            class="rounded-professional-lg p-6 bg-white shadow-soft animate-pulse"
            :class="containerClass"
        >
            <div class="flex items-center mb-4">
                <div class="loading-spinner mr-3" :class="sizeClass"></div>
                <div class="h-4 bg-gray-200 rounded w-1/3"></div>
            </div>
            <div class="space-y-3">
                <div class="h-3 bg-gray-200 rounded w-full"></div>
                <div class="h-3 bg-gray-200 rounded w-2/3"></div>
                <div class="h-3 bg-gray-200 rounded w-1/2"></div>
            </div>
        </div>

        <!-- Skeleton Loading -->
        <div
            v-else-if="type === 'skeleton'"
            class="animate-pulse"
            :class="containerClass"
        >
            <div class="space-y-4">
                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                <div class="h-4 bg-gray-200 rounded w-5/6"></div>
            </div>
        </div>

        <!-- Table Loading -->
        <div
            v-else-if="type === 'table'"
            class="overflow-hidden"
            :class="containerClass"
        >
            <div class="animate-pulse">
                <div class="space-y-3">
                    <div v-for="i in rows" :key="i" class="flex space-x-4">
                        <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Default Loading -->
        <div
            v-else
            class="flex items-center justify-center"
            :class="containerClass"
        >
            <div class="text-center">
                <div class="loading-spinner mb-2" :class="sizeClass"></div>
                <p class="text-sm text-gray-600" v-if="message">
                    {{ message }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    type: {
        type: String,
        default: "default",
        validator: (value) =>
            [
                "fullpage",
                "inline",
                "button",
                "card",
                "skeleton",
                "table",
                "default",
            ].includes(value),
    },
    size: {
        type: String,
        default: "medium",
        validator: (value) =>
            ["small", "medium", "large", "xl"].includes(value),
    },
    message: {
        type: String,
        default: "",
    },
    subMessage: {
        type: String,
        default: "",
    },
    rows: {
        type: Number,
        default: 5,
    },
    containerClass: {
        type: String,
        default: "",
    },
});

const sizeClass = computed(() => {
    const sizes = {
        small: "w-4 h-4",
        medium: "w-6 h-6",
        large: "w-8 h-8",
        xl: "w-12 h-12",
    };
    return sizes[props.size];
});
</script>

<style scoped>
.loading-spinner {
    border: 2px solid #f3f4f6;
    border-top: 2px solid var(--brand-primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.loading-container {
    transition: all 0.3s ease;
}
</style>
