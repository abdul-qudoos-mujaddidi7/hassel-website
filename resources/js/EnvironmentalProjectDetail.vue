<template>
    <div class="min-h-screen bg-gray-50">
        <div
            v-if="loading"
            class="min-h-screen flex items-center justify-center"
        >
            <div class="text-center">
                <div
                    class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto mb-4"
                ></div>
                <p class="text-gray-600">Loading project...</p>
            </div>
        </div>

        <div
            v-else-if="error"
            class="min-h-screen flex items-center justify-center"
        >
            <div class="text-center max-w-md mx-auto px-4">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Project Not Found
                </h2>
                <p class="text-gray-600 mb-6">{{ error }}</p>
                <router-link
                    to="/environmental-projects"
                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors"
                    >Back to Projects</router-link
                >
            </div>
        </div>

        <div v-else-if="project">
            <section class="relative overflow-hidden">
                <div class="absolute inset-0">
                    <img
                        :src="heroImage"
                        :alt="project.title || 'Environmental Project'"
                        class="w-full h-full object-cover"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-900/85 via-green-800/80 to-emerald-900/85"
                    ></div>
                </div>
                <div
                    class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-32"
                >
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
                            <router-link
                                to="/environmental-projects"
                                class="text-green-200 hover:text-white transition-colors"
                                >Environmental Projects</router-link
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
                                project.title
                            }}</span>
                        </div>
                    </nav>
                    <div class="text-center max-w-4xl mx-auto">
                        <div
                            v-if="project.project_type"
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
                            {{ formatProjectType(project.project_type) }}
                        </div>

                        <h1
                            class="text-3xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight"
                        >
                            {{ project.title }}
                        </h1>

                        <p
                            class="text-xl text-white mb-8 leading-relaxed max-w-3xl mx-auto"
                        >
                            {{
                                project.description ||
                                "No description available."
                            }}
                        </p>

                        <!-- Quick Meta -->
                        <div class="flex flex-wrap justify-center gap-6 mb-8">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">
                                    {{ project.funding_source || "N/A" }}
                                </div>
                                <div class="text-green-200 text-sm">
                                    Funding Source
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">
                                    {{
                                        project.impact_metrics &&
                                        project.impact_metrics.length
                                            ? project.impact_metrics.length
                                            : 0
                                    }}
                                </div>
                                <div class="text-green-200 text-sm">
                                    Impact Metrics
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-12 sm:py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                        <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 md:p-8"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-6"
                                >
                                    Overview
                                </h2>
                                <div class="prose max-w-none">
                                    <p class="text-gray-600 leading-relaxed">
                                        {{
                                            project.description ||
                                            "No description provided for this project."
                                        }}
                                    </p>
                                </div>
                            </div>

                            <!-- Impact Metrics -->
                            <div
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8"
                            >
                                <h2
                                    class="text-2xl font-bold text-gray-900 mb-6"
                                >
                                    Impact Metrics
                                </h2>
                                <template
                                    v-if="
                                        project.impact_metrics &&
                                        project.impact_metrics.length
                                    "
                                >
                                    <div class="flex flex-wrap gap-3">
                                        <span
                                            v-for="metric in project.impact_metrics"
                                            :key="metric"
                                            class="px-4 py-2 bg-emerald-100 text-emerald-800 text-sm font-medium rounded-full"
                                        >
                                            {{ formatMetric(metric) }}
                                        </span>
                                    </div>
                                </template>
                                <template v-else>
                                    <div
                                        class="p-6 bg-gray-50 border border-gray-200 rounded-xl text-center text-gray-600"
                                    >
                                        No impact metrics provided for this
                                        project.
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="space-y-4 sm:space-y-6">
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
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600">Type</span>
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full"
                                            >{{
                                                project.project_type
                                                    ? formatProjectType(
                                                          project.project_type
                                                      )
                                                    : "Not specified"
                                            }}</span
                                        >
                                    </div>
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600"
                                            >Status</span
                                        >
                                        <span
                                            class="text-gray-900 font-medium"
                                            >{{
                                                project.status || "Unknown"
                                            }}</span
                                        >
                                    </div>
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-gray-600"
                                            >Funding</span
                                        >
                                        <span
                                            class="text-gray-900 font-medium"
                                            >{{
                                                project.funding_source ||
                                                "Not specified"
                                            }}</span
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
import { onMounted, ref, watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const loading = ref(true);
const error = ref(null);
const project = ref(null);
const heroImage = ref("/images/ourWork/ourworkhero.avif");

onMounted(fetchProject);

watch(
    () => route.params.idOrSlug,
    () => {
        if (route.params.idOrSlug) {
            fetchProject();
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    }
);

async function fetchProject() {
    loading.value = true;
    error.value = null;
    try {
        const idOrSlug = route.params.idOrSlug;
        let res = await fetch(`/api/environmental-projects/${idOrSlug}`);
        if (res.ok) {
            const data = await res.json();
            const item = data?.data || data?.project || data;
            if (!item) throw new Error("Invalid project data received");
            project.value = mapProject(item);
            heroImage.value =
                project.value.cover_image || "/images/ourWork/ourworkhero.avif";
            return;
        }
        const listRes = await fetch("/api/environmental-projects");
        if (!listRes.ok) throw new Error("Failed to load projects");
        const listJson = await listRes.json();
        const list = Array.isArray(listJson?.data)
            ? listJson.data
            : Array.isArray(listJson)
            ? listJson
            : [];
        const found = list.find(
            (p) => p.slug === idOrSlug || String(p.id) === String(idOrSlug)
        );
        if (!found) throw new Error("Project not found");
        project.value = mapProject(found);
        heroImage.value =
            project.value.cover_image || "/images/ourWork/ourworkhero.avif";
    } catch (e) {
        error.value = e.message || "Failed to load project";
    } finally {
        loading.value = false;
    }
}

function mapProject(p) {
    return {
        id: p.id,
        title: p.title || "Environmental Project",
        slug: p.slug,
        description: p.description || "",
        cover_image:
            p.cover_image ||
            p.thumbnail_image ||
            "/images/ourWork/ourworkhero.avif",
        project_type: p.project_type,
        funding_source: p.funding_source || "",
        impact_metrics: Array.isArray(p.impact_metrics) ? p.impact_metrics : [],
        status: p.status || "published",
    };
}

function formatProjectType(type) {
    return String(type || "")
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
}

function formatMetric(metric) {
    return String(metric || "")
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
}
</script>
