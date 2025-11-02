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
                <p class="text-gray-600">
                    {{ t("seedsupply.detail.loading") }}
                </p>
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
                    {{ t("seedsupply.detail.error.title") }}
                </h2>
                <p class="text-gray-600 mb-6">{{ error }}</p>
                <router-link
                    to="/seed-supply"
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
                    {{ t("seedsupply.detail.error.back") }}
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
                        v-else
                        class="w-full h-full bg-gradient-to-br from-green-600 via-emerald-700 to-teal-800"
                    ></div>
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
                    class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20"
                >
                    <!-- Breadcrumbs -->
                    <nav class="mb-8">
                        <div class="flex items-center space-x-2 text-sm">
                            <router-link
                                to="/"
                                class="text-green-200 hover:text-white transition-colors"
                                >{{
                                    t("seedsupply.breadcrumb.home")
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
                            <router-link
                                to="/seed-supply"
                                class="text-green-200 hover:text-white transition-colors"
                                >{{ t("seedsupply.title") }}</router-link
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
                        <!-- Program Type Badge -->
                        <div
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-500/20 text-green-100 border border-green-400/30 mb-6"
                        >
                            <svg
                                class="w-4 h-4 mr-2"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            {{ formatInputType(program.input_type) }}
                        </div>

                        <h1
                            class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6 leading-tight"
                        >
                            {{ program.name }}
                        </h1>

                        <p
                            class="text-lg sm:text-xl text-white mb-6 sm:mb-8 leading-relaxed max-w-3xl mx-auto px-4 sm:px-0"
                        >
                            {{
                                program.short_description || program.description
                            }}
                        </p>

                        <!-- Quick Stats -->
                        <div
                            class="flex flex-wrap justify-center gap-4 sm:gap-6 mb-6 sm:mb-8"
                        >
                            <div
                                v-if="program.quality_grade"
                                class="text-center"
                            >
                                <div
                                    class="text-2xl sm:text-3xl font-bold text-white"
                                >
                                    {{ program.quality_grade }}
                                </div>
                                <div class="text-green-200 text-xs sm:text-sm">
                                    {{ t("seedsupply.detail.quality_grade") }}
                                </div>
                            </div>
                            <div
                                v-if="program.availability"
                                class="text-center"
                            >
                                <div
                                    class="text-2xl sm:text-3xl font-bold text-white"
                                >
                                    {{ program.availability }}
                                </div>
                                <div class="text-green-200 text-xs sm:text-sm">
                                    {{ t("seedsupply.detail.availability") }}
                                </div>
                            </div>
                            <div v-if="program.price_range" class="text-center">
                                <div
                                    class="text-2xl sm:text-3xl font-bold text-white"
                                >
                                    {{ program.price_range }}
                                </div>
                                <div class="text-green-200 text-xs sm:text-sm">
                                    {{ t("seedsupply.detail.price_range") }}
                                </div>
                            </div>
                        </div>

                        <!-- Learn More Button -->
                        <div class="flex justify-center px-4 sm:px-0">
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
                                {{ t("seedsupply.detail.learn_more") }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <section class="py-12 sm:py-16 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                        <!-- Main Content Column -->
                        <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                            <!-- Product Overview -->
                            <div
                                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-4"
                                >
                                    {{ t("seedsupply.detail.overview") }}
                                </h2>
                                <div
                                    class="prose prose-lg max-w-none text-gray-600"
                                >
                                    <p>
                                        {{
                                            program.description ||
                                            program.short_description
                                        }}
                                    </p>
                                </div>
                            </div>

                            <!-- Target Crops -->
                            <div
                                v-if="program.target_crops"
                                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-4"
                                >
                                    {{ t("seedsupply.detail.target_crops") }}
                                </h2>
                                <div class="flex flex-wrap gap-3">
                                    <span
                                        v-for="crop in getCropList(
                                            program.target_crops
                                        )"
                                        :key="crop"
                                        class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium"
                                    >
                                        {{ crop }}
                                    </span>
                                </div>
                            </div>

                            <!-- Technical Specifications -->
                            <div
                                v-if="program.technical_specifications"
                                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-4"
                                >
                                    {{
                                        t(
                                            "seedsupply.detail.technical_specifications"
                                        )
                                    }}
                                </h2>
                                <div
                                    class="prose prose-lg max-w-none text-gray-600"
                                >
                                    <p>
                                        {{ program.technical_specifications }}
                                    </p>
                                </div>
                            </div>

                            <!-- Usage Instructions -->
                            <div
                                v-if="program.usage_instructions"
                                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-4"
                                >
                                    {{
                                        t(
                                            "seedsupply.detail.usage_instructions"
                                        )
                                    }}
                                </h2>
                                <div
                                    class="prose prose-lg max-w-none text-gray-600"
                                >
                                    <p>{{ program.usage_instructions }}</p>
                                </div>
                            </div>

                            <!-- Distribution Centers -->
                            <div
                                v-if="program.distribution_centers"
                                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-4"
                                >
                                    {{
                                        t(
                                            "seedsupply.detail.distribution_centers"
                                        )
                                    }}
                                </h2>
                                <div class="flex flex-wrap gap-3">
                                    <span
                                        v-for="center in getDistributionList(
                                            program.distribution_centers
                                        )"
                                        :key="center"
                                        class="px-4 py-2 bg-emerald-100 text-emerald-800 rounded-full text-sm font-medium"
                                    >
                                        {{ center }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Column -->
                        <div class="space-y-4 sm:space-y-6">
                            <!-- Quick Info Card -->
                            <div
                                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-4"
                                >
                                    {{ t("seedsupply.detail.program_details") }}
                                </h3>
                                <div class="space-y-4">
                                    <div
                                        v-if="program.input_type"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">{{
                                            t("seedsupply.detail.input_type")
                                        }}</span>
                                        <span class="text-gray-900 font-medium">
                                            {{
                                                formatInputType(
                                                    program.input_type
                                                )
                                            }}
                                        </span>
                                    </div>
                                    <div
                                        v-if="program.quality_grade"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">{{
                                            t("seedsupply.detail.quality_grade")
                                        }}</span>
                                        <span class="text-gray-900 font-medium">
                                            {{ program.quality_grade }}
                                        </span>
                                    </div>
                                    <div
                                        v-if="program.availability"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">{{
                                            t("seedsupply.detail.availability")
                                        }}</span>
                                        <span
                                            class="text-green-600 font-medium"
                                        >
                                            {{ program.availability }}
                                        </span>
                                    </div>
                                    <div
                                        v-if="program.price_range"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">{{
                                            t("seedsupply.detail.price_range")
                                        }}</span>
                                        <span class="text-gray-900 font-medium">
                                            {{ program.price_range }}
                                        </span>
                                    </div>
                                    <div
                                        v-if="program.shelf_life"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">{{
                                            t("seedsupply.detail.shelf_life")
                                        }}</span>
                                        <span class="text-gray-900 font-medium">
                                            {{ program.shelf_life }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Information Card -->
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-100 p-6 shadow-sm"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-2"
                                >
                                    {{ t("seedsupply.detail.need_info") }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ t("seedsupply.detail.need_info_sub") }}
                                </p>

                                <router-link
                                    to="/contact"
                                    class="w-full bg-brand-primary text-white font-bold py-3 px-4 rounded-xl hover:bg-brand-secondary transition-all duration-200 shadow-sm hover:shadow-md text-center block"
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
                                    {{ t("seedsupply.detail.contact_us") }}
                                </router-link>
                            </div>

                            <!-- Contact Information -->
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-4"
                                >
                                    {{ t("seedsupply.detail.contact_info") }}
                                </h3>
                                <div class="space-y-3 text-sm">
                                    <div v-if="program.supplier" class="mb-3">
                                        <div class="text-gray-500 text-xs mb-1">
                                            {{
                                                t("seedsupply.detail.supplier")
                                            }}
                                        </div>
                                        <div class="text-gray-900 font-medium">
                                            {{ program.supplier }}
                                        </div>
                                    </div>
                                    <div
                                        v-if="program.contact_info"
                                        class="space-y-2"
                                    >
                                        <div
                                            v-for="info in getContactInfo(
                                                program.contact_info
                                            )"
                                            :key="info"
                                            class="flex items-center"
                                        >
                                            <svg
                                                class="w-4 h-4 text-green-600 mr-3"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                                ></path>
                                            </svg>
                                            <span class="text-gray-600">{{
                                                info
                                            }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from "vue";
import { useRoute } from "vue-router";
import { useI18n } from "./composables/useI18n";

const route = useRoute();

const loading = ref(true);
const error = ref(null);
const program = ref(null);
const { currentLanguage, onLanguageChange, t } = useI18n();
let unsubscribeLang = null;

onMounted(() => {
    fetchProgramDetail();
    unsubscribeLang = onLanguageChange(() => fetchProgramDetail());
});

onUnmounted(() => {
    if (typeof unsubscribeLang === "function") unsubscribeLang();
});

// Watch for route changes to handle in-app navigation
watch(
    () => route.params.idOrSlug,
    () => {
        if (route.params.idOrSlug) {
            fetchProgramDetail();
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    }
);

async function fetchProgramDetail() {
    loading.value = true;
    error.value = null;

    try {
        const idOrSlug = route.params.idOrSlug;
        console.log("Fetching seed supply program detail for:", idOrSlug);

        // Try to fetch by slug first (API expects slug)
        let response;
        try {
            const lang =
                localStorage.getItem("preferred_language") ||
                currentLanguage?.value ||
                "en";
            response = await fetch(
                `/api/seed-supply-programs/${idOrSlug}?lang=${encodeURIComponent(
                    lang
                )}`
            );
            if (response.ok) {
                const data = await response.json();
                program.value = formatProgram(data.data || data);
                return;
            }
        } catch (err) {
            console.log("Direct fetch failed, trying list approach:", err);
        }

        // If direct fetch fails, try to find by slug or ID in the list
        try {
            const lang =
                localStorage.getItem("preferred_language") ||
                currentLanguage?.value ||
                "en";
            const listResponse = await fetch(
                `/api/seed-supply-programs?lang=${encodeURIComponent(lang)}`
            );
            if (!listResponse.ok)
                throw new Error("Failed to fetch programs list");

            const listData = await listResponse.json();
            const programs = Array.isArray(listData?.data)
                ? listData.data
                : Array.isArray(listData)
                ? listData
                : [];
            console.log(
                "Available programs:",
                programs.map((p) => ({ id: p.id, slug: p.slug, name: p.name }))
            );
            console.log("Looking for:", idOrSlug);

            const foundProgram = programs.find(
                (p) =>
                    p.slug === idOrSlug ||
                    p.id == idOrSlug ||
                    String(p.id) === String(idOrSlug)
            );

            if (foundProgram) {
                program.value = formatProgram(foundProgram);
                return;
            } else {
                throw new Error(
                    `Program not found with identifier: ${idOrSlug}`
                );
            }
        } catch (err) {
            throw new Error(err.message || "Failed to find program");
        }
    } catch (err) {
        console.error("Error fetching program detail:", err);
        error.value = err.message || "Failed to load program details";
    } finally {
        loading.value = false;
    }
}

function formatProgram(rawProgram) {
    return {
        id: rawProgram.id,
        name: rawProgram.name || rawProgram.title || "Seed Supply Program",
        description:
            rawProgram.description || rawProgram.short_description || "",
        short_description:
            rawProgram.short_description || rawProgram.description || "",
        input_type: rawProgram.input_type || rawProgram.type,
        target_crops: rawProgram.target_crops,
        quality_grade: rawProgram.quality_grade,
        price_range: rawProgram.price_range,
        availability: rawProgram.availability || "Available",
        shelf_life: rawProgram.shelf_life,
        distribution_centers: rawProgram.distribution_centers,
        usage_instructions: rawProgram.usage_instructions,
        technical_specifications: rawProgram.technical_specifications,
        supplier: rawProgram.supplier,
        contact_info: rawProgram.contact_info,
        cover_image:
            rawProgram.cover_image ||
            rawProgram.thumbnail_image ||
            rawProgram.image,
        status: rawProgram.status || "published",
        slug: rawProgram.slug,
    };
}

function formatInputType(type) {
    if (!type) return t("seedsupply.detail.input_type");
    return String(type)
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
}

function formatCrops(crops) {
    if (!crops) return t("seedsupply.meta.various");
    if (typeof crops === "string") {
        try {
            const parsed = JSON.parse(crops);
            return Array.isArray(parsed) ? parsed.join(", ") : crops;
        } catch {
            return crops;
        }
    }
    if (Array.isArray(crops)) {
        return crops.join(", ");
    }
    return t("seedsupply.meta.various");
}

function getCropList(crops) {
    if (!crops) return [];
    if (typeof crops === "string") {
        try {
            const parsed = JSON.parse(crops);
            return Array.isArray(parsed) ? parsed : [crops];
        } catch {
            return crops
                .split(",")
                .map((c) => c.trim())
                .filter(Boolean);
        }
    }
    if (Array.isArray(crops)) {
        return crops;
    }
    return [];
}

function getDistributionList(centers) {
    if (!centers) return [];
    if (typeof centers === "string") {
        try {
            const parsed = JSON.parse(centers);
            return Array.isArray(parsed) ? parsed : [centers];
        } catch {
            return centers
                .split(",")
                .map((c) => c.trim())
                .filter(Boolean);
        }
    }
    if (Array.isArray(centers)) {
        return centers;
    }
    return [];
}

function getContactInfo(contact) {
    if (!contact) return [];
    return contact
        .split(",")
        .map((c) => c.trim())
        .filter(Boolean);
}
</script>
