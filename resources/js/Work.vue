<template>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <section class="relative text-white overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img
                    :src="'/images/ourWork/ourworkhero.avif'"
                    alt="Our Work"
                    class="w-full h-full object-cover"
                />
            </div>
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/60"></div>

            <div
                class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-40"
            >
                <div class="text-center">
                    <h1
                        class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fadeInUp"
                    >
                        Our <span class="gradient-text">Work</span>
                    </h1>
                    <p
                        class="text-xl md:text-2xl text-green-100 mb-8 max-w-3xl mx-auto animate-fadeInUp"
                        style="animation-delay: 0.2s"
                    >
                        Building resilient farming livelihoods across
                        Afghanistan through programs, tools, and partnerships.
                    </p>
                    <div
                        class="flex flex-col sm:flex-row gap-4 justify-center animate-fadeInUp"
                        style="animation-delay: 0.35s"
                    >
                        <router-link
                            to="/resources"
                            class="btn btn-secondary px-8 py-4 text-lg"
                            >Explore Resources</router-link
                        >
                        <router-link
                            to="/contact"
                            class="btn btn-cta px-8 py-4 text-lg"
                            >Contact Us</router-link
                        >
                    </div>
                </div>
            </div>
        </section>

        <!-- Thematic Areas Section -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-4">
                        Our Work Areas
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Extended overview of the five pillars that drive our
                        programs and impact.
                    </p>
                </div>

                <!-- Five Pillars (extended overview) -->
                <div
                    v-if="false"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <!-- Training Programs -->
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Training Programs
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Farmer education, GAP, and capacity building across
                            provinces.
                        </p>
                        <router-link
                            to="/training-programs"
                            class="text-green-700 font-semibold"
                            >Explore →</router-link
                        >
                    </div>

                    <!-- Agri‑Tech Tools -->
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-emerald-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v8m4-4H8"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Agri‑Tech Tools
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Practical tools, guides, and resources for smarter
                            farming.
                        </p>
                        <router-link
                            to="/agri-tech"
                            class="text-green-700 font-semibold"
                            >Explore →</router-link
                        >
                    </div>

                    <!-- Market Access Programs -->
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-yellow-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 10h18M7 15h10m-9 4h8"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Market Access Programs
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Linking farmers to buyers, value chains, and
                            partners.
                        </p>
                        <router-link
                            to="/market-access"
                            class="text-green-700 font-semibold"
                            >Explore →</router-link
                        >
                    </div>

                    <!-- Environmental Projects -->
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-teal-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 2l3 7h7l-5.5 4 2.5 7-7-4-7 4 2.5-7L2 9h7z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Environmental Projects
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Conservation, reforestation, and water management
                            initiatives.
                        </p>
                        <router-link
                            to="/environment"
                            class="text-green-700 font-semibold"
                            >Explore →</router-link
                        >
                    </div>

                    <!-- Community Programs -->
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4 9 5.567 9 7.5 10.343 11 12 11zM5 20a7 7 0 0114 0v1H5v-1z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Community Programs
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Empowerment for women, youth, cooperatives, and
                            farmers.
                        </p>
                        <router-link
                            to="/community"
                            class="text-green-700 font-semibold"
                            >Explore →</router-link
                        >
                    </div>
                </div>

                <!-- Our Work Areas (5 pillars) -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <!-- Training Programs -->
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Training Programs
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Farmer education, GAP, and capacity building across
                            provinces.
                        </p>
                        <router-link
                            to="/training-programs"
                            class="text-green-700 font-semibold"
                            >Explore →</router-link
                        >
                    </div>

                    <!-- Agri‑Tech Tools -->
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-emerald-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v8m4-4H8"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Agri‑Tech Tools
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Practical tools, guides, and resources for smarter
                            farming.
                        </p>
                        <router-link
                            to="/agri-tech"
                            class="text-green-700 font-semibold"
                            >Explore →</router-link
                        >
                    </div>

                    <!-- Market Access Programs -->
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-yellow-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 10h18M7 15h10m-9 4h8"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Market Access Programs
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Linking farmers to buyers, value chains, and
                            partners.
                        </p>
                        <router-link
                            to="/market-access"
                            class="text-green-700 font-semibold"
                            >Explore →</router-link
                        >
                    </div>

                    <!-- Environmental Projects -->
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-teal-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 2l3 7h7l-5.5 4 2.5 7-7-4-7 4 2.5-7L2 9h7z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Environmental Projects
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Conservation, reforestation, and water management
                            initiatives.
                        </p>
                        <router-link
                            to="/environment"
                            class="text-green-700 font-semibold"
                            >Explore →</router-link
                        >
                    </div>

                    <!-- Community Programs -->
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4 9 5.567 9 7.5 10.343 11 12 11zM5 20a7 7 0 0114 0v1H5v-1z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Community Programs
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Empowerment for women, youth, cooperatives, and
                            farmers.
                        </p>
                        <router-link
                            to="/community"
                            class="text-green-700 font-semibold"
                            >Explore →</router-link
                        >
                    </div>

                    <!-- Placeholder to balance 3-column grid on large screens -->
                    <div class="hidden lg:block"></div>
                </div>

                <div
                    v-if="false"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            Digital Transformation
                        </h3>
                        <p class="text-gray-600 mb-6">
                            Modernize your business processes with cutting-edge
                            digital solutions that drive efficiency and growth.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li>• Process automation</li>
                            <li>• Legacy system modernization</li>
                            <li>• Digital workflow optimization</li>
                            <li>• Change management support</li>
                        </ul>
                    </div>

                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-emerald-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            Cloud Solutions
                        </h3>
                        <p class="text-gray-600 mb-6">
                            Scalable, secure, and cost-effective cloud
                            infrastructure that grows with your business needs.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li>• Cloud migration</li>
                            <li>• Infrastructure as a Service</li>
                            <li>• Cloud security</li>
                            <li>• Multi-cloud strategies</li>
                        </ul>
                    </div>

                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-yellow-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            Data Analytics
                        </h3>
                        <p class="text-gray-600 mb-6">
                            Transform raw data into actionable insights that
                            drive informed business decisions and growth.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li>• Business intelligence</li>
                            <li>• Predictive analytics</li>
                            <li>• Data visualization</li>
                            <li>• Machine learning</li>
                        </ul>
                    </div>

                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            Cybersecurity
                        </h3>
                        <p class="text-gray-600 mb-6">
                            Protect your digital assets with comprehensive
                            security solutions and best practices.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li>• Security assessments</li>
                            <li>• Threat monitoring</li>
                            <li>• Compliance management</li>
                            <li>• Incident response</li>
                        </ul>
                    </div>

                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-purple-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            Mobile Development
                        </h3>
                        <p class="text-gray-600 mb-6">
                            Native and cross-platform mobile applications that
                            deliver exceptional user experiences.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li>• iOS development</li>
                            <li>• Android development</li>
                            <li>• Cross-platform apps</li>
                            <li>• App store optimization</li>
                        </ul>
                    </div>

                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            Growth Strategy
                        </h3>
                        <p class="text-gray-600 mb-6">
                            Strategic consulting and implementation to
                            accelerate your business growth and market presence.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li>• Market analysis</li>
                            <li>• Technology roadmaps</li>
                            <li>• Performance optimization</li>
                            <li>• Scalability planning</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Programs (Dynamic preview) -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-4">
                        Featured Programs
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        A quick look at ongoing initiatives across our pillars.
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="item in featuredPrograms"
                        :key="item.key"
                        class="p-6 rounded-professional-lg border border-gray-200 card-hover bg-white"
                    >
                        <div class="flex items-center justify-between mb-3">
                            <span
                                class="text-xs font-semibold px-2 py-1 rounded bg-green-50 text-green-700"
                                >{{ item.type }}</span
                            >
                            <router-link
                                :to="item.route"
                                class="text-sm text-green-700 hover:underline"
                                >View all</router-link
                            >
                        </div>
                        <h3
                            class="text-lg font-bold text-gray-900 mb-1 truncate"
                        >
                            {{ item.title }}
                        </h3>
                        <p
                            v-if="item.subtitle"
                            class="text-sm text-gray-600 line-clamp-2 mb-3"
                        >
                            {{ item.subtitle }}
                        </p>
                        <div class="flex flex-wrap gap-2 text-xs">
                            <span
                                v-if="item.status"
                                class="px-2 py-1 rounded bg-emerald-50 text-emerald-700"
                                >Status: {{ item.status }}</span
                            >
                            <span
                                v-if="item.location"
                                class="px-2 py-1 rounded bg-blue-50 text-blue-700"
                                >{{ item.location }}</span
                            >
                            <span
                                v-if="item.dateRange"
                                class="px-2 py-1 rounded bg-yellow-50 text-yellow-700"
                                >{{ item.dateRange }}</span
                            >
                        </div>
                    </div>

                    <!-- Loading / fallback cards -->
                    <div
                        v-if="featuredLoading"
                        class="p-6 rounded-professional-lg border border-gray-200 bg-white animate-pulse"
                        v-for="n in 3"
                        :key="'skeleton-' + n"
                    >
                        <div class="h-4 w-24 bg-gray-200 rounded mb-4"></div>
                        <div class="h-5 w-3/4 bg-gray-200 rounded mb-2"></div>
                        <div class="h-4 w-2/3 bg-gray-100 rounded"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Impact Stats Section -->
        <section
            class="section-padding bg-gradient-to-r from-green-600 to-emerald-600 text-white"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg mb-4">Our Impact</h2>
                    <p class="text-xl text-green-100 max-w-3xl mx-auto">
                        Measurable results from our beneficiaries and programs.
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">
                            {{ stats.beneficiaries ?? "—" }}
                        </div>
                        <div class="text-green-100">Beneficiaries</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">
                            {{ stats.programs ?? "—" }}
                        </div>
                        <div class="text-green-100">Programs</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">
                            {{ stats.projects ?? "—" }}
                        </div>
                        <div class="text-green-100">Projects</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">
                            {{ stats.locations ?? "—" }}
                        </div>
                        <div class="text-green-100">Locations</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="section-padding bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="heading-lg text-gray-900 mb-6">
                    Ready to Transform Your Business?
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Let's discuss how we can help you achieve your goals with
                    our technology solutions and expertise.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <router-link
                        to="/contact"
                        class="btn btn-cta text-lg px-8 py-4"
                    >
                        Start Your Project
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
                        to="/about"
                        class="btn btn-secondary text-lg px-8 py-4"
                    >
                        Learn More About Us
                    </router-link>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

const featuredPrograms = ref([]);
const featuredLoading = ref(true);
const stats = ref({});

async function safeFetchJson(url) {
    try {
        const res = await fetch(url);
        if (!res.ok) return null;
        return await res.json();
    } catch (e) {
        return null;
    }
}

onMounted(async () => {
    // Load impact stats
    const statsRes = await safeFetchJson("/api/stats");
    if (statsRes) {
        stats.value = {
            beneficiaries:
                statsRes.total_beneficiaries ??
                statsRes.beneficiaries ??
                statsRes.total ??
                0,
            programs: statsRes.total_programs ?? statsRes.programs ?? 0,
            projects: statsRes.total_projects ?? statsRes.projects ?? 0,
            locations:
                statsRes.total_locations ??
                statsRes.locations ??
                statsRes.provinces ??
                0,
        };
    }

    // Load a small preview across pillars (best-effort)
    const [tp, ma, cp] = await Promise.all([
        safeFetchJson("/api/training-programs?limit=1"),
        safeFetchJson("/api/market-access-programs?limit=1"),
        safeFetchJson("/api/community-programs?limit=1"),
    ]);

    const picked = [];
    if (tp?.data?.length)
        picked.push({
            key: `tp-${tp.data[0].id}`,
            type: "Training",
            title: tp.data[0].title ?? tp.data[0].name ?? "Training Program",
            subtitle:
                tp.data[0].short_description ?? tp.data[0].description ?? "",
            status: tp.data[0].status ?? tp.data[0].program_status,
            location:
                tp.data[0].location ??
                tp.data[0].province ??
                tp.data[0].district,
            dateRange:
                tp.data[0].start_date && tp.data[0].end_date
                    ? `${tp.data[0].start_date} – ${tp.data[0].end_date}`
                    : undefined,
            route: "/training-programs",
        });
    if (ma?.data?.length)
        picked.push({
            key: `ma-${ma.data[0].id}`,
            type: "Market Access",
            title: ma.data[0].title ?? ma.data[0].name ?? "Market Program",
            subtitle:
                ma.data[0].short_description ?? ma.data[0].description ?? "",
            status: ma.data[0].status ?? ma.data[0].program_status,
            location:
                ma.data[0].location ?? ma.data[0].region ?? ma.data[0].province,
            dateRange:
                ma.data[0].start_date && ma.data[0].end_date
                    ? `${ma.data[0].start_date} – ${ma.data[0].end_date}`
                    : undefined,
            route: "/market-access",
        });
    if (cp?.data?.length)
        picked.push({
            key: `cp-${cp.data[0].id}`,
            type: "Community",
            title: cp.data[0].title ?? cp.data[0].name ?? "Community Program",
            subtitle:
                cp.data[0].short_description ?? cp.data[0].description ?? "",
            status: cp.data[0].status ?? cp.data[0].program_status,
            location:
                cp.data[0].location ??
                cp.data[0].district ??
                cp.data[0].province,
            dateRange:
                cp.data[0].start_date && cp.data[0].end_date
                    ? `${cp.data[0].start_date} – ${cp.data[0].end_date}`
                    : undefined,
            route: "/community",
        });

    featuredPrograms.value = picked;
    featuredLoading.value = false;
});
</script>
