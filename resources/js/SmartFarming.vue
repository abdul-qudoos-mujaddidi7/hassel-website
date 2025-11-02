<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Modern Hero Section -->
        <section class="relative overflow-hidden">
            <!-- Background with gradient overlay -->
            <div class="absolute inset-0">
                <img
                    :src="'/images/ourWork/ourworkhero.avif'"
                    alt="Smart & Sustainable Farming"
                    class="w-full h-full object-cover"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-br from-green-900/85 via-emerald-800/80 to-teal-900/85"
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
                class="absolute top-1/2 left-1/4 w-16 h-16 bg-emerald-400/15 rounded-full blur-md"
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
                            >{{
                                t("smartfarming.breadcrumb.home")
                            }}</router-link
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
                        <span class="text-white font-medium">{{
                            t("smartfarming.title")
                        }}</span>
                    </div>
                </nav>

                <div class="text-center max-w-4xl mx-auto">
                    <!-- Category Badge -->
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-500/20 text-green-100 border border-green-400/30 mb-6"
                    >
                        <span class="text-white">{{
                            t("smartfarming.badge")
                        }}</span>
                    </div>

                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight"
                    >
                        {{ t("smartfarming.title") }}
                    </h1>

                    <p
                        class="text-xl text-white mb-8 leading-relaxed max-w-3xl mx-auto"
                    >
                        {{ t("smartfarming.subtitle") }}
                    </p>

                    <!-- Quick Stats -->
                    <div class="flex flex-wrap justify-center gap-6 mb-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ totalPrograms }}
                            </div>
                            <div class="text-green-200 text-sm">
                                {{ t("smartfarming.stats.active") }}
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ uniqueTechniques }}
                            </div>
                            <div class="text-green-200 text-sm">
                                {{ t("smartfarming.stats.techniques") }}
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ climateResilientCount }}
                            </div>
                            <div class="text-green-200 text-sm">
                                {{ t("smartfarming.stats.climate_resilient") }}
                            </div>
                        </div>
                    </div>

                    <!-- Scroll Indicator -->
                    <div class="flex flex-col items-center">
                        <span class="text-green-200 text-sm mb-2">{{
                            t("smartfarming.scroll")
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
        <section class="py-8 bg-gray-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ t("smartfarming.filters.title") }}
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
                        {{ t("smartfarming.filters.reset") }}
                    </button>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                >
                    <!-- Program Type Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >{{ t("smartfarming.filters.type") }}</label
                        >
                        <select
                            v-model="filters.type"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        >
                            <option value="">
                                {{ t("smartfarming.filters.type_all") }}
                            </option>
                            <option value="drip_irrigation">
                                {{
                                    t(
                                        "smartfarming.filters.type_drip_irrigation"
                                    )
                                }}
                            </option>
                            <option value="greenhouse">
                                {{ t("smartfarming.filters.type_greenhouse") }}
                            </option>
                            <option value="precision_agriculture">
                                {{
                                    t(
                                        "smartfarming.filters.type_precision_agriculture"
                                    )
                                }}
                            </option>
                            <option value="organic">
                                {{ t("smartfarming.filters.type_organic") }}
                            </option>
                            <option value="climate_resilient">
                                {{
                                    t(
                                        "smartfarming.filters.type_climate_resilient"
                                    )
                                }}
                            </option>
                            <option value="soil_health">
                                {{ t("smartfarming.filters.type_soil_health") }}
                            </option>
                        </select>
                    </div>

                    <!-- Target Crops Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >{{ t("smartfarming.filters.crops") }}</label
                        >
                        <select
                            v-model="filters.crops"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        >
                            <option value="">
                                {{ t("smartfarming.filters.crops_all") }}
                            </option>
                            <option value="vegetables">
                                {{ t("smartfarming.filters.crops_vegetables") }}
                            </option>
                            <option value="fruits">
                                {{ t("smartfarming.filters.crops_fruits") }}
                            </option>
                            <option value="cereals">
                                {{ t("smartfarming.filters.crops_cereals") }}
                            </option>
                            <option value="legumes">
                                {{ t("smartfarming.filters.crops_legumes") }}
                            </option>
                            <option value="spices">
                                {{ t("smartfarming.filters.crops_spices") }}
                            </option>
                            <option value="medicinal">
                                {{ t("smartfarming.filters.crops_medicinal") }}
                            </option>
                        </select>
                    </div>

                    <!-- Search Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >{{ t("smartfarming.filters.search") }}</label
                        >
                        <div class="relative">
                            <input
                                v-model="filters.search"
                                type="text"
                                :placeholder="
                                    t('smartfarming.filters.search_placeholder')
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
                                t("smartfarming.results.count", {
                                    count: total,
                                })
                            }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Programs Catalog Section -->
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

                <!-- Programs Grid -->
                <div v-else>
                    <div v-if="programs.length === 0" class="text-center py-12">
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
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ t("smartfarming.empty.title") }}
                        </h3>
                        <p class="text-gray-600 mb-6">
                            {{ t("smartfarming.empty.body") }}
                        </p>
                        <button
                            @click="resetFilters"
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors"
                        >
                            {{ t("smartfarming.empty.clear") }}
                        </button>
                    </div>

                    <div
                        v-else
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <div
                            v-for="program in programs"
                            :key="program.id"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow flex flex-col"
                        >
                            <!-- Program Image -->
                            <div
                                class="aspect-[16/9] bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg mb-4 flex items-center justify-center"
                            >
                                <div
                                    v-if="program.cover_image"
                                    class="w-full h-full"
                                >
                                    <img
                                        :src="program.cover_image"
                                        :alt="program.name"
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
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        ></path>
                                    </svg>
                                    <p class="text-green-600 font-medium">
                                        {{
                                            program.farming_type
                                                ? formatFarmingType(
                                                      program.farming_type
                                                  )
                                                : t("smartfarming.title")
                                        }}
                                    </p>
                                </div>
                            </div>

                            <!-- Program Info -->
                            <div class="mb-4 flex-grow">
                                <h3
                                    class="text-lg font-semibold text-gray-900 mb-2"
                                >
                                    {{ program.name }}
                                </h3>
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    {{
                                        program.short_description ||
                                        program.description
                                    }}
                                </p>
                            </div>

                            <!-- Program Meta -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    v-if="program.farming_type"
                                    class="px-2 py-1 bg-brand-cream text-brand-primary text-xs font-medium rounded-full"
                                >
                                    {{
                                        formatFarmingType(program.farming_type)
                                    }}
                                </span>
                                <span
                                    v-if="program.target_crops"
                                    class="px-2 py-1 bg-brand-cream text-brand-primary text-xs font-medium rounded-full"
                                >
                                    {{ formatCrops(program.target_crops) }}
                                </span>
                                <span
                                    v-if="program.sustainability_level"
                                    class="px-2 py-1 bg-brand-cream text-brand-primary text-xs font-medium rounded-full"
                                >
                                    {{ program.sustainability_level }}%
                                    {{ t("smartfarming.meta.sustainable") }}
                                </span>
                            </div>

                            <!-- Program Action -->
                            <div class="mt-4">
                                <router-link
                                    :to="`/smart-farming/${
                                        program.slug || program.id
                                    }`"
                                    class="w-full bg-brand-primary text-white font-semibold py-3 px-4 rounded-lg hover:opacity-90 transition-all duration-200 text-sm text-center shadow-sm hover:shadow-md block"
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
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        ></path>
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        ></path>
                                    </svg>
                                    {{ t("common.view_details") }}
                                </router-link>
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
const programs = ref([]);
const total = ref(0);
const { currentLanguage, onLanguageChange, t } = useI18n();
let unsubscribeLang = null;

const filters = ref({
    type: "",
    crops: "",
    search: "",
});

// Computed stats
const totalPrograms = computed(() => programs.value.length);
const uniqueTechniques = computed(() => {
    const techniques = programs.value
        .map((program) => program.farming_type)
        .filter(Boolean);
    return new Set(techniques).size;
});
const climateResilientCount = computed(() => {
    return programs.value.filter(
        (program) => program.farming_type === "climate_resilient"
    ).length;
});

// Watch filters and fetch programs
watch(
    filters,
    () => {
        fetchPrograms();
    },
    { deep: true }
);

onMounted(() => {
    fetchPrograms();
    unsubscribeLang = onLanguageChange(() => fetchPrograms());
});

onUnmounted(() => {
    if (typeof unsubscribeLang === "function") unsubscribeLang();
});

async function fetchPrograms() {
    loading.value = true;
    try {
        const params = new URLSearchParams();
        if (filters.value.type) params.set("farming_type", filters.value.type);
        if (filters.value.crops)
            params.set("target_crops", filters.value.crops);
        if (filters.value.search) params.set("search", filters.value.search);

        const lang =
            localStorage.getItem("preferred_language") ||
            currentLanguage?.value ||
            "en";
        params.set("lang", lang);
        console.log(
            "Fetching smart farming programs with params:",
            params.toString()
        );
        const res = await fetch(
            `/api/smart-farming-programs?${params.toString()}`
        );
        if (!res.ok) throw new Error("Failed to load programs");

        const data = await res.json();
        const list = Array.isArray(data?.data)
            ? data.data
            : Array.isArray(data)
            ? data
            : [];

        let mappedPrograms = list.map((program) => ({
            id: program.id,
            name: program.name || program.title || "Smart Farming Program",
            description: program.description || program.short_description || "",
            short_description:
                program.short_description || program.description || "",
            farming_type: program.farming_type || program.type,
            target_crops: program.target_crops,
            sustainability_level: program.sustainability_level,
            application_deadline: program.application_deadline,
            cover_image:
                program.cover_image || program.thumbnail_image || program.image,
            status: program.status || "published",
            slug: program.slug,
        }));

        // Client-side search if API doesn't handle it
        if (filters.value.search) {
            const searchTerm = filters.value.search.toLowerCase();
            mappedPrograms = mappedPrograms.filter(
                (program) =>
                    program.name.toLowerCase().includes(searchTerm) ||
                    program.description.toLowerCase().includes(searchTerm) ||
                    program.short_description
                        .toLowerCase()
                        .includes(searchTerm) ||
                    (program.farming_type &&
                        program.farming_type.toLowerCase().includes(searchTerm))
            );
        }

        programs.value = mappedPrograms;
        total.value = programs.value.length;

        // Debug: Log the first and last programs to see their data
        console.log("First program:", programs.value[0]);
        console.log("Last program:", programs.value[programs.value.length - 1]);
        console.log(
            "All program IDs and slugs:",
            programs.value.map((p) => ({
                id: p.id,
                slug: p.slug,
                name: p.name,
            }))
        );
    } catch (error) {
        console.error("Error fetching programs:", error);
        programs.value = [];
        total.value = 0;
    } finally {
        loading.value = false;
    }
}

function resetFilters() {
    filters.value = {
        type: "",
        crops: "",
        search: "",
    };
}

function formatFarmingType(type) {
    return String(type)
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
}

function formatCrops(crops) {
    if (!crops) return "Various";
    if (typeof crops === "string") {
        try {
            const parsed = JSON.parse(crops);
            return Array.isArray(parsed)
                ? parsed.slice(0, 2).join(", ")
                : crops;
        } catch {
            return crops.split(",").slice(0, 2).join(", ");
        }
    }
    if (Array.isArray(crops)) {
        return crops.slice(0, 2).join(", ");
    }
    return "Various";
}
</script>
