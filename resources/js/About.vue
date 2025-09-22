<template>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <section
            class="relative bg-gradient-to-br from-green-800 via-green-700 to-green-600 text-white overflow-hidden"
        >
            <img
                :src="'/images/about/Hero.webp'"
                alt="About hero"
                class="absolute inset-0 w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-black/25"></div>

            <div
                class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 lg:py-32"
            >
                <div class="text-center">
                    <h1
                        class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fadeInUp transition-all duration-500"
                    >
                        {{ "About Mount Agro Microfinance Institution" }}
                    </h1>
                    <p
                        class="text-lg md:text-2xl text-green-100 mb-6 md:mb-8 max-w-4xl mx-auto animate-fadeInUp transition-all duration-500"
                        style="animation-delay: 0.15s"
                    >
                        {{
                            "Learn more about our mission, history, and the people advancing Afghanistan's agricultural communities."
                        }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Who We Are Section (deeper narrative) -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14 md:mb-16">
                    <h2 class="heading-lg text-green-600 mb-4">Who We Are</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        {{
                            whoWeAreIntro ||
                            "Mount Agro Microfinance Institution (MAI) supports farmers, cooperatives, and rural entrepreneurs with inclusive finance, training, and market linkages."
                        }}
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                    <div class="order-2 lg:order-1">
                        <p class="text-lg text-gray-600 leading-relaxed mb-6">
                            {{
                                whoWeAreBodyA ||
                                "We combine microfinance solutions with technical assistance to unlock productivity, resilience, and incomes across Afghanistan's agri‑value chains. Through targeted programs and responsible finance, we help farmers adopt improved practices, access inputs, and connect to markets."
                            }}
                        </p>
                        <p class="text-lg text-gray-600 leading-relaxed mb-8">
                            {{
                                whoWeAreBodyB ||
                                "Our approach centers on community engagement, evidence‑based design, and partnerships with government, donors, and the private sector—ensuring impact at scale."
                            }}
                        </p>
                        <!-- Differentiators: deeper content than Home -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                            <div class="flex items-start gap-3">
                                <div
                                    class="mt-1 w-2 h-2 rounded-full bg-green-600"
                                ></div>
                                <p class="text-gray-700">
                                    Integrated model: finance + training +
                                    market access delivered together
                                </p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="mt-1 w-2 h-2 rounded-full bg-green-600"
                                ></div>
                                <p class="text-gray-700">
                                    Climate‑smart and gender‑responsive program
                                    design
                                </p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="mt-1 w-2 h-2 rounded-full bg-green-600"
                                ></div>
                                <p class="text-gray-700">
                                    Partnerships with local cooperatives and
                                    private buyers
                                </p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="mt-1 w-2 h-2 rounded-full bg-green-600"
                                ></div>
                                <p class="text-gray-700">
                                    Strong field presence and continuous
                                    technical advisory
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <router-link to="/our-work" class="btn btn-primary"
                                >Explore Our Work</router-link
                            >
                            <router-link to="/contact" class="btn btn-secondary"
                                >Contact Us</router-link
                            >
                        </div>
                    </div>

                    <div class="order-1 lg:order-2">
                        <div class="grid grid-cols-2 gap-4">
                            <img
                                :src="'/images/about/who_we_are_1.avif'"
                                alt="About hero"
                                class="col-span-2 h-64 md:h-80 w-full object-cover rounded-professional-lg shadow-professional"
                            />
                            <img
                                :src="'/images/about/who_we_are_2.avif'"
                                alt="Training session"
                                class="h-40 w-full object-cover rounded-professional-lg shadow-soft"
                            />
                            <img
                                :src="'/images/about/who_we_are_3.avif'"
                                alt="Market access"
                                class="h-40 w-full object-cover rounded-professional-lg shadow-soft"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our History (expanded timeline) -->
        <section class="section-padding bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14 md:mb-16">
                    <h2 class="heading-lg text-green-600 mb-4">Our History</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Key milestones in our journey serving Afghanistan\'s
                        agricultural sector.
                    </p>
                </div>

                <div
                    class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8"
                >
                    <div
                        class="text-center p-8 rounded-professional-lg bg-white card-hover shadow-professional"
                    >
                        <div class="text-5xl font-bold gradient-text mb-2">
                            2017
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-800">
                            Founded
                        </h3>
                        <p class="text-gray-600">
                            MAI established with a mandate to expand financial
                            inclusion for smallholder farmers.
                        </p>
                    </div>
                    <div
                        class="text-center p-8 rounded-professional-lg bg-white card-hover shadow-professional"
                    >
                        <div class="text-5xl font-bold gradient-text mb-2">
                            2020
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-800">
                            Capacity Building
                        </h3>
                        <p class="text-gray-600">
                            Launched national training programs on climate‑smart
                            agriculture and cooperative management.
                        </p>
                    </div>
                    <div
                        class="text-center p-8 rounded-professional-lg bg-white card-hover shadow-professional"
                    >
                        <div class="text-5xl font-bold gradient-text mb-2">
                            2024
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-800">
                            Market Access
                        </h3>
                        <p class="text-gray-600">
                            Scaled market linkage initiatives connecting
                            producers to buyers and value chains.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Goals & Objectives -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14 md:mb-16">
                    <h2 class="heading-lg text-green-600 mb-4">
                        Goals & Objectives
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        What we aim to achieve over the next three years.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div
                        class="p-8 rounded-professional-lg bg-gradient-to-br from-green-50 to-green-100 card-hover"
                    >
                        <h3 class="text-xl font-semibold mb-3 text-gray-900">
                            Financial Inclusion
                        </h3>
                        <p class="text-gray-600">
                            Expand access to affordable agri‑finance for
                            smallholders and agri‑SMEs across 20+ provinces.
                        </p>
                    </div>
                    <div
                        class="p-8 rounded-professional-lg bg-gradient-to-br from-emerald-50 to-emerald-100 card-hover"
                    >
                        <h3 class="text-xl font-semibold mb-3 text-gray-900">
                            Capacity & Resilience
                        </h3>
                        <p class="text-gray-600">
                            Deliver training and advisory services that increase
                            productivity and climate resilience.
                        </p>
                    </div>
                    <div
                        class="p-8 rounded-professional-lg bg-gradient-to-br from-yellow-50 to-yellow-100 card-hover"
                    >
                        <h3 class="text-xl font-semibold mb-3 text-gray-900">
                            Market Linkages
                        </h3>
                        <p class="text-gray-600">
                            Strengthen value chains and connect farmers with
                            reliable buyers and inputs.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Strategic Partnerships (profiles/logos) -->
        <section class="section-padding bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14 md:mb-16">
                    <h2 class="heading-lg text-green-600 mb-4">
                        Strategic Partnerships
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        We collaborate with donors and institutions to amplify
                        impact.
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                    <div
                        class="bg-white p-6 rounded-lg shadow-soft text-center"
                    >
                        <div class="text-gray-800 font-semibold">
                            World Bank
                        </div>
                        <div class="text-gray-500 text-sm">
                            Agricultural grants
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-soft text-center"
                    >
                        <div class="text-gray-800 font-semibold">USAID</div>
                        <div class="text-gray-500 text-sm">
                            Technical assistance
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-soft text-center"
                    >
                        <div class="text-gray-800 font-semibold">FAO</div>
                        <div class="text-gray-500 text-sm">Program support</div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-soft text-center"
                    >
                        <div class="text-gray-800 font-semibold">EU</div>
                        <div class="text-gray-500 text-sm">
                            Development funding
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Leadership Team (bios placeholders) -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14 md:mb-16">
                    <h2 class="heading-lg text-green-600 mb-4">
                        Leadership Team
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Meet the experienced professionals guiding our mission.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div
                        class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-green-50 to-green-100 card-hover"
                    >
                        <img
                            :src="'/images/about/CEO.avif'"
                            alt="Mount Agro CEO"
                            class="w-28 h-28 mx-auto mb-5 rounded-full bg-gradient-to-br from-green-600 to-emerald-600"
                        />

                        <h3 class="text-lg font-semibold mb-1 text-gray-800">
                            CEO & Founder
                        </h3>
                        <p class="text-gray-600 text-sm">
                            Strategic leadership, partnerships, and
                            organizational growth.
                        </p>
                    </div>
                    <div
                        class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-emerald-50 to-emerald-100 card-hover"
                    >
                        <img
                            :src="'/images/about/Directorprograms.avif'"
                            alt="Mount Agro CEO"
                            class="w-28 h-28 mx-auto mb-5 rounded-full bg-gradient-to-br from-green-600 to-emerald-600"
                        />
                        <h3 class="text-lg font-semibold mb-1 text-gray-800">
                            Director, Programs
                        </h3>
                        <p class="text-gray-600 text-sm">
                            Design and delivery of training, market, and
                            community programs.
                        </p>
                    </div>
                    <div
                        class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-yellow-50 to-yellow-100 card-hover"
                    >
                        <img
                            :src="'/images/about/directoreFinance.avif'"
                            alt="Mount Agro CEO"
                            class="w-28 h-28 mx-auto mb-5 rounded-full bg-gradient-to-br from-green-600 to-emerald-600"
                        />
                        <h3 class="text-lg font-semibold mb-1 text-gray-800">
                            Director, Finance
                        </h3>
                        <p class="text-gray-600 text-sm">
                            Financial stewardship and responsible microfinance
                            operations.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- What We Do (detailed) -->
        <section
            class="section-padding bg-gradient-to-r from-green-600 to-emerald-600 text-white"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14 md:mb-16">
                    <h2 class="heading-lg mb-4">What We Do</h2>
                    <p class="text-xl text-green-100 max-w-3xl mx-auto">
                        Our integrated model blends finance, training, and
                        market access.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6"
                        ></div>
                        <h3 class="text-xl font-bold mb-3">Microfinance</h3>
                        <p class="text-green-100">
                            Seasonal/crop loans, equipment financing, and MSME
                            support designed for farmers and agri‑SMEs.
                        </p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6"
                        ></div>
                        <h3 class="text-xl font-bold mb-3">
                            Training & Advisory
                        </h3>
                        <p class="text-green-100">
                            Capacity building on climate‑smart practices,
                            cooperative management, and entrepreneurship.
                        </p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6"
                        ></div>
                        <h3 class="text-xl font-bold mb-3">Market Access</h3>
                        <p class="text-green-100">
                            Linkages to buyers, inputs, and value chains that
                            increase incomes and reduce post‑harvest losses.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="section-padding bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="heading-lg mb-6 text-green-600">
                    Ready to Partner?
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Let\'s explore how we can strengthen agricultural
                    communities together.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <router-link
                        to="/contact"
                        class="btn btn-cta text-lg px-8 py-4"
                        >Contact Us</router-link
                    >
                    <router-link
                        to="/our-work"
                        class="btn btn-secondary text-lg px-8 py-4"
                        >View Our Work</router-link
                    >
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const whoWeAreIntro = ref("");
const whoWeAreBodyA = ref("");
const whoWeAreBodyB = ref("");
const mission = ref("");
const vision = ref("");

onMounted(async () => {
    document.title = "About | Mount Agro Microfinance Institution";
    await fetchAbout();
});
</script>
