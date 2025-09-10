<template>
    <div>
        <section
            id="hero"
            class="relative h-[70vh] min-h-[480px] overflow-hidden"
        >
            <div class="absolute inset-0 brand-gradient opacity-80"></div>
            <div class="absolute inset-0">
                <div
                    v-for="(img, i) in heroImages"
                    :key="img"
                    class="absolute inset-0 transition-opacity duration-[1200ms]"
                    :class="{
                        'opacity-100': currentSlide === i,
                        'opacity-0': currentSlide !== i,
                    }"
                >
                    <img
                        :src="img"
                        class="w-full h-full object-cover mix-blend-overlay kenburns"
                        alt="Project"
                    />
                </div>
            </div>
            <div
                class="relative z-10 max-w-7xl mx-auto px-4 h-full flex items-center"
            >
                <div class="max-w-2xl text-white animate-fadeInUp">
                    <h2
                        class="text-5xl md:text-6xl font-extrabold leading-tight tracking-tight"
                    >
                        Inclusive Finance for Sustainable Growth
                    </h2>
                    <p class="mt-5 text-xl text-white/90">
                        We empower farmers and entrepreneurs through
                        Sharia-compliant and conventional financial products.
                    </p>
                    <div class="mt-6 flex gap-3">
                        <router-link to="/our-work" class="btn btn-primary">
                            <i class="fa-solid fa-arrow-right"></i> Explore Our
                            Work
                        </router-link>
                        <router-link to="/resources" class="btn btn-secondary">
                            Latest Updates
                        </router-link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Welcome Intro -->
        <section
            id="welcome"
            class="py-16"
            style="background-color: var(--brand-light)"
        >
            <div
                class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-8 items-center"
            >
                <div>
                    <h3 class="text-3xl font-bold brand-text mb-3">
                        Welcome to HMI
                    </h3>
                    <p class="text-slate-700">
                        Hassel Microfinance Institution (HMI) advances financial
                        inclusion for farmers, micro-entrepreneurs, and
                        communities through ethical, accessible products.
                    </p>
                    <p class="text-slate-700 mt-3">
                        We partner with stakeholders and donors to grow
                        livelihoods, resilience, and sustainable prosperity.
                    </p>
                    <div class="mt-6 flex gap-3">
                        <router-link to="/about" class="btn btn-primary">
                            <i class="fa-solid fa-arrow-right"></i> Who We Are
                        </router-link>
                        <router-link to="/our-work" class="btn btn-secondary">
                            What We Do
                        </router-link>
                    </div>
                </div>
                <div class="relative">
                    <img
                        :src="welcomeImage"
                        class="rounded-2xl w-full h-72 object-cover shadow-xl gradient-border"
                        alt="Welcome"
                    />
                </div>
            </div>
        </section>

        <!-- Vision / Mission / Values -->
        <section
            id="vmv"
            class="py-16"
            style="background-color: var(--brand-white)"
        >
            <div class="max-w-7xl mx-auto px-4">
                <h3 class="text-3xl font-bold brand-text text-center mb-10">
                    <i class="fa-solid fa-lightbulb mr-2"></i>Our Vision,
                    Mission & Values
                </h3>
                <div class="grid gap-6 md:grid-cols-3">
                    <div
                        class="rounded-2xl p-6 card-hover"
                        style="
                            background-color: var(--brand-light);
                            border: 2px solid var(--brand-primary);
                        "
                    >
                        <div
                            class="text-sm uppercase tracking-wide brand-text mb-2"
                        >
                            <i class="fa-solid fa-eye mr-2"></i>Vision
                        </div>
                        <p class="text-slate-700">
                            To enable sustainable economic development and
                            financial inclusion across underserved communities.
                        </p>
                    </div>
                    <div
                        class="rounded-2xl p-6 card-hover"
                        style="
                            background-color: var(--brand-light);
                            border: 2px solid var(--brand-primary);
                        "
                    >
                        <div
                            class="text-sm uppercase tracking-wide brand-text mb-2"
                        >
                            <i class="fa-solid fa-bullseye mr-2"></i>Mission
                        </div>
                        <p class="text-slate-700">
                            Provide innovative, ethical, and accessible
                            financial services that grow livelihoods and
                            resilience.
                        </p>
                    </div>
                    <div
                        class="rounded-2xl p-6 card-hover"
                        style="
                            background-color: var(--brand-light);
                            border: 2px solid var(--brand-primary);
                        "
                    >
                        <div
                            class="text-sm uppercase tracking-wide brand-text mb-2"
                        >
                            <i class="fa-solid fa-heart mr-2"></i>Core Values
                        </div>
                        <ul
                            class="list-disc list-inside text-slate-700 space-y-1"
                        >
                            <li>Integrity & Transparency</li>
                            <li>Client-Centered Impact</li>
                            <li>Innovation & Excellence</li>
                            <li>Social Responsibility</li>
                        </ul>
                    </div>
                </div>
                <div class="mt-8 text-center">
                    <router-link to="/about" class="btn btn-secondary">
                        Learn more about our mission
                    </router-link>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <section
            id="stats"
            class="py-12"
            style="background-color: var(--brand-secondary)"
        >
            <div
                class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-4"
            >
                <div
                    v-for="s in stats"
                    :key="s.label"
                    class="rounded-2xl p-6 text-center card-hover"
                    style="
                        background-color: var(--brand-white);
                        border: 2px solid var(--brand-white);
                    "
                >
                    <div
                        class="text-3xl font-bold"
                        style="color: var(--brand-primary)"
                    >
                        {{ s.display }}
                    </div>
                    <div
                        class="text-sm mt-1 flex items-center justify-center gap-2"
                        style="color: var(--brand-gray)"
                    >
                        <i :class="s.icon"></i>
                        <span>{{ s.label }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Who we are / History -->
        <section
            id="who"
            class="py-16"
            style="background-color: var(--brand-light)"
        >
            <div
                class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-8 items-center"
            >
                <div class="order-2 md:order-1">
                    <h3 class="text-3xl font-bold brand-text mb-3">
                        Who We Are
                    </h3>
                    <p class="text-slate-700">
                        Founded to catalyze inclusive growth, HMI serves urban
                        and rural clients with products tailored to the
                        realities of agriculture and small business.
                    </p>
                    <h4 class="mt-6 font-semibold text-slate-800">
                        Our History
                    </h4>
                    <p class="text-slate-700">
                        From pilot projects to multi-region operations, our
                        focus has remained on impact, transparency, and client
                        success.
                    </p>
                </div>
                <div class="order-1 md:order-2 grid grid-cols-2 gap-3">
                    <img
                        :src="historyImages[0]"
                        class="rounded-xl h-40 w-full object-cover tilt-card"
                        alt="History"
                    />
                    <img
                        :src="historyImages[1]"
                        class="rounded-xl h-40 w-full object-cover tilt-card"
                        alt="History"
                    />
                    <img
                        :src="historyImages[2]"
                        class="rounded-xl h-40 w-full object-cover tilt-card col-span-2"
                        alt="History"
                    />
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 mt-8">
                <router-link to="/about" class="btn btn-primary">
                    <i class="fa-solid fa-arrow-right"></i> Explore About HMI
                </router-link>
            </div>
        </section>

        <!-- Thematic areas -->
        <section
            id="themes"
            class="py-16"
            style="background-color: var(--brand-white)"
        >
            <div class="max-w-7xl mx-auto px-4">
                <h3 class="text-3xl font-bold brand-text mb-8">
                    <i class="fa-solid fa-diagram-project mr-2"></i>Our Thematic
                    Areas
                </h3>
                <div class="grid gap-6 md:grid-cols-3">
                    <div
                        class="rounded-2xl p-6 tilt-card"
                        style="
                            background-color: var(--brand-light);
                            border: 2px solid var(--brand-primary);
                        "
                    >
                        <div
                            class="text-sm uppercase tracking-wide brand-text mb-2"
                        >
                            <i class="fa-solid fa-seedling mr-2"></i>Agriculture
                        </div>
                        <p class="text-slate-700">
                            Financing inputs, irrigation, storage, and market
                            access.
                        </p>
                    </div>
                    <div
                        class="rounded-2xl p-6 tilt-card"
                        style="
                            background-color: var(--brand-light);
                            border: 2px solid var(--brand-primary);
                        "
                    >
                        <div
                            class="text-sm uppercase tracking-wide brand-text mb-2"
                        >
                            <i class="fa-solid fa-cow mr-2"></i>Livestock
                        </div>
                        <p class="text-slate-700">
                            Working capital for herds, feed, and veterinary
                            services.
                        </p>
                    </div>
                    <div
                        class="rounded-2xl p-6 tilt-card"
                        style="
                            background-color: var(--brand-light);
                            border: 2px solid var(--brand-primary);
                        "
                    >
                        <div
                            class="text-sm uppercase tracking-wide brand-text mb-2"
                        >
                            <i class="fa-solid fa-hand-holding-dollar mr-2"></i
                            >Financial Services
                        </div>
                        <p class="text-slate-700">
                            Loans, Murabaha, Ijara, and Wakala tailored to
                            clients.
                        </p>
                    </div>
                </div>
                <div class="mt-8">
                    <router-link to="/our-work" class="btn btn-secondary">
                        See all services
                    </router-link>
                </div>
            </div>
        </section>

        <section
            id="news"
            class="py-16"
            style="background-color: var(--brand-light)"
        >
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-end justify-between mb-6">
                    <h3 class="text-3xl font-bold brand-text">
                        <i class="fa-regular fa-newspaper mr-2"></i>Latest News
                    </h3>
                    <router-link to="/resources" class="link-secondary text-sm">
                        View all
                    </router-link>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="n in latestNews"
                        :key="n.id"
                        class="rounded-xl overflow-hidden card-hover"
                        style="
                            background-color: var(--brand-white);
                            border: 2px solid var(--brand-primary);
                        "
                    >
                        <div class="p-5">
                            <div class="text-xs text-slate-500 mb-2">
                                {{
                                    new Date(
                                        n.published_at
                                    ).toLocaleDateString()
                                }}
                            </div>
                            <h4
                                class="font-semibold text-slate-800 line-clamp-2"
                            >
                                {{ n.title }}
                            </h4>
                            <p class="text-slate-600 text-sm mt-2 line-clamp-3">
                                {{ n.excerpt }}
                            </p>
                        </div>
                    </article>
                </div>
                <div class="mt-8">
                    <router-link to="/resources" class="btn btn-secondary">
                        Browse all news
                    </router-link>
                </div>
            </div>
        </section>

        <!-- Gallery preview -->
        <section
            id="gallery"
            class="py-16"
            style="background-color: var(--brand-secondary)"
        >
            <div class="max-w-7xl mx-auto px-4">
                <h3 class="text-3xl font-bold brand-text mb-6">
                    <i class="fa-regular fa-images mr-2"></i>Photo Gallery
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div
                        v-for="(g, idx) in gallery"
                        :key="idx"
                        class="overflow-hidden rounded-xl card-hover"
                        style="border: 2px solid var(--brand-white)"
                    >
                        <img
                            :src="g"
                            class="w-full h-40 object-cover"
                            alt="Gallery image"
                        />
                    </div>
                </div>
                <div class="mt-8">
                    <router-link to="/resources" class="btn btn-secondary">
                        View full gallery
                    </router-link>
                </div>
            </div>
        </section>

        <!-- Stakeholders -->
        <section
            id="stakeholders"
            class="py-16"
            style="background-color: var(--brand-white)"
        >
            <div class="max-w-7xl mx-auto px-4">
                <h3 class="text-3xl font-bold brand-text mb-6">
                    <i class="fa-solid fa-people-group mr-2"></i>Stakeholders
                </h3>
                <div
                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4"
                >
                    <div
                        v-for="s in stakeholders"
                        :key="s.id"
                        class="rounded-xl p-4 text-center card-hover"
                        style="
                            background-color: var(--brand-light);
                            border: 2px solid var(--brand-primary);
                        "
                    >
                        <div class="font-medium text-slate-800">
                            {{ s.name }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Funding partners -->
        <section
            id="funders"
            class="py-12"
            style="background-color: var(--brand-light)"
        >
            <div class="max-w-7xl mx-auto px-4">
                <h3 class="text-3xl font-bold brand-text mb-6">
                    <i class="fa-solid fa-hand-holding-dollar mr-2"></i>Funding
                    Partners
                </h3>
                <div
                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4"
                >
                    <div
                        v-for="p in fundingPartners"
                        :key="p.id"
                        class="rounded-xl p-4 text-center card-hover"
                        style="
                            background-color: var(--brand-white);
                            border: 2px solid var(--brand-primary);
                        "
                    >
                        <div class="font-medium text-slate-800">
                            {{ p.name }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Closing CTA -->
        <section id="contact-cta" class="py-16 brand-gradient text-white">
            <div
                class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-8 items-center"
            >
                <div>
                    <h3 class="text-3xl font-bold mb-3">Ready to Partner?</h3>
                    <p class="text-white/90">
                        Email us at info@hasselmfi.org or call +93 123 456 789.
                        We’d love to collaborate.
                    </p>
                </div>
                <div class="flex gap-3 md:justify-end">
                    <router-link to="/contact" class="btn btn-primary">
                        <i class="fa-solid fa-envelope"></i> Contact Us
                    </router-link>
                    <router-link to="/resources" class="btn btn-secondary">
                        See Latest News
                    </router-link>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

const heroImages = [
    "https://images.unsplash.com/photo-1532619187608-e5375cab36aa?auto=format&fit=crop&w=1600&q=80",
    "https://images.unsplash.com/photo-1620228885847-9eab2a1adddc?auto=format&fit=crop&w=1600&q=80",
    "https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=1600&q=80",
];
const currentSlide = ref(0);
let slideTimer;

onMounted(() => {
    slideTimer = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % heroImages.length;
    }, 6000);
});

// Animate counters
onMounted(() => {
    const duration = 1200;
    stats.value.forEach((item) => {
        const start = performance.now();
        const step = (now) => {
            const p = Math.min(1, (now - start) / duration);
            const val = Math.floor(item.value * p);
            item.display =
                p === 1
                    ? item.value.toLocaleString
                        ? item.value.toLocaleString() +
                          (typeof item.value === "number" && item.value >= 1000
                              ? "+"
                              : "")
                        : String(item.value)
                    : String(val);
            if (p < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    });
});
const latestNews = ref([
    {
        id: 1,
        title: "New Agricultural Loan Program Launch",
        excerpt:
            "A tailored loan program for smallholder farmers to scale sustainably.",
        published_at: "2024-06-15",
    },
    {
        id: 2,
        title: "HMI Expands to New Regions",
        excerpt: "Services now available in three additional provinces.",
        published_at: "2024-05-28",
    },
    {
        id: 3,
        title: "Partnership with Global Finance Initiative",
        excerpt: "Bringing innovative finance to rural entrepreneurs.",
        published_at: "2024-04-10",
    },
]);

const stats = ref([
    {
        label: "Beneficiaries",
        value: 15000,
        display: "0",
        icon: "fa-solid fa-people-group",
    },
    {
        label: "Projects",
        value: 120,
        display: "0",
        icon: "fa-solid fa-diagram-project",
    },
    { label: "Staff", value: 75, display: "0", icon: "fa-solid fa-user-tie" },
    {
        label: "Regions",
        value: 10,
        display: "0",
        icon: "fa-solid fa-location-dot",
    },
]);

const gallery = ref([
    "https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1581094288338-231b058b38b8?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1620228885847-9eab2a1adddc?auto=format&fit=crop&w=800&q=80",
]);

const stakeholders = ref([
    { id: 1, name: "World Bank" },
    { id: 2, name: "IFC" },
    { id: 3, name: "UNCDF" },
    { id: 4, name: "EU Fund" },
    { id: 5, name: "UNDP" },
]);

const fundingPartners = ref([
    { id: 1, name: "Global Finance Initiative" },
    { id: 2, name: "IFC" },
    { id: 3, name: "World Bank" },
    { id: 4, name: "EU Fund" },
    { id: 5, name: "UNDP" },
    { id: 6, name: "AKDN" },
]);

const welcomeImage =
    "https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?auto=format&fit=crop&w=1200&q=80";
const historyImages = [
    "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80",
    "https://unsplash.com/photos/vintage-pocket-watch-and-open-old-book-on-a-wooden-office-desk-background-closeup-view-time-science-concept-XxlZrSiPwpU",
];
</script>

<style scoped></style>
