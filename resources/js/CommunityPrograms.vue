<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Modern Hero Section -->
        <section class="relative overflow-hidden">
            <!-- Background with gradient overlay -->
            <div class="absolute inset-0">
                <img
                    :src="'/images/ourWork/ourworkhero.avif'"
                    alt="Community Programs"
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
                            ></path>
                        </svg>
                        <span class="text-white font-medium"
                            >Community Programs</span
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
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"
                            ></path>
                        </svg>
                        Community Development
                    </div>

                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight"
                    >
                        Community Programs
                    </h1>

                    <p
                        class="text-xl text-white mb-8 leading-relaxed max-w-3xl mx-auto"
                    >
                        Strengthen communities through targeted development
                        initiatives, capacity building, and sustainable
                        partnerships that create lasting positive impact.
                    </p>

                    <!-- Quick Stats -->
                    <div class="flex flex-wrap justify-center gap-6 mb-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ totalPrograms }}
                            </div>
                            <div class="text-green-200 text-sm">
                                Active Programs
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ uniqueTargetGroups }}
                            </div>
                            <div class="text-green-200 text-sm">
                                Target Groups
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ partnerCount }}
                            </div>
                            <div class="text-green-200 text-sm">
                                Partner Organizations
                            </div>
                        </div>
                    </div>

                    <!-- Scroll Indicator -->
                    <div class="flex flex-col items-center">
                        <span class="text-green-200 text-sm mb-2"
                            >Explore programs below</span
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
                        Filter Programs
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
                        Reset Filters
                    </button>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"
                >
                    <!-- Program Type Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Program Type</label
                        >
                        <select
                            v-model="filters.program_type"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        >
                            <option value="">All Types</option>
                            <option
                                v-for="type in programTypeOptions"
                                :key="type"
                                :value="type"
                            >
                                {{ formatProgramType(type) }}
                            </option>
                        </select>
                    </div>

                    <!-- Target Group Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Target Group</label
                        >
                        <select
                            v-model="filters.target_group"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        >
                            <option value="">All Groups</option>
                            <option
                                v-for="group in targetGroupOptions"
                                :key="group"
                                :value="group"
                            >
                                {{ formatTargetGroup(group) }}
                            </option>
                        </select>
                    </div>

                    <!-- Search Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Search</label
                        >
                        <div class="relative">
                            <input
                                v-model="filters.search"
                                type="text"
                                placeholder="Search programs..."
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
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            No Programs Found
                        </h3>
                        <p class="text-gray-600 mb-6">
                            No programs match your current filters. Try
                            adjusting your search criteria.
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
                                        :alt="program.title"
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
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                        ></path>
                                    </svg>
                                    <p class="text-green-600 font-medium">
                                        {{ program.program_type || "Program" }}
                                    </p>
                                </div>
                            </div>

                            <!-- Program Info -->
                            <div class="mb-4 flex-grow">
                                <h3
                                    class="text-lg font-semibold text-gray-900 mb-2"
                                >
                                    {{ program.title }}
                                </h3>
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    {{ program.description }}
                                </p>
                            </div>

                            <!-- Program Meta -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    v-if="program.program_type"
                                    class="px-2 py-1 bg-brand-cream text-brand-primary text-xs font-medium rounded-full"
                                >
                                    {{
                                        formatProgramType(program.program_type)
                                    }}
                                </span>
                                <span
                                    v-if="program.target_group"
                                    class="px-2 py-1 bg-brand-cream text-brand-primary text-xs font-medium rounded-full"
                                >
                                    {{
                                        formatTargetGroup(program.target_group)
                                    }}
                                </span>
                                <span
                                    v-if="program.partner_organizations"
                                    class="px-2 py-1 bg-brand-cream text-brand-primary text-xs font-medium rounded-full"
                                >
                                    {{
                                        formatPartners(
                                            program.partner_organizations
                                        )
                                    }}
                                </span>
                            </div>

                            <!-- Program Action -->
                            <div class="mt-4">
                                <router-link
                                    :to="`/community-programs/${
                                        program.slug || program.id
                                    }`"
                                    class="w-full bg-brand-primary text-white font-semibold py-3 px-4 rounded-lg hover:bg-brand-secondary transition-all duration-200 text-sm text-center shadow-sm hover:shadow-md block"
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
                                    View Details
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
import { onMounted, ref, watch, computed } from "vue";

const loading = ref(true);
const programs = ref([]);
const total = ref(0);

const filters = ref({
    program_type: "",
    target_group: "",
    search: "",
});

// Dynamic filter options
const programTypeOptions = computed(() => {
    const types = programs.value
        .map((program) => program.program_type)
        .filter(Boolean);
    return [...new Set(types)];
});

const targetGroupOptions = computed(() => {
    const groups = programs.value
        .map((program) => program.target_group)
        .filter(Boolean);
    return [...new Set(groups)];
});

// Computed stats
const totalPrograms = computed(() => programs.value.length);
const uniqueTargetGroups = computed(() => {
    const groups = programs.value
        .map((program) => program.target_group)
        .filter(Boolean);
    return new Set(groups).size;
});
const partnerCount = computed(() => {
    const partners = programs.value
        .map((program) => program.partner_organizations)
        .filter(Boolean);
    const allPartners = partners.flatMap((partner) => {
        if (typeof partner === "string") {
            try {
                return JSON.parse(partner);
            } catch {
                return partner.split(",").map((p) => p.trim());
            }
        }
        return Array.isArray(partner) ? partner : [];
    });
    return new Set(allPartners).size;
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
});

async function fetchPrograms() {
    loading.value = true;
    try {
        const params = new URLSearchParams();
        if (filters.value.program_type)
            params.set("program_type", filters.value.program_type);
        if (filters.value.target_group)
            params.set("target_group", filters.value.target_group);
        if (filters.value.search) params.set("search", filters.value.search);

        console.log(
            "Fetching community programs with params:",
            params.toString()
        );
        const res = await fetch(`/api/community-programs?${params.toString()}`);
        if (!res.ok) throw new Error("Failed to load programs");

        const data = await res.json();
        const list = Array.isArray(data?.data)
            ? data.data
            : Array.isArray(data)
            ? data
            : [];

        let mappedPrograms = list.map((program) => ({
            id: program.id,
            title: program.title || program.name || "Community Program",
            description: program.description || "",
            program_type: program.program_type,
            target_group: program.target_group,
            partner_organizations: program.partner_organizations,
            cover_image:
                program.cover_image ||
                program.featured_image ||
                program.thumbnail_image,
            status: program.status || "published",
            slug: program.slug,
        }));

        // Client-side search if API doesn't handle it
        if (filters.value.search) {
            const searchTerm = filters.value.search.toLowerCase();
            mappedPrograms = mappedPrograms.filter(
                (program) =>
                    program.title.toLowerCase().includes(searchTerm) ||
                    program.description.toLowerCase().includes(searchTerm) ||
                    (program.program_type &&
                        program.program_type
                            .toLowerCase()
                            .includes(searchTerm)) ||
                    (program.target_group &&
                        program.target_group.toLowerCase().includes(searchTerm))
            );
        }

        programs.value = mappedPrograms;
        total.value = programs.value.length;

        console.log("Community programs loaded:", programs.value.length);
    } catch (error) {
        console.error("Error fetching community programs:", error);
        programs.value = [];
        total.value = 0;
    } finally {
        loading.value = false;
    }
}

function resetFilters() {
    filters.value = {
        program_type: "",
        target_group: "",
        search: "",
    };
}

// Formatting functions
function formatProgramType(type) {
    if (!type) return "";
    return type
        .split("_")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
}

function formatTargetGroup(group) {
    if (!group) return "";
    return group
        .split("_")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
}

function formatPartners(partners) {
    if (!partners) return "";
    if (typeof partners === "string") {
        try {
            const parsed = JSON.parse(partners);
            return Array.isArray(parsed)
                ? parsed.length + " Partners"
                : "Partners";
        } catch {
            return partners.split(",").length + " Partners";
        }
    }
    if (Array.isArray(partners)) {
        return partners.length + " Partners";
    }
    return "Partners";
}
</script>
