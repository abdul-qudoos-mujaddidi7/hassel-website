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
                <router-link to="/resources" class="btn btn-primary">
                    Back to Resources
                </router-link>
            </div>
        </div>

        <!-- Article Content -->
        <div v-else-if="article" class="min-h-screen">
            <!-- Hero Section -->
            <section class="relative h-96 overflow-hidden">
                <img
                    :src="
                        article.featured_image ||
                        'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=1200&h=400&fit=crop&crop=center&auto=format'
                    "
                    :alt="article.title"
                    class="absolute inset-0 w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-black/50"></div>
                <div
                    class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-end"
                >
                    <div class="pb-12">
                        <div
                            class="flex items-center text-sm text-white/80 mb-4"
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
                            class="text-gray-700 leading-relaxed whitespace-pre-line"
                            v-html="
                                formatContent(
                                    article.content || article.excerpt
                                )
                            "
                        ></div>
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

            <!-- Navigation -->
            <section class="section-padding bg-gray-50">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-center">
                        <router-link
                            to="/resources"
                            class="inline-flex items-center text-green-600 hover:text-green-700 font-medium"
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
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>
                            Back to Resources
                        </router-link>
                    </div>
                </div>
            </section>

            <!-- Related Articles -->
            <section
                v-if="relatedArticles.length > 0"
                class="section-padding bg-white"
            >
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="heading-lg text-gray-900 text-center mb-8">
                        Related Articles
                    </h2>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <article
                            v-for="relatedArticle in relatedArticles"
                            :key="relatedArticle.id"
                            class="bg-white rounded-professional-lg overflow-hidden shadow-professional card-hover h-full flex flex-col"
                        >
                            <div class="flex-shrink-0">
                                <img
                                    :src="
                                        relatedArticle.featured_image ||
                                        'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=400&h=200&fit=crop&crop=center&auto=format'
                                    "
                                    :alt="relatedArticle.title"
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
                                    {{
                                        formatDate(relatedArticle.published_at)
                                    }}
                                </div>
                                <h3
                                    class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2 h-14 flex items-start"
                                >
                                    {{ relatedArticle.title }}
                                </h3>
                                <div class="flex-grow mb-4">
                                    <p
                                        class="text-gray-600 line-clamp-3 leading-relaxed"
                                    >
                                        {{
                                            relatedArticle.excerpt ||
                                            relatedArticle.content?.substring(
                                                0,
                                                150
                                            ) + "..."
                                        }}
                                    </p>
                                </div>
                                <div class="mt-auto">
                                    <router-link
                                        :to="`/news/${
                                            relatedArticle.slug ||
                                            relatedArticle.id
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
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
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
        const response = await axios.get(`/api/news/${slug}`, {
            timeout: 10000,
        });

        if (response.data) {
            article.value = response.data;
            // Fetch related articles
            await fetchRelatedArticles();
        } else {
            error.value = "Article not found";
        }
    } catch (err) {
        console.error("Error fetching article:", err);
        error.value = "Failed to load article";

        // No fallback data - show error state
        article.value = null;

        // Fetch related articles
        await fetchRelatedArticles();
    } finally {
        loading.value = false;
    }
};

// Fetch related articles
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

        if (response.data && response.data.data) {
            relatedArticles.value = response.data.data;
        } else if (Array.isArray(response.data)) {
            relatedArticles.value = response.data;
        }
    } catch (err) {
        console.error("Error fetching related articles:", err);
        // No fallback data - show empty state
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
