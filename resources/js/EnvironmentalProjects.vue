<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Modern Hero Section (matches CommunityPrograms.vue) -->
        <section class="relative overflow-hidden">
            <div class="absolute inset-0">
                <img
                    :src="'/images/ourWork/ourworkhero.avif'"
                    alt="Environmental Projects"
                    class="w-full h-full object-cover"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-br from-green-900/85 via-green-800/80 to-emerald-900/85"
                ></div>
            </div>

            <!-- Decorative floating elements -->
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
                <nav class="mb-8">
                    <div class="flex items-center space-x-2 text-sm">
                        <router-link
                            to="/"
                            class="text-green-200 hover:text-white transition-colors"
                            >Home</router-link
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
                            />
                        </svg>
                        <span class="text-white font-medium"
                            >Environmental Projects</span
                        >
                    </div>
                </nav>

                <div class="text-center max-w-4xl mx-auto">
                    <!-- Category Badge -->
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-500/20 text-green-100 border border-green-400/30 mb-6"
                    >
                        <svg
                            class="w-4 h-4 mr-2"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V8z"
                            />
                        </svg>
                        Environmental Stewardship
                    </div>

                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight"
                    >
                        Environmental Projects
                    </h1>
                    <p
                        class="text-xl text-white mb-8 leading-relaxed max-w-3xl mx-auto"
                    >
                        Protect ecosystems and promote sustainability through
                        evidence-based, community-driven projects.
                    </p>

                    <!-- Quick Stats -->
                    <div class="flex flex-wrap justify-center gap-6 mb-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ totalProjects }}
                            </div>
                            <div class="text-green-200 text-sm">
                                Active Projects
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ uniqueFundingSources }}
                            </div>
                            <div class="text-green-200 text-sm">
                                Funding Sources
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ totalImpactMetrics }}
                            </div>
                            <div class="text-green-200 text-sm">
                                Impact Metrics
                            </div>
                        </div>
                    </div>

                    <!-- Scroll Indicator -->
                    <div class="flex flex-col items-center">
                        <span class="text-green-200 text-sm mb-2"
                            >Explore projects below</span
                        >
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
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filters Section (mirrors CommunityPrograms.vue) -->
        <section class="py-8 bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Filter Projects
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
                            />
                        </svg>
                        Reset Filters
                    </button>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"
                >
                    <!-- Project Type Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Project Type</label
                        >
                        <select
                            v-model="filters.project_type"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        >
                            <option value="">All Types</option>
                            <option
                                v-for="type in projectTypeOptions"
                                :key="type"
                                :value="type"
                            >
                                {{ formatProjectType(type) }}
                            </option>
                        </select>
                    </div>

                    <!-- Search Filter -->
                    <div class="relative sm:col-span-2 lg:col-span-1">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Search</label
                        >
                        <div class="relative">
                            <input
                                v-model="filters.search"
                                type="text"
                                placeholder="Search projects..."
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
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Catalog Section -->
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

                <!-- Projects Grid / Empty -->
                <div v-else>
                    <div v-if="projects.length === 0" class="text-center py-12">
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
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            No Projects Found
                        </h3>
                        <p class="text-gray-600 mb-6">
                            No projects match your current filters. Try
                            adjusting your search.
                        </p>
                        <button
                            @click="resetFilters"
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors"
                        >
                            Clear Filters
                        </button>
                    </div>

                    <div
                        v-else
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <div
                            v-for="project in projects"
                            :key="project.id"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow flex flex-col"
                        >
                            <!-- Image -->
                            <div
                                class="aspect-[16/9] bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg mb-4 flex items-center justify-center"
                            >
                                <div
                                    v-if="project.cover_image"
                                    class="w-full h-full"
                                >
                                    <img
                                        :src="project.cover_image"
                                        :alt="project.title"
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
                                            d="M3 7l1.664 9.152A2 2 0 006.64 18h10.72a2 2 0 001.976-1.848L21 7M5 7h14M7 10h10"
                                        />
                                    </svg>
                                    <p class="text-green-600 font-medium">
                                        Environmental
                                    </p>
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="mb-4 flex-grow">
                                <h3
                                    class="text-lg font-semibold text-gray-900 mb-2"
                                >
                                    {{ project.title }}
                                </h3>
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    {{ project.description }}
                                </p>
                            </div>

                            <!-- Meta badges -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    v-if="project.project_type"
                                    class="px-2 py-1 bg-brand-cream text-brand-primary text-xs font-medium rounded-full"
                                    >{{
                                        formatProjectType(project.project_type)
                                    }}</span
                                >
                                <span
                                    v-if="project.funding_source"
                                    class="px-2 py-1 bg-brand-cream text-brand-primary text-xs font-medium rounded-full"
                                    >{{ project.funding_source }}</span
                                >
                                <span
                                    v-if="
                                        project.impact_metrics &&
                                        project.impact_metrics.length
                                    "
                                    class="px-2 py-1 bg-brand-cream text-brand-primary text-xs font-medium rounded-full"
                                    >{{
                                        project.impact_metrics.length
                                    }}
                                    Metrics</span
                                >
                            </div>

                            <!-- Action -->
                            <div class="mt-4">
                                <router-link
                                    :to="`/environmental-projects/${
                                        project.slug || project.id
                                    }`"
                                    class="w-full bg-brand-primary text-white font-semibold py-3 px-4 rounded-lg hover:bg-brand-secondary transition-all duration-200 text-sm text-center shadow-sm hover:shadow-md block"
                                    >View Details</router-link
                                >
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
const projects = ref([]);
const { currentLanguage, onLanguageChange } = useI18n();
let unsubscribeLang = null;

// Filters
const filters = ref({
    project_type: "",
    search: "",
});

// Options
const projectTypeOptions = computed(() => {
    const types = projects.value.map((p) => p.project_type).filter(Boolean);
    return [...new Set(types)];
});

// Stats
const totalProjects = computed(() => projects.value.length);
const uniqueFundingSources = computed(() => {
    const list = projects.value.map((p) => p.funding_source).filter(Boolean);
    return new Set(list).size;
});
const totalImpactMetrics = computed(() => {
    return projects.value.reduce(
        (sum, p) =>
            sum +
            (Array.isArray(p.impact_metrics) ? p.impact_metrics.length : 0),
        0
    );
});

watch(filters, fetchProjects, { deep: true });
onMounted(() => {
    fetchProjects();
    unsubscribeLang = onLanguageChange(() => fetchProjects());
});

onUnmounted(() => {
    if (typeof unsubscribeLang === "function") unsubscribeLang();
});

async function fetchProjects() {
    loading.value = true;
    try {
        const params = new URLSearchParams();
        if (filters.value.project_type)
            params.set("project_type", filters.value.project_type);
        if (filters.value.search) params.set("search", filters.value.search);

        const lang =
            localStorage.getItem("preferred_language") ||
            currentLanguage?.value ||
            "en";
        params.set("lang", lang);
        const res = await fetch(
            `/api/environmental-projects?${params.toString()}`
        );
        if (!res.ok) throw new Error("Failed to load projects");
        const data = await res.json();
        const list = Array.isArray(data?.data)
            ? data.data
            : Array.isArray(data)
            ? data
            : [];

        let mapped = list.map(mapProject);

        // Client-side search fallback
        if (filters.value.search) {
            const term = filters.value.search.toLowerCase();
            mapped = mapped.filter(
                (p) =>
                    (p.title && p.title.toLowerCase().includes(term)) ||
                    (p.description &&
                        p.description.toLowerCase().includes(term)) ||
                    (p.project_type &&
                        p.project_type.toLowerCase().includes(term))
            );
        }

        // Client-side type filter, if API ignores
        if (filters.value.project_type) {
            mapped = mapped.filter(
                (p) => p.project_type === filters.value.project_type
            );
        }

        projects.value = mapped;
    } catch (e) {
        projects.value = [];
    } finally {
        loading.value = false;
    }
}

function resetFilters() {
    filters.value = { project_type: "", search: "" };
}

function mapProject(p) {
    return {
        id: p.id,
        title: p.title || "Environmental Project",
        slug: p.slug,
        description: p.description || "",
        cover_image: p.cover_image || p.thumbnail_image,
        project_type: p.project_type || p.project_type_display,
        impact_metrics: Array.isArray(p.impact_metrics) ? p.impact_metrics : [],
        funding_source: p.funding_source || "",
        status: p.status || "published",
    };
}

function formatProjectType(type) {
    return String(type || "")
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
}
</script>
