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
                <p class="text-gray-600">Loading program details...</p>
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
                    Program Not Found
                </h2>
                <p class="text-gray-600 mb-6">{{ error }}</p>
                <router-link
                    to="/market-access"
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
                    Back to Programs
                </router-link>
            </div>
        </div>

        <!-- Program Detail Content -->
        <div v-else-if="program">
            <!-- Modern Hero Section -->
            <section class="relative overflow-hidden">
                <!-- Background with gradient overlay -->
                <div class="absolute inset-0">
                    <img
                        v-if="program.cover_image"
                        :src="program.cover_image"
                        :alt="program.name"
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
                            <router-link
                                to="/market-access"
                                class="text-green-200 hover:text-white transition-colors"
                                >Market Access Programs</router-link
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
                                program.name
                            }}</span>
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
                                ></path>
                            </svg>
                            {{ formatProgramType(program.program_type) }}
                        </div>

                        <h1
                            class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight"
                        >
                            {{ program.name }}
                        </h1>

                        <p
                            class="text-xl text-white mb-8 leading-relaxed max-w-3xl mx-auto"
                        >
                            {{
                                program.short_description || program.description
                            }}
                        </p>

                        <!-- Quick Meta -->
                        <div class="flex flex-wrap justify-center gap-6 mb-8">
                            <div
                                v-if="program.target_crops"
                                class="text-center"
                            >
                                <div class="text-2xl font-bold text-white">
                                    {{ getCropCount(program.target_crops) }}
                                </div>
                                <div class="text-green-200 text-sm">
                                    Target Crops
                                </div>
                            </div>
                            <div v-if="program.location" class="text-center">
                                <div class="text-2xl font-bold text-white">
                                    {{ program.location }}
                                </div>
                                <div class="text-green-200 text-sm">
                                    Location
                                </div>
                            </div>
                            <div
                                v-if="program.partner_organizations"
                                class="text-center"
                            >
                                <div class="text-2xl font-bold text-white">
                                    {{
                                        getPartnerCount(
                                            program.partner_organizations
                                        )
                                    }}
                                </div>
                                <div class="text-green-200 text-sm">
                                    Partners
                                </div>
                            </div>
                        </div>

                        <!-- Learn More Button -->
                        <div class="flex justify-center">
                            <router-link
                                to="/contact"
                                class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-brand-primary text-white font-semibold rounded-xl hover:bg-brand-secondary transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-sm sm:text-base"
                            >
                                <svg
                                    class="w-5 h-5 mr-3"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                    ></path>
                                </svg>
                                Learn More
                            </router-link>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <section class="py-12 sm:py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                        <!-- Main Content -->
                        <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                            <!-- Program Overview -->
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-8"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-6"
                                >
                                    Program Overview
                                </h2>
                                <div class="prose prose-lg max-w-none">
                                    <p class="text-gray-600 leading-relaxed">
                                        {{ program.description }}
                                    </p>
                                </div>
                            </div>

                            <!-- Target Crops -->
                            <div
                                v-if="program.target_crops"
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-6"
                                >
                                    Target Crops
                                </h2>
                                <div class="flex flex-wrap gap-3">
                                    <span
                                        v-for="crop in getCropList(
                                            program.target_crops
                                        )"
                                        :key="crop"
                                        class="px-4 py-2 bg-emerald-100 text-emerald-800 text-sm font-medium rounded-full"
                                    >
                                        {{ formatCropName(crop) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Partner Organizations -->
                            <div
                                v-if="program.partner_organizations"
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-6"
                                >
                                    Partner Organizations
                                </h2>
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 gap-4"
                                >
                                    <div
                                        v-for="partner in getPartnerList(
                                            program.partner_organizations
                                        )"
                                        :key="partner"
                                        class="flex items-center p-4 bg-green-50 rounded-lg border border-green-100"
                                    >
                                        <svg
                                            class="w-8 h-8 text-green-600 mr-3"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                            ></path>
                                        </svg>
                                        <span class="text-gray-900 font-medium">
                                            {{ partner }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-4 sm:space-y-6">
                            <!-- Quick Info Card -->
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-4"
                                >
                                    Quick Information
                                </h3>
                                <div class="space-y-4">
                                    <div
                                        v-if="program.program_type"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">Type</span>
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full"
                                        >
                                            {{
                                                formatProgramType(
                                                    program.program_type
                                                )
                                            }}
                                        </span>
                                    </div>
                                    <div
                                        v-if="program.location"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600"
                                            >Location</span
                                        >
                                        <span class="text-gray-900 font-medium">
                                            {{ program.location }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Application Card -->
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-200 p-6"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-4"
                                >
                                    Need More Information?
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    Get detailed information about this market
                                    access program and how it can benefit your
                                    agricultural business.
                                </p>
                                <router-link
                                    to="/contact"
                                    class="w-full bg-brand-primary text-white font-semibold py-3 px-4 rounded-xl hover:bg-brand-secondary transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 text-center block"
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
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                        ></path>
                                    </svg>
                                    Get Information
                                </router-link>
                            </div>

                            <!-- Contact Information -->
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-4"
                                >
                                    Need Help?
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    Contact our team for more information about
                                    this program.
                                </p>
                                <router-link
                                    to="/contact"
                                    class="inline-flex items-center text-green-600 hover:text-green-700 font-medium transition-colors"
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
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                        ></path>
                                    </svg>
                                    Contact Us
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const loading = ref(true);
const error = ref(null);
const program = ref(null);

onMounted(async () => {
    await fetchProgram();
});

// Watch for route changes to handle in-app navigation
watch(
    () => route.params.idOrSlug,
    () => {
        if (route.params.idOrSlug) {
            fetchProgram();
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    }
);

async function fetchProgram() {
    loading.value = true;
    error.value = null;

    try {
        const slug = route.params.idOrSlug;
        console.log("Fetching program with slug:", slug);

        const res = await fetch(`/api/market-access-programs/${slug}`);
        console.log("Response status:", res.status);

        if (!res.ok) {
            if (res.status === 404) {
                throw new Error("Program not found");
            }
            throw new Error(`Failed to load program: ${res.status}`);
        }

        const data = await res.json();
        console.log("Raw API response:", data);

        // Check if we have the expected data structure
        if (!data || !data.program) {
            console.error("Invalid API response structure:", data);
            throw new Error("Invalid program data received");
        }

        program.value = {
            id: data.program.id,
            name:
                data.program.title ||
                data.program.name ||
                "Market Access Program",
            description: data.program.description || "",
            short_description: data.program.description || "",
            program_type: data.program.program_type,
            target_crops: data.program.target_crops,
            partner_organizations: data.program.partner_organizations,
            location: data.program.location,
            application_deadline: data.program.application_deadline,
            cover_image:
                data.program.cover_image || data.program.thumbnail_image,
            status: data.program.status || "published",
            slug: data.program.slug,
        };

        console.log("Successfully mapped program:", program.value);
    } catch (err) {
        console.error("Error fetching program:", err);
        error.value = err.message;
    } finally {
        loading.value = false;
    }
}

function formatProgramType(type) {
    return String(type)
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
}

function formatCropName(crop) {
    return String(crop)
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
}

function getCropList(crops) {
    if (!crops) return [];
    if (Array.isArray(crops)) return crops;
    if (typeof crops === "string") {
        try {
            const parsed = JSON.parse(crops);
            return Array.isArray(parsed) ? parsed : [crops];
        } catch {
            return crops.split(",").map((c) => c.trim());
        }
    }
    return [];
}

function getCropCount(crops) {
    return getCropList(crops).length;
}

function getPartnerList(partners) {
    if (!partners) return [];
    if (Array.isArray(partners)) return partners;
    if (typeof partners === "string") {
        try {
            const parsed = JSON.parse(partners);
            return Array.isArray(parsed) ? parsed : [partners];
        } catch {
            return partners.split(",").map((p) => p.trim());
        }
    }
    return [];
}

function getPartnerCount(partners) {
    return getPartnerList(partners).length;
}
</script>
