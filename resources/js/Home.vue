<template>
    <div class="min-h-screen">
        <!-- Hero Section with 5 Images Slider -->
        <section class="relative h-screen overflow-hidden text-white">
            <!-- Image Slider Background -->
            <div class="absolute inset-0">
                <div
                    v-for="(slide, index) in heroSlides"
                    :key="index"
                    :class="[
                        'absolute inset-0 transition-opacity duration-1000 z-0',
                        currentSlide === index ? 'opacity-100' : 'opacity-0',
                    ]"
                >
                    <img
                        :src="slide.image"
                        :alt="slide.title"
                        class="absolute inset-0 w-full h-full object-cover kenburns"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"
                    ></div>
                </div>
            </div>

            <!-- Fallback Gradient -->
            <div
                class="absolute inset-0 bg-gradient-to-br from-green-800 via-green-700 to-green-600 -z-10"
            ></div>

            <div
                class="relative flex items-center justify-center min-h-screen z-10"
            >
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <!-- Dynamic Hero Content -->
                    <div v-if="heroSlides[currentSlide]" class="mb-8">
                        <h1
                            class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fadeInUp"
                        >
                            {{ heroSlides[currentSlide].title }}
                        </h1>
                        <p
                            class="text-xl md:text-2xl text-gray-100 mb-8 max-w-4xl mx-auto animate-fadeInUp"
                            style="animation-delay: 0.2s"
                        >
                            {{ heroSlides[currentSlide].description }}
                        </p>
                    </div>

                    <div
                        class="flex flex-col gap-3 justify-center items-center animate-fadeInUp sm:flex-row sm:gap-4"
                        style="animation-delay: 0.4s"
                    >
                        <router-link
                            to="/training-programs"
                            class="btn btn-cta w-full sm:w-auto flex items-center justify-center text-base px-4 py-3 md:text-lg md:px-8 md:py-4"
                        >
                            Explore Our Programs
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
                            class="btn btn-secondary w-full sm:w-auto flex items-center justify-center text-base px-4 py-3 md:text-lg md:px-8 md:py-4"
                        >
                            Learn About Us
                        </router-link>
                    </div>
                </div>
            </div>

            <!-- Slide Indicators -->
            <div
                class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20"
            >
                <button
                    v-for="(slide, index) in heroSlides"
                    :key="index"
                    @click="currentSlide = index"
                    :class="[
                        'w-3 h-3 rounded-full transition-all duration-300',
                        currentSlide === index
                            ? 'bg-white scale-110'
                            : 'bg-white/50 hover:bg-white/75',
                    ]"
                    :aria-label="`Go to slide ${index + 1}`"
                ></button>
            </div>
        </section>

        <!-- Welcome Section with Animated Stats -->
        <section class="section-padding bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-6">
                        Welcome to Mount Agro Microfinance Institution
                    </h2>
                    <p
                        class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed"
                    >
                        Empowering Afghanistan's agricultural communities
                        through innovative microfinance solutions, comprehensive
                        training programs, and sustainable development
                        initiatives. We are committed to building stronger, more
                        resilient farming communities across the nation.
                    </p>
                </div>

                <!-- Animated Statistics (Beneficiaries Stats) -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8"
                >
                    <!-- Beneficiaries (Total with Male/Female breakdown) -->
                    <div
                        class="p-6 bg-white rounded-professional-lg shadow-soft"
                    >
                        <div class="text-center">
                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4"
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
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                            </div>
                            <div
                                class="text-2xl md:text-3xl font-bold text-green-600 mb-1 md:mb-2"
                                ref="totalBeneficiariesRef"
                            >
                                0
                            </div>
                            <div class="text-gray-600 font-medium mb-2 md:mb-4">
                                Beneficiaries
                            </div>
                        </div>
                        <div class="hidden">
                            <div class="text-center p-3 rounded-lg bg-green-50">
                                <div class="text-sm text-gray-500 mb-1">
                                    Male
                                </div>
                                <div
                                    class="text-xl font-semibold text-emerald-700"
                                    ref="maleBeneficiariesRef"
                                >
                                    0
                                </div>
                            </div>
                            <div class="text-center p-3 rounded-lg bg-pink-50">
                                <div class="text-sm text-gray-500 mb-1">
                                    Female
                                </div>
                                <div
                                    class="text-xl font-semibold text-pink-600"
                                    ref="femaleBeneficiariesRef"
                                >
                                    0
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Programs Completed -->
                    <div
                        class="text-center p-6 bg-white rounded-professional-lg shadow-soft"
                    >
                        <div
                            class="w-12 h-12 md:w-16 md:h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4"
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
                                    d="M9 12l2 2 4-4M7 7h10v10H7z"
                                />
                            </svg>
                        </div>
                        <div
                            class="text-2xl md:text-3xl font-bold text-blue-600 mb-1 md:mb-2"
                            ref="programsCompletedRef"
                        >
                            0
                        </div>
                        <div class="text-gray-600 font-medium">
                            Programs Completed
                        </div>
                    </div>

                    <!-- Provinces Reached -->
                    <div
                        class="text-center p-6 bg-white rounded-professional-lg shadow-soft"
                    >
                        <div
                            class="w-12 h-12 md:w-16 md:h-16 bg-orange-600 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4"
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
                                    d="M12 2a10 10 0 100 20 10 10 0 000-20zm2 11l-2 2-2-2 2-2 2 2z"
                                />
                            </svg>
                        </div>
                        <div
                            class="text-2xl md:text-3xl font-bold text-orange-600 mb-1 md:mb-2"
                            ref="provincesReachedRef"
                        >
                            0
                        </div>
                        <div class="text-gray-600 font-medium">
                            Provinces Reached
                        </div>
                    </div>

                    <!-- Cooperatives Formed -->
                    <div
                        class="text-center p-6 bg-white rounded-professional-lg shadow-soft"
                    >
                        <div
                            class="w-12 h-12 md:w-16 md:h-16 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4"
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
                                    d="M7 8h10M7 12h8m-8 4h6"
                                />
                            </svg>
                        </div>
                        <div
                            class="text-2xl md:text-3xl font-bold text-purple-600 mb-1 md:mb-2"
                            ref="cooperativesFormedRef"
                        >
                            0
                        </div>
                        <div class="text-gray-600 font-medium">
                            Cooperatives Formed
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision / Mission / Values Section -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-4">
                        Our Foundation
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Built on strong principles that guide everything we do
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Vision -->
                    <div
                        class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-green-50 to-green-100 card-hover"
                    >
                        <div
                            class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-6"
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
                                    d="M15 12a3 3 0 11-6 0 3 3 0 616 0z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">
                            Vision
                        </h3>
                        <p class="text-gray-600">
                            To be the leading microfinance institution
                            empowering Afghanistan's agricultural communities
                            through innovative financial solutions and
                            sustainable development programs.
                        </p>
                    </div>

                    <!-- Mission -->
                    <div
                        class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-emerald-50 to-emerald-100 card-hover"
                    >
                        <div
                            class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6"
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
                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">
                            Mission
                        </h3>
                        <p class="text-gray-600">
                            We provide accessible microfinance services,
                            agricultural training, and technical support to help
                            farmers increase productivity, improve livelihoods,
                            and build resilient communities.
                        </p>
                    </div>

                    <!-- Values -->
                    <div
                        class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-blue-50 to-blue-100 card-hover"
                    >
                        <div
                            class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6"
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
                                />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">
                            Values
                        </h3>
                        <p class="text-gray-600">
                            Integrity, transparency, community focus, and
                            sustainable development guide our commitment to
                            serving Afghanistan's agricultural sector with
                            excellence and trust.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Business Pillars Slider Section (3 cards at a time: 123→234→345→451→512→123) -->
        <section class="section-padding bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-6">
                        Our Business Pillars
                    </h2>
                    <p
                        class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed"
                    >
                        Seven core pillars that drive our mission to transform
                        Afghanistan's agricultural landscape through
                        comprehensive support and innovative solutions.
                    </p>
                </div>

                <!-- Business Pillars Slider -->
                <div class="relative">
                    <!-- Navigation Buttons -->
                    <button
                        @click="previousPillarSlide"
                        class="hidden md:flex absolute left-2 lg:left-4 top-1/2 transform -translate-y-1/2 z-10 w-10 h-10 lg:w-12 lg:h-12 bg-white rounded-full shadow-lg items-center justify-center text-green-600 hover:text-green-700 hover:shadow-xl transition-all duration-300 border-2 border-green-100 hover:border-green-300"
                    >
                        <svg
                            class="w-5 h-5 lg:w-6 lg:h-6"
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
                        @click="nextPillarSlide"
                        class="hidden md:flex absolute right-2 lg:right-4 top-1/2 transform -translate-y-1/2 z-10 w-10 h-10 lg:w-12 lg:h-12 bg-white rounded-full shadow-lg items-center justify-center text-green-600 hover:text-green-700 hover:shadow-xl transition-all duration-300 border-2 border-green-100 hover:border-green-300"
                    >
                        <svg
                            class="w-5 h-5 lg:w-6 lg:h-6"
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

                    <!-- Slider Container -->
                    <div class="overflow-hidden">
                        <div
                            class="flex transition-transform duration-500 ease-in-out"
                            :style="{
                                transform: `translateX(-${
                                    currentPillarSlide * (100 / cardsPerView)
                                }%)`,
                            }"
                        >
                            <!-- Show cards in sequence: 1-2-3-4-5-1-2-3-4-5 for seamless loop -->
                            <div
                                v-for="(pillar, index) in [
                                    ...businessPillars,
                                    ...businessPillars,
                                ]"
                                :key="`${pillar.id}-${Math.floor(index / 5)}`"
                                class="flex-shrink-0 px-4"
                                :style="{ width: `${100 / cardsPerView}%` }"
                            >
                                <div
                                    class="h-full p-8 rounded-professional-lg border border-gray-200 card-hover flex flex-col bg-white shadow-professional"
                                >
                                    <!-- Icon -->
                                    <div
                                        :class="[
                                            'w-16 h-16 rounded-lg flex items-center justify-center mb-6 mx-auto',
                                            pillar.bgColor,
                                        ]"
                                    >
                                        <svg
                                            :class="[
                                                'w-8 h-8',
                                                pillar.textColor,
                                            ]"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                :d="pillar.icon"
                                            />
                                        </svg>
                                    </div>

                                    <!-- Title - Fixed Height -->
                                    <h3
                                        class="text-2xl font-bold text-gray-900 mb-3 text-center h-16 flex items-center justify-center"
                                    >
                                        {{ pillar.title }}
                                    </h3>

                                    <!-- Count -->
                                    <div
                                        :class="[
                                            'text-3xl font-bold mb-4 text-center h-12 flex items-center justify-center',
                                            pillar.countColor,
                                        ]"
                                    >
                                        <span
                                            v-if="pillarLoading"
                                            class="animate-pulse"
                                            >Loading...</span
                                        >
                                        <span v-else
                                            >{{
                                                pillarCounts[pillar.countKey]
                                            }}+ {{ pillar.countLabel }}</span
                                        >
                                    </div>

                                    <!-- Description - Fixed Height with Overflow -->
                                    <div
                                        class="text-gray-600 mb-6 flex-grow text-center flex items-start min-h-[120px]"
                                    >
                                        <p class="leading-relaxed">
                                            {{ pillar.description }}
                                        </p>
                                    </div>

                                    <!-- CTA Button - Always at Bottom -->
                                    <div class="mt-auto">
                                        <router-link
                                            :to="pillar.route"
                                            class="btn btn-primary w-full justify-center"
                                        >
                                            Learn More
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide Indicators -->
                    <div class="flex justify-center mt-8 space-x-3">
                        <button
                            v-for="index in 5"
                            :key="index"
                            @click="currentPillarSlide = index - 1"
                            :class="[
                                'w-3 h-3 rounded-full transition-all duration-300',
                                currentPillarSlide === index - 1
                                    ? 'bg-green-600 scale-110 shadow-lg'
                                    : 'bg-gray-300 hover:bg-gray-400 hover:scale-105',
                            ]"
                            :aria-label="`Go to slide ${index}`"
                        ></button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Who We Are Section -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center"
                >
                    <div>
                        <h2 class="heading-lg text-gray-900 mb-6">
                            Who We Are
                        </h2>
                        <p class="text-xl text-gray-600 mb-6 leading-relaxed">
                            Mount Agro Microfinance Institution is a leading
                            financial services provider dedicated to
                            transforming Afghanistan's agricultural sector
                            through innovative microfinance solutions and
                            comprehensive support programs.
                        </p>
                        <p class="text-gray-600 mb-8 leading-relaxed">
                            Since our establishment, we have been committed to
                            empowering farmers, agricultural entrepreneurs, and
                            rural communities by providing accessible financial
                            services, technical training, and market linkage
                            opportunities.
                        </p>
                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div class="text-center">
                                <div
                                    class="text-3xl font-bold text-green-600 mb-2"
                                >
                                    15,000+
                                </div>
                                <div class="text-gray-600">Farmers Served</div>
                            </div>
                            <div class="text-center">
                                <div
                                    class="text-3xl font-bold text-green-600 mb-2"
                                >
                                    34
                                </div>
                                <div class="text-gray-600">
                                    Provinces Covered
                                </div>
                            </div>
                        </div>
                        <router-link to="/about" class="btn btn-primary"
                            >Learn More About Us</router-link
                        >
                    </div>
                    <div class="relative">
                        <img
                            src="https://media.istockphoto.com/id/1154958041/photo/taking-care-of-the-crop-aerial-view-of-a-tractor-fertilizing-a-cultivated-agricultural-field.jpg?s=2048x2048&w=is&k=20&c=H0a7ngBV9Bu8Oq9SMWBnLxluAOVD7_-hBra_zrNRzcg="
                            alt="Afghan farmers working in field"
                            class="w-full h-full rounded-professional-lg shadow-professional object-cover"
                            onload="this.style.opacity=1"
                            style="
                                opacity: 0;
                                transition: opacity 0.3s ease-in-out;
                            "
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest News Section -->
        <section class="section-padding bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-6">
                        Latest News & Updates
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Stay informed about our latest programs, success
                        stories, and developments in Afghanistan's agricultural
                        sector.
                    </p>
                </div>

                <!-- Loading State -->
                <div
                    v-if="newsLoading"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div v-for="i in 3" :key="i" class="animate-pulse">
                        <div class="bg-gray-300 h-48 rounded-lg mb-4"></div>
                        <div class="h-4 bg-gray-300 rounded mb-2"></div>
                        <div class="h-4 bg-gray-300 rounded w-3/4 mb-2"></div>
                        <div class="h-3 bg-gray-300 rounded w-1/2"></div>
                    </div>
                </div>

                <!-- News Articles -->
                <div
                    v-else
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <article
                        v-for="article in latestNews"
                        :key="article.id"
                        class="bg-white rounded-professional-lg overflow-hidden shadow-professional card-hover h-full flex flex-col"
                    >
                        <div class="flex-shrink-0">
                            <img
                                :src="
                                    article.featured_image ||
                                    'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=400&h=200&fit=crop&crop=center&auto=format'
                                "
                                :alt="article.title"
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
                                {{ formatDate(article.published_at) }}
                            </div>
                            <h3
                                class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2 h-14 flex items-start"
                            >
                                {{ article.title }}
                            </h3>
                            <div class="flex-grow mb-4">
                                <p
                                    class="text-gray-600 line-clamp-3 leading-relaxed"
                                >
                                    {{
                                        article.excerpt ||
                                        article.content?.substring(0, 150) +
                                            "..."
                                    }}
                                </p>
                            </div>
                            <div class="mt-auto">
                                <router-link
                                    :to="`/news/${article.slug}`"
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

                <div class="text-center mt-12">
                    <router-link to="/news" class="btn btn-primary"
                        >View All News</router-link
                    >
                </div>
            </div>
        </section>

        <!-- Photo Gallery Section -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-6">
                        Our Impact in Pictures
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Witness the transformation of Afghanistan's agricultural
                        communities through our comprehensive programs and
                        initiatives.
                    </p>
                </div>

                <!-- Loading State -->
                <div
                    v-if="galleryLoading"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div v-for="i in 6" :key="i" class="animate-pulse">
                        <div class="bg-gray-300 h-64 rounded-lg mb-4"></div>
                        <div class="bg-white p-4 rounded-b-lg">
                            <div class="h-4 bg-gray-300 rounded mb-2"></div>
                            <div class="h-3 bg-gray-300 rounded w-2/3"></div>
                        </div>
                    </div>
                </div>

                <!-- Gallery Images -->
                <div
                    v-else
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <router-link
                        v-for="(image, index) in galleryImages"
                        :key="index"
                        :to="`/gallery/${image.gallery_slug || 'gallery'}`"
                        class="relative group cursor-pointer"
                    >
                        <img
                            :src="resolveImageSrc(image.thumbnail || image.url)"
                            @error="
                                $event.target.src =
                                    'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=400&h=300&fit=crop&crop=center&auto=format'
                            "
                            :alt="image.title"
                            class="w-full h-48 object-cover rounded-lg transition-transform duration-300 group-hover:scale-105"
                        />
                    </router-link>
                </div>

                <div class="text-center mt-12">
                    <router-link to="/gallery" class="btn btn-primary"
                        >View Full Gallery</router-link
                    >
                </div>
            </div>
        </section>

        <!-- Stakeholders Section -->
        <section class="section-padding bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-6">
                        Our Partners & Stakeholders
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Working together with government institutions, NGOs, and
                        private sector partners to maximize our impact.
                    </p>
                </div>

                <div
                    class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center"
                >
                    <div
                        class="flex items-center justify-center p-6 bg-white rounded-lg shadow-soft"
                    >
                        <div
                            class="text-lg font-bold text-gray-700 text-center"
                        >
                            <div class="mb-1">Ministry of Agriculture</div>
                            <div class="text-xs text-gray-500">
                                Government Partner
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center p-6 bg-white rounded-lg shadow-soft"
                    >
                        <div
                            class="text-lg font-bold text-gray-700 text-center"
                        >
                            <div class="mb-1">UNDP</div>
                            <div class="text-xs text-gray-500">
                                Development Partner
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center p-6 bg-white rounded-lg shadow-soft"
                    >
                        <div
                            class="text-lg font-bold text-gray-700 text-center"
                        >
                            <div class="mb-1">Local Banks</div>
                            <div class="text-xs text-gray-500">
                                Financial Partners
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center p-6 bg-white rounded-lg shadow-soft"
                    >
                        <div
                            class="text-lg font-bold text-gray-700 text-center"
                        >
                            <div class="mb-1">Farmer Associations</div>
                            <div class="text-xs text-gray-500">
                                Community Partners
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center p-6 bg-white rounded-lg shadow-soft"
                    >
                        <div
                            class="text-lg font-bold text-gray-700 text-center"
                        >
                            <div class="mb-1">Tech Companies</div>
                            <div class="text-xs text-gray-500">
                                Innovation Partners
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center p-6 bg-white rounded-lg shadow-soft"
                    >
                        <div
                            class="text-lg font-bold text-gray-700 text-center"
                        >
                            <div class="mb-1">Research Institutes</div>
                            <div class="text-xs text-gray-500">
                                Academic Partners
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Funding Partners Section -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-6">
                        Our Funding Partners & Donors
                    </h2>
                    <p
                        class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed"
                    >
                        We are grateful to our international donors and funding
                        partners who support Afghanistan's agricultural
                        development through microfinance and capacity building
                        programs.
                    </p>
                </div>

                <!-- Major Donors Row -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12"
                >
                    <div
                        class="bg-white p-8 rounded-professional-lg shadow-soft text-center card-hover"
                    >
                        <div
                            class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4"
                        >
                            <svg
                                class="w-10 h-10 text-white"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            World Bank Group
                        </h3>
                        <p class="text-gray-600 text-sm">
                            International Development Association
                        </p>
                        <div class="mt-4 text-green-600 font-medium">
                            Major Grant Provider
                        </div>
                    </div>

                    <div
                        class="bg-white p-8 rounded-professional-lg shadow-soft text-center card-hover"
                    >
                        <div
                            class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4"
                        >
                            <svg
                                class="w-10 h-10 text-white"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            USAID
                        </h3>
                        <p class="text-gray-600 text-sm">
                            United States Agency for International Development
                        </p>
                        <div class="mt-4 text-green-600 font-medium">
                            Technical Assistance
                        </div>
                    </div>

                    <div
                        class="bg-white p-8 rounded-professional-lg shadow-soft text-center card-hover"
                    >
                        <div
                            class="w-20 h-20 bg-orange-600 rounded-full flex items-center justify-center mx-auto mb-4"
                        >
                            <svg
                                class="w-10 h-10 text-white"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            FAO
                        </h3>
                        <p class="text-gray-600 text-sm">
                            Food and Agriculture Organization
                        </p>
                        <div class="mt-4 text-green-600 font-medium">
                            Program Support
                        </div>
                    </div>
                </div>

                <!-- Supporting Partners Row -->
                <div
                    class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6"
                >
                    <div
                        class="bg-white p-6 rounded-lg shadow-soft text-center"
                    >
                        <div class="text-lg font-bold text-gray-700 mb-1">
                            EU
                        </div>
                        <div class="text-xs text-gray-500">European Union</div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-soft text-center"
                    >
                        <div class="text-lg font-bold text-gray-700 mb-1">
                            GIZ
                        </div>
                        <div class="text-xs text-gray-500">
                            German Development
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-soft text-center"
                    >
                        <div class="text-lg font-bold text-gray-700 mb-1">
                            JICA
                        </div>
                        <div class="text-xs text-gray-500">
                            Japan International
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-soft text-center"
                    >
                        <div class="text-lg font-bold text-gray-700 mb-1">
                            DFID
                        </div>
                        <div class="text-xs text-gray-500">UK Development</div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-soft text-center"
                    >
                        <div class="text-lg font-bold text-gray-700 mb-1">
                            CIDA
                        </div>
                        <div class="text-xs text-gray-500">Canadian Aid</div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-soft text-center"
                    >
                        <div class="text-lg font-bold text-gray-700 mb-1">
                            ADB
                        </div>
                        <div class="text-xs text-gray-500">
                            Asian Development
                        </div>
                    </div>
                </div>

                <!-- Partnership Impact -->
                <div class="mt-12 text-center">
                    <div
                        class="bg-green-50 border border-green-200 rounded-professional-lg p-8 max-w-4xl mx-auto"
                    >
                        <div class="flex items-center justify-center mb-4">
                            <svg
                                class="w-8 h-8 text-green-600 mr-3"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 616 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                            <h3 class="text-xl font-bold text-green-800">
                                Partnership Impact
                            </h3>
                        </div>
                        <p class="text-green-700 leading-relaxed">
                            Through strategic partnerships with international
                            donors, we have successfully reached over
                            <strong>15,000+ farmers</strong> and implemented
                            <strong>120+ agricultural projects</strong>
                            across Afghanistan, contributing to food security
                            and rural economic development.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Closing CTA Section -->
        <section
            class="section-padding bg-gradient-to-r from-green-600 to-emerald-600 text-white"
        >
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="heading-lg mb-6">
                    Ready to Transform Agricultural Communities?
                </h2>
                <p class="text-xl text-green-100 mb-8">
                    Join us in our mission to empower farmers and strengthen
                    Afghanistan's agricultural sector through innovative
                    microfinance solutions.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <router-link
                        to="/contact"
                        class="btn btn-cta text-lg px-8 py-4"
                    >
                        Get Started
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
                        class="btn border-2 border-white text-white hover:bg-white hover:text-green-600 text-lg px-8 py-4"
                    >
                        Learn More About Us
                    </router-link>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import axios from "axios";

// Hero slider state
const currentSlide = ref(0);

// Business pillars slider state (3 cards at a time: 123→234→345→451→512→123)
const currentPillarSlide = ref(0);

// Hero slider data - 5 images
const heroSlides = ref([
    {
        image: "/images/home/hero1.avif",
        title: "Empowering Agricultural Communities",
        description:
            "Building sustainable futures through innovative agricultural programs, training, and community development initiatives across Afghanistan.",
    },
    {
        image: "/images/home/hero2.avif",
        title: "Comprehensive Training Programs",
        description:
            "Providing farmers and agricultural professionals with cutting-edge knowledge, skills, and techniques for modern sustainable farming.",
    },
    {
        image: "/images/home/hero3.avif",
        title: "Agricultural Technology Solutions",
        description:
            "Integrating modern technology with traditional farming practices to boost productivity and ensure food security.",
    },
    {
        image: "/images/home/hero4.avif",
        title: "Community Development",
        description:
            "Strengthening rural communities through inclusive programs that promote social development and economic empowerment.",
    },
    {
        image: "/images/home/hero5.avif",
        title: "Environmental Conservation",
        description:
            "Promoting sustainable agricultural practices that protect our environment while ensuring productive and profitable farming.",
    },
]);

// Business pillars data
const businessPillars = ref([
    {
        id: "training",
        title: "Training Programs",
        icon: "M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253",
        bgColor: "bg-green-100",
        textColor: "text-green-600",
        countColor: "text-green-600",
        description:
            "Comprehensive agricultural education and capacity building programs for farmers, cooperatives, and agricultural professionals.",
        route: "/training-programs",
        countKey: "trainingPrograms",
        countLabel: "Programs",
    },
    {
        id: "agritech",
        title: "Agri-Tech Tools",
        icon: "M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z",
        bgColor: "bg-emerald-100",
        textColor: "text-emerald-600",
        countColor: "text-emerald-600",
        description:
            "Modern agricultural technologies and digital solutions to enhance farming productivity and efficiency.",
        route: "/agri-tech",
        countKey: "agriTechTools",
        countLabel: "Tools",
    },
    {
        id: "smartfarming",
        title: "Smart & Sustainable Farming",
        icon: "M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z",
        bgColor: "bg-teal-100",
        textColor: "text-teal-600",
        countColor: "text-teal-600",
        description:
            "Promote modern techniques like drip irrigation, greenhouse farming, and precision agriculture with climate-resilient crops.",
        route: "/smart-farming",
        countKey: "smartFarming",
        countLabel: "Programs",
    },
    {
        id: "seedSupply",
        title: "Seed & Input Supply Chain",
        icon: "M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8-4",
        bgColor: "bg-orange-100",
        textColor: "text-orange-600",
        countColor: "text-orange-600",
        description:
            "Provide high-quality seeds, fertilizers, and eco-friendly pesticides with reliable distribution networks across provinces.",
        route: "/seed-supply",
        countKey: "seedSupply",
        countLabel: "Products",
    },
    {
        id: "market",
        title: "Market Access Programs",
        icon: "M13 7h8m0 0v8m0-8l-8 8-4-4-6 6",
        bgColor: "bg-yellow-100",
        textColor: "text-yellow-600",
        countColor: "text-yellow-600",
        description:
            "Connecting farmers and agricultural producers to profitable markets and value chains for sustainable income growth.",
        route: "/market-access",
        countKey: "marketAccess",
        countLabel: "Programs",
    },
    {
        id: "environmental",
        title: "Environmental Projects",
        icon: "M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z",
        bgColor: "bg-blue-100",
        textColor: "text-blue-600",
        countColor: "text-blue-600",
        description:
            "Sustainable environmental initiatives promoting conservation, climate resilience, and eco-friendly agricultural practices.",
        route: "/environmental-projects",
        countKey: "environmental",
        countLabel: "Projects",
    },
    {
        id: "community",
        title: "Community Programs",
        icon: "M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 616 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z",
        bgColor: "bg-purple-100",
        textColor: "text-purple-600",
        countColor: "text-purple-600",
        description:
            "Comprehensive community development initiatives focusing on rural empowerment, social inclusion, and livelihood improvement.",
        route: "/community-programs",
        countKey: "community",
        countLabel: "Programs",
    },
]);

// Template refs for animated counters (beneficiaries_stats)
const totalBeneficiariesRef = ref(null);
const maleBeneficiariesRef = ref(null);
const femaleBeneficiariesRef = ref(null);
const programsCompletedRef = ref(null);
const provincesReachedRef = ref(null);
const cooperativesFormedRef = ref(null);

// Statistics data aligned to beneficiaries_stats
const stats = ref({
    total_beneficiaries: 0,
    male_beneficiaries: 0,
    female_beneficiaries: 0,
    programs_completed: 0,
    provinces_reached: 0,
    cooperatives_formed: 0,
});

// News data
const latestNews = ref([]);
const newsLoading = ref(true);

// Gallery data
const galleryImages = ref([]);
const galleryLoading = ref(true);

// Business pillar counts
const pillarCounts = ref({
    trainingPrograms: 0,
    agriTechTools: 0,
    smartFarming: 0,
    seedSupply: 0,
    marketAccess: 0,
    environmental: 0,
    community: 0,
});
const pillarLoading = ref(true);

// Auto-slide timers
let slideInterval = null;
let pillarSlideInterval = null;

// Responsive cards per view for pillars
const cardsPerView = ref(3);
const updateCardsPerView = () => {
    if (window.innerWidth < 768) {
        cardsPerView.value = 1;
    } else if (window.innerWidth < 1024) {
        cardsPerView.value = 2;
    } else {
        cardsPerView.value = 3;
    }
};

// Counter animation function
const animateCounter = (element, targetValue, duration = 2000) => {
    if (!element) return;

    let startValue = 0;
    const increment = targetValue / (duration / 16); // 60fps

    const timer = setInterval(() => {
        startValue += increment;
        if (startValue >= targetValue) {
            element.textContent = targetValue.toLocaleString();
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(startValue).toLocaleString();
        }
    }, 16);
};

// Auto-slide functionality for hero
const startAutoSlide = () => {
    slideInterval = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % heroSlides.value.length;
    }, 6000); // Change slide every 6 seconds
};

const stopAutoSlide = () => {
    if (slideInterval) {
        clearInterval(slideInterval);
        slideInterval = null;
    }
};

// Business pillars slider functions (3 cards at a time: 123→234→345→451→512→123)
const nextPillarSlide = () => {
    currentPillarSlide.value++;

    // When we reach the end of first set, reset to beginning for seamless loop
    if (currentPillarSlide.value >= 5) {
        setTimeout(() => {
            // Remove transition temporarily
            const slider = document.querySelector(".flex.transition-transform");
            if (slider) {
                slider.style.transition = "none";
                currentPillarSlide.value = 0;

                // Re-enable transition after a brief moment
                setTimeout(() => {
                    slider.style.transition = "transform 500ms ease-in-out";
                }, 50);
            }
        }, 500); // Wait for current transition to complete
    }
};

const previousPillarSlide = () => {
    if (currentPillarSlide.value === 0) {
        // Jump to the end position without animation
        const slider = document.querySelector(".flex.transition-transform");
        if (slider) {
            slider.style.transition = "none";
            currentPillarSlide.value = 4;

            // Re-enable transition and move to previous
            setTimeout(() => {
                slider.style.transition = "transform 500ms ease-in-out";
                currentPillarSlide.value--;
            }, 50);
        }
    } else {
        currentPillarSlide.value--;
    }
};

// Auto-rotate pillar slider
const startPillarAutoSlide = () => {
    pillarSlideInterval = setInterval(() => {
        nextPillarSlide();
    }, 4000); // Change slide every 8 seconds (slower than hero)
};

const stopPillarAutoSlide = () => {
    if (pillarSlideInterval) {
        clearInterval(pillarSlideInterval);
        pillarSlideInterval = null;
    }
};

// Fetch statistics from API (handles summary + historical shapes)
const fetchStatistics = async () => {
    try {
        const response = await axios.get("/api/stats", { timeout: 5000 });
        const payload = response.data?.data ?? response.data ?? {};

        const summary = payload.summary ?? {};
        const historical = payload.historical ?? {};

        const sumFromHist = (type) => {
            try {
                return Object.values(historical)
                    .flat()
                    .filter((x) => x.stat_type === type)
                    .reduce((acc, x) => acc + (Number(x.value) || 0), 0);
            } catch (_) {
                return 0;
            }
        };

        stats.value = {
            total_beneficiaries:
                Number(summary.total_beneficiaries) ||
                sumFromHist("total_beneficiaries") ||
                0,
            male_beneficiaries: sumFromHist("male_beneficiaries") || 0,
            female_beneficiaries: sumFromHist("female_beneficiaries") || 0,
            programs_completed: sumFromHist("programs_completed") || 0,
            provinces_reached: sumFromHist("provinces_reached") || 0,
            cooperatives_formed: sumFromHist("cooperatives_formed") || 0,
        };
    } catch (error) {
        console.log("Using fallback beneficiaries_stats data");
        stats.value = {
            total_beneficiaries: 2500,
            male_beneficiaries: 1400,
            female_beneficiaries: 1100,
            programs_completed: 45,
            provinces_reached: 12,
            cooperatives_formed: 25,
        };
    }
};

// Fetch latest news
const fetchLatestNews = async () => {
    try {
        newsLoading.value = true;
        const response = await axios.get("/api/news", {
            params: {
                limit: 3,
                sort: "published_at",
                order: "desc",
                status: "published",
            },
            timeout: 5000,
        });

        const raw =
            response.data && response.data.data
                ? response.data.data
                : Array.isArray(response.data)
                ? response.data
                : [];

        // Client-side safeguard: sort newest-first by published_at/created_at
        const sorted = raw.sort((a, b) => {
            const da = new Date(a.published_at || a.created_at || 0);
            const db = new Date(b.published_at || b.created_at || 0);
            return db - da;
        });

        latestNews.value = sorted.slice(0, 3);
    } catch (error) {
        console.error("NEWS API ERROR:", error);
        // Fallback news data
        latestNews.value = [
            {
                id: 1,
                title: "New Training Program Launched in Herat Province",
                excerpt:
                    "Mount Agro launches comprehensive agricultural training program reaching 500 farmers in Herat, focusing on modern irrigation techniques and crop diversification.",
                featured_image:
                    "https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=400&h=250&fit=crop&crop=center&auto=format",
                published_at: new Date().toISOString(),
                slug: "new-training-program-launch",
            },
            {
                id: 2,
                title: "AgriTech Mobile App Reaches 10,000 Users",
                excerpt:
                    "Our innovative mobile application providing weather forecasts, market prices, and agricultural advice has successfully reached 10,000 active users across Afghanistan.",
                featured_image:
                    "https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=250&fit=crop&crop=center&auto=format",
                published_at: new Date(
                    Date.now() - 7 * 24 * 60 * 60 * 1000
                ).toISOString(),
                slug: "agritech-app-milestone",
            },
            {
                id: 3,
                title: "Women's Cooperative Program Shows Remarkable Success",
                excerpt:
                    "Our women's agricultural cooperative program has empowered over 200 women farmers, increasing their income by an average of 40% through collective farming and marketing initiatives.",
                featured_image:
                    "https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=250&fit=crop&crop=center&auto=format",
                published_at: new Date(
                    Date.now() - 14 * 24 * 60 * 60 * 1000
                ).toISOString(),
                slug: "womens-cooperative-success",
            },
        ];
    } finally {
        newsLoading.value = false;
    }
};

// Fetch gallery images
const fetchGalleryImages = async () => {
    try {
        galleryLoading.value = true;
        const response = await axios.get("/api/galleries", {
            params: { orderBy: "created_at", direction: "desc" },
            timeout: 5000,
        });

        if (response.data && response.data.data) {
            const galleries = response.data.data;
            const images = [];

            // Ensure galleries newest-first as a safeguard
            const sortedGalleries = [...galleries].sort((a, b) => {
                const da = new Date(a.created_at || 0);
                const db = new Date(b.created_at || 0);
                return db - da;
            });

            sortedGalleries.forEach((gallery) => {
                if (gallery.images && gallery.images.length > 0) {
                    // Sort images newest-first too, then pick top 2
                    const imgs = [...gallery.images].sort((a, b) => {
                        const da = new Date(a.created_at || 0);
                        const db = new Date(b.created_at || 0);
                        return db - da;
                    });
                    imgs.slice(0, 2).forEach((image) => {
                        images.push({
                            id: image.id,
                            title: image.title || gallery.title,
                            category: gallery.title,
                            gallery_slug: gallery.slug,
                            url: resolveImageSrc(
                                image.image_path || image.url || image.path
                            ),
                            thumbnail: resolveImageSrc(
                                image.image_path || image.url || image.path
                            ),
                        });
                    });
                }
            });

            galleryImages.value = images.slice(0, 6);
        }
    } catch (error) {
        console.error("GALLERY API ERROR:", error);
        // Fallback gallery images
        galleryImages.value = [
            {
                id: 1,
                title: "Training Program in Action",
                category: "Capacity Building",
                gallery_slug: "training-programs",
                url: "https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=800&h=600&fit=crop&crop=center&auto=format",
                thumbnail:
                    "https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=400&h=300&fit=crop&crop=center&auto=format",
            },
            {
                id: 2,
                title: "Modern Agricultural Techniques",
                category: "Agri-Tech",
                gallery_slug: "agri-tech-solutions",
                url: "https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&h=600&fit=crop&crop=center&auto=format",
                thumbnail:
                    "https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=300&fit=crop&crop=center&auto=format",
            },
            {
                id: 3,
                title: "Community Development Project",
                category: "Community Programs",
                gallery_slug: "community-programs",
                url: "https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&h=600&fit=crop&crop=center&auto=format",
                thumbnail:
                    "https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=300&fit=crop&crop=center&auto=format",
            },
            {
                id: 4,
                title: "Market Access Initiative",
                category: "Market Programs",
                gallery_slug: "market-access",
                url: "https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop&crop=center&auto=format",
                thumbnail:
                    "https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop&crop=center&auto=format",
            },
            {
                id: 5,
                title: "Environmental Conservation",
                category: "Environmental Projects",
                gallery_slug: "environmental-projects",
                url: "https://images.unsplash.com/photo-1593113598332-cd288d649433?w=800&h=600&fit=crop&crop=center&auto=format",
                thumbnail:
                    "https://images.unsplash.com/photo-1593113598332-cd288d649433?w=400&h=300&fit=crop&crop=center&auto=format",
            },
            {
                id: 6,
                title: "Livestock Development",
                category: "Animal Husbandry",
                gallery_slug: "livestock-programs",
                url: "https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=800&h=600&fit=crop&crop=center&auto=format",
                thumbnail:
                    "https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=400&h=300&fit=crop&crop=center&auto=format",
            },
        ];
    } finally {
        galleryLoading.value = false;
    }
};

// Fetch business pillar counts
const fetchPillarCounts = async () => {
    try {
        pillarLoading.value = true;

        const [
            training,
            agriTech,
            smartFarming,
            seedSupply,
            marketAccess,
            environmental,
            community,
        ] = await Promise.all([
            axios.get("/api/training-programs", {
                params: { count_only: true },
                timeout: 5000,
            }),
            axios.get("/api/agri-tech-tools", {
                params: { count_only: true },
                timeout: 5000,
            }),
            axios.get("/api/smart-farming-programs", {
                params: { count_only: true },
                timeout: 5000,
            }),
            axios.get("/api/seed-supply-programs", {
                params: { count_only: true },
                timeout: 5000,
            }),
            axios.get("/api/market-access-programs", {
                params: { count_only: true },
                timeout: 5000,
            }),
            axios.get("/api/environmental-projects", {
                params: { count_only: true },
                timeout: 5000,
            }),
            axios.get("/api/community-programs", {
                params: { count_only: true },
                timeout: 5000,
            }),
        ]);

        pillarCounts.value = {
            trainingPrograms:
                training.data.total || training.data.data?.length || 18,
            agriTechTools:
                agriTech.data.total || agriTech.data.data?.length || 8,
            smartFarming:
                smartFarming.data.total || smartFarming.data.data?.length || 6,
            seedSupply:
                seedSupply.data.total || seedSupply.data.data?.length || 6,
            marketAccess:
                marketAccess.data.total || marketAccess.data.data?.length || 3,
            environmental:
                environmental.data.total ||
                environmental.data.data?.length ||
                3,
            community: community.data.total || community.data.data?.length || 3,
        };
    } catch (error) {
        console.error("PILLAR COUNTS API ERROR:", error);
        // Fallback counts
        pillarCounts.value = {
            trainingPrograms: 18,
            agriTechTools: 8,
            smartFarming: 6,
            seedSupply: 6,
            marketAccess: 3,
            environmental: 3,
            community: 3,
        };
    } finally {
        pillarLoading.value = false;
    }
};

// Initialize statistics animation
const initializeStats = () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounter(
                        totalBeneficiariesRef.value,
                        stats.value.total_beneficiaries
                    );
                    animateCounter(
                        maleBeneficiariesRef.value,
                        stats.value.male_beneficiaries
                    );
                    animateCounter(
                        femaleBeneficiariesRef.value,
                        stats.value.female_beneficiaries
                    );
                    animateCounter(
                        programsCompletedRef.value,
                        stats.value.programs_completed
                    );
                    animateCounter(
                        provincesReachedRef.value,
                        stats.value.provinces_reached
                    );
                    animateCounter(
                        cooperativesFormedRef.value,
                        stats.value.cooperatives_formed
                    );

                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.5 }
    );

    if (totalBeneficiariesRef.value) {
        observer.observe(
            totalBeneficiariesRef.value.parentElement.parentElement
        );
    }
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

// Resolve image path helper
const resolveImageSrc = (path) => {
    if (!path) return "";
    const p = String(path).trim();
    if (p.startsWith("http://") || p.startsWith("https://")) return p;
    return `/storage/${p.replace(/^\/+/, "")}`;
};

// Gallery functions removed - now using router links

onMounted(async () => {
    console.log("🚀 HOME PAGE MOUNTED");

    // Initialize responsive pillars per view and listen to resize
    updateCardsPerView();
    window.addEventListener("resize", updateCardsPerView);

    // Start hero slider
    startAutoSlide();

    // Start pillar auto-slide
    startPillarAutoSlide();

    // Fetch all dynamic content
    console.log("📡 FETCHING DYNAMIC CONTENT FROM APIs...");
    await fetchStatistics();
    fetchLatestNews();
    fetchGalleryImages();
    fetchPillarCounts();

    // Initialize stats animation after data is loaded
    setTimeout(initializeStats, 100);
});

onUnmounted(() => {
    stopAutoSlide();
    stopPillarAutoSlide();
    window.removeEventListener("resize", updateCardsPerView);
});
</script>
