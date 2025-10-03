<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Loading State -->
        <div
            v-if="loading"
            class="min-h-screen flex items-center justify-center"
        >
            <div class="text-center">
                <div
                    class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto mb-4"
                ></div>
                <p class="text-gray-600">Loading tool details...</p>
            </div>
        </div>

        <!-- Error State -->
        <div
            v-else-if="error"
            class="min-h-screen flex items-center justify-center"
        >
            <div class="text-center max-w-md mx-auto px-4">
                <div
                    class="w-24 h-24 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center"
                >
                    <svg
                        class="w-12 h-12 text-red-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                        ></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Tool Not Found
                </h2>
                <p class="text-gray-600 mb-6">{{ error }}</p>
                <router-link
                    to="/agri-tech"
                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors"
                >
                    <svg
                        class="w-5 h-5 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"
                        ></path>
                    </svg>
                    Back to Tools
                </router-link>
            </div>
        </div>

        <!-- Tool Detail Content -->
        <div v-else-if="tool">
            <!-- Clean Header Section -->
            <section class="bg-white border-b border-gray-200">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <!-- Breadcrumbs -->
                    <nav class="mb-6">
                        <div class="flex items-center space-x-2 text-sm">
                            <router-link
                                to="/"
                                class="text-gray-500 hover:text-green-600 transition-colors"
                                >Home</router-link
                            >
                            <svg
                                class="w-4 h-4 text-gray-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            <router-link
                                to="/agri-tech"
                                class="text-gray-500 hover:text-green-600 transition-colors"
                                >Agri-Tech Tools</router-link
                            >
                            <svg
                                class="w-4 h-4 text-gray-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            <span class="text-gray-900 font-medium">{{
                                tool.name
                            }}</span>
                        </div>
                    </nav>

                    <!-- Tool Header -->
                    <div
                        class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6"
                    >
                        <div class="flex-1">
                            <!-- Tool Type Badge -->
                            <div
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 mb-4"
                            >
                                {{ formatToolType(tool.tool_type) }}
                            </div>

                            <h1
                                class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4"
                            >
                                {{ tool.name }}
                            </h1>

                            <p
                                class="text-lg text-gray-700 mb-6 leading-relaxed"
                            >
                                {{ tool.short_description || tool.description }}
                            </p>

                            <!-- Quick Meta -->
                            <div
                                class="flex flex-wrap gap-4 text-sm text-gray-500"
                            >
                                <span
                                    v-if="tool.platform"
                                    class="flex items-center"
                                >
                                    <svg
                                        class="w-4 h-4 mr-2"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V8z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                    {{ tool.platform }}
                                </span>
                                <span
                                    v-if="tool.version"
                                    class="flex items-center"
                                >
                                    <svg
                                        class="w-4 h-4 mr-2"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                    v{{ tool.version }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button
                                v-if="tool.documentation_url"
                                @click="openDocumentation(tool)"
                                class="inline-flex items-center justify-center px-6 py-3 bg-white text-green-600 font-semibold rounded-lg hover:bg-green-50 transition-colors border border-green-600"
                            >
                                <svg
                                    class="w-5 h-5 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    ></path>
                                </svg>
                                Documentation
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <section class="py-8 sm:py-16 bg-white">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Tool Visual -->
                    <div class="mb-8">
                        <div class="bg-gray-100 rounded-2xl p-4 sm:p-6 lg:p-8">
                            <div
                                v-if="tool.thumbnail_image"
                                class="aspect-video rounded-xl overflow-hidden bg-white"
                            >
                                <img
                                    :src="tool.thumbnail_image"
                                    :alt="tool.name"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <div
                                v-else
                                class="aspect-video rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center"
                            >
                                <div class="text-center">
                                    <svg
                                        class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 text-green-400 mx-auto mb-3 sm:mb-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                        ></path>
                                    </svg>
                                    <p
                                        class="text-green-600 font-semibold text-lg sm:text-xl"
                                    >
                                        {{ formatToolType(tool.tool_type) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tool Info and Download Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Tool Information -->
                        <div
                            class="lg:col-span-2 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-100 p-4 sm:p-6 shadow-sm"
                        >
                            <h3
                                class="text-lg sm:text-xl font-bold text-gray-900 mb-4"
                            >
                                Tool Information
                            </h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div v-if="tool.tool_type">
                                    <div class="text-gray-500 mb-1">Type</div>
                                    <div class="text-gray-900 font-semibold">
                                        {{ formatToolType(tool.tool_type) }}
                                    </div>
                                </div>
                                <div v-if="tool.platform">
                                    <div class="text-gray-500 mb-1">
                                        Platform
                                    </div>
                                    <div class="text-gray-900 font-semibold">
                                        {{ tool.platform }}
                                    </div>
                                </div>
                                <div v-if="tool.version">
                                    <div class="text-gray-500 mb-1">
                                        Version
                                    </div>
                                    <div class="text-gray-900 font-semibold">
                                        v{{ tool.version }}
                                    </div>
                                </div>
                                <div v-if="tool.file_size">
                                    <div class="text-gray-500 mb-1">
                                        File Size
                                    </div>
                                    <div class="text-gray-900 font-semibold">
                                        {{ tool.file_size }}
                                    </div>
                                </div>
                                <div v-if="tool.developer">
                                    <div class="text-gray-500 mb-1">
                                        Developer
                                    </div>
                                    <div class="text-gray-900 font-semibold">
                                        {{ tool.developer }}
                                    </div>
                                </div>
                                <div v-if="tool.last_updated">
                                    <div class="text-gray-500 mb-1">
                                        Last Updated
                                    </div>
                                    <div class="text-gray-900 font-semibold">
                                        {{ formatDate(tool.last_updated) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Download Card -->
                        <div
                            class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-100 p-4 sm:p-6 shadow-sm"
                        >
                            <h3
                                class="text-lg sm:text-xl font-bold text-gray-900 mb-2"
                            >
                                Download
                            </h3>
                            <p class="text-gray-600 text-sm mb-4">
                                Get the latest version of this tool
                            </p>

                            <button
                                v-if="tool.download_url"
                                @click="downloadTool(tool)"
                                class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-green-700 transition-colors"
                            >
                                <svg
                                    class="w-5 h-5 inline mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    ></path>
                                </svg>
                                Download Now
                            </button>
                            <div v-else class="text-center py-3 text-gray-500">
                                <svg
                                    class="w-8 h-8 mx-auto mb-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    ></path>
                                </svg>
                                <p class="text-sm">Coming Soon</p>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div
                        v-if="
                            tool.features &&
                            formatFeatures(tool.features).length > 0
                        "
                        class="mb-8"
                    >
                        <h2
                            class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6"
                        >
                            Key Features
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                v-for="(feature, index) in formatFeatures(
                                    tool.features
                                )"
                                :key="index"
                                class="flex items-start space-x-3 p-4 bg-green-50 rounded-xl border border-green-100"
                            >
                                <div
                                    class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-0.5"
                                >
                                    <svg
                                        class="w-3 h-3 text-white"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </div>
                                <p
                                    class="text-gray-700 font-medium text-sm leading-relaxed"
                                >
                                    {{ feature }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Default Features if no specific features provided -->
                    <div v-else class="mb-8">
                        <h2
                            class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6"
                        >
                            Key Features
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                v-for="(feature, index) in getDefaultFeatures(
                                    tool
                                )"
                                :key="index"
                                class="flex items-start space-x-3 p-4 bg-green-50 rounded-xl border border-green-100"
                            >
                                <div
                                    class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-0.5"
                                >
                                    <svg
                                        class="w-3 h-3 text-white"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </div>
                                <p
                                    class="text-gray-700 font-medium text-sm leading-relaxed"
                                >
                                    {{ feature }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Usage Guide -->
                    <div v-if="tool.usage_guide" class="mb-8">
                        <h2
                            class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6"
                        >
                            How to Use
                        </h2>
                        <div
                            class="prose prose-lg max-w-none text-gray-600 leading-relaxed text-sm sm:text-base"
                        >
                            <p>{{ tool.usage_guide }}</p>
                        </div>
                    </div>

                    <!-- Technical Specifications -->
                    <div v-if="tool.technical_specs" class="mb-8">
                        <h2
                            class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6"
                        >
                            Technical Specifications
                        </h2>
                        <div class="bg-gray-50 rounded-2xl p-4 sm:p-6">
                            <div
                                class="prose prose-lg max-w-none text-gray-600 leading-relaxed text-sm sm:text-base"
                            >
                                <p>{{ tool.technical_specs }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Related Tools -->
                    <div
                        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6"
                    >
                        <h3
                            class="text-lg sm:text-xl font-bold text-gray-900 mb-4"
                        >
                            Related Tools
                        </h3>
                        <div class="space-y-3">
                            <div
                                v-for="relatedTool in relatedTools.slice(0, 3)"
                                :key="relatedTool.id"
                                class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors cursor-pointer"
                                @click="navigateToTool(relatedTool)"
                            >
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center"
                                >
                                    <svg
                                        class="w-4 h-4 sm:w-5 sm:h-5 text-green-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                        ></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p
                                        class="text-sm font-medium text-gray-900 truncate"
                                    >
                                        {{ relatedTool.name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ relatedTool.tool_type }}
                                    </p>
                                </div>
                                <svg
                                    class="w-4 h-4 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5l7 7-7 7"
                                    ></path>
                                </svg>
                            </div>
                        </div>

                        <router-link
                            to="/agri-tech"
                            class="block mt-4 text-center text-green-600 hover:text-green-700 font-medium text-sm"
                        >
                            View All Tools →
                        </router-link>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed, watch, nextTick } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const loading = ref(true);
const error = ref(null);
const tool = ref(null);
const relatedTools = ref([]);

onMounted(() => {
    fetchToolDetail();
    fetchRelatedTools();
});

// React to route changes so detail updates without refresh
watch(
    () => route.params.idOrSlug,
    async () => {
        await fetchToolDetail();
        await fetchRelatedTools();
        await nextTick();
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
);

async function fetchToolDetail() {
    loading.value = true;
    error.value = null;

    try {
        const idOrSlug = route.params.idOrSlug;
        console.log("Fetching tool detail for:", idOrSlug);

        // Try to fetch by slug first (API expects slug)
        let response;
        try {
            response = await fetch(`/api/agri-tech-tools/${idOrSlug}`);
            if (response.ok) {
                const data = await response.json();
                tool.value = formatTool(data.data || data);
                return;
            }
        } catch (err) {
            console.log("Direct fetch failed, trying list approach:", err);
        }

        // If direct fetch fails, try to find by slug or ID in the list
        try {
            const listResponse = await fetch("/api/agri-tech-tools");
            if (!listResponse.ok) throw new Error("Failed to fetch tools list");

            const listData = await listResponse.json();
            const tools = Array.isArray(listData?.data)
                ? listData.data
                : Array.isArray(listData)
                ? listData
                : [];
            console.log(
                "Available tools:",
                tools.map((t) => ({ id: t.id, slug: t.slug, name: t.name }))
            );
            console.log("Looking for:", idOrSlug);

            const foundTool = tools.find(
                (t) =>
                    t.slug === idOrSlug ||
                    t.id == idOrSlug ||
                    String(t.id) === String(idOrSlug)
            );

            if (foundTool) {
                tool.value = formatTool(foundTool);
                return;
            } else {
                throw new Error(`Tool not found with identifier: ${idOrSlug}`);
            }
        } catch (err) {
            throw new Error(err.message || "Failed to find tool");
        }
    } catch (err) {
        console.error("Error fetching tool detail:", err);
        error.value = err.message || "Failed to load tool details";
    } finally {
        loading.value = false;
    }
}

async function fetchRelatedTools() {
    try {
        const response = await fetch("/api/agri-tech-tools");
        if (!response.ok) throw new Error("Failed to load related tools");

        const data = await response.json();
        const tools = Array.isArray(data?.data)
            ? data.data
            : Array.isArray(data)
            ? data
            : [];

        // Filter out current tool and get tools with same type or platform
        const currentTool = tool.value;
        relatedTools.value = tools
            .filter(
                (t) => t.id !== currentTool?.id && t.slug !== currentTool?.slug
            )
            .filter(
                (t) =>
                    t.tool_type === currentTool?.tool_type ||
                    t.platform === currentTool?.platform
            )
            .slice(0, 6)
            .map(formatTool);
    } catch (err) {
        console.error("Error fetching related tools:", err);
        relatedTools.value = [];
    }
}

function formatTool(rawTool) {
    return {
        id: rawTool.id,
        name: rawTool.name || rawTool.title || "Agri-Tech Tool",
        description: rawTool.description || rawTool.short_description || "",
        short_description:
            rawTool.short_description || rawTool.description || "",
        tool_type: rawTool.tool_type || rawTool.type,
        platform: rawTool.platform,
        version: rawTool.version,
        download_url: rawTool.download_url || rawTool.download_link,
        documentation_url: rawTool.documentation_url || rawTool.docs_url,
        thumbnail_image:
            rawTool.thumbnail_image || rawTool.cover_image || rawTool.image,
        features: rawTool.features,
        usage_guide: rawTool.usage_guide,
        technical_specs: rawTool.technical_specs,
        file_size: rawTool.file_size,
        developer: rawTool.developer,
        last_updated: rawTool.last_updated || rawTool.updated_at,
        status: rawTool.status || "published",
        slug: rawTool.slug,
    };
}

function formatToolType(type) {
    if (!type) return "Tool";
    return String(type)
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
}

function formatFeatures(features) {
    if (!features) return [];

    // Handle array directly
    if (Array.isArray(features)) return features;

    // Handle string
    if (typeof features === "string") {
        // Try to parse as JSON first (in case it's a JSON string)
        try {
            const parsed = JSON.parse(features);
            if (Array.isArray(parsed)) return parsed;
        } catch (e) {
            // Not JSON, continue with string parsing
        }

        // Split by common delimiters and clean up
        return features
            .split(/[,;|\n]/)
            .map((f) => f.trim().replace(/^["']|["']$/g, "")) // Remove quotes
            .filter(Boolean);
    }

    return [];
}

function getDefaultFeatures(tool) {
    // Provide default features based on tool type and platform
    const defaultFeatures = [
        "User-friendly interface for easy navigation",
        "Real-time data monitoring and analysis",
        "Cross-platform compatibility",
        "Regular updates and improvements",
        "Technical support and documentation",
        "Scalable for different farm sizes",
    ];

    // Customize features based on tool type
    if (tool.tool_type === "mobile_app") {
        return [
            "Mobile-optimized interface",
            "Offline functionality",
            "Push notifications for updates",
            "Easy installation and setup",
            "Battery-efficient design",
            "Data synchronization across devices",
        ];
    } else if (tool.tool_type === "web_tool") {
        return [
            "Browser-based access",
            "No installation required",
            "Cross-browser compatibility",
            "Responsive design for all devices",
            "Cloud-based data storage",
            "Real-time collaboration features",
        ];
    } else if (tool.tool_type === "desktop_software") {
        return [
            "Full-featured desktop application",
            "Advanced data processing capabilities",
            "Local data storage and backup",
            "Integration with other agricultural tools",
            "High-performance computing",
            "Customizable user interface",
        ];
    }

    return defaultFeatures;
}

function formatDate(dateString) {
    if (!dateString) return "N/A";
    try {
        return new Date(dateString).toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric",
        });
    } catch {
        return dateString;
    }
}

function downloadTool(tool) {
    if (tool.download_url) {
        window.open(tool.download_url, "_blank");
    }
}

function openDocumentation(tool) {
    if (tool.documentation_url) {
        window.open(tool.documentation_url, "_blank");
    }
}

function navigateToTool(tool) {
    const route = tool.slug || tool.id;
    router.push(`/agri-tech/${route}`);
}
</script>
