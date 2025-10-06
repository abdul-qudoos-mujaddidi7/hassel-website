<template>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <section class="relative text-white overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img
                    :src="'/images/about/contact-hero.avif'"
                    alt="Contact Us"
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
                        {{ t("contact.hero.title") }}
                    </h1>
                    <p
                        class="text-xl md:text-2xl text-green-100 mb-8 max-w-3xl mx-auto animate-fadeInUp"
                        style="animation-delay: 0.2s"
                    >
                        {{ t("contact.hero.subtitle") }}
                    </p>
                    <div
                        class="flex flex-col sm:flex-row gap-4 justify-center animate-fadeInUp"
                        style="animation-delay: 0.35s"
                    >
                        <a
                            href="#contact-form"
                            class="btn btn-secondary px-8 py-4 text-lg"
                            >{{ t("contact.hero.send_message") }}</a
                        >
                        <a
                            href="tel:+93701234567"
                            class="btn btn-cta px-8 py-4 text-lg"
                            >{{ t("contact.hero.call_now") }}</a
                        >
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Information & Form Section -->
        <section id="contact-form" class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Contact Information -->
                    <div class="order-2 lg:order-1">
                        <h2 class="heading-lg text-gray-900 mb-8">
                            Get in Touch
                        </h2>
                        <div class="space-y-8">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-lg flex items-center justify-center"
                                >
                                    <svg
                                        class="w-6 h-6 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-xl font-semibold mb-2 text-gray-900"
                                    >
                                        Head Office
                                    </h3>
                                    <p class="text-gray-600">
                                        123 Business Street<br />
                                        San Francisco, CA 94105<br />
                                        United States
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-green-600 rounded-lg flex items-center justify-center"
                                >
                                    <svg
                                        class="w-6 h-6 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-xl font-semibold mb-2 text-gray-900"
                                    >
                                        Phone
                                    </h3>
                                    <p class="text-gray-600">
                                        +1 (555) 123-4567<br />
                                        +1 (555) 987-6543
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center"
                                >
                                    <svg
                                        class="w-6 h-6 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-xl font-semibold mb-2 text-gray-900"
                                    >
                                        Email
                                    </h3>
                                    <p class="text-gray-600">
                                        info@mountagro.com<br />
                                        support@mountagro.com
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-lg flex items-center justify-center"
                                >
                                    <svg
                                        class="w-6 h-6 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-xl font-semibold mb-2 text-gray-900"
                                    >
                                        Business Hours
                                    </h3>
                                    <p class="text-gray-600">
                                        Monday - Friday: 9:00 AM - 6:00 PM<br />
                                        Saturday: 10:00 AM - 4:00 PM<br />
                                        Sunday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="mt-12">
                            <h3
                                class="text-xl font-semibold mb-6 text-gray-900"
                            >
                                Follow Us
                            </h3>
                            <div class="flex flex-wrap gap-4">
                                <!-- Facebook -->
                                <a
                                    href="https://facebook.com/mountagro"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center text-white hover:scale-110 transition-all duration-300 hover:shadow-lg"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
                                        />
                                    </svg>
                                </a>

                                <!-- Twitter -->
                                <a
                                    href="https://twitter.com/mountagro"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-12 h-12 bg-gradient-to-br from-sky-400 to-sky-500 rounded-full flex items-center justify-center text-white hover:scale-110 transition-all duration-300 hover:shadow-lg"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"
                                        />
                                    </svg>
                                </a>

                                <!-- LinkedIn -->
                                <a
                                    href="https://linkedin.com/company/mountagro"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-12 h-12 bg-gradient-to-br from-blue-700 to-blue-800 rounded-full flex items-center justify-center text-white hover:scale-110 transition-all duration-300 hover:shadow-lg"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"
                                        />
                                    </svg>
                                </a>

                                <!-- Instagram -->
                                <a
                                    href="https://instagram.com/mountagro"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-12 h-12 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center text-white hover:scale-110 transition-all duration-300 hover:shadow-lg"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"
                                        />
                                    </svg>
                                </a>

                                <!-- YouTube -->
                                <a
                                    href="https://youtube.com/@mountagro"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-700 rounded-full flex items-center justify-center text-white hover:scale-110 transition-all duration-300 hover:shadow-lg"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"
                                        />
                                    </svg>
                                </a>

                                <!-- WhatsApp -->
                                <a
                                    href="https://wa.me/93701234567"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white hover:scale-110 transition-all duration-300 hover:shadow-lg"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"
                                        />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="order-1 lg:order-2">
                        <h2 class="heading-lg text-gray-900 mb-8">
                            Send us a Message
                        </h2>
                        <form @submit.prevent="submitForm" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        for="firstName"
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                        >First Name *</label
                                    >
                                    <input
                                        type="text"
                                        id="firstName"
                                        v-model="form.firstName"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                    />
                                </div>
                                <div>
                                    <label
                                        for="lastName"
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                        >Last Name *</label
                                    >
                                    <input
                                        type="text"
                                        id="lastName"
                                        v-model="form.lastName"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    for="email"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Email *</label
                                >
                                <input
                                    type="email"
                                    id="email"
                                    v-model="form.email"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                />
                            </div>

                            <div>
                                <label
                                    for="phone"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Phone</label
                                >
                                <input
                                    type="tel"
                                    id="phone"
                                    v-model="form.phone"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                />
                            </div>

                            <div>
                                <label
                                    for="subject"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Subject *</label
                                >
                                <select
                                    id="subject"
                                    v-model="form.subject"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                >
                                    <option value="">Select a subject</option>
                                    <option value="job_application">
                                        Job Application
                                    </option>
                                    <option value="general_inquiry">
                                        General Inquiry
                                    </option>
                                    <option value="project_discussion">
                                        Project Discussion
                                    </option>
                                    <option value="technical_support">
                                        Technical Support
                                    </option>
                                    <option value="partnership">
                                        Partnership
                                    </option>
                                    <option value="media_inquiry">
                                        Media Inquiry
                                    </option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Job Application Specific Fields -->
                            <div
                                v-if="form.subject === 'job_application'"
                                class="space-y-4 p-3 bg-green-50 rounded-lg border border-green-200"
                            >
                                <h3
                                    class="text-base font-semibold text-green-800"
                                >
                                    Job Application Details
                                </h3>

                                <div>
                                    <label
                                        for="job_title"
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Job Title *
                                    </label>
                                    <input
                                        type="text"
                                        id="job_title"
                                        v-model="form.job_title"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                        placeholder="e.g., Software Developer"
                                    />
                                </div>

                                <div>
                                    <label
                                        for="location"
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Your Location
                                    </label>
                                    <input
                                        type="text"
                                        id="location"
                                        v-model="form.location"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                        placeholder="e.g., Kabul, Afghanistan"
                                    />
                                </div>

                                <div>
                                    <label
                                        for="cover_letter"
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Cover Letter *
                                    </label>
                                    <textarea
                                        id="cover_letter"
                                        v-model="form.cover_letter"
                                        required
                                        rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                                        placeholder="Tell us why you're interested in this position and what makes you a good fit..."
                                    ></textarea>
                                </div>

                                <div>
                                    <label
                                        for="cv_file"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        CV/Resume Upload
                                    </label>
                                    <input
                                        type="file"
                                        id="cv_file"
                                        @change="handleFileUpload"
                                        accept=".pdf,.doc,.docx"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors text-sm"
                                    />
                                    <p class="text-xs text-gray-500 mt-1">
                                        PDF, DOC, DOCX (Max 5MB)
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label
                                    for="message"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Message *</label
                                >
                                <textarea
                                    id="message"
                                    v-model="form.message"
                                    required
                                    rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    :placeholder="
                                        form.subject === 'job_application'
                                            ? 'Please provide any additional information about your application...'
                                            : 'Please describe your inquiry in detail...'
                                    "
                                ></textarea>
                            </div>

                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="w-full btn btn-primary py-4 text-lg"
                            >
                                <LoadingSpinner
                                    v-if="isSubmitting"
                                    type="button"
                                    size="small"
                                    message="Sending..."
                                />
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
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                                        />
                                    </svg>
                                    Send Message
                                </template>
                            </button>
                        </form>

                        <!-- Success Message -->
                        <div
                            v-if="showSuccess"
                            class="mt-6 p-4 rounded-lg text-green-800 bg-green-50 border border-green-200"
                        >
                            <div class="flex items-center gap-2">
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
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <span class="font-medium"
                                    >Message sent successfully!</span
                                >
                            </div>
                            <p class="text-sm mt-1">
                                Thank you for contacting us. We'll get back to
                                you within 24 hours.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Regional Offices Section -->
        <section class="section-padding bg-gradient-bg-organic">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="heading-lg text-gray-900 mb-4">Our Offices</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Visit us at one of our locations or reach out to our
                        regional teams
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="office in regionalOffices"
                        :key="office.id"
                        class="rounded-professional-lg p-8 card-hover bg-white shadow-professional"
                    >
                        <h3 class="text-xl font-semibold gradient-text mb-4">
                            {{ office.city }}
                        </h3>
                        <div class="space-y-3 text-gray-600">
                            <p class="flex items-center">
                                <svg
                                    class="w-4 h-4 mr-3 text-green-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                                {{ office.address }}
                            </p>
                            <p class="flex items-center">
                                <svg
                                    class="w-4 h-4 mr-3 text-green-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                    />
                                </svg>
                                {{ office.phone }}
                            </p>
                            <p class="flex items-center">
                                <svg
                                    class="w-4 h-4 mr-3 text-green-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>
                                {{ office.email }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section
            class="section-padding bg-gradient-to-r from-green-600 to-emerald-600 text-white"
        >
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="heading-lg mb-6">Ready to Get Started?</h2>
                <p class="text-xl text-green-100 mb-8">
                    Let's discuss how we can help transform your business with
                    our technology solutions.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <router-link
                        to="/our-work"
                        class="btn btn-cta text-lg px-8 py-4"
                    >
                        View Our Work
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
                    <!-- About link removed; consolidated into Home -->
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import LoadingSpinner from "./components/LoadingSpinner.vue";
import { useI18n } from "./composables/useI18n.js";

const { t } = useI18n();

const isSubmitting = ref(false);
const showSuccess = ref(false);

const form = ref({
    firstName: "",
    lastName: "",
    email: "",
    phone: "",
    subject: "",
    message: "",
    job_title: "",
    job_id: "",
    location: "",
    cover_letter: "",
    cv_file: null,
});

// Handle URL parameters for job applications
onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    const subject = urlParams.get("subject");
    const jobTitle = urlParams.get("job_title");
    const jobId = urlParams.get("job_id");

    if (subject === "job_application") {
        form.value.subject = "job_application";
        if (jobTitle) form.value.job_title = decodeURIComponent(jobTitle);
        if (jobId) form.value.job_id = jobId;
    }

    // Language change handler to update placeholders/labels (static via t())
    const handleLanguageChanged = () => {
        // No API fetch required, but this ensures reactivity for placeholders
        form.value = { ...form.value };
    };
    window.addEventListener("language:changed", handleLanguageChanged);

    onUnmounted(() => {
        window.removeEventListener("language:changed", handleLanguageChanged);
    });
});

// Handle file upload
const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Check file size (5MB limit)
        if (file.size > 5 * 1024 * 1024) {
            alert("File size must be less than 5MB");
            return;
        }
        form.value.cv_file = file;
    }
};

const submitForm = async () => {
    isSubmitting.value = true;

    try {
        // Create form data
        const formData = new FormData();
        formData.append(
            "name",
            `${form.value.firstName} ${form.value.lastName}`
        );
        formData.append("email", form.value.email);
        formData.append("phone", form.value.phone);
        formData.append("subject", form.value.subject);
        formData.append("message", form.value.message);

        // Add job application fields if applicable
        if (form.value.subject === "job_application") {
            formData.append("job_title", form.value.job_title);
            formData.append("job_id", form.value.job_id);
            formData.append("location", form.value.location);
            formData.append("cover_letter", form.value.cover_letter);

            if (form.value.cv_file) {
                formData.append("cv_file", form.value.cv_file);
            }
        }

        // Submit to API
        const response = await fetch("/api/contact", {
            method: "POST",
            body: formData,
        });

        if (response.ok) {
            showSuccess.value = true;
            // Reset form
            form.value = {
                firstName: "",
                lastName: "",
                email: "",
                phone: "",
                subject: "",
                message: "",
                job_title: "",
                job_id: "",
                location: "",
                cover_letter: "",
                cv_file: null,
            };
        } else {
            throw new Error("Submission failed");
        }
    } catch (error) {
        console.error("Error submitting form:", error);
        alert(
            "Sorry, there was an error submitting your form. Please try again."
        );
    } finally {
        isSubmitting.value = false;
    }

    // Hide success message after 5 seconds
    setTimeout(() => {
        showSuccess.value = false;
    }, 5000);
};

const regionalOffices = [
    {
        id: 1,
        city: "New York",
        address: "123 Business Ave, Manhattan, NY 10001",
        phone: "+1 (555) 123-4567",
        email: "ny@mountagro.com",
    },
    {
        id: 2,
        city: "Los Angeles",
        address: "456 Tech Street, LA, CA 90210",
        phone: "+1 (555) 234-5678",
        email: "la@mountagro.com",
    },
    {
        id: 3,
        city: "Chicago",
        address: "789 Innovation Blvd, Chicago, IL 60601",
        phone: "+1 (555) 345-6789",
        email: "chicago@mountagro.com",
    },
];
</script>
