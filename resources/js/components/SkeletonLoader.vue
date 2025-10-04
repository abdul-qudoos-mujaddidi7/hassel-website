<template>
    <div class="skeleton-container" :class="containerClass">
        <!-- Card Skeleton -->
        <div v-if="type === 'card'" class="space-y-6">
            <div
                v-for="i in count"
                :key="i"
                class="rounded-professional-lg p-6 bg-white shadow-soft animate-pulse"
            >
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 bg-gray-200 rounded-lg"></div>
                    <div class="flex-1 space-y-3">
                        <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                        <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                        <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                        <div class="flex gap-2">
                            <div
                                class="h-6 bg-gray-200 rounded-full w-16"
                            ></div>
                            <div
                                class="h-6 bg-gray-200 rounded-full w-20"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- List Skeleton -->
        <div v-else-if="type === 'list'" class="space-y-4">
            <div
                v-for="i in count"
                :key="i"
                class="flex items-center gap-4 p-4 bg-white rounded-lg shadow-soft animate-pulse"
            >
                <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                <div class="flex-1 space-y-2">
                    <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                    <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                </div>
                <div class="h-8 bg-gray-200 rounded w-20"></div>
            </div>
        </div>

        <!-- Table Skeleton -->
        <div v-else-if="type === 'table'" class="overflow-hidden">
            <div class="animate-pulse">
                <!-- Header -->
                <div class="flex space-x-4 p-4 bg-gray-50">
                    <div
                        v-for="i in columns"
                        :key="i"
                        class="h-4 bg-gray-200 rounded w-1/4"
                    ></div>
                </div>
                <!-- Rows -->
                <div class="space-y-3 p-4">
                    <div v-for="i in count" :key="i" class="flex space-x-4">
                        <div
                            v-for="j in columns"
                            :key="j"
                            class="h-4 bg-gray-200 rounded w-1/4"
                        ></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Text Skeleton -->
        <div v-else-if="type === 'text'" class="space-y-3 animate-pulse">
            <div
                v-for="i in count"
                :key="i"
                class="h-4 bg-gray-200 rounded"
                :class="i === count ? 'w-3/4' : 'w-full'"
            ></div>
        </div>

        <!-- Image Skeleton -->
        <div v-else-if="type === 'image'" class="animate-pulse">
            <div
                class="bg-gray-200 rounded-lg"
                :style="{ width: width, height: height }"
            ></div>
        </div>

        <!-- Default Skeleton -->
        <div v-else class="animate-pulse">
            <div class="space-y-4">
                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                <div class="h-4 bg-gray-200 rounded w-5/6"></div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    type: {
        type: String,
        default: "default",
        validator: (value) =>
            ["card", "list", "table", "text", "image", "default"].includes(
                value
            ),
    },
    count: {
        type: Number,
        default: 3,
    },
    columns: {
        type: Number,
        default: 4,
    },
    width: {
        type: String,
        default: "100%",
    },
    height: {
        type: String,
        default: "200px",
    },
    containerClass: {
        type: String,
        default: "",
    },
});
</script>

<style scoped>
.skeleton-container {
    transition: opacity 0.3s ease;
}

@keyframes pulse {
    0%,
    100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
