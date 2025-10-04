<template>
    <div class="min-h-screen bg-gradient-bg-organic">
        <!-- 404 Error Page -->
        <section
            class="relative text-white overflow-hidden min-h-screen flex items-center"
        >
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img
                    :src="'/images/home/hero1.avif'"
                    alt="404 Error"
                    class="w-full h-full object-cover"
                />
            </div>
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/60"></div>

            <div
                class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-40"
            >
                <div class="text-center">
                    <!-- 404 Number -->
                    <div class="mb-8">
                        <h1
                            class="text-9xl md:text-[12rem] font-bold text-brand-accent animate-fadeInUp"
                        >
                            404
                        </h1>
                    </div>

                    <!-- Error Message -->
                    <div class="mb-8">
                        <h2
                            class="text-4xl md:text-6xl font-bold mb-6 animate-fadeInUp"
                            style="animation-delay: 0.2s"
                        >
                            Oops! Page Not Found
                        </h2>
                        <p
                            class="text-xl md:text-2xl text-white mb-8 max-w-3xl mx-auto animate-fadeInUp"
                            style="animation-delay: 0.4s"
                        >
                            The page you're looking for seems to have wandered
                            off into the digital wilderness.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div
                        class="flex flex-col sm:flex-row gap-4 justify-center animate-fadeInUp"
                        style="animation-delay: 0.6s"
                    >
                        <button
                            @click="goBack"
                            class="btn btn-primary text-white px-8 py-4 text-lg"
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
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                                ></path>
                            </svg>
                            Go Back
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const goBack = () => {
    if (window.history.length > 1) {
        router.go(-1);
    } else {
        router.push("/");
    }
};

const searchSite = () => {
    // Focus on search if available, otherwise redirect to home
    router.push("/");
    // You can implement a search modal or redirect to a search page
};
</script>
