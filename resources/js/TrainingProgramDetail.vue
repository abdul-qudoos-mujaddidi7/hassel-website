<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Modern Hero Section -->
        <section class="relative overflow-hidden">
            <!-- Background with gradient overlay -->
            <div class="absolute inset-0">
                <img
                    :src="heroImage"
                    alt="Program"
                    class="w-full h-full object-cover"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-br from-green-900/80 via-green-800/70 to-emerald-900/80"
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
                class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-32"
            >
                <!-- Breadcrumbs with modern styling -->
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
                        <router-link
                            to="/training-programs"
                            class="text-green-200 hover:text-white transition-colors"
                            >Training Programs</router-link
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
                        <span class="text-white font-medium">{{
                            program?.title || "Program"
                        }}</span>
                    </div>
                </nav>

                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div>
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-100 border border-green-400/30 mb-6"
                        >
                            <svg
                                class="w-4 h-4 mr-2"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            Training Program
                        </div>

                        <h1
                            class="text-3xl sm:text-4xl md:text-6xl font-bold text-white mb-4 sm:mb-6 leading-tight"
                        >
                            {{ program?.title || "Program" }}
                        </h1>

                        <p
                            v-if="program?.short_description"
                            class="text-lg sm:text-xl text-green-100 mb-6 sm:mb-8 leading-relaxed"
                        >
                            {{ program.short_description }}
                        </p>

                        <!-- Modern status badges -->
                        <div class="flex flex-wrap gap-2 sm:gap-3 mb-6 sm:mb-8">
                            <div
                                v-if="program?.status"
                                class="flex items-center px-3 sm:px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 text-sm"
                            >
                                <div
                                    class="w-2 h-2 bg-green-400 rounded-full mr-3"
                                ></div>
                                <span class="text-white font-medium">{{
                                    program.status
                                }}</span>
                            </div>
                            <div
                                v-if="program?.location"
                                class="flex items-center px-3 sm:px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 text-sm"
                            >
                                <svg
                                    class="w-4 h-4 mr-3 text-green-300"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <span class="text-white font-medium">{{
                                    program.location
                                }}</span>
                            </div>
                            <div
                                v-if="dateRange"
                                class="flex items-center px-3 sm:px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 text-sm"
                            >
                                <svg
                                    class="w-4 h-4 mr-3 text-green-300"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <span class="text-white font-medium">{{
                                    dateRange
                                }}</span>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                            <router-link
                                to="/contact"
                                class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm sm:text-base"
                            >
                                Register Now
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
                                    ></path>
                                </svg>
                            </router-link>
                            <button
                                class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-white/10 backdrop-blur-sm border border-white/30 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300 text-sm sm:text-base"
                            >
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
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                    ></path>
                                </svg>
                                Save Program
                            </button>
                        </div>
                    </div>

                    <!-- Program stats card -->
                    <div class="lg:ml-8 mt-8 lg:mt-0">
                        <div
                            class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 sm:p-8 border border-white/20"
                        >
                            <h3 class="text-xl font-bold text-white mb-6">
                                Program Details
                            </h3>
                            <div class="space-y-4">
                                <div
                                    class="flex justify-between items-center py-3 border-b border-white/10"
                                >
                                    <span class="text-green-200">Duration</span>
                                    <span class="text-white font-semibold">{{
                                        program?.duration || "TBD"
                                    }}</span>
                                </div>
                                <div
                                    class="flex justify-between items-center py-3 border-b border-white/10"
                                >
                                    <span class="text-green-200"
                                        >Max Participants</span
                                    >
                                    <span class="text-white font-semibold">{{
                                        program?.max_participants || "Unlimited"
                                    }}</span>
                                </div>
                                <div
                                    class="flex justify-between items-center py-3 border-b border-white/10"
                                >
                                    <span class="text-green-200"
                                        >Instructor</span
                                    >
                                    <span class="text-white font-semibold">{{
                                        program?.instructor || "TBD"
                                    }}</span>
                                </div>
                                <div
                                    class="flex justify-between items-center py-3"
                                >
                                    <span class="text-green-200"
                                        >Program Type</span
                                    >
                                    <span
                                        class="text-white font-semibold capitalize"
                                        >{{
                                            program?.program_type || "General"
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Loading State -->
                <div v-if="loading" class="animate-pulse">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2">
                            <div
                                class="h-8 w-1/3 bg-gray-200 rounded mb-6"
                            ></div>
                            <div
                                class="h-4 w-full bg-gray-100 rounded mb-2"
                            ></div>
                            <div
                                class="h-4 w-3/4 bg-gray-100 rounded mb-2"
                            ></div>
                            <div class="h-4 w-1/2 bg-gray-100 rounded"></div>
                        </div>
                        <div class="lg:col-span-1">
                            <div class="h-64 bg-gray-200 rounded-xl"></div>
                        </div>
                    </div>
                </div>

                <!-- Error State -->
                <div v-else-if="!program" class="text-center py-16">
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
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                            ></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        Program Not Found
                    </h3>
                    <p class="text-gray-600 mb-6">
                        The training program you're looking for doesn't exist or
                        has been removed.
                    </p>
                    <router-link
                        to="/training-programs"
                        class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors"
                    >
                        Browse All Programs
                    </router-link>
                </div>

                <!-- Main Content -->
                <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <article class="lg:col-span-2">
                        <!-- Program Overview -->
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 mb-6 sm:mb-8"
                        >
                            <div class="flex items-start mb-4 sm:mb-6">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-xl flex items-center justify-center mr-3 sm:mr-4 flex-shrink-0"
                                >
                                    <svg
                                        class="w-5 h-5 sm:w-6 sm:h-6 text-green-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                        ></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h2
                                        class="text-xl sm:text-2xl font-bold text-gray-900 mb-1"
                                    >
                                        Program Overview
                                    </h2>
                                    <p
                                        class="text-sm sm:text-base text-gray-600"
                                    >
                                        Comprehensive training details and
                                        curriculum
                                    </p>
                                </div>
                            </div>

                            <div
                                v-if="program.description"
                                class="prose prose-sm sm:prose-lg max-w-none"
                            >
                                <p
                                    class="text-gray-700 leading-relaxed whitespace-pre-line text-sm sm:text-base"
                                >
                                    {{ program.description }}
                                </p>
                            </div>
                        </div>

                        <!-- Program Details Grid -->
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8"
                        >
                            <!-- Objectives -->
                            <div
                                v-if="program.objectives?.length"
                                class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-4 sm:p-6 border border-green-100"
                            >
                                <div class="flex items-center mb-3 sm:mb-4">
                                    <div
                                        class="w-6 h-6 sm:w-8 sm:h-8 bg-green-500 rounded-lg flex items-center justify-center mr-2 sm:mr-3"
                                    >
                                        <svg
                                            class="w-3 h-3 sm:w-4 sm:h-4 text-white"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    </div>
                                    <h3
                                        class="text-base sm:text-lg font-semibold text-gray-900"
                                    >
                                        Learning Objectives
                                    </h3>
                                </div>
                                <ul class="space-y-1.5 sm:space-y-2">
                                    <li
                                        v-for="(
                                            objective, i
                                        ) in program.objectives"
                                        :key="i"
                                        class="flex items-start"
                                    >
                                        <div
                                            class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-500 rounded-full mt-1.5 sm:mt-2 mr-2 sm:mr-3 flex-shrink-0"
                                        ></div>
                                        <span
                                            class="text-gray-700 text-sm sm:text-base"
                                            >{{ objective }}</span
                                        >
                                    </li>
                                </ul>
                            </div>

                            <!-- Syllabus -->
                            <div
                                v-if="program.syllabus || program.outline"
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-4 sm:p-6 border border-blue-100"
                            >
                                <div class="flex items-center mb-3 sm:mb-4">
                                    <div
                                        class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-2 sm:mr-3"
                                    >
                                        <svg
                                            class="w-3 h-3 sm:w-4 sm:h-4 text-white"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                            ></path>
                                        </svg>
                                    </div>
                                    <h3
                                        class="text-base sm:text-lg font-semibold text-gray-900"
                                    >
                                        Course Syllabus
                                    </h3>
                                </div>
                                <div
                                    class="text-gray-700 whitespace-pre-line text-sm sm:text-base"
                                >
                                    {{ program.syllabus || program.outline }}
                                </div>
                            </div>
                        </div>

                        <!-- Instructors & Partners -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Instructors -->
                            <div
                                v-if="program.instructors?.length"
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
                            >
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3"
                                    >
                                        <svg
                                            class="w-4 h-4 text-white"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                            ></path>
                                        </svg>
                                    </div>
                                    <h3
                                        class="text-lg font-semibold text-gray-900"
                                    >
                                        Instructors
                                    </h3>
                                </div>
                                <div class="space-y-3">
                                    <div
                                        v-for="(
                                            instructor, i
                                        ) in program.instructors"
                                        :key="i"
                                        class="flex items-center"
                                    >
                                        <div
                                            class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3"
                                        >
                                            <svg
                                                class="w-5 h-5 text-gray-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div
                                                class="font-medium text-gray-900"
                                            >
                                                {{
                                                    instructor.name ||
                                                    instructor
                                                }}
                                            </div>
                                            <div
                                                v-if="instructor.role"
                                                class="text-sm text-gray-600"
                                            >
                                                {{ instructor.role }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Partners -->
                            <div
                                v-if="program.partners?.length"
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
                            >
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3"
                                    >
                                        <svg
                                            class="w-4 h-4 text-white"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                            ></path>
                                        </svg>
                                    </div>
                                    <h3
                                        class="text-lg font-semibold text-gray-900"
                                    >
                                        Partners
                                    </h3>
                                </div>
                                <div class="space-y-2">
                                    <div
                                        v-for="(partner, i) in program.partners"
                                        :key="i"
                                        class="flex items-center"
                                    >
                                        <div
                                            class="w-2 h-2 bg-orange-500 rounded-full mr-3"
                                        ></div>
                                        <span class="text-gray-700">{{
                                            partner.name || partner
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Sidebar -->
                    <aside class="lg:col-span-1">
                        <!-- Registration Card -->
                        <div
                            class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white mb-6 shadow-lg"
                        >
                            <div class="text-center mb-6">
                                <div
                                    class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4"
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
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                        ></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold mb-2">
                                    Ready to Join?
                                </h3>
                                <p class="text-green-100 mb-6">
                                    Register for this program and start your
                                    agricultural journey with us.
                                </p>
                            </div>

                            <router-link
                                to="/contact"
                                class="block w-full bg-white text-green-600 font-semibold py-4 px-6 rounded-xl text-center hover:bg-gray-50 transition-colors mb-4"
                            >
                                Register Now
                            </router-link>

                            <div class="text-center">
                                <p class="text-green-100 text-sm mb-2">
                                    Have questions?
                                </p>
                                <router-link
                                    to="/contact"
                                    class="text-white hover:text-green-200 text-sm underline"
                                >
                                    Contact our team
                                </router-link>
                            </div>
                        </div>

                        <!-- Related Programs -->
                        <div
                            v-if="related.length"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
                        >
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-4"
                            >
                                Related Programs
                            </h3>
                            <div class="space-y-3">
                                <router-link
                                    v-for="r in related"
                                    :key="r.id"
                                    :to="`/training-programs/${r.slug || r.id}`"
                                    class="block p-3 rounded-lg border border-gray-100 hover:border-green-200 hover:bg-green-50 transition-all group"
                                >
                                    <div
                                        class="font-medium text-gray-900 group-hover:text-green-700"
                                    >
                                        {{ r.title }}
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        View details →
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const idOrSlug = route.params.idOrSlug;
const loading = ref(true);
const program = ref(null);
const related = ref([]);

const dateRange = computed(() => {
    if (!program.value) return "";
    const s = program.value.start_date;
    const e = program.value.end_date;
    return s && e ? `${s} – ${e}` : "";
});

const heroImage = computed(() => {
    const p = program.value;
    const img = p?.cover_image || p?.thumbnail_image || p?.featured_image;
    if (!img) return "/images/ourWork/ourworkhero.avif";
    return img.startsWith("http")
        ? img
        : `/storage/${String(img).replace(/^\/+/, "")}`;
});

const registerRoute = computed(() => "/contact");

onMounted(async () => {
    await fetchProgram();
    await fetchRelated();
});

async function fetchProgram() {
    loading.value = true;
    try {
        // try slug endpoint first, then id
        let res = await fetch(`/api/training-programs/${idOrSlug}`);
        if (!res.ok) {
            // fallback: if slug route not supported, try by query
            res = await fetch(
                `/api/training-programs?slug=${encodeURIComponent(
                    idOrSlug
                )}&limit=1`
            );
        }
        if (res.ok) {
            const data = await res.json();
            const item = Array.isArray(data?.data)
                ? data.data[0]
                : data?.data || data;
            program.value = normalize(item);
        } else {
            program.value = null;
        }
    } catch (e) {
        program.value = null;
    } finally {
        loading.value = false;
    }
}

function normalize(r) {
    if (!r) return null;
    return {
        ...r,
        title: r.title || r.name || "Training Program",
        location: r.location || r.province || r.region || r.district,
        status: r.status || r.program_status,
    };
}

async function fetchRelated() {
    try {
        const res = await fetch(
            `/api/training-programs?limit=4&orderBy=published_at&direction=desc`
        );
        if (!res.ok) return;
        const data = await res.json();
        const list = Array.isArray(data?.data)
            ? data.data
            : Array.isArray(data)
            ? data
            : [];
        related.value = list
            .filter((x) => String(x.slug || x.id) !== String(idOrSlug))
            .slice(0, 3)
            .map((x) => ({
                id: x.id,
                slug: x.slug,
                title: x.title || x.name,
            }));
    } catch (e) {
        related.value = [];
    }
}
</script>
