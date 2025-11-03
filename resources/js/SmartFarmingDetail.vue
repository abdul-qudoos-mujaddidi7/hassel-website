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
                    {{ t("smartfarming.detail.loading") }}
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
                    {{ t("smartfarming.detail.error.title") }}
                </h2>
                <p class="text-gray-600 mb-6">{{ error }}</p>
                <router-link
                    to="/smart-farming"
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
                    {{ t("smartfarming.detail.error.back") }}
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
                    class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-24"
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
                            <router-link
                                to="/smart-farming"
                                class="text-green-200 hover:text-white transition-colors"
                                >{{ t("smartfarming.title") }}</router-link
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
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V8z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            {{ t("smartfarming.detail.badge") }}
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

                        <!-- Quick Stats -->
                        <div class="flex flex-wrap justify-center gap-6 mb-8">
                            <div
                                v-if="program.target_crops"
                                class="text-center"
                            >
                                <div class="text-3xl font-bold text-white">
                                    {{ getCropCount(program.target_crops) }}
                                </div>
                                <div class="text-green-200 text-sm">
                                    {{
                                        t(
                                            "smartfarming.detail.target_crops_count"
                                        )
                                    }}
                                </div>
                            </div>
                            <div
                                v-if="program.sustainability_level"
                                class="text-center"
                            >
                                <div class="text-3xl font-bold text-white">
                                    {{ program.sustainability_level }}%
                                </div>
                                <div class="text-green-200 text-sm">
                                    {{
                                        t("smartfarming.detail.sustainability")
                                    }}
                                </div>
                            </div>
                            <div v-if="program.duration" class="text-center">
                                <div class="text-3xl font-bold text-white">
                                    {{ program.duration }}
                                </div>
                                <div class="text-green-200 text-sm">
                                    {{ t("smartfarming.detail.duration") }}
                                </div>
                            </div>
                        </div>

                        <!-- Learn More Button -->
                        <div class="flex justify-center">
                            <router-link
                                to="/contact"
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
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
                                {{ t("smartfarming.detail.learn_more") }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <section class="py-16 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Main Content Column -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Program Overview -->
                            <div
                                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-4"
                                >
                                    {{ t("smartfarming.detail.overview") }}
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
                                    {{ t("smartfarming.detail.target_crops") }}
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

                            <!-- Implementation Guide -->
                            <div
                                v-if="program.implementation_guide"
                                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-4"
                                >
                                    {{
                                        t(
                                            "smartfarming.detail.implementation_guide"
                                        )
                                    }}
                                </h2>
                                <div
                                    class="prose prose-lg max-w-none text-gray-600"
                                >
                                    <p>{{ program.implementation_guide }}</p>
                                </div>
                            </div>

                            <!-- Sustainability Impact -->
                            <div
                                v-if="program.sustainability_impact"
                                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-4"
                                >
                                    {{
                                        t(
                                            "smartfarming.detail.sustainability_impact"
                                        )
                                    }}
                                </h2>
                                <div
                                    class="prose prose-lg max-w-none text-gray-600"
                                >
                                    <p>{{ program.sustainability_impact }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Column -->
                        <div class="space-y-6">
                            <!-- Quick Info Card -->
                            <div
                                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-4"
                                >
                                    {{
                                        t("smartfarming.detail.program_details")
                                    }}
                                </h3>
                                <div class="space-y-4">
                                    <div
                                        v-if="program.farming_type"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">{{
                                            t(
                                                "smartfarming.detail.farming_type"
                                            )
                                        }}</span>
                                        <span class="text-gray-900 font-medium">
                                            {{
                                                formatFarmingType(
                                                    program.farming_type
                                                )
                                            }}
                                        </span>
                                    </div>
                                    <div
                                        v-if="program.duration"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">{{
                                            t("smartfarming.detail.duration")
                                        }}</span>
                                        <span class="text-gray-900 font-medium">
                                            {{ program.duration }}
                                        </span>
                                    </div>
                                    <div
                                        v-if="program.location"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">{{
                                            t("smartfarming.detail.location")
                                        }}</span>
                                        <span class="text-gray-900 font-medium">
                                            {{ program.location }}
                                        </span>
                                    </div>
                                    <div
                                        v-if="program.sustainability_level"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">{{
                                            t(
                                                "smartfarming.detail.sustainability"
                                            )
                                        }}</span>
                                        <span
                                            class="text-green-600 font-medium"
                                        >
                                            {{ program.sustainability_level }}%
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Information Card -->
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-200 p-6"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-2"
                                >
                                    {{ t("smartfarming.detail.need_info") }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ t("smartfarming.detail.need_info_sub") }}
                                </p>

                                <router-link
                                    to="/contact"
                                    class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-3 px-4 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-sm hover:shadow-md text-center block"
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
                                    {{ t("smartfarming.detail.contact_us") }}
                                </router-link>
                            </div>

                            <!-- Contact Information -->
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-4"
                                >
                                    {{ t("smartfarming.detail.contact_info") }}
                                </h3>
                                <div class="space-y-3 text-sm">
                                    <div class="flex items-center">
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
                                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                            ></path>
                                        </svg>
                                        <span class="text-gray-600"
                                            >info@mountagro.af</span
                                        >
                                    </div>
                                    <div class="flex items-center">
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
                                        <span class="text-gray-600"
                                            >+93-70-123-4567</span
                                        >
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
import { ref, onMounted, onUnmounted, watch, nextTick } from "vue";
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

// React to route changes so detail updates without refresh
watch(
    () => route.params.idOrSlug,
    async () => {
        await fetchProgramDetail();
        await nextTick();
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
);

async function fetchProgramDetail() {
    loading.value = true;
    error.value = null;

    try {
        const idOrSlug = route.params.idOrSlug;
        console.log("Fetching smart farming program detail for:", idOrSlug);

        // Try to fetch by slug first (API expects slug)
        let response;
        try {
            const lang =
                localStorage.getItem("preferred_language") ||
                currentLanguage?.value ||
                "en";
            response = await fetch(
                `/api/smart-farming-programs/${idOrSlug}?lang=${encodeURIComponent(
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
                `/api/smart-farming-programs?lang=${encodeURIComponent(lang)}`
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
        name: rawProgram.name || rawProgram.title || "Smart Farming Program",
        description:
            rawProgram.description || rawProgram.short_description || "",
        short_description:
            rawProgram.short_description || rawProgram.description || "",
        farming_type: rawProgram.farming_type || rawProgram.type,
        target_crops: rawProgram.target_crops,
        sustainability_level: rawProgram.sustainability_level,
        implementation_guide: rawProgram.implementation_guide,
        sustainability_impact: rawProgram.sustainability_impact,
        duration: rawProgram.duration,
        location: rawProgram.location,
        cover_image:
            rawProgram.cover_image ||
            rawProgram.thumbnail_image ||
            rawProgram.image,
        status: rawProgram.status || "published",
        slug: rawProgram.slug,
    };
}

function formatFarmingType(type) {
    if (!type) return "Farming Program";
    return String(type)
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
}

function formatCrops(crops) {
    if (!crops) return "Various";
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
    return "Various";
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

function getCropCount(crops) {
    return getCropList(crops).length;
}
</script>
