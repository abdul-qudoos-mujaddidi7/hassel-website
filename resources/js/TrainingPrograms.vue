<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Modern Hero Section -->
        <section class="relative overflow-hidden">
            <!-- Background with gradient overlay -->
            <div class="absolute inset-0">
                <img
                    :src="'/images/ourWork/ourworkhero.avif'"
                    alt="Training Programs"
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
                class="absolute top-1/2 left-1/4 w-16 h-16 bg-yellow-400/15 rounded-full blur-md"
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
                            >{{ t("training.breadcrumb.home") }}</router-link
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
                            >Training Programs</span
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
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                        {{ t("training.badge") }}
                    </div>

                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight"
                    >
                        {{ t("training.title") }}
                    </h1>

                    <p
                        class="text-xl text-white mb-8 leading-relaxed max-w-3xl mx-auto"
                    >
                        {{ t("training.subtitle") }}
                    </p>

                    <!-- Scroll Indicator -->
                    <div class="flex flex-col items-center">
                        <span class="text-green-200 text-sm mb-2">{{
                            t("training.scroll")
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
                        {{ t("training.filters.title") }}
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
                        {{ t("training.filters.reset") }}
                    </button>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                >
                    <!-- Status Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >{{ t("training.filters.status") }}</label
                        >
                        <select
                            v-model="filters.status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        >
                            <option value="">
                                {{ t("training.filters.status_all") }}
                            </option>
                            <option value="published">
                                {{ t("training.filters.status_published") }}
                            </option>
                            <option value="ongoing">
                                {{ t("training.filters.status_ongoing") }}
                            </option>
                            <option value="completed">
                                {{ t("training.filters.status_completed") }}
                            </option>
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >{{ t("training.filters.location") }}</label
                        >
                        <div class="relative">
                            <input
                                v-model="filters.location"
                                type="text"
                                :placeholder="
                                    t('training.filters.location_placeholder')
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
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
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
                                t("training.results.count", { count: total })
                            }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Programs Section -->
        <section class="py-12 bg-gray-50" ref="programsTopRef">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <SkeletonLoader
                    v-if="loading"
                    type="card"
                    :count="6"
                    container-class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                />

                <div v-else>
                    <div
                        v-if="items.length === 0"
                        class="text-center text-gray-600 py-12"
                    >
                        {{ t("training.empty") }}
                    </div>
                    <div
                        v-else
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <article
                            v-for="p in items"
                            :key="p.id"
                            class="rounded-professional-lg border border-gray-200 bg-white card-hover overflow-hidden flex flex-col h-full"
                        >
                            <div class="relative aspect-[16/9] bg-gray-100">
                                <img
                                    v-if="p.image"
                                    :src="p.image"
                                    :alt="p.title"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                />
                                <span
                                    v-if="p.status"
                                    class="absolute left-3 top-3 text-xs font-semibold px-2 py-1 rounded bg-green-50 text-green-700"
                                    >{{ p.status }}</span
                                >
                            </div>
                            <div class="p-5 flex flex-col flex-1">
                                <h3
                                    class="font-bold text-lg text-gray-900 mb-1 line-clamp-2 min-h-[3.25rem]"
                                >
                                    {{ p.title }}
                                </h3>
                                <p
                                    v-if="p.subtitle"
                                    class="text-sm text-gray-600 line-clamp-2 mb-3 min-h-[2.5rem]"
                                >
                                    {{ p.subtitle }}
                                </p>
                                <div
                                    class="flex flex-wrap gap-2 text-xs mb-3 min-h-[1.75rem]"
                                >
                                    <span
                                        v-if="p.location"
                                        class="px-2 py-1 rounded bg-brand-cream text-brand-primary"
                                        >{{ p.location }}</span
                                    >
                                    <span
                                        v-if="p.dateRange"
                                        class="px-2 py-1 rounded bg-brand-cream text-brand-primary"
                                        >{{ p.dateRange }}</span
                                    >
                                </div>
                                <router-link
                                    :to="`/training-programs/${p.slugOrId}`"
                                    class="text-green-700 font-semibold text-sm hover:underline mt-auto"
                                    >{{
                                        t("training.view_details")
                                    }}</router-link
                                >
                            </div>
                        </article>
                    </div>

                    <div class="flex items-center justify-center gap-2 mt-8">
                        <button
                            :disabled="page <= 1 || loading"
                            @click="onPrevClick"
                            class="px-3 py-2 border rounded-md disabled:opacity-50"
                            @mousedown.prevent
                            @keydown.prevent.stop
                        >
                            {{ t("training.pagination.prev") }}
                        </button>
                        <span class="text-sm text-gray-600">{{
                            t("training.pagination.page_of", {
                                page,
                                total: totalPages,
                            })
                        }}</span>
                        <button
                            :disabled="page >= totalPages || loading"
                            @click="onNextClick"
                            class="px-3 py-2 border rounded-md disabled:opacity-50"
                            @mousedown.prevent
                            @keydown.prevent.stop
                        >
                            {{ t("training.pagination.next") }}
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, ref, watch, computed, nextTick } from "vue";
import { useI18n } from "./composables/useI18n";
import SkeletonLoader from "./components/SkeletonLoader.vue";

const loading = ref(true);
const items = ref([]);
const page = ref(1);
const perPage = ref(9);
const programsTopRef = ref(null);

// i18n
const { currentLanguage, onLanguageChange, t } = useI18n();
let unsubscribeLang = null;

async function scrollToTopSmooth() {
    await nextTick();
    const root = programsTopRef.value;
    if (root && typeof root.scrollIntoView === "function") {
        root.scrollIntoView({ behavior: "smooth", block: "start" });
    } else {
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
}
const total = ref(0);
const sortUi = ref("recent");

const filters = ref({ status: "", location: "" });

// Column-based filters: no dynamic dropdowns to avoid huge lists

function resetFilters() {
    filters.value = { status: "", location: "" };
}

const totalPages = computed(() =>
    Math.max(1, Math.ceil(total.value / perPage.value))
);

// Deep-watch filters to react to nested changes
watch(
    filters,
    () => {
        page.value = 1;
        fetchPrograms();
    },
    { deep: true }
);

// sort removed from UI; keep default 'recent'

watch(page, () => {
    fetchPrograms();
});

onMounted(() => {
    fetchPrograms();
    // Refetch when language changes
    unsubscribeLang = onLanguageChange(() => {
        fetchPrograms();
    });
});

onUnmounted(() => {
    if (typeof unsubscribeLang === "function") unsubscribeLang();
});

function buildQuery() {
    const params = new URLSearchParams();
    params.set("page", String(page.value));
    params.set("per_page", String(perPage.value));
    if (sortUi.value === "recent") {
        params.set("orderBy", "created_at");
        params.set("direction", "desc");
    } else if (sortUi.value === "upcoming") {
        params.set("orderBy", "start_date");
        params.set("direction", "asc");
    } else if (sortUi.value === "az") {
        params.set("orderBy", "title");
        params.set("direction", "asc");
    }
    if (filters.value.status) params.set("status", filters.value.status);
    if (filters.value.location) params.set("location", filters.value.location);
    // Ensure language is sent for dynamic translations
    const lang =
        localStorage.getItem("preferred_language") ||
        currentLanguage?.value ||
        "en";
    params.set("lang", lang);
    // Enforce status on client too in case backend ignores it
    return params.toString();
}

async function fetchPrograms() {
    loading.value = true;
    try {
        const qs = buildQuery();
        console.log("Fetching with query:", qs); // Debug log
        console.log("Current filters:", filters.value); // Debug log
        const res = await fetch(`/api/training-programs?${qs}`);
        if (!res.ok) throw new Error("Failed to load");
        const data = await res.json();
        console.log("API response:", data); // Debug log
        const list = Array.isArray(data?.data)
            ? data.data
            : Array.isArray(data)
            ? data
            : [];
        // Map
        const mapped = list.map((r) => ({
            id: r.id,
            slugOrId: r.slug || r.id,
            title: r.title || r.name || "Training Program",
            subtitle: r.short_description || r.description || "",
            status: r.status || r.program_status,
            location: r.location || r.province || r.region || r.district,
            dateRange:
                r.start_date && r.end_date
                    ? `${r.start_date} – ${r.end_date}`
                    : undefined,
            image:
                r.thumbnail_image || r.cover_image || r.featured_image || null,
            created_at: r.created_at || r.start_date,
            start_date: r.start_date || null,
        }));
        // Client-side fallback sort matching UI + enforce status filter if provided
        if (sortUi.value === "recent") {
            items.value = mapped.sort(
                (a, b) =>
                    new Date(b.created_at || 0) - new Date(a.created_at || 0)
            );
        } else if (sortUi.value === "az") {
            items.value = mapped.sort((a, b) =>
                String(a.title).localeCompare(String(b.title))
            );
        } else {
            items.value = mapped;
        }
        if (filters.value.status) {
            items.value = items.value.filter(
                (x) =>
                    String(x.status || "").toLowerCase() ===
                    String(filters.value.status).toLowerCase()
            );
        }
        // Basic pagination derive if meta present
        if (data?.meta?.total) {
            total.value = Number(data.meta.total) || mapped.length;
            perPage.value = Number(data.meta.per_page) || perPage.value;
            page.value = Number(data.meta.current_page) || page.value;
        } else {
            total.value = mapped.length;
        }
    } catch (e) {
        items.value = [];
        total.value = 0;
    } finally {
        loading.value = false;
    }
}

// removed dynamic type options fetch to keep filters column-based

function prevPage() {
    if (page.value > 1) {
        page.value -= 1;
    }
}
function nextPage() {
    if (page.value < totalPages.value) {
        page.value += 1;
    }
}

async function onPrevClick() {
    prevPage();
    await scrollToTopSmooth();
}
async function onNextClick() {
    nextPage();
    await scrollToTopSmooth();
}
</script>
