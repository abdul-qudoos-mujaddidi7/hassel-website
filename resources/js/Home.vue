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
                        Welcome to <span class="gradient-text">Mount Agro</span>
                    </h1>
                    <p
                        class="text-xl md:text-2xl text-green-100 mb-8 max-w-3xl mx-auto animate-fadeInUp"
                        style="animation-delay: 0.2s"
                    >
                        Professional solutions for modern challenges. We build
                        tomorrow's technology today.
                    </p>
                    <div
                        class="flex flex-col sm:flex-row gap-4 justify-center animate-fadeInUp"
                        style="animation-delay: 0.4s"
                    >
                        <router-link
                            to="/our-work"
                            class="btn btn-cta text-lg px-8 py-4"
                        >
                            Explore Our Work
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
                            to="/contact"
                            class="btn btn-secondary text-lg px-8 py-4"
                        >
                            Get In Touch
                        </router-link>
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
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
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
                            To be the leading provider of innovative solutions
                            that transform businesses and create lasting impact
                            in the digital landscape.
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
                            We deliver exceptional value through cutting-edge
                            technology, expert guidance, and unwavering
                            commitment to our clients' success.
                        </p>
                    </div>

                    <!-- Values -->
                    <div
                        class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-yellow-50 to-yellow-100 card-hover"
                    >
                        <div
                            class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6"
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
                            Integrity, innovation, excellence, and collaboration
                            are the core values that drive our team and define
                            our culture.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section
            class="section-padding bg-gradient-to-r from-green-600 to-emerald-600 text-white"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg mb-4">Our Impact in Numbers</h2>
                    <p class="text-xl text-green-100 max-w-3xl mx-auto">
                        Measurable results that speak to our commitment to
                        excellence
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">
                            500+
                        </div>
                        <div class="text-green-100">Projects Completed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">
                            98%
                        </div>
                        <div class="text-green-100">Client Satisfaction</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">
                            50+
                        </div>
                        <div class="text-green-100">Team Members</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">
                            10+
                        </div>
                        <div class="text-green-100">Years Experience</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Who We Are / History Section -->
        <section class="section-padding bg-gradient-bg-organic">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center"
                >
                    <div>
                        <h2 class="heading-lg text-gray-900 mb-6">
                            Who We Are
                        </h2>
                        <p class="text-lg text-gray-600 mb-6">
                            Founded in 2013, Mount Agro has grown from a small
                            startup into a leading technology solutions
                            provider. Our journey began with a simple mission:
                            to help businesses leverage technology for growth
                            and innovation.
                        </p>
                        <p class="text-lg text-gray-600 mb-8">
                            Over the years, we've built a reputation for
                            delivering exceptional results through our expertise
                            in modern technologies, strategic thinking, and
                            unwavering commitment to our clients' success.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <router-link to="/about" class="btn btn-primary">
                                Learn More About Us
                            </router-link>
                            <router-link
                                to="/our-work"
                                class="btn btn-secondary"
                            >
                                See Our Portfolio
                            </router-link>
                        </div>
                    </div>
                    <div class="relative">
                        <div
                            class="bg-gradient-to-br from-green-600 to-emerald-600 rounded-professional-lg p-8 text-white"
                        >
                            <h3 class="text-2xl font-bold mb-4">Our Journey</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div
                                        class="w-3 h-3 bg-white rounded-full mt-2 mr-4 flex-shrink-0"
                                    ></div>
                                    <div>
                                        <div class="font-semibold">
                                            2013 - Founded
                                        </div>
                                        <div class="text-green-100 text-sm">
                                            Started with a vision to transform
                                            businesses
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div
                                        class="w-3 h-3 bg-white rounded-full mt-2 mr-4 flex-shrink-0"
                                    ></div>
                                    <div>
                                        <div class="font-semibold">
                                            2016 - Expansion
                                        </div>
                                        <div class="text-green-100 text-sm">
                                            Grew our team and expanded services
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div
                                        class="w-3 h-3 bg-white rounded-full mt-2 mr-4 flex-shrink-0"
                                    ></div>
                                    <div>
                                        <div class="font-semibold">
                                            2020 - Innovation
                                        </div>
                                        <div class="text-green-100 text-sm">
                                            Pioneered new technologies and
                                            methodologies
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div
                                        class="w-3 h-3 bg-white rounded-full mt-2 mr-4 flex-shrink-0"
                                    ></div>
                                    <div>
                                        <div class="font-semibold">
                                            2024 - Leadership
                                        </div>
                                        <div class="text-green-100 text-sm">
                                            Recognized as industry leaders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Thematic Areas Section -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-4">
                        Our Thematic Areas
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Specialized expertise across key domains that drive
                        modern business success
                    </p>
                </div>

                <div
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
                        <p class="text-gray-600">
                            Modernize your business processes with cutting-edge
                            digital solutions that drive efficiency and growth.
                        </p>
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
                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            Cloud Solutions
                        </h3>
                        <p class="text-gray-600">
                            Scalable, secure, and cost-effective cloud
                            infrastructure that grows with your business needs.
                        </p>
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
                        <p class="text-gray-600">
                            Transform raw data into actionable insights that
                            drive informed business decisions and growth.
                        </p>
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
                        <p class="text-gray-600">
                            Protect your digital assets with comprehensive
                            security solutions and best practices.
                        </p>
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
                        <p class="text-gray-600">
                            Native and cross-platform mobile applications that
                            deliver exceptional user experiences.
                        </p>
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
                        <p class="text-gray-600">
                            Strategic consulting and implementation to
                            accelerate your business growth and market presence.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Preview Section -->
        <section class="section-padding bg-gradient-bg-organic">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-4">
                        Our Work in Action
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        A glimpse into the projects and solutions that define
                        our expertise
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div
                        class="relative group rounded-professional-lg overflow-hidden card-hover bg-white shadow-lg"
                    >
                        <div
                            class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-green-500 to-green-600"
                        >
                            <div
                                class="flex items-center justify-center text-white p-6"
                            >
                                <div class="text-center">
                                    <svg
                                        class="w-16 h-16 mx-auto mb-4"
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
                                    <h3 class="text-xl font-bold">
                                        E-Commerce Platform
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center p-6"
                        >
                            <div class="text-white text-center">
                                <h3 class="text-xl font-bold mb-2">
                                    E-Commerce Platform
                                </h3>
                                <p class="text-sm text-green-100">
                                    Modern online store solution
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="relative group rounded-professional-lg overflow-hidden card-hover bg-white shadow-lg"
                    >
                        <div
                            class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-emerald-500 to-emerald-600"
                        >
                            <div
                                class="flex items-center justify-center text-white p-6"
                            >
                                <div class="text-center">
                                    <svg
                                        class="w-16 h-16 mx-auto mb-4"
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
                                    <h3 class="text-xl font-bold">
                                        Analytics Dashboard
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center p-6"
                        >
                            <div class="text-white text-center">
                                <h3 class="text-xl font-bold mb-2">
                                    Analytics Dashboard
                                </h3>
                                <p class="text-sm text-emerald-100">
                                    Real-time business intelligence
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="relative group rounded-professional-lg overflow-hidden card-hover bg-white shadow-lg"
                    >
                        <div
                            class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-yellow-500 to-orange-500"
                        >
                            <div
                                class="flex items-center justify-center text-white p-6"
                            >
                                <div class="text-center">
                                    <svg
                                        class="w-16 h-16 mx-auto mb-4"
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
                                    <h3 class="text-xl font-bold">
                                        Mobile App
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center p-6"
                        >
                            <div class="text-white text-center">
                                <h3 class="text-xl font-bold mb-2">
                                    Mobile App
                                </h3>
                                <p class="text-sm text-yellow-100">
                                    Cross-platform mobile solution
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <router-link
                        to="/our-work"
                        class="btn btn-primary text-lg px-8 py-4"
                    >
                        View All Projects
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
                </div>
            </div>
        </section>

        <!-- Funding Partners Section -->
        <section class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-4">
                        Our Funding Partners
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Trusted by leading organizations and investors who
                        believe in our vision
                    </p>
                </div>

                <div
                    class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center"
                >
                    <div
                        class="flex items-center justify-center p-6 bg-gray-50 rounded-lg"
                    >
                        <div class="text-2xl font-bold text-gray-400">
                            Partner 1
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center p-6 bg-gray-50 rounded-lg"
                    >
                        <div class="text-2xl font-bold text-gray-400">
                            Partner 2
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center p-6 bg-gray-50 rounded-lg"
                    >
                        <div class="text-2xl font-bold text-gray-400">
                            Partner 3
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center p-6 bg-gray-50 rounded-lg"
                    >
                        <div class="text-2xl font-bold text-gray-400">
                            Partner 4
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center p-6 bg-gray-50 rounded-lg"
                    >
                        <div class="text-2xl font-bold text-gray-400">
                            Partner 5
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center p-6 bg-gray-50 rounded-lg"
                    >
                        <div class="text-2xl font-bold text-gray-400">
                            Partner 6
                        </div>
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
                    Ready to Transform Your Business?
                </h2>
                <p class="text-xl text-green-100 mb-8">
                    Let's discuss how we can help you achieve your goals with
                    our professional solutions and expertise.
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
// No additional script needed for this component
</script>
