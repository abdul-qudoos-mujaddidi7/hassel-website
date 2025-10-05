<template>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <section
            class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-24"
        >
            <div class="absolute inset-0 bg-black opacity-40"></div>
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
                        Resources
                    </h1>
                    <p
                        class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed"
                    >
                        Access our comprehensive collection of publications,
                        research, and media resources
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Tab Navigation -->
                <div class="mb-16">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8 justify-center">
                            <button
                                @click="activeTab = 'news'"
                                :class="[
                                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                                    activeTab === 'news'
                                        ? 'border-green-600 text-green-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                ]"
                            >
                                News
                            </button>
                            <button
                                @click="activeTab = 'publications'"
                                :class="[
                                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                                    activeTab === 'publications'
                                        ? 'border-green-600 text-green-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                ]"
                            >
                                Publications
                            </button>
                            <button
                                @click="activeTab = 'success-stories'"
                                :class="[
                                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                                    activeTab === 'success-stories'
                                        ? 'border-green-600 text-green-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                ]"
                            >
                                Success Stories
                            </button>
                            <button
                                @click="activeTab = 'rfps'"
                                :class="[
                                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                                    activeTab === 'rfps'
                                        ? 'border-green-600 text-green-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                ]"
                            >
                                RFPs/RFQs
                            </button>
                            <button
                                @click="activeTab = 'gallery'"
                                :class="[
                                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                                    activeTab === 'gallery'
                                        ? 'border-green-600 text-green-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                ]"
                            >
                                Gallery
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- News Tab -->
                <div v-if="activeTab === 'news'" class="space-y-12">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">
                            Latest News
                        </h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            Stay informed with our latest updates and
                            announcements
                        </p>
                    </div>

                    <div class="relative min-h-[600px]">
                        <!-- Loading State -->
                        <div
                            v-if="newsLoading && news.length === 0"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                        >
                            <div v-for="i in 6" :key="i" class="animate-pulse">
                                <div
                                    class="bg-gray-200 h-48 rounded-lg mb-4"
                                ></div>
                                <div class="space-y-3">
                                    <div class="h-4 bg-gray-200 rounded"></div>
                                    <div
                                        class="h-4 bg-gray-200 rounded w-3/4"
                                    ></div>
                                    <div
                                        class="h-3 bg-gray-200 rounded w-1/2"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <!-- News Grid -->
                        <div
                            v-else-if="news.length > 0"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative"
                        >
                            <!-- Loading overlay for pagination -->
                            <div
                                v-if="newsLoading"
                                class="absolute inset-0 bg-white bg-opacity-80 flex items-center justify-center z-10 rounded-lg"
                            >
                                <div
                                    class="flex items-center space-x-3 text-gray-600"
                                >
                                    <div
                                        class="animate-spin rounded-full h-6 w-6 border-b-2 border-gray-600"
                                    ></div>
                                    <span class="font-medium">Loading...</span>
                                </div>
                            </div>

                            <article
                                v-for="article in news"
                                :key="article.id"
                                class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200 h-full flex flex-col"
                            >
                                <div class="relative">
                                    <img
                                        :src="
                                            article.featured_image ||
                                            '/images/placeholder-news.jpg'
                                        "
                                        :alt="article.title"
                                        class="w-full h-48 object-cover"
                                    />
                                </div>
                                <div class="p-6 flex-1 flex flex-col">
                                    <div
                                        class="flex items-center text-sm text-gray-500 mb-3"
                                    >
                                        <span>{{
                                            formatDate(article.published_at)
                                        }}</span>
                                        <span class="mx-2">•</span>
                                        <span>5 min read</span>
                                    </div>
                                    <h3
                                        class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2"
                                    >
                                        {{ article.title }}
                                    </h3>
                                    <p
                                        class="text-gray-600 mb-4 flex-1 line-clamp-3"
                                    >
                                        {{ article.excerpt }}
                                    </p>
                                    <router-link
                                        :to="`/news/${
                                            article.slug || article.id
                                        }`"
                                        class="inline-flex items-center text-green-600 hover:text-green-700 font-medium text-sm transition-colors duration-200"
                                    >
                                        Read More
                                        <svg
                                            class="ml-2 w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 5l7 7-7 7"
                                            />
                                        </svg>
                                    </router-link>
                                </div>
                            </article>
                        </div>

                        <!-- Empty State -->
                        <div v-else class="text-center py-16">
                            <div class="max-w-md mx-auto">
                                <div
                                    class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-8 h-8 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                                        />
                                    </svg>
                                </div>
                                <h3
                                    class="text-lg font-medium text-gray-900 mb-2"
                                >
                                    No news articles found
                                </h3>
                                <p class="text-gray-500">
                                    Check back later for the latest updates
                                </p>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div
                            v-if="newsPagination.totalPages > 1"
                            class="flex justify-center items-center space-x-2 mt-12"
                        >
                            <button
                                @click="
                                    goToNewsPage(newsPagination.currentPage - 1)
                                "
                                :disabled="
                                    newsPagination.currentPage === 1 ||
                                    newsLoading
                                "
                                class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                            >
                                Previous
                            </button>

                            <div class="flex items-center space-x-1">
                                <button
                                    v-for="page in visiblePages"
                                    :key="page"
                                    @click="goToNewsPage(page)"
                                    :disabled="newsLoading"
                                    :class="[
                                        'px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed',
                                        page === newsPagination.currentPage
                                            ? 'bg-green-600 text-white'
                                            : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100',
                                    ]"
                                >
                                    {{ page }}
                                </button>
                            </div>

                            <button
                                @click="
                                    goToNewsPage(newsPagination.currentPage + 1)
                                "
                                :disabled="
                                    newsPagination.currentPage ===
                                        newsPagination.totalPages || newsLoading
                                "
                                class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Other Tabs - Empty States -->
                <div
                    v-else-if="activeTab === 'publications'"
                    class="text-center py-20"
                >
                    <div class="max-w-md mx-auto">
                        <div
                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            Publications
                        </h3>
                        <p class="text-gray-500">
                            Research papers and publications will be available
                            here
                        </p>
                    </div>
                </div>

                <div
                    v-else-if="activeTab === 'success-stories'"
                    class="text-center py-20"
                >
                    <div class="max-w-md mx-auto">
                        <div
                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            Success Stories
                        </h3>
                        <p class="text-gray-500">
                            Inspiring stories from our community will be shared
                            here
                        </p>
                    </div>
                </div>

                <div v-else-if="activeTab === 'rfps'" class="text-center py-20">
                    <div class="max-w-md mx-auto">
                        <div
                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            RFPs/RFQs
                        </h3>
                        <p class="text-gray-500">
                            Request for proposals and quotations will be posted
                            here
                        </p>
                    </div>
                </div>

                <div
                    v-else-if="activeTab === 'gallery'"
                    class="text-center py-20"
                >
                    <div class="max-w-md mx-auto">
                        <div
                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            Gallery
                        </h3>
                        <p class="text-gray-500">
                            Photos and media from our activities will be
                            displayed here
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gray-900">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Stay Connected
                </h2>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    Get the latest updates and insights from Mount Agro
                    Institution
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <router-link
                        to="/contact"
                        class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-200"
                    >
                        Contact Us
                    </router-link>
                    <router-link
                        to="/resources"
                        class="border-2 border-gray-300 text-gray-300 px-8 py-3 rounded-lg font-semibold hover:bg-gray-800 hover:border-gray-400 transition-colors duration-200"
                    >
                        Browse Resources
                    </router-link>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";

const activeTab = ref("news");

// News data and pagination
const news = ref([]);
const newsLoading = ref(false);
const newsPagination = ref({
    currentPage: 1,
    totalPages: 1,
    totalItems: 0,
    perPage: 6,
});

// Computed property for visible pagination pages
const visiblePages = computed(() => {
    const current = newsPagination.value.currentPage;
    const total = newsPagination.value.totalPages;
    const pages = [];

    // Show up to 5 page numbers
    const start = Math.max(1, current - 2);
    const end = Math.min(total, start + 4);

    for (let i = start; i <= end; i++) {
        pages.push(i);
    }

    return pages;
});

// Fetch news with pagination
const fetchNews = async (page = 1) => {
    try {
        newsLoading.value = true;
        const response = await axios.get("/api/news", {
            params: {
                page: page,
                per_page: newsPagination.value.perPage,
            },
        });

        const data = response.data;

        // Check if we got data
        if (!data) {
            console.error("No data received from API");
            return;
        }

        if (data.data) {
            news.value = data.data;
            newsPagination.value = {
                currentPage: data.meta?.current_page || page,
                totalPages: data.meta?.last_page || 1,
                totalItems: data.meta?.total || 0,
                perPage: data.meta?.per_page || 6,
            };
        } else if (Array.isArray(data)) {
            news.value = data;
            newsPagination.value = {
                currentPage: 1,
                totalPages: 1,
                totalItems: data.length,
                perPage: 6,
            };
        }
    } catch (error) {
        console.error("Error fetching news:", error);
        console.error("Error details:", error.response?.data || error.message);
        console.error("Error status:", error.response?.status);

        // Set empty state on error
        news.value = [];
        newsPagination.value = {
            currentPage: 1,
            totalPages: 1,
            totalItems: 0,
            perPage: 6,
        };
    } finally {
        newsLoading.value = false;
    }
};

// Go to specific news page
const goToNewsPage = (page) => {
    if (
        page >= 1 &&
        page <= newsPagination.value.totalPages &&
        !newsLoading.value
    ) {
        fetchNews(page);
    }
};

// Format date
const formatDate = (dateString) => {
    if (!dateString) return "";
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
};

// Load data on component mount
onMounted(() => {
    fetchNews();
});
</script>

<style scoped>
/* Custom animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeInUp {
    animation: fadeInUp 0.6s ease-out;
}

/* Card hover effects */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Professional rounded corners */
.rounded-professional-lg {
    border-radius: 12px;
}

/* Professional shadows */
.shadow-professional {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
        0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Heading styles */
.heading-lg {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.2;
}

/* Button styles */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Line clamp utilities */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
