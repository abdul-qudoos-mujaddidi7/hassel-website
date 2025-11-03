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
                <p class="text-gray-600">{{ t("community.detail.loading") }}</p>
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
                        />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    {{ t("community.detail.error.title") }}
                </h2>
                <p class="text-gray-600 mb-6">{{ error }}</p>
                <router-link
                    to="/community-programs"
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
                        />
                    </svg>
                    {{ t("community.detail.error.back") }}
                </router-link>
            </div>
        </div>

        <!-- Program Detail Content -->
        <div v-else-if="program">
            <!-- Hero Section -->
            <section class="relative overflow-hidden">
                <div class="absolute inset-0">
                    <img
                        :src="heroImage"
                        :alt="program.title || 'Community Program'"
                        class="w-full h-full object-cover"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-900/85 via-green-800/80 to-emerald-900/85"
                    ></div>
                </div>

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
                                    t("community.breadcrumb.home")
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
                                />
                            </svg>
                            <router-link
                                to="/community-programs"
                                class="text-green-200 hover:text-white transition-colors"
                                >{{ t("community.title") }}</router-link
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
                            <span class="text-white font-medium">{{
                                program.title
                            }}</span>
                        </div>
                    </nav>

                    <div class="text-center max-w-4xl mx-auto">
                        <div
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-500/20 text-green-100 border border-green-400/30 mb-6"
                            v-if="program.program_type"
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
                            {{ formatProgramType(program.program_type) }}
                        </div>

                        <h1
                            class="text-3xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight"
                        >
                            {{ program.title }}
                        </h1>

                        <p
                            class="text-xl text-white mb-8 leading-relaxed max-w-3xl mx-auto"
                        >
                            {{
                                program.short_description || program.description
                            }}
                        </p>

                        <div class="flex flex-wrap justify-center gap-6 mb-8">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">
                                    {{
                                        program.target_group
                                            ? formatTargetGroup(
                                                  program.target_group
                                              )
                                            : t(
                                                  "community.meta.general_community"
                                              )
                                    }}
                                </div>
                                <div class="text-green-200 text-sm">
                                    {{ t("community.detail.target_group") }}
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">
                                    {{
                                        getPartnerCount(
                                            program.partner_organizations
                                        )
                                    }}
                                </div>
                                <div class="text-green-200 text-sm">
                                    {{ t("community.detail.partners") }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <section class="py-12 sm:py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                        <!-- Main -->
                        <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 md:p-8"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-6"
                                >
                                    {{ t("community.detail.overview") }}
                                </h2>
                                <div class="prose max-w-none">
                                    <p class="text-gray-600 leading-relaxed">
                                        {{
                                            program.description ||
                                            t("community.detail.no_description")
                                        }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-6"
                                >
                                    {{
                                        t(
                                            "community.detail.partner_organizations"
                                        )
                                    }}
                                </h2>
                                <template
                                    v-if="
                                        getPartnerCount(
                                            program.partner_organizations
                                        ) > 0
                                    "
                                >
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
                                                />
                                            </svg>
                                            <span
                                                class="text-gray-900 font-medium"
                                                >{{ partner }}</span
                                            >
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div
                                        class="p-6 bg-gray-50 border border-gray-200 rounded-xl text-center text-gray-600"
                                    >
                                        {{ t("community.detail.no_partners") }}
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-4 sm:space-y-6">
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-4"
                                >
                                    {{ t("community.detail.quick_info") }}
                                </h3>
                                <div class="space-y-4">
                                    <div
                                        v-if="program.program_type"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">{{
                                            t("community.detail.program_type")
                                        }}</span>
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full"
                                            >{{
                                                formatProgramType(
                                                    program.program_type
                                                )
                                            }}</span
                                        >
                                    </div>
                                    <div
                                        v-if="program.location"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">{{
                                            t("community.detail.location")
                                        }}</span>
                                        <span
                                            class="text-gray-900 font-medium"
                                            >{{ program.location }}</span
                                        >
                                    </div>
                                </div>
                            </div>

                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-200 p-6"
                            >
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-4"
                                >
                                    {{ t("community.detail.need_info") }}
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    {{ t("community.detail.need_info_sub") }}
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
                                        />
                                    </svg>
                                    {{ t("community.detail.contact_us") }}
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
import { onMounted, onUnmounted, ref, watch } from "vue";
import { useRoute } from "vue-router";
import { useI18n } from "./composables/useI18n";

const route = useRoute();
const loading = ref(true);
const error = ref(null);
const program = ref(null);
const heroImage = ref("/images/ourWork/ourworkhero.avif");
const { currentLanguage, onLanguageChange, t } = useI18n();
let unsubscribeLang = null;

onMounted(async () => {
    await fetchProgram();
    unsubscribeLang = onLanguageChange(() => fetchProgram());
});

onUnmounted(() => {
    if (typeof unsubscribeLang === "function") unsubscribeLang();
});

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
        const idOrSlug = route.params.idOrSlug;
        // Try direct endpoint first
        const lang =
            localStorage.getItem("preferred_language") ||
            currentLanguage?.value ||
            "en";
        let res = await fetch(
            `/api/community-programs/${idOrSlug}?lang=${encodeURIComponent(
                lang
            )}`
        );
        if (res.ok) {
            const data = await res.json();
            const item = data?.data || data?.program || data;
            if (!item) throw new Error("Invalid program data received");
            program.value = mapProgram(item);
            heroImage.value =
                program.value.cover_image || "/images/ourWork/ourworkhero.avif";
            return;
        }

        // Fallback: fetch list and find
        const listRes = await fetch(
            `/api/community-programs?lang=${encodeURIComponent(lang)}`
        );
        if (!listRes.ok) throw new Error("Failed to load programs");
        const listJson = await listRes.json();
        const list = Array.isArray(listJson?.data)
            ? listJson.data
            : Array.isArray(listJson)
            ? listJson
            : [];
        const found = list.find(
            (p) => p.slug === idOrSlug || String(p.id) === String(idOrSlug)
        );
        if (!found) throw new Error("Program not found");
        program.value = mapProgram(found);
        heroImage.value =
            program.value.cover_image || "/images/ourWork/ourworkhero.avif";
    } catch (err) {
        error.value = err.message || "Failed to load program";
    } finally {
        loading.value = false;
    }
}

function mapProgram(p) {
    return {
        id: p.id,
        title: p.title || p.name || "Community Program",
        description: p.description || "",
        short_description: p.short_description || p.description || "",
        program_type: p.program_type,
        target_group: p.target_group,
        partner_organizations: p.partner_organizations,
        location: p.location,
        cover_image:
            p.cover_image ||
            p.featured_image ||
            p.thumbnail_image ||
            "/images/ourWork/ourworkhero.avif",
        status: p.status || "published",
        slug: p.slug,
    };
}

function formatProgramType(type) {
    return String(type)
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
}

function formatTargetGroup(group) {
    return String(group)
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
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
