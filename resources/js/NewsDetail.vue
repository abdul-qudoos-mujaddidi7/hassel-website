<template>
    <div class="min-h-screen">
        <!-- Loading State -->
        <div
            v-if="loading"
            class="min-h-screen flex items-center justify-center"
        >
            <div class="text-center">
                <div
                    class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto mb-4"
                ></div>
                <p class="text-gray-600">Loading article...</p>
            </div>
        </div>

        <!-- Error State -->
        <div
            v-else-if="error"
            class="min-h-screen flex items-center justify-center"
        >
            <div class="text-center">
                <div
                    class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-full mb-4"
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
                    {{ error }}
                </div>
            </div>
        </div>

        <!-- Article Content -->
        <div v-else-if="article" class="min-h-screen pt-24">
            <!-- Hero Section -->
            <section
                class="relative h-[500px] md:h-[600px] lg:h-[700px] bg-cover bg-center bg-no-repeat"
                :style="{
                    backgroundImage: `url(${
                        article.featured_image ||
                        'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=1200&h=400&fit=crop&crop=center&auto=format'
                    })`,
                }"
            >
                <div
                    class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/40 to-black/60"
                ></div>
                <div
                    class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center"
                >
                    <div class="text-center w-full">
                        <div
                            class="flex items-center justify-center text-sm text-white/80 mb-4"
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
                        <h1
                            class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6"
                        >
                            {{ article.title }}
                        </h1>
                        <p
                            v-if="article.excerpt"
                            class="text-xl text-white/90 max-w-3xl"
                        >
                            {{ article.excerpt }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- Article Content -->
            <section class="section-padding bg-white">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Article Meta Information -->
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <div
                            class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4"
                        >
                            <div class="flex items-center">
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
                                Published:
                                {{ formatDate(article.published_at) }}
                            </div>
                            <div class="flex items-center">
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
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                Reading time: {{ readingTime }} min read
                            </div>
                            <div
                                v-if="article.author"
                                class="flex items-center"
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
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                                By {{ article.author }}
                            </div>
                        </div>

                        <!-- Article Tags/Categories -->
                        <div
                            v-if="article.tags && article.tags.length > 0"
                            class="flex flex-wrap gap-2"
                        >
                            <span
                                v-for="tag in article.tags"
                                :key="tag"
                                class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full"
                            >
                                {{ tag }}
                            </span>
                        </div>
                    </div>

                    <!-- Article Content -->
                    <div class="prose prose-lg max-w-none">
                        <div
                            v-if="article.content || article.excerpt"
                            class="text-gray-700 leading-relaxed whitespace-pre-line"
                            v-html="
                                formatContent(
                                    article.content || article.excerpt
                                )
                            "
                        ></div>
                        <div v-else class="text-center py-12 text-gray-500">
                            <svg
                                class="w-16 h-16 mx-auto mb-4 text-gray-300"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                            <p class="text-lg">
                                No content available for this article.
                            </p>
                            <p class="text-sm mt-2">
                                The article may be under review or the content
                                is not yet published.
                            </p>
                        </div>
                    </div>

                    <!-- Article Footer -->
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
                        >
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-500"
                                    >Share this article:</span
                                >
                                <button
                                    @click="shareArticle"
                                    class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm"
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
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"
                                        />
                                    </svg>
                                    Share
                                </button>
                            </div>

                            <div class="text-sm text-gray-500">
                                Last updated:
                                {{
                                    formatDate(
                                        article.updated_at ||
                                            article.published_at
                                    )
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Related Articles -->
            <section
                v-if="relatedArticles.length > 0"
                class="section-padding bg-white"
            >
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        Related Articles
                    </h2>
                    <div class="space-y-3">
                        <div
                            v-for="relatedArticle in relatedArticles.slice(
                                0,
                                3
                            )"
                            :key="relatedArticle.id"
                            class="border-b border-gray-200 pb-3 last:border-b-0"
                        >
                            <router-link
                                :to="`/news/${
                                    relatedArticle.slug || relatedArticle.id
                                }`"
                                class="block hover:bg-gray-50 p-3 rounded-lg transition-colors"
                            >
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3
                                            class="text-lg font-medium text-gray-900 hover:text-green-600 transition-colors"
                                        >
                                            {{ relatedArticle.title }}
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{
                                                formatDate(
                                                    relatedArticle.published_at
                                                )
                                            }}
                                        </p>
                                    </div>
                                    <svg
                                        class="w-5 h-5 text-gray-400 ml-3 flex-shrink-0"
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
                                </div>
                            </router-link>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";

const route = useRoute();
const article = ref(null);
const relatedArticles = ref([]);
const loading = ref(true);
const error = ref(null);

// Computed properties
const readingTime = computed(() => {
    if (!article.value?.content) return 1;
    const wordsPerMinute = 200;
    const wordCount = article.value.content.split(" ").length;
    return Math.max(1, Math.ceil(wordCount / wordsPerMinute));
});

// Fetch article by slug or ID
const fetchArticle = async () => {
    try {
        loading.value = true;
        error.value = null;

        const slug = route.params.slug;
        console.log("Fetching article with slug:", slug);

        const response = await axios.get(`/api/news/${slug}`, {
            timeout: 10000,
        });

        console.log("Article response:", response.data);

        if (response.data && response.data.news) {
            // API returns { news: {...}, related_news: [...] }
            article.value = response.data.news;
            relatedArticles.value = response.data.related_news || [];
            console.log("Article data:", article.value);
            console.log("Article content:", article.value?.content);
        } else if (response.data && response.data.data) {
            article.value = response.data.data;
            console.log("Article data:", article.value);
            console.log("Article content:", article.value?.content);
            await fetchRelatedArticles();
        } else if (response.data) {
            article.value = response.data;
            console.log("Article data:", article.value);
            console.log("Article content:", article.value?.content);
            await fetchRelatedArticles();
        } else {
            error.value = "Article not found";
            return;
        }
    } catch (err) {
        console.error("Error fetching article:", err);

        if (err.response?.status === 404) {
            error.value = "Article not found";
        } else if (err.response?.status >= 500) {
            error.value = "Server error. Please try again later.";
        } else {
            error.value =
                "Failed to load article. Please check your connection.";
        }

        article.value = null;
        // Still try to fetch related articles even if main article fails
        await fetchRelatedArticles();
    } finally {
        loading.value = false;
    }
};

// Fetch related articles (only called if not already provided by main API)
const fetchRelatedArticles = async () => {
    try {
        const response = await axios.get("/api/news", {
            params: {
                limit: 3,
                exclude: article.value?.id,
                sort: "published_at",
                order: "desc",
                status: "published",
            },
            timeout: 5000,
        });

        console.log("Related articles response:", response.data);

        if (response.data && response.data.data) {
            relatedArticles.value = response.data.data.slice(0, 3);
        } else if (Array.isArray(response.data)) {
            relatedArticles.value = response.data.slice(0, 3);
        } else {
            relatedArticles.value = [];
        }
    } catch (err) {
        console.error("Error fetching related articles:", err);
        relatedArticles.value = [];
    }
};

// Share article functionality
const shareArticle = async () => {
    if (navigator.share) {
        try {
            await navigator.share({
                title: article.value.title,
                text: article.value.excerpt,
                url: window.location.href,
            });
        } catch (err) {
            console.log("Error sharing:", err);
        }
    } else {
        // Fallback: copy to clipboard
        try {
            await navigator.clipboard.writeText(window.location.href);
            alert("Link copied to clipboard!");
        } catch (err) {
            console.log("Error copying to clipboard:", err);
        }
    }
};

// Format content utility
const formatContent = (content) => {
    if (!content) return "";
    // Convert line breaks to HTML
    return content
        .replace(/\n\n/g, "</p><p>")
        .replace(/\n/g, "<br>")
        .replace(/^/, "<p>")
        .replace(/$/, "</p>");
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

// Initialize article when component mounts
onMounted(() => {
    fetchArticle();
    const handleLanguageChanged = () => {
        fetchArticle();
    };
    window.addEventListener("language:changed", handleLanguageChanged);
    onUnmounted(() => {
        window.removeEventListener("language:changed", handleLanguageChanged);
    });
});
</script>

<style scoped>
.prose {
    color: #374151;
    line-height: 1.75;
}

.prose h1,
.prose h2,
.prose h3,
.prose h4,
.prose h5,
.prose h6 {
    color: #1f2937;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose p {
    margin-bottom: 1.5rem;
}

.prose ul,
.prose ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose strong {
    font-weight: 600;
    color: #1f2937;
}
</style>
