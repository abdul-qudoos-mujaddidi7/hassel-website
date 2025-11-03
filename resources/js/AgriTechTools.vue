<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Modern Hero Section -->
        <section class="relative overflow-hidden">
            <!-- Background with gradient overlay -->
            <div class="absolute inset-0">
                <img
                    :src="'/images/ourWork/ourworkhero.avif'"
                    alt="Agri-Tech Tools"
                    class="w-full h-full object-cover"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-br from-green-900/85 via-green-800/80 to-emerald-900/85"
                ></div>
            </div>

            <!-- Floating elements for visual interest -->
            <div
                class="absolute top-20 right-20 w-32 h-32 bg-white/10 rounded-full blur-xl"
            ></div>
            <div
                class="absolute bottom-20 left-20 w-24 h-24 bg-green-400/20 rounded-full blur-lg"
            ></div>
            <div
                class="absolute top-1/2 left-1/4 w-16 h-16 bg-green-400/15 rounded-full blur-md"
            ></div>

            <div
                class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-32"
            >
                <!-- Breadcrumbs -->
                <!-- <nav class="mb-8">
                    <div class="flex items-center space-x-2 text-sm">
                        <router-link
                            to="/"
                            class="text-green-200 hover:text-white transition-colors"
                            >{{ t("agritech.breadcrumb.home") }}</router-link
                        >
                        <svg
                            class="w-4 h-4 text-green-300"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        <span class="text-white font-medium"
                            >Agri-Tech Tools</span
                        >
                    </div>
                </nav> -->

                <div class="text-center max-w-4xl mx-auto">
                    <!-- Category Badge -->
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-500/20 text-green-100 border border-green-400/30 mb-6"
                    >
                        <span class="text-white">{{
                            t("agritech.badge")
                        }}</span>
                    </div>

                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight"
                    >
                        {{ t("agritech.title") }}
                    </h1>

                    <p
                        class="text-xl text-white mb-8 leading-relaxed max-w-3xl mx-auto"
                    >
                        {{ t("agritech.subtitle") }}
                    </p>

                    <!-- Quick Stats -->
                    <div class="flex flex-wrap justify-center gap-6 mb-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ totalTools }}
                            </div>
                            <div class="text-green-200 text-sm">
                                {{ t("agritech.stats.tools") }}
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ uniquePlatforms }}
                            </div>
                            <div class="text-green-200 text-sm">
                                {{ t("agritech.stats.platforms") }}
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                100%
                            </div>
                            <div class="text-green-200 text-sm">
                                {{ t("agritech.stats.free") }}
                            </div>
                        </div>
                    </div>

                    <!-- Scroll Indicator -->
                    <div class="flex flex-col items-center">
                        <span class="text-green-200 text-sm mb-2">{{
                            t("agritech.scroll")
                        }}</span>
                        <svg
                            class="w-6 h-6 text-green-300 animate-bounce"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3"
                            ></path>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filters Section -->
        <section class="py-8 bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ t("agritech.filters.title") }}
                    </h2>
                    <button
                        @click="resetFilters"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        <svg
                            class="w-4 h-4 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                            ></path>
                        </svg>
                        {{ t("agritech.filters.reset") }}
                    </button>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                >
                    <!-- Tool Type Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >{{ t("agritech.filters.type") }}</label
                        >
                        <select
                            v-model="filters.type"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        >
                            <option value="">
                                {{ t("agritech.filters.type_all") }}
                            </option>
                            <option value="mobile_app">
                                {{ t("agritech.filters.type_mobile_app") }}
                            </option>
                            <option value="web_tool">
                                {{ t("agritech.filters.type_web_tool") }}
                            </option>
                            <option value="desktop_software">
                                {{
                                    t("agritech.filters.type_desktop_software")
                                }}
                            </option>
                        </select>
                    </div>

                    <!-- Platform Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >{{ t("agritech.filters.platform") }}</label
                        >
                        <select
                            v-model="filters.platform"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        >
                            <option value="">
                                {{ t("agritech.filters.platform_all") }}
                            </option>
                            <option value="Android">Android</option>
                            <option value="iOS">iOS</option>
                            <option value="Web">Web</option>
                            <option value="Windows">Windows</option>
                        </select>
                    </div>

                    <!-- Search Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >{{ t("agritech.filters.search") }}</label
                        >
                        <div class="relative">
                            <input
                                v-model="filters.search"
                                type="text"
                                :placeholder="
                                    t('agritech.filters.search_placeholder')
                                "
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                            />
                            <svg
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                ></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Results Count -->
                    <div class="flex items-end">
                        <div
                            class="w-full bg-gray-50 rounded-lg px-4 py-3 text-sm text-gray-600"
                        >
                            <span class="font-medium">{{
                                t("agritech.results.count", { count: total })
                            }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tools Catalog Section -->
        <section class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Loading State -->
                <div
                    v-if="loading"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div
                        v-for="n in 6"
                        :key="'sk-' + n"
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 animate-pulse"
                    >
                        <div
                            class="aspect-[16/9] bg-gray-200 rounded-lg mb-4"
                        ></div>
                        <div class="h-6 bg-gray-200 w-3/4 mb-2"></div>
                        <div class="h-4 bg-gray-100 w-1/2 mb-4"></div>
                        <div class="h-4 bg-gray-100 w-full"></div>
                    </div>
                </div>

                <!-- Tools Grid -->
                <div v-else>
                    <div v-if="tools.length === 0" class="text-center py-12">
                        <div
                            class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center"
                        >
                            <svg
                                class="w-12 h-12 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ t("agritech.empty.title") }}
                        </h3>
                        <p class="text-gray-600 mb-6">
                            {{ t("agritech.empty.body") }}
                        </p>
                        <button
                            @click="resetFilters"
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors"
                        >
                            {{ t("agritech.empty.clear") }}
                        </button>
                    </div>

                    <div
                        v-else
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <div
                            v-for="tool in tools"
                            :key="tool.id"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow"
                        >
                            <!-- Tool Image -->
                            <div
                                class="aspect-[16/9] bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg mb-4 flex items-center justify-center"
                            >
                                <div
                                    v-if="tool.thumbnail_image"
                                    class="w-full h-full"
                                >
                                    <img
                                        :src="tool.thumbnail_image"
                                        :alt="tool.name"
                                        class="w-full h-full object-cover rounded-lg"
                                    />
                                </div>
                                <div v-else class="text-center">
                                    <svg
                                        class="w-16 h-16 text-green-400 mx-auto mb-2"
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
                                    <p class="text-green-600 font-medium">
                                        {{ tool.tool_type || "Tool" }}
                                    </p>
                                </div>
                            </div>

                            <!-- Tool Info -->
                            <div class="mb-4">
                                <h3
                                    class="text-lg font-semibold text-gray-900 mb-2"
                                >
                                    {{ tool.name }}
                                </h3>
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    {{
                                        tool.short_description ||
                                        tool.description
                                    }}
                                </p>
                            </div>

                            <!-- Tool Meta -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    v-if="tool.tool_type"
                                    class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full"
                                >
                                    {{ formatToolType(tool.tool_type) }}
                                </span>
                                <span
                                    v-if="tool.platform"
                                    class="px-2 py-1 bg-brand-cream text-brand-primary text-xs font-medium rounded-full"
                                >
                                    {{ tool.platform }}
                                </span>
                                <span
                                    v-if="tool.version"
                                    class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full"
                                >
                                    v{{ tool.version }}
                                </span>
                            </div>

                            <!-- Tool Actions -->
                            <div class="flex gap-2">
                                <router-link
                                    :to="`/agri-tech/${tool.slug || tool.id}`"
                                    class="flex-1 bg-brand-primary text-white font-semibold py-2 px-4 rounded-lg hover:opacity-90 transition-colors text-sm text-center inline-flex items-center justify-center"
                                >
                                    <template v-if="!isRTL">
                                        {{ t("common.view_details") }}
                                        <svg
                                            class="w-4 h-4 ml-2"
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
                                    </template>
                                    <template v-else>
                                        <svg
                                            class="w-4 h-4 mr-2"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 19l-7-7 7-7"
                                            ></path>
                                        </svg>
                                        {{ t("common.view_details") }}
                                    </template>
                                </router-link>
                                <button
                                    v-if="tool.download_url"
                                    @click="downloadTool(tool)"
                                    class="flex-1 bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors text-sm"
                                >
                                    <svg
                                        class="w-4 h-4 inline mr-2"
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
                                    {{ t("agritech.download") }}
                                </button>
                                <button
                                    v-else
                                    class="flex-1 bg-gray-100 text-gray-700 font-semibold py-2 px-4 rounded-lg cursor-not-allowed opacity-75 text-sm"
                                    disabled
                                >
                                    <svg
                                        class="w-4 h-4 inline mr-2"
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
                                    {{ t("agritech.coming_soon") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, ref, watch, computed } from "vue";
import { useI18n } from "./composables/useI18n";

const loading = ref(true);
const tools = ref([]);
const total = ref(0);
const { currentLanguage, onLanguageChange, t, isRTL } = useI18n();
let unsubscribeLang = null;

const filters = ref({
    type: "",
    platform: "",
    search: "",
});

// Computed stats
const totalTools = computed(() => tools.value.length);
const uniquePlatforms = computed(() => {
    const platforms = tools.value.map((tool) => tool.platform).filter(Boolean);
    return new Set(platforms).size;
});

// Watch filters and fetch tools
watch(
    filters,
    () => {
        fetchTools();
    },
    { deep: true }
);

onMounted(() => {
    fetchTools();
    unsubscribeLang = onLanguageChange(() => fetchTools());
});

onUnmounted(() => {
    if (typeof unsubscribeLang === "function") unsubscribeLang();
});

async function fetchTools() {
    loading.value = true;
    try {
        const params = new URLSearchParams();
        if (filters.value.type) params.set("tool_type", filters.value.type);
        if (filters.value.platform)
            params.set("platform", filters.value.platform);
        if (filters.value.search) params.set("search", filters.value.search);

        const lang =
            localStorage.getItem("preferred_language") ||
            currentLanguage?.value ||
            "en";
        params.set("lang", lang);
        console.log("Fetching tools with params:", params.toString());
        const res = await fetch(`/api/agri-tech-tools?${params.toString()}`);
        if (!res.ok) throw new Error("Failed to load tools");

        const data = await res.json();
        const list = Array.isArray(data?.data)
            ? data.data
            : Array.isArray(data)
            ? data
            : [];

        let mappedTools = list.map((tool) => ({
            id: tool.id,
            name: tool.name || tool.title || "Agri-Tech Tool",
            description: tool.description || tool.short_description || "",
            short_description: tool.short_description || tool.description || "",
            tool_type: tool.tool_type || tool.type,
            platform: tool.platform,
            version: tool.version,
            download_url: tool.download_url || tool.download_link,
            documentation_url: tool.documentation_url || tool.docs_url,
            thumbnail_image:
                tool.thumbnail_image || tool.cover_image || tool.image,
            status: tool.status || "published",
        }));

        // Client-side search if API doesn't handle it
        if (filters.value.search) {
            const searchTerm = filters.value.search.toLowerCase();
            mappedTools = mappedTools.filter(
                (tool) =>
                    tool.name.toLowerCase().includes(searchTerm) ||
                    tool.description.toLowerCase().includes(searchTerm) ||
                    tool.short_description.toLowerCase().includes(searchTerm) ||
                    (tool.tool_type &&
                        tool.tool_type.toLowerCase().includes(searchTerm)) ||
                    (tool.platform &&
                        tool.platform.toLowerCase().includes(searchTerm))
            );
        }

        tools.value = mappedTools;

        // Debug: Log the first and last tools to see their data
        console.log("First tool:", tools.value[0]);
        console.log("Last tool:", tools.value[tools.value.length - 1]);
        console.log(
            "All tool IDs and slugs:",
            tools.value.map((t) => ({ id: t.id, slug: t.slug, name: t.name }))
        );

        total.value = tools.value.length;
    } catch (error) {
        console.error("Error fetching tools:", error);
        tools.value = [];
        total.value = 0;
    } finally {
        loading.value = false;
    }
}

function resetFilters() {
    filters.value = {
        type: "",
        platform: "",
        search: "",
    };
}

function formatToolType(type) {
    return String(type)
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
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
</script>
