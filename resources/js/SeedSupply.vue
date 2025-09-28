<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Modern Hero Section -->
        <section class="relative overflow-hidden">
            <!-- Background with gradient overlay -->
            <div class="absolute inset-0">
                <img
                    :src="'/images/ourWork/ourworkhero.avif'"
                    alt="Seed & Input Supply Chain"
                    class="w-full h-full object-cover"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-br from-green-900/85 via-emerald-800/80 to-teal-900/85"
                ></div>
            </div>

            <!-- Floating elements for visual interest -->
            <div
                class="absolute top-20 right-20 w-32 h-32 bg-white/10 rounded-full blur-xl"
            ></div>
            <div
                class="absolute bottom-20 left-20 w-24 h-24 bg-green-400/20 rounded-full blur-lg"
            ></div>
            <div
                class="absolute top-1/2 left-1/4 w-16 h-16 bg-emerald-400/15 rounded-full blur-md"
            ></div>

            <div
                class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-32"
            >
                <!-- Breadcrumbs -->
                <nav class="mb-8">
                    <div class="flex items-center space-x-2 text-sm">
                        <router-link
                            to="/"
                            class="text-green-200 hover:text-white transition-colors"
                            >Home</router-link
                        >
                        <svg
                            class="w-4 h-4 text-green-300"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        <span class="text-white font-medium"
                            >Seed & Input Supply Chain</span
                        >
                    </div>
                </nav>

                <div class="text-center max-w-4xl mx-auto">
                    <!-- Category Badge -->
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-500/20 text-green-100 border border-green-400/30 mb-6"
                    >
                        <svg
                            class="w-4 h-4 mr-2"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V8z"
                            ></path>
                        </svg>
                        Quality Inputs
                    </div>

                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight"
                    >
                        Seed & Input Supply Chain
                    </h1>

                    <p
                        class="text-xl text-green-100 mb-8 leading-relaxed max-w-3xl mx-auto"
                    >
                        Access high-quality seeds, fertilizers, and eco-friendly
                        inputs through our reliable distribution network.
                        Building sustainable supply chains across provinces for
                        better yields and farming success.
                    </p>

                    <!-- Quick Stats -->
                    <div class="flex flex-wrap justify-center gap-6 mb-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ totalPrograms }}
                            </div>
                            <div class="text-green-200 text-sm">
                                Supply Programs
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ uniqueInputs }}
                            </div>
                            <div class="text-green-200 text-sm">
                                Input Types
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                {{ distributionCenters }}
                            </div>
                            <div class="text-green-200 text-sm">
                                Distribution Centers
                            </div>
                        </div>
                    </div>

                    <!-- Scroll Indicator -->
                    <div class="flex flex-col items-center">
                        <span class="text-green-200 text-sm mb-2"
                            >Explore supply programs below</span
                        >
                        <svg
                            class="w-6 h-6 text-green-300 animate-bounce"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3"
                            ></path>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <!-- Key Inputs Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Quality Inputs & Distribution
                    </h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Comprehensive supply chain solutions providing farmers
                        with access to premium seeds, fertilizers, and
                        eco-friendly inputs through reliable distribution
                        networks.
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <!-- High-Quality Seeds -->
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100"
                    >
                        <div
                            class="w-16 h-16 bg-green-500 rounded-xl flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            High-Quality Seeds
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Certified seeds with high germination rates, disease
                            resistance, and improved yield potential.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Certified quality assurance</li>
                            <li>• Disease-resistant varieties</li>
                            <li>• High germination rates</li>
                            <li>• Improved yield potential</li>
                        </ul>
                    </div>

                    <!-- Eco-Friendly Fertilizers -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-100"
                    >
                        <div
                            class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Eco-Friendly Fertilizers
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Organic and sustainable fertilizers that improve
                            soil health while boosting crop productivity.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Organic composition</li>
                            <li>• Soil health improvement</li>
                            <li>• Sustainable production</li>
                            <li>• Environmentally safe</li>
                        </ul>
                    </div>

                    <!-- Pest Management -->
                    <div
                        class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl p-6 border border-red-100"
                    >
                        <div
                            class="w-16 h-16 bg-red-500 rounded-xl flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Eco-Friendly Pesticides
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Biodegradable pest control solutions that protect
                            crops without harming beneficial insects or
                            environment.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Biodegradable formulas</li>
                            <li>• Beneficial insect protection</li>
                            <li>• Effective pest control</li>
                            <li>• Safe for environment</li>
                        </ul>
                    </div>

                    <!-- Distribution Network -->
                    <div
                        class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6 border border-purple-100"
                    >
                        <div
                            class="w-16 h-16 bg-purple-500 rounded-xl flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Distribution Network
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Extensive network of distribution centers ensuring
                            timely delivery of inputs to farmers across
                            provinces.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Provincial coverage</li>
                            <li>• Timely delivery</li>
                            <li>• Quality assurance</li>
                            <li>• Local partnerships</li>
                        </ul>
                    </div>

                    <!-- Technical Support -->
                    <div
                        class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-6 border border-yellow-100"
                    >
                        <div
                            class="w-16 h-16 bg-yellow-500 rounded-xl flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Technical Support
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Expert guidance on input selection, application
                            methods, and optimal usage for maximum crop
                            performance.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Expert consultation</li>
                            <li>• Application guidance</li>
                            <li>• Usage optimization</li>
                            <li>• Performance monitoring</li>
                        </ul>
                    </div>

                    <!-- Quality Assurance -->
                    <div
                        class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-2xl p-6 border border-teal-100"
                    >
                        <div
                            class="w-16 h-16 bg-teal-500 rounded-xl flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Quality Assurance
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Rigorous testing and certification processes
                            ensuring all inputs meet the highest quality
                            standards.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Testing laboratories</li>
                            <li>• Certification standards</li>
                            <li>• Quality monitoring</li>
                            <li>• Compliance assurance</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filters Section -->
        <section class="py-8 bg-gray-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Filter Supply Programs
                    </h2>
                    <button
                        @click="resetFilters"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
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
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                            ></path>
                        </svg>
                        Reset Filters
                    </button>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                >
                    <!-- Input Type Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Input Type</label
                        >
                        <select
                            v-model="filters.type"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                        >
                            <option value="">All Types</option>
                            <option value="seeds">Seeds</option>
                            <option value="fertilizers">Fertilizers</option>
                            <option value="pesticides">
                                Eco-Friendly Pesticides
                            </option>
                            <option value="tools">Farming Tools</option>
                            <option value="equipment">Equipment</option>
                            <option value="distribution">
                                Distribution Services
                            </option>
                        </select>
                    </div>

                    <!-- Target Crops Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Target Crops</label
                        >
                        <select
                            v-model="filters.crops"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                        >
                            <option value="">All Crops</option>
                            <option value="cereals">
                                Cereals (Wheat, Rice, Maize)
                            </option>
                            <option value="vegetables">Vegetables</option>
                            <option value="fruits">Fruits</option>
                            <option value="pulses">Pulses & Legumes</option>
                            <option value="oilseeds">Oilseeds</option>
                            <option value="spices">Spices & Herbs</option>
                            <option value="cash_crops">Cash Crops</option>
                        </select>
                    </div>

                    <!-- Search Filter -->
                    <div class="relative">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Search</label
                        >
                        <div class="relative">
                            <input
                                v-model="filters.search"
                                type="text"
                                placeholder="Search programs..."
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                            />
                            <svg
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                ></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Results Count -->
                    <div class="flex items-end">
                        <div
                            class="w-full bg-gray-50 rounded-lg px-4 py-3 text-sm text-gray-600"
                        >
                            <span class="font-medium"
                                >{{ total }} programs found</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Programs Catalog Section -->
        <section class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Loading State -->
                <div
                    v-if="loading"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div
                        v-for="n in 6"
                        :key="'sk-' + n"
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 animate-pulse"
                    >
                        <div
                            class="aspect-[16/9] bg-gray-200 rounded-lg mb-4"
                        ></div>
                        <div class="h-6 bg-gray-200 w-3/4 mb-2"></div>
                        <div class="h-4 bg-gray-100 w-1/2 mb-4"></div>
                        <div class="h-4 bg-gray-100 w-full"></div>
                    </div>
                </div>

                <!-- Programs Grid -->
                <div v-else>
                    <div v-if="programs.length === 0" class="text-center py-12">
                        <div
                            class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center"
                        >
                            <svg
                                class="w-12 h-12 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            No Programs Found
                        </h3>
                        <p class="text-gray-600 mb-6">
                            No programs match your current filters. Try
                            adjusting your search criteria.
                        </p>
                        <button
                            @click="resetFilters"
                            class="inline-flex items-center px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition-colors"
                        >
                            Clear Filters
                        </button>
                    </div>

                    <div
                        v-else
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <div
                            v-for="program in programs"
                            :key="program.id"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow"
                        >
                            <!-- Program Image -->
                            <div
                                class="aspect-[16/9] bg-gradient-to-br from-orange-50 to-yellow-50 rounded-lg mb-4 flex items-center justify-center"
                            >
                                <div
                                    v-if="program.cover_image"
                                    class="w-full h-full"
                                >
                                    <img
                                        :src="program.cover_image"
                                        :alt="program.name"
                                        class="w-full h-full object-cover rounded-lg"
                                    />
                                </div>
                                <div v-else class="text-center">
                                    <svg
                                        class="w-16 h-16 text-orange-400 mx-auto mb-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                        ></path>
                                    </svg>
                                    <p class="text-orange-600 font-medium">
                                        {{
                                            program.input_type ||
                                            "Supply Program"
                                        }}
                                    </p>
                                </div>
                            </div>

                            <!-- Program Info -->
                            <div class="mb-4">
                                <h3
                                    class="text-lg font-semibold text-gray-900 mb-2"
                                >
                                    {{ program.name }}
                                </h3>
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    {{
                                        program.short_description ||
                                        program.description
                                    }}
                                </p>
                            </div>

                            <!-- Program Meta -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    v-if="program.input_type"
                                    class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full"
                                >
                                    {{ formatInputType(program.input_type) }}
                                </span>
                                <span
                                    v-if="program.target_crops"
                                    class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full"
                                >
                                    {{ formatCrops(program.target_crops) }}
                                </span>
                                <span
                                    v-if="program.availability"
                                    class="px-2 py-1 bg-emerald-100 text-emerald-800 text-xs font-medium rounded-full"
                                >
                                    {{ program.availability }}
                                </span>
                            </div>

                            <!-- Program Action -->
                            <div class="mt-4">
                                <router-link
                                    :to="`/seed-supply/${
                                        program.slug || program.id
                                    }`"
                                    class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 text-sm text-center shadow-sm hover:shadow-md block"
                                >
                                    <svg
                                        class="w-4 h-4 inline mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        ></path>
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        ></path>
                                    </svg>
                                    View Details
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { onMounted, ref, watch, computed } from "vue";

const loading = ref(true);
const programs = ref([]);
const total = ref(0);

const filters = ref({
    type: "",
    crops: "",
    search: "",
});

// Computed stats
const totalPrograms = computed(() => programs.value.length);
const uniqueInputs = computed(() => {
    const inputs = programs.value
        .map((program) => program.input_type)
        .filter(Boolean);
    return new Set(inputs).size;
});
const distributionCenters = computed(() => {
    const locations = programs.value
        .map((program) => program.distribution_centers)
        .filter(Boolean);
    const allLocations = locations.flatMap((location) => {
        if (typeof location === "string") {
            try {
                return JSON.parse(location);
            } catch {
                return location.split(",").map((l) => l.trim());
            }
        }
        return Array.isArray(location) ? location : [];
    });
    return new Set(allLocations).size;
});

// Watch filters and fetch programs
watch(
    filters,
    () => {
        fetchPrograms();
    },
    { deep: true }
);

onMounted(() => {
    fetchPrograms();
});

async function fetchPrograms() {
    loading.value = true;
    try {
        const params = new URLSearchParams();
        if (filters.value.type) params.set("input_type", filters.value.type);
        if (filters.value.crops)
            params.set("target_crops", filters.value.crops);
        if (filters.value.search) params.set("search", filters.value.search);

        console.log(
            "Fetching seed supply programs with params:",
            params.toString()
        );
        const res = await fetch(
            `/api/seed-supply-programs?${params.toString()}`
        );
        if (!res.ok) throw new Error("Failed to load programs");

        const data = await res.json();
        const list = Array.isArray(data?.data)
            ? data.data
            : Array.isArray(data)
            ? data
            : [];

        let mappedPrograms = list.map((program) => ({
            id: program.id,
            name: program.name || program.title || "Seed Supply Program",
            description: program.description || program.short_description || "",
            short_description:
                program.short_description || program.description || "",
            input_type: program.input_type || program.type,
            target_crops: program.target_crops,
            availability: program.availability || "Available",
            distribution_centers: program.distribution_centers,
            cover_image:
                program.cover_image || program.thumbnail_image || program.image,
            status: program.status || "published",
            slug: program.slug,
        }));

        // Client-side search if API doesn't handle it
        if (filters.value.search) {
            const searchTerm = filters.value.search.toLowerCase();
            mappedPrograms = mappedPrograms.filter(
                (program) =>
                    program.name.toLowerCase().includes(searchTerm) ||
                    program.description.toLowerCase().includes(searchTerm) ||
                    program.short_description
                        .toLowerCase()
                        .includes(searchTerm) ||
                    (program.input_type &&
                        program.input_type.toLowerCase().includes(searchTerm))
            );
        }

        programs.value = mappedPrograms;
        total.value = programs.value.length;

        // Debug: Log the first and last programs to see their data
        console.log("First program:", programs.value[0]);
        console.log("Last program:", programs.value[programs.value.length - 1]);
        console.log(
            "All program IDs and slugs:",
            programs.value.map((p) => ({
                id: p.id,
                slug: p.slug,
                name: p.name,
            }))
        );
    } catch (error) {
        console.error("Error fetching programs:", error);
        programs.value = [];
        total.value = 0;
    } finally {
        loading.value = false;
    }
}

function resetFilters() {
    filters.value = {
        type: "",
        crops: "",
        search: "",
    };
}

function formatInputType(type) {
    return String(type)
        .replace(/_/g, " ")
        .replace(/\b\w/g, (c) => c.toUpperCase());
}

function formatCrops(crops) {
    if (!crops) return "Various";
    if (typeof crops === "string") {
        try {
            const parsed = JSON.parse(crops);
            return Array.isArray(parsed)
                ? parsed.slice(0, 2).join(", ")
                : crops;
        } catch {
            return crops.split(",").slice(0, 2).join(", ");
        }
    }
    if (Array.isArray(crops)) {
        return crops.slice(0, 2).join(", ");
    }
    return "Various";
}
</script>
