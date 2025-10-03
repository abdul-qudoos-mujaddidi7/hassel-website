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
                        Extended overview of the seven pillars that drive our
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

                    <!-- Smart & Sustainable Farming -->
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
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Smart & Sustainable Farming
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Modern techniques like drip irrigation, greenhouse
                            farming, and precision agriculture with
                            climate-resilient crops.
                        </p>
                        <router-link
                            to="/smart-farming"
                            class="text-green-700 font-semibold"
                            >Explore →</router-link
                        >
                    </div>

                    <!-- Seed & Input Supply Chain -->
                    <div
                        class="p-8 rounded-professional-lg border border-gray-200 card-hover"
                    >
                        <div
                            class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-6 h-6 text-orange-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8-4"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Seed & Input Supply Chain
                        </h3>
                        <p class="text-gray-600 mb-4">
                            High-quality seeds, fertilizers, and eco-friendly
                            pesticides with reliable distribution networks.
                        </p>
                        <router-link
                            to="/seed-supply"
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
                        A quick look at ongoing initiatives across our company.
                    </p>
                    <!-- Filter Chips -->
                    <div
                        class="mt-6 flex flex-wrap items-center justify-center gap-2"
                    >
                        <button
                            v-for="f in filters"
                            :key="f"
                            type="button"
                            @click="activeFilter = f"
                            class="px-3 py-1.5 rounded-full text-sm border transition-colors"
                            :class="
                                activeFilter === f
                                    ? 'bg-green-600 text-white border-green-600'
                                    : 'bg-white text-gray-700 border-gray-300 hover:border-gray-400'
                            "
                        >
                            {{ f }}
                        </button>
                    </div>
                </div>

                <div class="relative overflow-visible">
                    <button
                        type="button"
                        @click="scrollFeatured(-1)"
                        class="hidden md:flex absolute left-0 -translate-x-1/2 top-1/2 -translate-y-1/2 z-20 items-center justify-center w-10 h-10 rounded-full bg-white/95 shadow ring-1 ring-black/5 hover:bg-white"
                        aria-label="Previous"
                    >
                        <svg
                            class="w-5 h-5"
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
                    </button>
                    <button
                        type="button"
                        @click="scrollFeatured(1)"
                        class="hidden md:flex absolute right-0 translate-x-1/2 top-1/2 -translate-y-1/2 z-20 items-center justify-center w-10 h-10 rounded-full bg-white/95 shadow ring-1 ring-black/5 hover:bg-white"
                        aria-label="Next"
                    >
                        <svg
                            class="w-5 h-5"
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
                    </button>

                    <div
                        ref="featuredTrack"
                        class="flex gap-6 overflow-x-auto snap-x snap-mandatory snap-always scroll-smooth pb-2 px-2 md:px-3"
                        style="
                            scroll-snap-stop: always;
                            scroll-padding-inline: 1rem;
                        "
                        @mouseenter="pauseAuto()"
                        @mouseleave="resumeAuto()"
                    >
                        <!-- Start spacer to prevent first card peeking under arrows -->
                        <div class="shrink-0 w-6 md:w-6 lg:w-8"></div>
                        <div
                            v-for="item in filteredFeatured"
                            :key="item.key"
                            class="min-w-[100%] sm:min-w-[60%] md:min-w-[340px] lg:min-w-[380px] snap-start rounded-professional-lg border border-gray-200 bg-white card-hover"
                        >
                            <div
                                class="relative aspect-[16/9] overflow-hidden rounded-t-professional-lg bg-gray-100"
                            >
                                <img
                                    v-if="item.image"
                                    :src="item.image"
                                    :alt="item.title"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center text-gray-400 text-sm"
                                >
                                    No image
                                </div>
                                <span
                                    class="absolute left-3 top-3 text-xs font-semibold px-2 py-1 rounded bg-green-50 text-green-700"
                                    >{{ item.type }}</span
                                >
                            </div>
                            <div class="p-5">
                                <h3
                                    class="text-base md:text-lg font-bold text-gray-900 mb-1 truncate"
                                >
                                    {{ item.title }}
                                </h3>
                                <p
                                    v-if="item.subtitle"
                                    class="text-sm text-gray-600 line-clamp-2 mb-3"
                                >
                                    {{ item.subtitle }}
                                </p>
                                <div class="flex flex-wrap gap-2 text-xs mb-3">
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
                                <div class="flex items-center justify-between">
                                    <router-link
                                        :to="item.route"
                                        class="text-sm text-green-700 font-semibold hover:underline"
                                        >View all</router-link
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- End spacer to prevent last card from peeking -->
                        <div class="shrink-0 w-6 md:w-6 lg:w-8"></div>

                        <div
                            v-if="featuredLoading"
                            v-for="n in 3"
                            :key="'sk-' + n"
                            class="min-w-[280px] md:min-w-[340px] lg:min-w-[380px] snap-start rounded-professional-lg border border-gray-200 bg-white animate-pulse"
                        >
                            <div
                                class="aspect-[16/9] bg-gray-200 rounded-t-professional-lg"
                            ></div>
                            <div class="p-5">
                                <div
                                    class="h-5 w-3/4 bg-gray-200 rounded mb-2"
                                ></div>
                                <div
                                    class="h-4 w-2/3 bg-gray-100 rounded mb-3"
                                ></div>
                                <div class="flex gap-2">
                                    <div
                                        class="h-4 w-20 bg-gray-100 rounded"
                                    ></div>
                                    <div
                                        class="h-4 w-16 bg-gray-100 rounded"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured CTA Row -->
        <section class="py-6 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col sm:flex-row gap-3 sm:gap-4 items-center justify-center"
                >
                    <router-link
                        to="/training-programs"
                        class="btn btn-primary"
                    >
                        View all programs
                    </router-link>
                    <router-link to="/contact" class="btn btn-secondary">
                        Contact program team
                    </router-link>
                </div>
            </div>
        </section>

        <!-- Success Stories -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-4">
                        Success Stories
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Real stories from the farmers and communities we serve.
                    </p>
                </div>

                <div class="relative">
                    <div class="overflow-hidden">
                        <div
                            class="flex gap-6"
                            :class="{ 'animate-pulse': testimonialsLoading }"
                        >
                            <article
                                v-for="story in testimonials"
                                :key="story.id"
                                class="flex-shrink-0 w-full md:w-1/2 lg:w-1/3 bg-white rounded-professional-lg border border-gray-200 shadow-professional p-6"
                            >
                                <div class="flex items-center gap-4 mb-4">
                                    <img
                                        :src="story.avatar"
                                        alt="avatar"
                                        class="w-12 h-12 rounded-full object-cover"
                                    />
                                    <div>
                                        <h3 class="font-semibold text-gray-900">
                                            {{ story.author }}
                                        </h3>
                                        <div class="text-sm text-gray-500">
                                            {{ story.location }}
                                        </div>
                                    </div>
                                </div>
                                <p
                                    class="text-gray-700 leading-relaxed mb-4 line-clamp-4"
                                >
                                    “{{ story.excerpt }}”
                                </p>
                                <router-link
                                    :to="`/success-stories/${story.slug}`"
                                    class="text-green-700 font-semibold hover:underline"
                                    >Read full story</router-link
                                >
                            </article>

                            <!-- Skeletons -->
                            <article
                                v-if="testimonialsLoading"
                                v-for="n in 3"
                                :key="'t-sk-' + n"
                                class="flex-shrink-0 w-full md:w-1/2 lg:w-1/3 bg-white rounded-professional-lg border border-gray-200 p-6 animate-pulse"
                            >
                                <div
                                    class="h-12 w-12 rounded-full bg-gray-200 mb-4"
                                ></div>
                                <div class="h-4 w-1/2 bg-gray-200 mb-2"></div>
                                <div class="h-3 w-1/3 bg-gray-100 mb-4"></div>
                                <div class="h-3 w-full bg-gray-100 mb-2"></div>
                                <div class="h-3 w-5/6 bg-gray-100 mb-2"></div>
                                <div class="h-3 w-2/3 bg-gray-100"></div>
                            </article>
                        </div>
                    </div>
                </div>

                <div
                    v-if="testimonialsError"
                    class="mt-6 text-center text-red-600"
                >
                    {{ testimonialsError }}
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
                            {{ stats.projects ?? "—" }}
                        </div>
                        <div class="text-green-100">Projects</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">
                            {{ stats.team ?? "—" }}
                        </div>
                        <div class="text-green-100">Team Members</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">
                            {{ stats.partners ?? "—" }}
                        </div>
                        <div class="text-green-100">Partner Orgs</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";

const featuredPrograms = ref([]);
const featuredLoading = ref(true);
const stats = ref({});
const featuredTrack = ref(null);
let autoTimer = null;
const filters = ref(["All"]);
const activeFilter = ref("All");
const testimonials = ref([]);
const testimonialsLoading = ref(true);
const testimonialsError = ref("");

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
        // Prefer summary block if provided by API
        const s = statsRes.summary ?? {};

        // Optional fallback: try to infer from historical if summary is missing
        const hist = statsRes.historical ?? {};
        const sumFromHist = (type) => {
            try {
                return Object.values(hist)
                    .flat()
                    .filter((x) => x.stat_type === type)
                    .reduce((acc, x) => acc + (Number(x.value) || 0), 0);
            } catch (_) {
                return 0;
            }
        };

        stats.value = {
            beneficiaries:
                s.total_beneficiaries ??
                sumFromHist("total_beneficiaries") ??
                0,
            projects: s.active_projects ?? sumFromHist("active_projects") ?? 0,
            team: s.team_members ?? sumFromHist("team_members") ?? 0,
            partners:
                s.partner_organizations ??
                sumFromHist("partner_organizations") ??
                0,
        };
    }

    // Load a wider preview across pillars (best-effort)
    const [tp, ma, cp, env, tools, smartFarming, seedSupply] =
        await Promise.all([
            safeFetchJson(
                "/api/training-programs?limit=5&orderBy=published_at&direction=desc"
            ),
            safeFetchJson(
                "/api/market-access-programs?limit=5&orderBy=published_at&direction=desc"
            ),
            safeFetchJson(
                "/api/community-programs?limit=5&orderBy=published_at&direction=desc"
            ),
            safeFetchJson(
                "/api/environmental-projects?limit=5&orderBy=published_at&direction=desc"
            ),
            safeFetchJson(
                "/api/agri-tech-tools?limit=5&orderBy=published_at&direction=desc"
            ),
            safeFetchJson(
                "/api/smart-farming-programs?limit=5&orderBy=published_at&direction=desc"
            ),
            safeFetchJson(
                "/api/seed-supply-programs?limit=5&orderBy=published_at&direction=desc"
            ),
        ]);

    const picked = [];
    const mapItem = (type, r, route) => ({
        key: `${type}-${r.id}`,
        type,
        title: r.title ?? r.name ?? type,
        subtitle: r.short_description ?? r.description ?? "",
        status: r.status ?? r.program_status,
        location: r.location ?? r.province ?? r.region ?? r.district,
        dateRange:
            r.start_date && r.end_date
                ? `${r.start_date} – ${r.end_date}`
                : undefined,
        image: r.thumbnail_image ?? r.cover_image ?? r.featured_image ?? null,
        published_at: r.published_at ?? r.start_date ?? r.created_at ?? null,
        route,
    });

    for (const r of tp?.data ?? [])
        picked.push(mapItem("Training", r, "/training-programs"));
    for (const r of ma?.data ?? [])
        picked.push(mapItem("Market Access", r, "/market-access"));
    for (const r of cp?.data ?? [])
        picked.push(mapItem("Community", r, "/community"));
    for (const r of env?.data ?? [])
        picked.push(mapItem("Environment", r, "/environment"));
    for (const r of tools?.data ?? [])
        picked.push(mapItem("Agri‑Tech", r, "/agri-tech"));
    for (const r of smartFarming?.data ?? [])
        picked.push(mapItem("Smart Farming", r, "/smart-farming"));
    for (const r of seedSupply?.data ?? [])
        picked.push(mapItem("Seed Supply", r, "/seed-supply"));

    // client-side fallback: ensure newest first
    featuredPrograms.value = picked.sort((a, b) => {
        const da = a.published_at ? new Date(a.published_at) : new Date(0);
        const db = b.published_at ? new Date(b.published_at) : new Date(0);
        return db - da;
    });
    featuredLoading.value = false;

    // start auto slider
    startAuto();

    // load testimonials
    fetchTestimonials();

    // build dynamic filters from actual data
    buildDynamicFilters();
});

function scrollFeatured(dir) {
    const el = featuredTrack.value;
    if (!el) return;
    const step = 380;
    el.scrollBy({ left: dir * step, behavior: "smooth" });
}

function startAuto() {
    stopAuto();
    autoTimer = setInterval(() => scrollFeatured(1), 4000);
}

function stopAuto() {
    if (autoTimer) clearInterval(autoTimer);
    autoTimer = null;
}

function pauseAuto() {
    stopAuto();
}
function resumeAuto() {
    startAuto();
}

async function fetchTestimonials() {
    try {
        testimonialsLoading.value = true;
        testimonialsError.value = "";
        const res = await fetch("/api/success-stories?limit=6");
        if (!res.ok) throw new Error("Failed to load testimonials");
        const data = await res.json();
        const items = Array.isArray(data?.data)
            ? data.data
            : Array.isArray(data)
            ? data
            : [];
        testimonials.value = items
            .map((s) => ({
                id: s.id,
                slug: s.slug || String(s.id),
                author: s.author || s.title || "Client",
                location: s.location || s.region || "",
                excerpt:
                    s.excerpt ||
                    s.summary ||
                    (s.description ? String(s.description).slice(0, 160) : ""),
                avatar: resolveImageSrc(
                    s.thumbnail_image ||
                        s.cover_image ||
                        s.featured_image ||
                        "/images/shared/avatar-placeholder.png"
                ),
                published_at: s.published_at || s.created_at || null,
            }))
            .sort((a, b) => {
                const da = a.published_at
                    ? new Date(a.published_at)
                    : new Date(0);
                const db = b.published_at
                    ? new Date(b.published_at)
                    : new Date(0);
                return db - da;
            });
    } catch (e) {
        testimonialsError.value = "Unable to load testimonials right now.";
        testimonials.value = [];
    } finally {
        testimonialsLoading.value = false;
    }
}

function resolveImageSrc(path) {
    if (!path) return "";
    const p = String(path).trim();
    if (p.startsWith("http://") || p.startsWith("https://")) return p;
    return `/storage/${p.replace(/^\/+/, "")}`;
}

const filteredFeatured = computed(() => {
    if (activeFilter.value === "All") return featuredPrograms.value;
    return featuredPrograms.value.filter((p) => p.type === activeFilter.value);
});

function buildDynamicFilters() {
    // Extract unique types from featured programs
    const types = [...new Set(featuredPrograms.value.map((p) => p.type))];
    filters.value = ["All", ...types.sort()];
}
</script>
