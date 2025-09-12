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
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <article
                            v-for="article in news"
                            :key="article.id"
                            class="rounded-professional-lg overflow-hidden card-hover bg-white shadow-professional"
                        >
                            <div class="p-6">
                                <div class="text-xs text-gray-500 mb-2">
                                    {{ article.date }}
                                </div>
                                <h3
                                    class="font-semibold text-lg mb-3 text-gray-900"
                                >
                                    {{ article.title }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ article.excerpt }}
                                </p>
                                <a
                                    href="#"
                                    class="text-sm gradient-text hover:underline"
                                    >Read more →</a
                                >
                            </div>
                        </article>
                    </div>
                </div>

                <!-- Publications Tab -->
                <div v-if="activeTab === 'publications'" class="space-y-8">
                    <h2 class="heading-lg text-gray-900 text-center mb-8">
                        Publications
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div
                            v-for="pub in publications"
                            :key="pub.id"
                            class="rounded-professional-lg p-6 card-hover bg-white shadow-professional"
                        >
                            <div class="flex items-start gap-4">
                                <div class="text-3xl gradient-text">
                                    <svg
                                        class="w-8 h-8"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3
                                        class="font-semibold text-lg mb-2 text-gray-900"
                                    >
                                        {{ pub.title }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-3">
                                        {{ pub.description }}
                                    </p>
                                    <div
                                        class="flex items-center gap-4 text-sm text-gray-500"
                                    >
                                        <span>{{ pub.date }}</span>
                                        <span>{{ pub.size }}</span>
                                    </div>
                                </div>
                                <button class="btn btn-secondary text-sm">
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
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                    Download
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success Stories Tab -->
                <div v-if="activeTab === 'stories'" class="space-y-8">
                    <h2 class="heading-lg text-gray-900 text-center mb-8">
                        Success Stories
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div
                            v-for="story in successStories"
                            :key="story.id"
                            class="rounded-professional-lg overflow-hidden card-hover bg-white shadow-professional"
                        >
                            <img
                                :src="story.image"
                                :alt="story.title"
                                class="w-full h-48 object-cover"
                            />
                            <div class="p-6">
                                <h3
                                    class="font-semibold text-lg mb-3 text-gray-900"
                                >
                                    {{ story.title }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ story.excerpt }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">{{
                                        story.location
                                    }}</span>
                                    <a
                                        href="#"
                                        class="text-sm gradient-text hover:underline"
                                        >Read full story →</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RFPs/RFQs Tab -->
                <div v-if="activeTab === 'rfps'" class="space-y-8">
                    <h2 class="heading-lg text-gray-900 text-center mb-8">
                        RFPs & RFQs
                    </h2>
                    <div class="space-y-4">
                        <div
                            v-for="rfp in rfps"
                            :key="rfp.id"
                            class="rounded-professional-lg p-6 card-hover bg-white shadow-professional"
                        >
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3
                                        class="font-semibold text-lg mb-2 text-gray-900"
                                    >
                                        {{ rfp.title }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-2">
                                        {{ rfp.description }}
                                    </p>
                                    <div
                                        class="flex items-center gap-4 text-sm text-gray-500"
                                    >
                                        <span
                                            >Deadline: {{ rfp.deadline }}</span
                                        >
                                        <span>Type: {{ rfp.type }}</span>
                                    </div>
                                </div>
                                <button class="btn btn-secondary">
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
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                    Download
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gallery Tab -->
                <div v-if="activeTab === 'gallery'" class="space-y-8">
                    <h2 class="heading-lg text-gray-900 text-center mb-8">
                        Photo Gallery
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div
                            v-for="(image, index) in gallery"
                            :key="index"
                            class="overflow-hidden rounded-professional-lg card-hover border border-gray-200"
                        >
                            <img
                                :src="image"
                                alt="Gallery image"
                                class="w-full h-40 object-cover hover:scale-105 transition-transform"
                            />
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
import { ref } from "vue";

const activeTab = ref("news");

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

const news = [
    {
        id: 1,
        title: "New Technology Solutions Launch",
        excerpt:
            "A comprehensive suite of technology solutions designed to accelerate business growth and digital transformation.",
        date: "June 15, 2024",
    },
    {
        id: 2,
        title: "Mount Agro Expands to New Markets",
        excerpt:
            "Services now available in three additional regions with specialized local support teams.",
        date: "May 28, 2024",
    },
    {
        id: 3,
        title: "Partnership with Global Tech Leaders",
        excerpt:
            "Strategic partnerships bringing cutting-edge technology solutions to our clients.",
        date: "April 10, 2024",
    },
];

const publications = [
    {
        id: 1,
        title: "Annual Report 2023",
        description:
            "Comprehensive overview of Mount Agro's activities and impact in 2023",
        date: "March 2024",
        size: "2.5 MB",
    },
    {
        id: 2,
        title: "Technology Strategy Guide",
        description:
            "Best practices for technology adoption and digital transformation",
        date: "February 2024",
        size: "1.8 MB",
    },
];

const successStories = [
    {
        id: 1,
        title: "From Startup to Scale-up",
        excerpt:
            "How Mount Agro helped TechCorp scale their platform to serve 100,000+ users.",
        location: "San Francisco, CA",
        image: "https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=800&q=80",
    },
    {
        id: 2,
        title: "Digital Transformation Success",
        excerpt:
            "Stories of businesses that transformed their operations through our technology solutions.",
        location: "New York, NY",
        image: "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=800&q=80",
    },
];

const rfps = [
    {
        id: 1,
        title: "Cloud Infrastructure RFP",
        description:
            "Request for proposals for upgrading cloud infrastructure and security systems",
        deadline: "March 15, 2024",
        type: "RFP",
    },
    {
        id: 2,
        title: "Development Services RFQ",
        description:
            "Request for quotations for custom software development and integration services",
        deadline: "March 20, 2024",
        type: "RFQ",
    },
];

const gallery = [
    "https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1581094288338-231b058b38b8?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1620228885847-9eab2a1adddc?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1532619187608-e5375cab36aa?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80",
];
</script>
