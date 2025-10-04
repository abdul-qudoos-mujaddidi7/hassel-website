<template>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <section
            class="relative bg-gradient-to-br from-green-800 via-green-700 to-green-600 text-white overflow-hidden"
        >
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="absolute inset-0 opacity-5">
                <div
                    class="absolute inset-0"
                    style="
                        background-image: radial-gradient(
                            circle at 1px 1px,
                            white 1px,
                            transparent 0
                        );
                        background-size: 20px 20px;
                    "
                ></div>
            </div>

            <div
                class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32"
            >
                <div class="text-center">
                    <h1
                        class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fadeInUp"
                    >
                        Resources & <span class="gradient-text">Media</span>
                    </h1>
                    <p
                        class="text-xl md:text-2xl text-green-100 mb-8 max-w-3xl mx-auto animate-fadeInUp"
                        style="animation-delay: 0.2s"
                    >
                        Access our latest publications, insights, success
                        stories, and media resources
                    </p>
                </div>
            </div>
        </section>

        <!-- Tab Navigation -->
        <section class="py-8 bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap justify-center gap-4">
                    <button
                        v-for="tab in tabs"
                        :key="tab.id"
                        @click="activeTab = tab.id"
                        :class="[
                            'px-6 py-3 rounded-lg font-semibold transition-colors',
                            activeTab === tab.id
                                ? 'btn-primary'
                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                        ]"
                    >
                        <component :is="tab.icon" class="w-5 h-5 mr-2 inline" />
                        {{ tab.name }}
                    </button>
                </div>
            </div>
        </section>

        <!-- Tab Content -->
        <section class="section-padding bg-gradient-bg-organic">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- News Tab -->
                <div v-if="activeTab === 'news'" class="space-y-8">
                    <h2 class="heading-lg text-gray-900 text-center mb-8">
                        Latest News
                    </h2>

                    <!-- News Articles Container - Always maintain height -->
                    <div class="space-y-8 relative min-h-[600px]">
                        <!-- Debug Info -->
                        <div class="bg-yellow-100 p-2 mb-4 text-xs">
                            <p>Loading: {{ newsLoading }}</p>
                            <p>News Count: {{ news.length }}</p>
                            <p>Total Pages: {{ newsPagination.totalPages }}</p>
                        </div>

                        <!-- Loading State - Show skeleton when no news or loading -->
                        <div
                            v-if="newsLoading && news.length === 0"
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"
                        >
                            <div v-for="i in 6" :key="i" class="animate-pulse">
                                <div
                                    class="bg-gray-300 h-48 rounded-lg mb-4"
                                ></div>
                                <div class="h-4 bg-gray-300 rounded mb-2"></div>
                                <div
                                    class="h-4 bg-gray-300 rounded w-3/4 mb-2"
                                ></div>
                                <div
                                    class="h-3 bg-gray-300 rounded w-1/2"
                                ></div>
                            </div>
                        </div>

                        <!-- News Grid with Loading Overlay -->
                        <div
                            v-else-if="news.length > 0"
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 relative"
                        >
                            <!-- Loading overlay for pagination -->
                            <div
                                v-if="newsLoading"
                                class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center z-10 rounded-lg"
                            >
                                <div
                                    class="flex items-center space-x-2 text-green-600"
                                >
                                    <div
                                        class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-600"
                                    ></div>
                                    <span class="font-medium">Loading...</span>
                                </div>
                            </div>
                            <article
                                v-for="article in news"
                                :key="article.id"
                                class="bg-white rounded-professional-lg overflow-hidden shadow-professional card-hover h-full flex flex-col"
                            >
                                <div class="flex-shrink-0">
                                    <img
                                        :src="
                                            article.featured_image ||
                                            'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=400&h=200&fit=crop&crop=center&auto=format'
                                        "
                                        :alt="article.title"
                                        class="w-full h-48 object-cover"
                                    />
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <div
                                        class="flex items-center text-sm text-gray-500 mb-3"
                                    >
                                        <svg
                                            class="w-4 h-4 mr-1"
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
                                        {{ formatDate(article.published_at) }}
                                    </div>
                                    <h3
                                        class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2 h-14 flex items-start"
                                    >
                                        {{ article.title }}
                                    </h3>
                                    <div class="flex-grow mb-4">
                                        <p
                                            class="text-gray-600 line-clamp-3 leading-relaxed"
                                        >
                                            {{
                                                article.excerpt ||
                                                article.content?.substring(
                                                    0,
                                                    150
                                                ) + "..."
                                            }}
                                        </p>
                                    </div>
                                    <div class="mt-auto">
                                        <router-link
                                            :to="`/news/${
                                                article.slug || article.id
                                            }`"
                                            class="inline-flex items-center text-green-600 hover:text-green-700 font-medium"
                                        >
                                            Read More
                                            <svg
                                                class="w-4 h-4 ml-1"
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
                                </div>
                            </article>
                        </div>

                        <!-- Pagination -->
                        <div
                            v-if="newsPagination.totalPages > 1"
                            class="flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-2 mt-8"
                        >
                            <button
                                @click="
                                    goToNewsPage(newsPagination.currentPage - 1)
                                "
                                :disabled="
                                    newsPagination.currentPage === 1 ||
                                    newsLoading
                                "
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:scale-105 active:scale-95 min-w-[80px]"
                            >
                                Previous
                            </button>

                            <div class="flex space-x-1">
                                <button
                                    v-for="page in visiblePages"
                                    :key="page"
                                    @click="goToNewsPage(page)"
                                    :disabled="newsLoading"
                                    :class="[
                                        'px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed hover:scale-105 active:scale-95 min-w-[40px]',
                                        page === newsPagination.currentPage
                                            ? 'bg-green-600 text-white shadow-md'
                                            : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50',
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
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:scale-105 active:scale-95 min-w-[80px]"
                            >
                                Next
                            </button>
                        </div>

                        <!-- Empty State -->
                        <div v-else class="text-center py-12">
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
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                No news articles found.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Publications Tab -->
                <div v-if="activeTab === 'publications'" class="space-y-8">
                    <h2 class="heading-lg text-gray-900 text-center mb-8">
                        Publications
                    </h2>
                    <div class="text-center py-12">
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
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            No publications found.
                        </div>
                    </div>
                </div>

                <!-- Success Stories Tab -->
                <div v-if="activeTab === 'stories'" class="space-y-8">
                    <h2 class="heading-lg text-gray-900 text-center mb-8">
                        Success Stories
                    </h2>
                    <div class="text-center py-12">
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
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            No success stories found.
                        </div>
                    </div>
                </div>

                <!-- RFPs/RFQs Tab -->
                <div v-if="activeTab === 'rfps'" class="space-y-8">
                    <h2 class="heading-lg text-gray-900 text-center mb-8">
                        RFPs & RFQs
                    </h2>
                    <div class="text-center py-12">
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
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            No RFPs or RFQs found.
                        </div>
                    </div>
                </div>

                <!-- Gallery Tab -->
                <div v-if="activeTab === 'gallery'" class="space-y-8">
                    <h2 class="heading-lg text-gray-900 text-center mb-8">
                        Photo Gallery
                    </h2>
                    <div class="text-center py-12">
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
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            No photos found.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section
            class="section-padding bg-gradient-to-r from-green-600 to-emerald-600 text-white"
        >
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="heading-lg mb-6">Need More Information?</h2>
                <p class="text-xl text-green-100 mb-8">
                    Can't find what you're looking for? Contact us for
                    additional resources and support.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <router-link
                        to="/contact"
                        class="btn btn-cta text-lg px-8 py-4"
                    >
                        Contact Us
                        <svg
                            class="w-5 h-5 ml-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"
                            />
                        </svg>
                    </router-link>
                    <router-link
                        to="/our-work"
                        class="btn border-2 border-white text-white hover:bg-white hover:text-green-600 text-lg px-8 py-4"
                    >
                        View Our Work
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

        // Fallback news data
        news.value = [
            {
                id: 1,
                title: "New Training Program Launched in Herat Province",
                excerpt:
                    "Mount Agro launches comprehensive agricultural training program reaching 500 farmers in Herat, focusing on modern irrigation techniques and crop diversification.",
                content:
                    "Mount Agro has successfully launched a new comprehensive agricultural training program in Herat Province, reaching over 500 farmers across the region. The program focuses on modern irrigation techniques, crop diversification, and sustainable farming practices. This initiative is part of our ongoing commitment to empower Afghanistan's agricultural communities through innovative solutions and comprehensive support programs.",
                featured_image:
                    "https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=400&h=250&fit=crop&crop=center&auto=format",
                published_at: new Date().toISOString(),
                slug: "new-training-program-launch",
            },
            {
                id: 2,
                title: "AgriTech Mobile App Reaches 10,000 Users",
                excerpt:
                    "Our innovative mobile application providing weather forecasts, market prices, and agricultural advice has successfully reached 10,000 active users across Afghanistan.",
                content:
                    "Our innovative mobile application has reached a significant milestone with 10,000 active users across Afghanistan. The app provides farmers with real-time weather forecasts, market prices, and expert agricultural advice, helping them make informed decisions about their farming activities. This digital solution is transforming how farmers access information and manage their agricultural operations.",
                featured_image:
                    "https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=250&fit=crop&crop=center&auto=format",
                published_at: new Date(
                    Date.now() - 7 * 24 * 60 * 60 * 1000
                ).toISOString(),
                slug: "agritech-app-milestone",
            },
            {
                id: 3,
                title: "Women's Cooperative Program Shows Remarkable Success",
                excerpt:
                    "Our women's agricultural cooperative program has empowered over 200 women farmers, increasing their income by an average of 40% through collective farming and marketing initiatives.",
                content:
                    "Our women's agricultural cooperative program has achieved remarkable success, empowering over 200 women farmers across Afghanistan. Through collective farming and marketing initiatives, participants have seen an average income increase of 40%. This program demonstrates our commitment to gender equality and women's empowerment in the agricultural sector.",
                featured_image:
                    "https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=250&fit=crop&crop=center&auto=format",
                published_at: new Date(
                    Date.now() - 14 * 24 * 60 * 60 * 1000
                ).toISOString(),
                slug: "womens-cooperative-success",
            },
            {
                id: 4,
                title: "Environmental Conservation Project Launched",
                excerpt:
                    "New environmental conservation project focuses on sustainable farming practices and climate resilience across multiple provinces.",
                content:
                    "We have launched a comprehensive environmental conservation project that focuses on promoting sustainable farming practices and building climate resilience across multiple provinces. This initiative includes training on soil conservation, water management, and climate-smart agriculture techniques.",
                featured_image:
                    "https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400&h=250&fit=crop&crop=center&auto=format",
                published_at: new Date(
                    Date.now() - 21 * 24 * 60 * 60 * 1000
                ).toISOString(),
                slug: "environmental-conservation-project",
            },
            {
                id: 5,
                title: "Market Access Program Expands to New Regions",
                excerpt:
                    "Our market access program has expanded to three new regions, connecting farmers with profitable markets and value chains.",
                content:
                    "Our market access program has successfully expanded to three new regions, providing farmers with direct connections to profitable markets and value chains. This expansion has resulted in increased income opportunities for over 1,000 farmers and improved market access for agricultural products.",
                featured_image:
                    "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=250&fit=crop&crop=center&auto=format",
                published_at: new Date(
                    Date.now() - 28 * 24 * 60 * 60 * 1000
                ).toISOString(),
                slug: "market-access-expansion",
            },
            {
                id: 6,
                title: "Smart Farming Technology Implementation",
                excerpt:
                    "Implementation of smart farming technology has increased crop yields by 25% in pilot regions.",
                content:
                    "The implementation of smart farming technology in pilot regions has shown remarkable results, with crop yields increasing by an average of 25%. This technology includes precision irrigation systems, soil monitoring sensors, and automated farming equipment that helps farmers optimize their agricultural practices.",
                featured_image:
                    "https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400&h=250&fit=crop&crop=center&auto=format",
                published_at: new Date(
                    Date.now() - 35 * 24 * 60 * 60 * 1000
                ).toISOString(),
                slug: "smart-farming-technology",
            },
            {
                id: 7,
                title: "Community Development Initiative Success",
                excerpt:
                    "Community development initiative has established 15 new farmer cooperatives across the country.",
                content:
                    "Our community development initiative has successfully established 15 new farmer cooperatives across the country, bringing together over 2,000 farmers in collective farming and marketing efforts. These cooperatives have improved access to resources, reduced costs, and increased market bargaining power for participating farmers.",
                featured_image:
                    "https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=400&h=250&fit=crop&crop=center&auto=format",
                published_at: new Date(
                    Date.now() - 42 * 24 * 60 * 60 * 1000
                ).toISOString(),
                slug: "community-development-success",
            },
            {
                id: 8,
                title: "Seed Supply Chain Strengthened",
                excerpt:
                    "Strengthened seed supply chain now provides high-quality seeds to over 5,000 farmers.",
                content:
                    "Our seed supply chain has been significantly strengthened, now providing high-quality, certified seeds to over 5,000 farmers across Afghanistan. This improved supply chain ensures farmers have access to the best seeds for their specific growing conditions and climate requirements.",
                featured_image:
                    "https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=400&h=250&fit=crop&crop=center&auto=format",
                published_at: new Date(
                    Date.now() - 49 * 24 * 60 * 60 * 1000
                ).toISOString(),
                slug: "seed-supply-chain-strengthened",
            },
        ];
        newsPagination.value = {
            currentPage: 1,
            totalPages: 1,
            totalItems: news.value.length,
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

// Format date utility
const formatDate = (dateString) => {
    if (!dateString) return "";
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
};

// Initialize news when component mounts
onMounted(() => {
    fetchNews(1);
});

const tabs = [
    { id: "news", name: "News", icon: "NewsIcon" },
    { id: "publications", name: "Publications", icon: "PublicationsIcon" },
    { id: "stories", name: "Success Stories", icon: "StoriesIcon" },
    { id: "rfps", name: "RFPs/RFQs", icon: "RfpsIcon" },
    { id: "gallery", name: "Gallery", icon: "GalleryIcon" },
];

// Icon components
const NewsIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
        },
        [
            h("path", {
                "stroke-linecap": "round",
                "stroke-linejoin": "round",
                "stroke-width": "2",
                d: "M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z",
            }),
        ]
    );

const PublicationsIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
        },
        [
            h("path", {
                "stroke-linecap": "round",
                "stroke-linejoin": "round",
                "stroke-width": "2",
                d: "M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z",
            }),
        ]
    );

const StoriesIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
        },
        [
            h("path", {
                "stroke-linecap": "round",
                "stroke-linejoin": "round",
                "stroke-width": "2",
                d: "M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z",
            }),
        ]
    );

const RfpsIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
        },
        [
            h("path", {
                "stroke-linecap": "round",
                "stroke-linejoin": "round",
                "stroke-width": "2",
                d: "M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01",
            }),
        ]
    );

const GalleryIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
        },
        [
            h("path", {
                "stroke-linecap": "round",
                "stroke-linejoin": "round",
                "stroke-width": "2",
                d: "M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z",
            }),
        ]
    );

// Static data arrays removed - using dynamic API data instead
</script>
