<template>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <section
            class="relative text-white overflow-hidden min-h-[70vh] flex items-center"
        >
            <div class="absolute inset-0">
                <img
                    :src="'/images/home/hero1.avif'"
                    alt="Careers"
                    class="w-full h-full object-cover"
                />
            </div>
            <div
                class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"
            ></div>
            <div
                class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24"
            >
                <div class="text-center">
                    <h1
                        class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fadeInUp"
                    >
                        Careers at
                        <span class="text-green-400">Mount Agro</span>
                    </h1>
                    <p
                        class="text-xl md:text-2xl text-gray-100 mb-8 max-w-3xl mx-auto animate-fadeInUp"
                        style="animation-delay: 0.2s"
                    >
                        Join our mission to empower communities through
                        innovation and sustainable development.
                    </p>
                    <div class="animate-fadeInUp" style="animation-delay: 0.4s">
                        <div
                            class="inline-flex items-center px-6 py-3 bg-green-600/20 backdrop-blur-sm rounded-full border border-green-400/30"
                        >
                            <svg
                                class="w-5 h-5 mr-2 text-green-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"
                                ></path>
                            </svg>
                            <span class="text-white font-medium"
                                >Building Afghanistan's Future</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Work With Us section removed per requirements -->

        <!-- Current Openings Section -->
        <section class="p-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-4">
                        Current Job Openings
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-6">
                        Explore opportunities and apply by email.
                    </p>
                    <button
                        @click="fetchJobs"
                        :disabled="loading"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    >
                        <svg
                            v-if="!loading"
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
                        <svg
                            v-else
                            class="animate-spin w-4 h-4 mr-2"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        {{ loading ? "Loading..." : "Refresh Jobs" }}
                    </button>
                </div>

                <!-- Loading State -->
                <div v-if="loading" class="text-center py-12">
                    <div
                        class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full"
                    >
                        <svg
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        Loading job openings...
                    </div>
                </div>

                <!-- Error State -->
                <div v-else-if="error" class="text-center py-12">
                    <div
                        class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-full"
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
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                        {{ error }}
                    </div>
                </div>

                <!-- No Jobs State -->
                <div v-else-if="jobs.length === 0" class="text-center py-12">
                    <div
                        class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-600 rounded-full"
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
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"
                            ></path>
                        </svg>
                        No job openings available at the moment
                    </div>
                </div>

                <!-- Jobs List -->
                <div v-else class="space-y-6">
                    <div
                        v-for="job in jobs"
                        :key="job.id"
                        class="rounded-professional-lg p-8 card-hover bg-white shadow-professional border border-gray-200"
                    >
                        <div
                            class="flex flex-col md:flex-row md:items-center md:justify-between gap-4"
                        >
                            <div class="flex-1">
                                <h3
                                    class="text-xl font-semibold mb-2 text-gray-900"
                                >
                                    {{ job.title }}
                                </h3>
                                <div
                                    class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-3"
                                >
                                    <span class="flex items-center gap-1">
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                            />
                                        </svg>
                                        {{ job.location }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"
                                            />
                                        </svg>
                                        {{
                                            job.status === "open" && job.is_open
                                                ? "Open"
                                                : "Closed"
                                        }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                        Deadline
                                        {{
                                            job.deadline_formatted ||
                                            job.deadline ||
                                            ""
                                        }}
                                    </span>
                                </div>
                                <p class="text-gray-700 mb-4 line-clamp-3">
                                    {{ job.description }}
                                </p>
                            </div>
                            <div class="flex flex-col gap-2">
                                <a
                                    :href="`/contact?subject=job_application&job_title=${encodeURIComponent(
                                        job.title
                                    )}&job_id=${job.id}`"
                                    class="btn btn-primary"
                                >
                                    Apply for this Position
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Apply by Email Note -->
        <section
            class="section-padding bg-gradient-to-r from-green-600 to-emerald-600 text-white"
        >
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="heading-lg mb-4">How to Apply</h2>
                <p class="text-lg text-green-100">
                    Email your CV to
                    <a
                        href="mailto:info@mountagro.com"
                        class="underline font-semibold"
                        >info@mountagro.com</a
                    >
                    and include the job title in the subject.
                </p>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const jobs = ref([]);
const loading = ref(false);
const error = ref("");

async function fetchJobs() {
    try {
        loading.value = true;
        error.value = "";
        console.log("Fetching open jobs...");

        const res = await axios.get("/api/jobs", {
            params: { status: "open" },
            timeout: 7000,
        });

        console.log("API Response:", res.data);

        // Handle the response - API returns array directly
        const list = Array.isArray(res.data) ? res.data : [];
        jobs.value = list.filter(Boolean);

        console.log(`Loaded ${jobs.value.length} open jobs`);
    } catch (e) {
        console.error("JOBS API ERROR:", e);
        error.value = "Unable to load jobs right now.";
        jobs.value = [];
    } finally {
        loading.value = false;
    }
}

onMounted(fetchJobs);
</script>
