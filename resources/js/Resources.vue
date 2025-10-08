<template>
    <div class="min-h-screen overflow-x-hidden">
        <!-- Hero Section -->
        <section
            class="relative h-[340px] md:h-[440px] lg:h-[520px] overflow-hidden"
            :style="{
                backgroundImage: `url(/images/ourWork/ourworkhero.avif)`,
            }"
        >
            <div class="absolute inset-0 bg-black/60"></div>
            <div
                class="relative z-10 max-w-7xl mx-auto h-full flex items-center px-4 sm:px-6 lg:px-8"
            >
                <div class="text-center w-full">
                    <h1
                        class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4"
                    >
                        Resources
                    </h1>
                    <p
                        class="text-base md:text-xl text-white/90 max-w-3xl mx-auto leading-relaxed"
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
                <div class="mb-10 md:mb-16">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex gap-2 md:gap-6 justify-center">
                            <button
                                @click="activeTab = 'news'"
                                :class="[
                                    'whitespace-nowrap py-3 md:py-4 px-2 md:px-1 border-b-2 font-medium text-xs md:text-sm transition-colors duration-200',
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
                                    'whitespace-nowrap py-3 md:py-4 px-2 md:px-1 border-b-2 font-medium text-xs md:text-sm transition-colors duration-200',
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
                                    'whitespace-nowrap py-3 md:py-4 px-2 md:px-1 border-b-2 font-medium text-xs md:text-sm transition-colors duration-200',
                                    activeTab === 'success-stories'
                                        ? 'border-green-600 text-green-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                ]"
                            >
                                Success Stories
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

                <!-- Publications Tab -->
                <div
                    v-else-if="activeTab === 'publications'"
                    class="space-y-12"
                >
                    <div class="text-center">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">
                            Publications & Resources
                        </h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            Access our comprehensive collection of research
                            papers, reports, and publications
                        </p>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="bg-gray-50 rounded-lg p-4 md:p-6">
                        <div class="max-w-2xl mx-auto">
                            <!-- Unified Search Input -->
                            <div class="relative">
                                <input
                                    v-model="publicationSearch"
                                    @input="searchPublications"
                                    type="text"
                                    placeholder="Search by title or type (e.g., Report)"
                                    class="w-full pl-9 pr-3 py-2 text-sm md:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                />
                                <svg
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Publications Grid -->
                    <div class="relative min-h-[600px]">
                        <!-- Loading State -->
                        <div
                            v-if="
                                publicationsLoading && publications.length === 0
                            "
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                        >
                            <div v-for="i in 6" :key="i" class="animate-pulse">
                                <div
                                    class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
                                >
                                    <div class="flex items-center mb-4">
                                        <div
                                            class="w-12 h-12 bg-gray-200 rounded-lg"
                                        ></div>
                                        <div class="ml-3 flex-1">
                                            <div
                                                class="h-4 bg-gray-200 rounded w-3/4 mb-2"
                                            ></div>
                                            <div
                                                class="h-3 bg-gray-200 rounded w-1/2"
                                            ></div>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div
                                            class="h-4 bg-gray-200 rounded"
                                        ></div>
                                        <div
                                            class="h-4 bg-gray-200 rounded w-5/6"
                                        ></div>
                                    </div>
                                    <div
                                        class="mt-4 h-10 bg-gray-200 rounded"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <!-- Publications Grid -->
                        <div
                            v-else-if="publications.length > 0"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 relative"
                        >
                            <!-- Loading overlay for pagination -->
                            <div
                                v-if="publicationsLoading"
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

                            <div
                                v-for="publication in publications"
                                :key="publication.id"
                                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden"
                            >
                                <div class="p-3 md:p-6">
                                    <!-- File Type Icon and Info -->
                                    <div class="flex items-start mb-2 md:mb-4">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 md:w-12 md:h-12 bg-green-100 rounded-lg flex items-center justify-center"
                                            >
                                                <svg
                                                    v-if="
                                                        publication.file_type ===
                                                        'pdf'
                                                    "
                                                    class="w-4 h-4 md:w-6 md:h-6 text-red-600"
                                                    fill="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"
                                                    />
                                                </svg>
                                                <svg
                                                    v-else-if="
                                                        publication.file_type ===
                                                            'doc' ||
                                                        publication.file_type ===
                                                            'docx'
                                                    "
                                                    class="w-4 h-4 md:w-6 md:h-6 text-blue-600"
                                                    fill="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"
                                                    />
                                                </svg>
                                                <svg
                                                    v-else
                                                    class="w-4 h-4 md:w-6 md:h-6 text-gray-600"
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
                                        </div>
                                        <div class="ml-3 flex-1 min-w-0">
                                            <div
                                                class="flex items-center justify-between"
                                            >
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                                >
                                                    {{
                                                        publication.file_type_display
                                                    }}
                                                </span>
                                                <span
                                                    class="text-xs text-gray-500"
                                                >
                                                    {{ publication.file_size }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Publication Title -->
                                    <h3
                                        class="text-sm md:text-lg font-semibold text-gray-900 mb-1 md:mb-2 line-clamp-2"
                                    >
                                        {{ publication.title }}
                                    </h3>

                                    <!-- Publication Description -->
                                    <p
                                        class="text-gray-600 text-xs md:text-sm mb-2 md:mb-4 line-clamp-2 md:line-clamp-3"
                                    >
                                        {{ publication.description }}
                                    </p>

                                    <!-- Publication Meta -->
                                    <div
                                        class="flex items-center justify-between text-xs md:text-sm text-gray-500 mb-2 md:mb-4"
                                    >
                                        <span class="truncate">{{
                                            publication.published_date
                                        }}</span>
                                        <span
                                            v-if="
                                                publication.download_count > 0
                                            "
                                            class="hidden md:inline"
                                        >
                                            {{ publication.download_count }}
                                            downloads
                                        </span>
                                    </div>

                                    <!-- Download Button -->
                                    <button
                                        @click="
                                            downloadPublication(publication)
                                        "
                                        class="w-full bg-green-600 text-white px-2 md:px-4 py-1.5 md:py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center justify-center text-xs md:text-sm"
                                    >
                                        <svg
                                            class="w-3 h-3 md:w-4 md:h-4 mr-1 md:mr-2"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                            />
                                        </svg>
                                        Download
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-else class="text-center py-20">
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
                                <h3
                                    class="text-lg font-medium text-gray-900 mb-2"
                                >
                                    No publications found
                                </h3>
                                <p class="text-gray-500">
                                    Try adjusting your search or filter criteria
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="publications.length > 0"
                        class="flex justify-center"
                    >
                        <nav class="flex items-center space-x-2">
                            <button
                                @click="
                                    loadPublications(
                                        publicationsCurrentPage - 1
                                    )
                                "
                                :disabled="publicationsCurrentPage <= 1"
                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                Previous
                            </button>
                            <span class="px-3 py-2 text-sm text-gray-700">
                                Page {{ publicationsCurrentPage }} of
                                {{ publicationsTotalPages }}
                            </span>
                            <button
                                @click="
                                    loadPublications(
                                        publicationsCurrentPage + 1
                                    )
                                "
                                :disabled="
                                    publicationsCurrentPage >=
                                    publicationsTotalPages
                                "
                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                Next
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Other Tabs - Empty States -->

                <div
                    v-else-if="activeTab === 'success-stories'"
                    class="space-y-12"
                >
                    <div class="text-center">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">
                            Success Stories
                        </h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            Real impact from our community and clients
                        </p>
                    </div>

                    <!-- Search -->
                    <div
                        class="bg-gray-50 rounded-lg p-4 md:p-6 max-w-2xl mx-auto"
                    >
                        <div class="relative">
                            <input
                                v-model="successStoriesSearch"
                                @input="searchSuccessStories"
                                type="text"
                                placeholder="Search by title, client or keywords"
                                class="w-full pl-9 pr-3 py-2 text-sm md:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            />
                            <svg
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                        </div>
                    </div>

                    <!-- Stories (Z-layout with Load More) -->
                    <div class="relative min-h-[400px]">
                        <div
                            v-if="
                                successStoriesLoading &&
                                successStories.length === 0
                            "
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                        >
                            <div v-for="i in 6" :key="i" class="animate-pulse">
                                <div
                                    class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden"
                                >
                                    <div class="h-40 bg-gray-200"></div>
                                    <div class="p-4 space-y-2">
                                        <div
                                            class="h-4 bg-gray-200 rounded w-3/4"
                                        ></div>
                                        <div
                                            class="h-3 bg-gray-200 rounded w-1/2"
                                        ></div>
                                        <div
                                            class="h-3 bg-gray-200 rounded w-full"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            v-else-if="successStories.length > 0"
                            class="space-y-16 md:space-y-20"
                        >
                            <article
                                v-for="(story, idx) in successStories"
                                :key="story.id"
                                class="flex flex-col md:flex-row md:items-center gap-4 md:gap-10 lg:gap-14"
                                :class="{
                                    'md:flex-row-reverse': idx % 2 === 1,
                                }"
                            >
                                <img
                                    :src="
                                        story.image_url ||
                                        '/images/placeholder-news.jpg'
                                    "
                                    :alt="story.title"
                                    class="w-full md:w-1/2 h-56 md:h-[22rem] object-cover rounded-xl shadow-sm"
                                />
                                <div class="w-full md:w-1/2">
                                    <div class="text-xs text-gray-500 mb-2">
                                        {{ story.published_date }}
                                    </div>
                                    <h3
                                        class="text-xl md:text-2xl font-semibold text-gray-900 mb-2 md:mb-3 leading-snug"
                                    >
                                        {{ story.title }}
                                    </h3>
                                    <div
                                        v-if="story.client_name"
                                        class="text-sm text-gray-600 mb-2 md:mb-3"
                                    >
                                        Client: {{ story.client_name }}
                                    </div>
                                    <p class="text-gray-700 mb-3 md:mb-5">
                                        {{ story.story_excerpt }}
                                    </p>
                                </div>
                            </article>
                        </div>

                        <div v-else class="text-center py-12 text-gray-500">
                            No stories found
                        </div>
                    </div>

                    <!-- Load more -->
                    <div
                        v-if="successStoriesPage < successStoriesTotalPages"
                        class="flex justify-center mt-8 md:mt-12"
                    >
                        <button
                            @click="loadMoreSuccessStories"
                            :disabled="successStoriesLoading"
                            class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 disabled:opacity-50 shadow-sm"
                        >
                            {{
                                successStoriesLoading
                                    ? "Loading…"
                                    : "Load more stories"
                            }}
                        </button>
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
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from "vue";
import axios from "axios";

// Initialize activeTab from URL hash or localStorage
const getInitialTab = () => {
    // Check URL hash first
    if (window.location.hash) {
        const hash = window.location.hash.replace("#", "");
        if (
            ["news", "publications", "success-stories", "rfps"].includes(hash)
        ) {
            return hash;
        }
    }

    // Fallback to localStorage
    const savedTab = localStorage.getItem("resourcesActiveTab");
    if (
        savedTab &&
        ["news", "publications", "success-stories", "rfps"].includes(savedTab)
    ) {
        return savedTab;
    }

    // Default to news
    return "news";
};

const activeTab = ref(getInitialTab());

// Watch for tab changes and update URL hash and localStorage
watch(activeTab, (newTab) => {
    // Update URL hash
    window.location.hash = newTab;

    // Save to localStorage
    localStorage.setItem("resourcesActiveTab", newTab);

    // Load data for the new tab
    if (newTab === "publications") {
        fetchPublications();
    } else if (newTab === "news") {
        fetchNews();
    } else if (newTab === "success-stories") {
        fetchSuccessStories();
    }
});

// News data and pagination
const news = ref([]);
const newsLoading = ref(false);
const newsPagination = ref({
    currentPage: 1,
    totalPages: 1,
    totalItems: 0,
    perPage: 6,
});

// Publications data and pagination
const publications = ref([]);
const publicationsLoading = ref(false);
const publicationSearch = ref("");
const publicationsPagination = ref({
    currentPage: 1,
    totalPages: 1,
    totalItems: 0,
    perPage: 12,
});

// Computed properties for publications
const publicationsCurrentPage = computed(
    () => publicationsPagination.value.currentPage
);
const publicationsTotalPages = computed(
    () => publicationsPagination.value.totalPages
);

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
                status: "published",
                orderBy: "published_at",
                direction: "desc",
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

        // Fallback: if no localized news returned, retry with English directly (bypass interceptor)
        if (!news.value || news.value.length === 0) {
            try {
                const origin = window.location.origin;
                const params = new URLSearchParams();
                params.set("per_page", String(newsPagination.value.perPage));
                params.set("page", String(page));
                params.set("status", "published");
                params.set("orderBy", "published_at");
                params.set("direction", "desc");
                params.set("lang", "en");
                const resEn = await fetch(`${origin}/api/news?${params.toString()}`);
                if (resEn.ok) {
                    const dataEn = await resEn.json();
                    if (dataEn?.data?.length) {
                        news.value = dataEn.data;
                        newsPagination.value = {
                            currentPage: dataEn.meta?.current_page || page,
                            totalPages: dataEn.meta?.last_page || 1,
                            totalItems: dataEn.meta?.total || 0,
                            perPage: dataEn.meta?.per_page || 6,
                        };
                    }
                }
            } catch (_) {}
        }

        // Last-resort UI fallback (if API has no items at all)
        if (!news.value || news.value.length === 0) {
            news.value = [];
            newsPagination.value = {
                currentPage: 1,
                totalPages: 1,
                totalItems: 0,
                perPage: newsPagination.value.perPage,
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

// Success Stories state
const successStories = ref([]);
const successStoriesLoading = ref(false);
const successStoriesSearch = ref("");
const successStoriesPage = ref(1);
const successStoriesTotalPages = ref(1);

const fetchSuccessStories = async (page = 1) => {
    try {
        successStoriesLoading.value = true;
        const response = await axios.get("/api/success-stories", {
            params: {
                page,
                per_page: 3,
                search: successStoriesSearch.value || undefined,
            },
        });
        const data = response.data;
        successStories.value = data.data || [];
        successStoriesPage.value = data.meta?.current_page || page;
        successStoriesTotalPages.value = data.meta?.last_page || 1;
    } catch (e) {
        console.error("Error fetching success stories", e);
        successStories.value = [];
        successStoriesPage.value = 1;
        successStoriesTotalPages.value = 1;
    } finally {
        successStoriesLoading.value = false;
    }
};

const searchSuccessStories = () => {
    successStoriesPage.value = 1;
    fetchSuccessStories(1);
};

const loadSuccessStories = (page) => {
    if (
        page >= 1 &&
        page <= successStoriesTotalPages.value &&
        !successStoriesLoading.value
    ) {
        fetchSuccessStories(page);
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
};

// Append next page to the existing list for "Load more"
const loadMoreSuccessStories = async () => {
    if (successStoriesPage.value >= successStoriesTotalPages.value) return;
    const next = successStoriesPage.value + 1;
    try {
        successStoriesLoading.value = true;
        const response = await axios.get("/api/success-stories", {
            params: {
                page: next,
                per_page: 3,
                search: successStoriesSearch.value || undefined,
            },
        });
        const data = response.data;
        const batch = data.data || [];
        successStories.value = [...successStories.value, ...batch];
        successStoriesPage.value = data.meta?.current_page || next;
        successStoriesTotalPages.value =
            data.meta?.last_page || successStoriesTotalPages.value;
    } catch (e) {
        console.error("Error loading more success stories", e);
    } finally {
        successStoriesLoading.value = false;
    }
};

const openStory = (story) => {
    // For now, navigate to a dedicated page if exists later; keep simple
    alert(story.title + "\n\n" + story.story);
};

// Publications methods
const fetchPublications = async (page = 1) => {
    try {
        publicationsLoading.value = true;
        const response = await axios.get("/api/publications", {
            params: {
                page: page,
                per_page: publicationsPagination.value.perPage,
                search: publicationSearch.value || undefined,
            },
        });

        const data = response.data;

        if (data.data) {
            publications.value = data.data;
            publicationsPagination.value = {
                currentPage: data.meta?.current_page || page,
                totalPages: data.meta?.last_page || 1,
                totalItems: data.meta?.total || 0,
                perPage: data.meta?.per_page || 12,
            };
        } else if (Array.isArray(data)) {
            publications.value = data;
            publicationsPagination.value = {
                currentPage: 1,
                totalPages: 1,
                totalItems: data.length,
                perPage: 12,
            };
        }

        // Fallback: if no localized publications returned, retry with English directly (bypass interceptor)
        if (!publications.value || publications.value.length === 0) {
            try {
                const origin = window.location.origin;
                const params = new URLSearchParams();
                params.set("page", String(page));
                params.set(
                    "per_page",
                    String(publicationsPagination.value.perPage)
                );
                if (publicationSearch.value)
                    params.set("search", publicationSearch.value);
                params.set("lang", "en");
                const resEn = await fetch(
                    `${origin}/api/publications?${params.toString()}`
                );
                if (resEn.ok) {
                    const dataEn = await resEn.json();
                    if (dataEn?.data?.length) {
                        publications.value = dataEn.data;
                        publicationsPagination.value = {
                            currentPage: dataEn.meta?.current_page || page,
                            totalPages: dataEn.meta?.last_page || 1,
                            totalItems: dataEn.meta?.total || 0,
                            perPage: dataEn.meta?.per_page || 12,
                        };
                    }
                }
            } catch (_) {}
        }
    } catch (error) {
        console.error("Error fetching publications:", error);
        console.error("Error details:", error.response?.data || error.message);
        console.error("Error status:", error.response?.status);

        // Set empty state on error
        publications.value = [];
        publicationsPagination.value = {
            currentPage: 1,
            totalPages: 1,
            totalItems: 0,
            perPage: 12,
        };
    } finally {
        publicationsLoading.value = false;
    }
};

const loadPublications = (page) => {
    if (
        page >= 1 &&
        page <= publicationsPagination.value.totalPages &&
        !publicationsLoading.value
    ) {
        fetchPublications(page);
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
};

const searchPublications = () => {
    // Reset to first page when searching
    publicationsPagination.value.currentPage = 1;
    fetchPublications(1);
};

// No separate filter; search handles type/title/description

const downloadPublication = async (publication) => {
    try {
        if (publication.file_url) {
            // Create a temporary link to download the file
            const link = document.createElement("a");
            link.href = publication.file_url;
            link.download = publication.title;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            // Track download (optional - you might want to send analytics)
            console.log(`Downloaded: ${publication.title}`);
        } else {
            console.error("No file URL available for download");
        }
    } catch (error) {
        console.error("Error downloading publication:", error);
    }
};

// Load data on component mount
onMounted(() => {
    // Only load data for the initial active tab
    if (activeTab.value === "news") {
        fetchNews();
    } else if (activeTab.value === "publications") {
        fetchPublications();
    } else if (activeTab.value === "success-stories") {
        fetchSuccessStories();
    }

    // Refetch current tab when language changes
    const handleLanguageChanged = () => {
        if (activeTab.value === "news") {
            fetchNews(newsPagination.value.currentPage || 1);
        } else if (activeTab.value === "publications") {
            fetchPublications(publicationsPagination.value.currentPage || 1);
        } else if (activeTab.value === "success-stories") {
            fetchSuccessStories(successStoriesPage.value || 1);
        }
    };
    window.addEventListener("language:changed", handleLanguageChanged);

    onUnmounted(() => {
        window.removeEventListener("language:changed", handleLanguageChanged);
    });
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

/* Hide horizontal scrollbar for tab nav on mobile */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
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
