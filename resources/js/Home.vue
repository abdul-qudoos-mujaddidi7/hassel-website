<template>
    <div>
        <!-- Hero Section with 5 Images Slider -->
        <section
            class="relative h-[70vh] sm:h-[60vh] md:h-[87vh] max-h-screen overflow-hidden text-white"
        >
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
                        :class="[
                            'absolute inset-0 w-full h-full object-cover',
                            windowWidth < 768 ? '' : 'kenburns',
                        ]"
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

            <div class="relative flex items-center justify-center h-full z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <!-- Dynamic Hero Content -->
                    <div v-if="heroSlides[currentSlide]" class="mb-8">
                        <h1
                            class="heading-hero font-bold mb-6 animate-fadeInUp text-center"
                        >
                            {{ heroSlides[currentSlide].title }}
                        </h1>
                        <p
                            class="text-xl md:text-2xl text-gray-100 mb-8 max-w-4xl mx-auto animate-fadeInUp text-center"
                            style="animation-delay: 0.2s"
                        >
                            {{ heroSlides[currentSlide].description }}
                        </p>
                    </div>

                    <div
                        class="flex flex-col gap-2 justify-center items-center animate-fadeInUp sm:flex-row sm:gap-4 text-center"
                        style="animation-delay: 0.4s"
                    >
                        <router-link
                            to="/contact"
                            class="btn btn-cta inline-flex items-center justify-center text-xs px-3 py-2 md:text-lg md:px-8 md:py-4 rounded-md"
                        >
                            <template v-if="!isRTL">
                                {{ t("home.hero.contact") }}
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
                            </template>
                            <template v-else>
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
                                        d="M7 8l-4 4m0 0l4 4m-4-4h18"
                                    />
                                </svg>
                                {{ t("home.hero.contact") }}
                            </template>
                        </router-link>
                    </div>
                </div>
            </div>

            <!-- Slide Indicators -->
            <div
                class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-2 z-20"
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
    
        <!-- welcome section -->

        <!-- Welcome Section -->
<section class="section-padding bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="heading-lg text-green-600 mb-4">
                {{ t("home.welcome.title") }}
            </h2>
            <div class="mx-auto max-w-2xl">
                <p
                    class="text-lg sm:text-xl text-gray-600 leading-relaxed text-center rtl:text-right"
                >
                    {{ t("home.welcome.body") }}
                </p>
            </div>
        </div>
    </div>
</section>


        <!-- About Us Section -->
        <section class="section-padding bg-white about-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="heading-lg text-green-600 mb-16 text-center">
                {{ t("home.about.title") }}
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch">
            <!-- Image Column - First on small screens -->
            <div class="order-1 lg:order-2 flex items-center">
                <img
                    :src="'/images/about/who_we_are_1.avif'"
                    alt="Mount Agro agricultural operations"
                    class="w-full h-full max-h-[500px] object-cover rounded-professional-lg shadow-professional"
                    loading="lazy"
                />
            </div>

            <!-- Text Column - Second on small screens -->
            <div class="order-2 lg:order-1 flex flex-col justify-center h-full">
                <div class="h-full flex flex-col justify-center">
                    <p
                        class="text-xl text-gray-600 mb-6 text-left rtl:text-right leading-relaxed"
                    >
                        {{ t("home.about.p1") }}
                    </p>
                    <p
                        class="text-lg text-gray-600 text-left rtl:text-right leading-relaxed"
                    >
                        {{ t("home.about.p2") }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

        <!-- Key Statistics Section -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8"
                >
                    <!-- Beneficiaries -->
                    <div
                        class="p-6 bg-white rounded-professional-lg shadow-soft text-center"
                    >
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
                            class="text-2xl md:text-3xl font-bold text-green-600 mb-1 md:mb-2 text-center"
                            ref="totalBeneficiariesRef"
                        >
                            0
                        </div>
                        <div class="text-gray-600 font-medium text-center">
                            {{ t("home.stats.beneficiaries") }}
                        </div>
                    </div>

                    <!-- Programs Completed -->
                    <div
                        class="p-6 bg-white rounded-professional-lg shadow-soft text-center"
                    >
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
                                    d="M9 12l2 2 4-4M7 7h10v10H7z"
                                />
                            </svg>
                        </div>
                        <div
                            class="text-2xl md:text-3xl font-bold text-green-600 mb-1 md:mb-2 text-center"
                            ref="programsCompletedRef"
                        >
                            0
                        </div>
                        <div class="text-gray-600 font-medium text-center">
                            {{ t("home.stats.programs_completed") }}
                        </div>
                    </div>

                    <!-- Provinces Reached -->
                    <div
                        class="p-6 bg-white rounded-professional-lg shadow-soft text-center"
                    >
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
                                    d="M12 2a10 10 0 100 20 10 10 0 000-20zm2 11l-2 2-2-2 2-2 2 2z"
                                />
                            </svg>
                        </div>
                        <div
                            class="text-2xl md:text-3xl font-bold text-green-600 mb-1 md:mb-2 text-center"
                            ref="provincesReachedRef"
                        >
                            0
                        </div>
                        <div class="text-gray-600 font-medium text-center">
                            {{ t("home.stats.provinces_reached") }}
                        </div>
                    </div>

                    <!-- Cooperatives Formed -->
                    <div
                        class="p-6 bg-white rounded-professional-lg shadow-soft text-center"
                    >
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
                                    d="M7 8h10M7 12h8m-8 4h6"
                                />
                            </svg>
                        </div>
                        <div
                            class="text-2xl md:text-3xl font-bold text-green-600 mb-1 md:mb-2 text-center"
                            ref="cooperativesFormedRef"
                        >
                            0
                        </div>
                        <div class="text-gray-600 font-medium text-center">
                            {{ t("home.stats.cooperatives_formed") }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision / Mission / Values Section -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10 md:mb-12">
                    <h2 class="heading-lg text-green-600 mb-4 text-center">
                        {{ t("home.foundation.title") }}
                    </h2>
                    <p
                        class="text-xl text-gray-600 max-w-3xl mx-auto text-center"
                    >
                        {{ t("home.foundation.subtitle") }}
                    </p>
                </div>

                <!-- Three Cards Side by Side -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                    <!-- Vision Card -->
                    <div
                        class="bg-white rounded-professional-lg border border-gray-200 shadow-professional p-6 lg:p-8 text-center card-hover"
                    >
                        <div
                            class="w-16 h-16 rounded-full bg-brand-primary flex items-center justify-center mb-6 mx-auto"
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
                        <h3
                            class="text-2xl font-bold text-gray-900 mb-4 text-center"
                        >
                            {{ t("home.foundation.vision.title") }}
                        </h3>
                        <p
                            class="text-gray-700 leading-relaxed text-left rtl:text-right"
                        >
                            {{ t("home.foundation.vision.body") }}
                        </p>
                    </div>

                    <!-- Mission Card -->
                    <div
                        class="bg-white rounded-professional-lg border border-gray-200 shadow-professional p-6 lg:p-8 text-center card-hover"
                    >
                        <div
                            class="w-16 h-16 rounded-full bg-brand-primary flex items-center justify-center mb-6 mx-auto"
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
                        <h3
                            class="text-2xl font-bold text-gray-900 mb-4 text-center"
                        >
                            {{ t("home.foundation.mission.title") }}
                        </h3>
                        <p
                            class="text-gray-700 leading-relaxed text-left rtl:text-right"
                        >
                            {{ t("home.foundation.mission.body") }}
                        </p>
                    </div>

                    <!-- Values Card -->
                    <div
                        class="bg-white rounded-professional-lg border border-gray-200 shadow-professional p-6 lg:p-8 text-center card-hover"
                    >
                        <div
                            class="w-16 h-16 rounded-full bg-brand-primary flex items-center justify-center mb-6 mx-auto"
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
                        <h3
                            class="text-2xl font-bold text-gray-900 mb-4 text-center"
                        >
                            {{ t("home.foundation.values.title") }}
                        </h3>
                        <p
                            class="text-gray-700 leading-relaxed text-left rtl:text-right"
                        >
                             <ul>
                                <li v-for="(item, index) in t('home.foundation.values.body')" :key="index">
                                    {{ index + 1 }}. {{ item }}
                                </li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Business Pillars Slider Section -->
        <section ref="pillarsSectionRef" class="section-padding bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-green-600 mb-6 text-center">
                        {{ t("home.pillars.title") }}
                    </h2>
                    <p
                        class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed text-center"
                    >
                        {{ t("home.pillars.subtitle") }}
                    </p>
                </div>

                <!-- Business Pillars Slider -->
                <div class="relative">
                    <!-- Navigation Buttons -->
                    <button
                        @click="previousPillarSlide"
                        class="hidden md:flex absolute left-0 cursor-pointer top-1/2 transform -translate-y-1/2 z-10 w-10 h-10 lg:w-12 lg:h-12 bg-white rounded-full shadow-lg items-center justify-center text-green-600 hover:text-green-700 hover:shadow-xl transition-all duration-300 border-2 border-green-100 hover:border-green-300"
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
                        class="hidden md:flex cursor-pointer absolute right-0 top-1/2 transform -translate-y-1/2 z-10 w-10 h-10 lg:w-12 lg:h-12 bg-white rounded-full shadow-lg items-center justify-center text-green-600 hover:text-green-700 hover:shadow-xl transition-all duration-300 border-2 border-green-100 hover:border-green-300"
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
                                transform: isRTL
                                    ? `translateX(${
                                          currentPillarSlide *
                                          (100 / cardsPerView)
                                      }%)`
                                    : `translateX(-${
                                          currentPillarSlide *
                                          (100 / cardsPerView)
                                      }%)`,
                            }"
                        >
                            <!-- Show cards in sequence: 1-2-3-4-5-6-7-1-2-3-4-5-6-7 for seamless loop -->
                            <div
                                v-for="(pillar, index) in [
                                    ...businessPillars,
                                    ...businessPillars,
                                ]"
                                :key="`${pillar.id}-${Math.floor(
                                    index / businessPillars.length
                                )}`"
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
                                            'text-2xl font-bold mb-4 text-center h-12 flex items-center justify-center',
                                            pillar.countColor,
                                        ]"
                                    >
                                        <span
                                            v-if="pillarLoading"
                                            class="animate-pulse"
                                            >{{ t("common.loading") }}</span
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
                                        <p
                                            class="leading-relaxed text-left rtl:text-right"
                                        >
                                            {{ pillar.description }}
                                        </p>
                                    </div>

                                    <!-- CTA Button - Always at Bottom -->
                                    <div class="mt-auto">
                                        <router-link
                                            :to="pillar.route"
                                            class="btn btn-primary w-full justify-center inline-flex items-center"
                                        >
                                            <template v-if="!isRTL">
                                                {{ t("common.view_details") }}
                                                <svg
                                                    class="w-4 h-4 ml-2"
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
                                            </template>
                                            <template v-else>
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
                                                {{ t("common.view_details") }}
                                            </template>
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide Indicators -->
                    <div class="flex justify-center mt-8 gap-2">
                        <button
                            v-for="index in totalSlides"
                            :key="index"
                            @click="goToPillarSlide(index - 1)"
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

        <!-- Latest News Section -->
        <section class="section-padding bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-green-600 mb-6 text-center">
                        {{ t("home.news.title") }}
                    </h2>
                    <p
                        class="text-xl text-gray-600 max-w-3xl mx-auto text-center"
                    >
                        {{ t("home.news.subtitle") }}
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
                    v-if="!newsLoading && (!latestNews || latestNews.length === 0)"
                    class="text-center py-12"
                    role="status"
                    aria-live="polite"
                >
                    <svg
                        class="mx-auto mb-4 w-12 h-12 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    <p class="text-gray-600 text-lg">
                        {{ t("No news available yet.") }}
                    </p>

                </div>
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
                                class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2 h-14 flex items-start text-left rtl:text-right"
                            >
                                {{ article.title }}
                            </h3>
                            <div class="flex-grow mb-4">
                                <p
                                    class="text-gray-600 line-clamp-3 leading-relaxed text-left rtl:text-right"
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
                                    :to="`/news/${article.slug || article.id}`"
                                    class="inline-flex items-center text-green-600 hover:text-green-700 font-medium"
                                >
                                    <template v-if="!isRTL">
                                        {{ t("home.news.read_more") }}
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
                                    </template>
                                    <template v-else>
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
                                                d="M15 19l-7-7 7-7"
                                            />
                                        </svg>
                                        {{ t("home.news.read_more") }}
                                    </template>
                                </router-link>
                            </div>
                        </div>
                    </article>
                    
               
                </div>
                <div v-if="!newsLoading && (latestNews.length > 0)"
                 class="text-center mt-12 " >
                    <router-link to="/resources" class="btn btn-primary">{{
                        t("home.news.view_all")
                    }}</router-link>
                </div>
                

            </div>
        </section>

        <!-- Stakeholders Section -->
        <!-- <section class="section-padding bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-green-600 mb-6 text-center">
                        {{ t("home.partners.title") }}
                    </h2>
                    <p
                        class="text-xl text-gray-600 max-w-3xl mx-auto text-center"
                    >
                        {{ t("home.partners.subtitle") }}
                    </p>
                </div>

                Icon badges for partners -->
        <!-- <div
                    class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-6 md:gap-8 items-center"
                >
                    <div class="flex items-center justify-center">
                        <div
                            class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white shadow-soft flex items-center justify-center text-gray-700 font-semibold text-center"
                            aria-label="Ministry of Agriculture"
                        >
                            MoA
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <div
                            class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white shadow-soft flex items-center justify-center text-gray-700 font-semibold text-center"
                            aria-label="United Nations Development Programme"
                        >
                            UNDP
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <div
                            class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white shadow-soft flex items-center justify-center text-gray-700 font-semibold text-center"
                            aria-label="Local Banks"
                        >
                            Banks
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <div
                            class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white shadow-soft flex items-center justify-center text-gray-700 font-semibold text-center"
                            aria-label="Farmer Associations"
                        >
                            FA
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <div
                            class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white shadow-soft flex items-center justify-center text-gray-700 font-semibold text-center"
                            aria-label="Tech Companies"
                        >
                            Tech
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <div
                            class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white shadow-soft flex items-center justify-center text-gray-700 font-semibold text-center"
                            aria-label="Research Institutes"
                        >
                            RI
                        </div>
                    </div>
                </div>
            </div> 
        </section> -->

        <!-- Leadership Team -->
        <!-- <section class="pt-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h2 class="heading-lg text-green-600 mb-4 text-center">
                        {{ t("home.leadership.title") }}
                    </h2>
                    <p
                        class="text-xl text-gray-600 max-w-3xl mx-auto text-center"
                    >
                        {{ t("home.leadership.subtitle") }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div
                        class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-green-50 to-green-100 card-hover"
                    >
                        <img
                            :src="'/images/about/CEO.avif'"
                            alt="CEO"
                            class="w-28 h-28 mx-auto mb-5 rounded-full bg-brand-primary"
                        />
                        <h3
                            class="text-lg font-semibold mb-1 text-brand-primary text-center"
                        >
                            {{ t("home.leadership.ceo_title") }}
                        </h3>
                        <p class="text-brand-secondary text-sm text-center">
                            {{ t("home.leadership.ceo_desc") }}
                        </p>
                    </div>
                    <div
                        class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-green-50 to-green-100 card-hover"
                    >
                        <img
                            :src="'/images/about/Directorprograms.avif'"
                            alt="Director Programs"
                            class="w-28 h-28 mx-auto mb-5 rounded-full bg-brand-primary"
                        />
                        <h3
                            class="text-lg font-semibold mb-1 text-brand-primary text-center"
                        >
                            {{ t("home.leadership.programs_title") }}
                        </h3>
                        <p class="text-brand-secondary text-sm text-center">
                            {{ t("home.leadership.programs_desc") }}
                        </p>
                    </div>
                    <div
                        class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-green-50 to-green-100 card-hover"
                    >
                        <img
                            :src="'/images/about/directoreFinance.avif'"
                            alt="Director Finance"
                            class="w-28 h-28 mx-auto mb-5 rounded-full bg-brand-primary"
                        />
                        <h3
                            class="text-lg font-semibold mb-1 text-brand-primary text-center"
                        >
                            {{ t("home.leadership.finance_title") }}
                        </h3>
                        <p class="text-brand-secondary text-sm text-center">
                            {{ t("home.leadership.finance_desc") }}
                        </p>
                    </div>
                </div>
            </div>
        </section> -->

        <!-- Closing CTA Section -->
        <section class="section-padding text-white">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="heading-lg mb-6 text-green-600 text-center">
                    {{ t("home.cta.title") }}
                </h2>
                <div class="max-w-3xl mx-auto">
                    <p class="text-xl text-green-100 mb-8 text-center">
                        {{ t("home.cta.body") }}
                    </p>
                </div>
                <div class=" gap-4 justify-center">
                    <router-link
                        to="/contact"
                        class="btn btn-cta text-lg px-8 py-4 inline-flex items-center"
                    >
                        <template v-if="!isRTL">
                            {{ t("home.cta.get_started") }}
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
                        </template>
                        <template v-else>
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
                                    d="M7 8l-4 4m0 0l4 4m-4-4h18"
                                />
                            </svg>
                            {{ t("home.cta.get_started") }}
                        </template>
                    </router-link>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import axios from "axios";
import { useI18n } from "./composables/useI18n.js";

const { t, isRTL, currentLang, setLang } = useI18n();

function toggleLang() {
    setLang(currentLang.value === "en" ? "fa" : "en");
}

// Hero slider state
const currentSlide = ref(0);

// Business pillars slider state
const currentPillarSlide = ref(0);

// Window width for responsive behavior
const windowWidth = ref(
    typeof window !== "undefined" ? window.innerWidth : 768
);

// Update window width on resize
const updateWindowWidth = () => {
    windowWidth.value = window.innerWidth;
};

// Calculate total slides based on screen size
const totalSlides = computed(() => {
    // Safety check for businessPillars
    if (!businessPillars.value || businessPillars.value.length === 0) {
        return 1; // Default to 1 slide if no data
    }

    // Mobile: 1 card at a time, 7 slides
    // Desktop: 3 cards at a time, 5 slides (7-3+1=5)
    return windowWidth.value < 768
        ? businessPillars.value.length
        : businessPillars.value.length - 2;
});

// Foundation tabs state (Vision / Mission / Values)

// Hero slider data - 5 images
// Use one consistent hero headline/description across all slides (better UX)
const heroSlides = computed(() => [
    {
        image: "/images/home/hero1.avif",
        title: t("home.hero.title"),
        description: t("home.hero.subtitle"),
    },
    {
        image: "/images/home/hero2.avif",
        title: t("home.hero.title"),
        description: t("home.hero.subtitle"),
    },
    {
        image: "/images/home/hero3.avif",
        title: t("home.hero.title"),
        description: t("home.hero.subtitle"),
    },
    {
        image: "/images/home/hero4.avif",
        title: t("home.hero.title"),
        description: t("home.hero.subtitle"),
    },
    {
        image: "/images/home/hero5.avif",
        title: t("home.hero.title"),
        description: t("home.hero.subtitle"),
    },
]);

// Business pillars data
const businessPillars = computed(() => [
    {
        id: "training",
        title: t("home.pillars.training.title"),
        icon: "M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253",
        bgColor: "bg-green-100",
        textColor: "text-green-600",
        countColor: "text-green-600",
        description: t("home.pillars.training.description"),
        route: "/training-programs",
        countKey: "trainingPrograms",
        countLabel: t("home.pillars.training.countLabel"),
    },
    {
        id: "agritech",
        title: t("home.pillars.agritech.title"),
        icon: "M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z",
        bgColor: "bg-green-100",
        textColor: "text-green-600",
        countColor: "text-green-600",
        description: t("home.pillars.agritech.description"),
        route: "/agri-tech",
        countKey: "agriTechTools",
        countLabel: t("home.pillars.agritech.countLabel"),
    },
    {
        id: "smartfarming",
        title: t("home.pillars.smartfarming.title"),
        icon: "M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z",
        bgColor: "bg-green-100",
        textColor: "text-green-600",
        countColor: "text-green-600",
        description: t("home.pillars.smartfarming.description"),
        route: "/smart-farming",
        countKey: "smartFarming",
        countLabel: t("home.pillars.smartfarming.countLabel"),
    },
    {
        id: "seedSupply",
        title: t("home.pillars.seedSupply.title"),
        icon: "M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8-4",
        bgColor: "bg-green-100",
        textColor: "text-green-600",
        countColor: "text-green-600",
        description: t("home.pillars.seedSupply.description"),
        route: "/seed-supply",
        countKey: "seedSupply",
        countLabel: t("home.pillars.seedSupply.countLabel"),
    },
    {
        id: "market",
        title: t("home.pillars.market.title"),
        icon: "M13 7h8m0 0v8m0-8l-8 8-4-4-6 6",
        bgColor: "bg-green-100",
        textColor: "text-green-600",
        countColor: "text-green-600",
        description: t("home.pillars.market.description"),
        route: "/market-access",
        countKey: "marketAccess",
        countLabel: t("home.pillars.market.countLabel"),
    },
    {
        id: "environmental",
        title: t("home.pillars.environmental.title"),
        icon: "M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z",
        bgColor: "bg-green-100",
        textColor: "text-green-600",
        countColor: "text-green-600",
        description: t("home.pillars.environmental.description"),
        route: "/environmental-projects",
        countKey: "environmental",
        countLabel: t("home.pillars.environmental.countLabel"),
    },
    {
        id: "community",
        title: t("home.pillars.community.title"),
        icon: "M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 616 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z",
        bgColor: "bg-green-100",
        textColor: "text-green-600",
        countColor: "text-green-600",
        description: t("home.pillars.community.description"),
        route: "/community-programs",
        countKey: "community",
        countLabel: t("home.pillars.community.countLabel"),
    },
]);

// Template refs for animated counters (beneficiaries_stats)
const totalBeneficiariesRef = ref(null);
const maleBeneficiariesRef = ref(null);
const femaleBeneficiariesRef = ref(null);
const programsCompletedRef = ref(null);
const provincesReachedRef = ref(null);
const cooperativesFormedRef = ref(null);
// Ref for observing when the pillars section enters viewport
const pillarsSectionRef = ref(null);

// IntersectionObserver instance for pillars (will be initialized on mount)
let pillarsObserver = null;

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
const newsLoading = ref(false);

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
const pillarLoading = ref(false);

// Cache and loading flags to prevent duplicate API calls
const statsCache = ref(null);
const newsCache = ref({});
const pillarCountsCache = ref({});
const isFetchingStats = ref(false);
const isFetchingNews = ref(false);
const isFetchingPillars = ref(false);

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

// Business pillars slider functions with smooth infinite scroll
const nextPillarSlide = () => {
    if (totalSlides.value <= 0) return; // Safety check

    currentPillarSlide.value++;

    // When we reach the end, reset to beginning without animation
    if (currentPillarSlide.value >= totalSlides.value) {
        const slider = document.querySelector(".flex.transition-transform");
        if (slider) {
            slider.style.transition = "none";
            currentPillarSlide.value = 0;

            // Force a reflow
            slider.offsetHeight;

            // Re-enable transition for next movement
            slider.style.transition = "transform 500ms ease-in-out";
        }
    }
};

const previousPillarSlide = () => {
    if (totalSlides.value <= 0) return; // Safety check

    if (currentPillarSlide.value === 0) {
        // Jump to the end position without animation
        const slider = document.querySelector(".flex.transition-transform");
        if (slider) {
            slider.style.transition = "none";
            currentPillarSlide.value = totalSlides.value - 1;

            // Force a reflow
            slider.offsetHeight;

            // Re-enable transition
            slider.style.transition = "transform 500ms ease-in-out";
        }
    } else {
        currentPillarSlide.value--;
    }
};

// Go to specific slide
const goToPillarSlide = (index) => {
    if (totalSlides.value <= 0) return; // Safety check
    if (index < 0 || index >= totalSlides.value) return; // Bounds check
    currentPillarSlide.value = index;
};

// Auto-rotate pillar slider (idempotent: will not create duplicate intervals)
const startPillarAutoSlide = () => {
    if (pillarSlideInterval) return; // already running
    pillarSlideInterval = setInterval(() => {
        nextPillarSlide();
    }, 4000); // Change slide every 4 seconds
};

const stopPillarAutoSlide = () => {
    if (pillarSlideInterval) {
        clearInterval(pillarSlideInterval);
        pillarSlideInterval = null;
    }
};

// Fetch statistics from API (handles summary + historical shapes)
const fetchStatistics = async () => {
    // Return cached data if available (stats don't change with language)
    if (statsCache.value) {
        stats.value = statsCache.value;
        return;
    }

    // Prevent duplicate concurrent requests
    if (isFetchingStats.value) {
        return;
    }

    try {
        isFetchingStats.value = true;
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

        const statsData = {
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

        stats.value = statsData;
        statsCache.value = statsData; // Cache for future use
    } catch (error) {
        console.log("Using fallback beneficiaries_stats data");
        const fallbackStats = {
            total_beneficiaries: 2500,
            male_beneficiaries: 1400,
            female_beneficiaries: 1100,
            programs_completed: 45,
            provinces_reached: 12,
            cooperatives_formed: 25,
        };
        stats.value = fallbackStats;
        statsCache.value = fallbackStats; // Cache fallback too
    } finally {
        isFetchingStats.value = false;
    }
};

// Fetch latest news
const fetchLatestNews = async (forceRefresh = false) => {
    const lang = currentLang.value || localStorage.getItem("preferred_language") || "en";
    
    // Return cached data if available and not forcing refresh
    if (!forceRefresh && newsCache.value[lang]) {
        latestNews.value = newsCache.value[lang];
        return;
    }

    // Prevent duplicate concurrent requests
    if (isFetchingNews.value) {
        return;
    }

    try {
        isFetchingNews.value = true;
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

        const newsData = sorted.slice(0, 3);
        latestNews.value = newsData;
        newsCache.value[lang] = newsData; // Cache by language
    } catch (error) {
        console.error("NEWS API ERROR:", error);
        latestNews.value = [];
    } finally {
        newsLoading.value = false;
        isFetchingNews.value = false;
    }
};

// Fetch business pillar counts
const fetchPillarCounts = async (forceRefresh = false) => {
    const lang = currentLang.value || localStorage.getItem("preferred_language") || "en";
    
    // Return cached data if available and not forcing refresh
    // Note: Counts might be language-agnostic, but we cache by language to be safe
    if (!forceRefresh && pillarCountsCache.value[lang]) {
        pillarCounts.value = pillarCountsCache.value[lang];
        return;
    }

    // Prevent duplicate concurrent requests
    if (isFetchingPillars.value) {
        return;
    }

    try {
        isFetchingPillars.value = true;
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

        const countsData = {
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

        pillarCounts.value = countsData;
        pillarCountsCache.value[lang] = countsData; // Cache by language
    } catch (error) {
        console.error("PILLAR COUNTS API ERROR:", error);
        // Fallback counts
        const fallbackCounts = {
            trainingPrograms: 18,
            agriTechTools: 8,
            smartFarming: 6,
            seedSupply: 6,
            marketAccess: 3,
            environmental: 3,
            community: 3,
        };
        pillarCounts.value = fallbackCounts;
        pillarCountsCache.value[lang] = fallbackCounts; // Cache fallback too
    } finally {
        pillarLoading.value = false;
        isFetchingPillars.value = false;
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

// Gallery functions removed - now using router links

onMounted(async () => {
    console.log("🚀 HOME PAGE MOUNTED");

    // Initialize responsive pillars per view and listen to resize
    updateCardsPerView();
    window.addEventListener("resize", updateCardsPerView);
    window.addEventListener("resize", updateWindowWidth);

    // Start hero slider
    startAutoSlide();

    // Start pillar auto-slide only when the pillars section becomes visible
    // (use IntersectionObserver to start/stop automatic sliding)
    const handlePillarsIntersection = (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                // Begin auto-rotation when the section is in view
                startPillarAutoSlide();
            } else {
                // Pause/stop auto-rotation when the section leaves view
                stopPillarAutoSlide();
            }
        });
    };

    // Create observer with a moderate threshold (50% visible)
    pillarsObserver = new IntersectionObserver(handlePillarsIntersection, {
        threshold: 0.5,
    });

    // Observe the pillars section element if available
    try {
        if (pillarsSectionRef.value)
            pillarsObserver.observe(pillarsSectionRef.value);
    } catch (e) {
        // Defensive: if ref isn't available yet, attempt a DOM lookup as fallback
        const el = document.querySelector("section.section-padding.bg-gray-50");
        if (el) pillarsObserver.observe(el);
    }

    // Fetch all dynamic content
    console.log("📡 FETCHING DYNAMIC CONTENT FROM APIs...");
    await fetchStatistics();
    fetchLatestNews();
    fetchPillarCounts();

    // Initialize stats animation after data is loaded
    setTimeout(initializeStats, 100);

    // Refetch translatable dynamic data when language changes
    // Use a debounced handler to prevent rapid-fire duplicate calls
    let languageChangeTimeout = null;
    const handleLanguageChanged = () => {
        // Clear any pending language change handler
        if (languageChangeTimeout) {
            clearTimeout(languageChangeTimeout);
        }
        
        // Debounce: wait 100ms before refetching (in case multiple events fire)
        languageChangeTimeout = setTimeout(() => {
            // Force refresh when language changes (don't use cache)
            fetchLatestNews(true);
            fetchPillarCounts(true);
        }, 100);
    };
    window.addEventListener("language:changed", handleLanguageChanged);

    // Store cleanup function for unmount
    const cleanupLanguageHandler = () => {
        if (languageChangeTimeout) {
            clearTimeout(languageChangeTimeout);
        }
        window.removeEventListener("language:changed", handleLanguageChanged);
    };
});

onUnmounted(() => {
    stopAutoSlide();
    stopPillarAutoSlide();
    if (pillarsObserver) {
        try {
            pillarsObserver.disconnect();
        } catch (e) {
            // ignore
        }
        pillarsObserver = null;
    }
    window.removeEventListener("resize", updateCardsPerView);
    window.removeEventListener("resize", updateWindowWidth);
    // Cleanup language change handler
    cleanupLanguageHandler();
});
</script>
