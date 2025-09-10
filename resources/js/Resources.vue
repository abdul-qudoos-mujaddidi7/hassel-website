<template>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <section class="py-20 brand-gradient text-white">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-5xl font-bold mb-6">Resources & Media</h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto">
                    Access our latest publications, news, success stories, and
                    media resources
                </p>
            </div>
        </section>

        <!-- Tab Navigation -->
        <section class="py-8" style="background-color: var(--brand-cream)">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-wrap justify-center gap-4">
                    <button
                        v-for="tab in tabs"
                        :key="tab.id"
                        @click="activeTab = tab.id"
                        :class="[
                            'px-6 py-3 rounded-lg font-semibold transition-colors',
                            activeTab === tab.id
                                ? 'btn-primary'
                                : 'bg-white text-slate-600 hover:bg-slate-50',
                        ]"
                    >
                        <i :class="tab.icon" class="mr-2"></i>
                        {{ tab.name }}
                    </button>
                </div>
            </div>
        </section>

        <!-- Tab Content -->
        <section class="py-16" style="background-color: var(--brand-wheat)">
            <div class="max-w-7xl mx-auto px-4">
                <!-- News Tab -->
                <div v-if="activeTab === 'news'" class="space-y-8">
                    <h2 class="text-3xl font-bold brand-text text-center mb-8">
                        Latest News
                    </h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <article
                            v-for="article in news"
                            :key="article.id"
                            class="rounded-xl overflow-hidden card-hover"
                            style="
                                background-color: var(--brand-cream);
                                border: 1px solid var(--brand-sage);
                            "
                        >
                            <div class="p-6">
                                <div class="text-xs text-slate-500 mb-2">
                                    {{ article.date }}
                                </div>
                                <h3 class="font-semibold text-lg mb-3">
                                    {{ article.title }}
                                </h3>
                                <p class="text-slate-600 text-sm mb-4">
                                    {{ article.excerpt }}
                                </p>
                                <a
                                    href="#"
                                    class="text-sm brand-text hover:underline"
                                    >Read more →</a
                                >
                            </div>
                        </article>
                    </div>
                </div>

                <!-- Publications Tab -->
                <div v-if="activeTab === 'publications'" class="space-y-8">
                    <h2 class="text-3xl font-bold brand-text text-center mb-8">
                        Publications
                    </h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div
                            v-for="pub in publications"
                            :key="pub.id"
                            class="rounded-xl p-6 card-hover"
                            style="
                                background-color: var(--brand-cream);
                                border: 1px solid var(--brand-sage);
                            "
                        >
                            <div class="flex items-start gap-4">
                                <div class="text-3xl brand-text">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg mb-2">
                                        {{ pub.title }}
                                    </h3>
                                    <p class="text-slate-600 text-sm mb-3">
                                        {{ pub.description }}
                                    </p>
                                    <div
                                        class="flex items-center gap-4 text-sm text-slate-500"
                                    >
                                        <span>{{ pub.date }}</span>
                                        <span>{{ pub.size }}</span>
                                    </div>
                                </div>
                                <button class="btn btn-secondary text-sm">
                                    <i class="fa-solid fa-download mr-1"></i>
                                    Download
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success Stories Tab -->
                <div v-if="activeTab === 'stories'" class="space-y-8">
                    <h2 class="text-3xl font-bold brand-text text-center mb-8">
                        Success Stories
                    </h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div
                            v-for="story in successStories"
                            :key="story.id"
                            class="rounded-xl overflow-hidden card-hover"
                            style="
                                background-color: var(--brand-cream);
                                border: 1px solid var(--brand-sage);
                            "
                        >
                            <img
                                :src="story.image"
                                :alt="story.title"
                                class="w-full h-48 object-cover"
                            />
                            <div class="p-6">
                                <h3 class="font-semibold text-lg mb-3">
                                    {{ story.title }}
                                </h3>
                                <p class="text-slate-600 text-sm mb-4">
                                    {{ story.excerpt }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-500">{{
                                        story.location
                                    }}</span>
                                    <a
                                        href="#"
                                        class="text-sm brand-text hover:underline"
                                        >Read full story →</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RFPs/RFQs Tab -->
                <div v-if="activeTab === 'rfps'" class="space-y-8">
                    <h2 class="text-3xl font-bold brand-text text-center mb-8">
                        RFPs & RFQs
                    </h2>
                    <div class="space-y-4">
                        <div
                            v-for="rfp in rfps"
                            :key="rfp.id"
                            class="rounded-xl p-6 card-hover"
                            style="
                                background-color: var(--brand-cream);
                                border: 1px solid var(--brand-sage);
                            "
                        >
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-semibold text-lg mb-2">
                                        {{ rfp.title }}
                                    </h3>
                                    <p class="text-slate-600 text-sm mb-2">
                                        {{ rfp.description }}
                                    </p>
                                    <div
                                        class="flex items-center gap-4 text-sm text-slate-500"
                                    >
                                        <span
                                            >Deadline: {{ rfp.deadline }}</span
                                        >
                                        <span>Type: {{ rfp.type }}</span>
                                    </div>
                                </div>
                                <button class="btn btn-secondary">
                                    <i class="fa-solid fa-download mr-2"></i>
                                    Download
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gallery Tab -->
                <div v-if="activeTab === 'gallery'" class="space-y-8">
                    <h2 class="text-3xl font-bold brand-text text-center mb-8">
                        Photo Gallery
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div
                            v-for="(image, index) in gallery"
                            :key="index"
                            class="overflow-hidden rounded-xl card-hover"
                            style="border: 1px solid var(--brand-earth)"
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
    </div>
</template>

<script setup>
import { ref } from "vue";

const activeTab = ref("news");

const tabs = [
    { id: "news", name: "News", icon: "fa-solid fa-newspaper" },
    { id: "publications", name: "Publications", icon: "fa-solid fa-file-pdf" },
    { id: "stories", name: "Success Stories", icon: "fa-solid fa-star" },
    { id: "rfps", name: "RFPs/RFQs", icon: "fa-solid fa-clipboard-list" },
    { id: "gallery", name: "Gallery", icon: "fa-solid fa-images" },
];

const news = [
    {
        id: 1,
        title: "New Agricultural Loan Program Launch",
        excerpt:
            "A tailored loan program for smallholder farmers to scale sustainably.",
        date: "June 15, 2024",
    },
    {
        id: 2,
        title: "HMI Expands to New Regions",
        excerpt: "Services now available in three additional provinces.",
        date: "May 28, 2024",
    },
    {
        id: 3,
        title: "Partnership with Global Finance Initiative",
        excerpt: "Bringing innovative finance to rural entrepreneurs.",
        date: "April 10, 2024",
    },
];

const publications = [
    {
        id: 1,
        title: "Annual Report 2023",
        description:
            "Comprehensive overview of HMI's activities and impact in 2023",
        date: "March 2024",
        size: "2.5 MB",
    },
    {
        id: 2,
        title: "Agricultural Finance Guide",
        description:
            "Best practices for agricultural lending and risk management",
        date: "February 2024",
        size: "1.8 MB",
    },
];

const successStories = [
    {
        id: 1,
        title: "From Small Farm to Agribusiness",
        excerpt:
            "How HMI helped Ahmad expand his wheat farm into a thriving agribusiness.",
        location: "Herat Province",
        image: "https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=800&q=80",
    },
    {
        id: 2,
        title: "Women Entrepreneurs Leading Change",
        excerpt:
            "Stories of women who transformed their communities through microfinance.",
        location: "Kabul Province",
        image: "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=800&q=80",
    },
];

const rfps = [
    {
        id: 1,
        title: "IT System Upgrade RFP",
        description:
            "Request for proposals for upgrading HMI's core banking system",
        deadline: "March 15, 2024",
        type: "RFP",
    },
    {
        id: 2,
        title: "Training Services RFQ",
        description:
            "Request for quotations for staff training and capacity building",
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
