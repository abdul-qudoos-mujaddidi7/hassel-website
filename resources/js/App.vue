<template>
    <div id="app">
        <!-- Header -->
        <header class="sticky top-0 z-50 brand-gradient shadow-lg">
            <nav class="max-w-7xl mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <router-link to="/" class="flex items-center space-x-2">
                            <div
                                class="w-10 h-10 bg-white rounded-lg flex items-center justify-center"
                            >
                                <i
                                    class="fa-solid fa-seedling text-2xl brand-text"
                                ></i>
                            </div>
                            <span class="text-white font-bold text-xl"
                                >HMI</span
                            >
                        </router-link>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-8">
                        <router-link
                            to="/"
                            class="text-white hover:text-white/80 transition-colors"
                        >
                            <i class="fa-solid fa-home mr-1"></i>Home
                        </router-link>
                        <router-link
                            to="/about"
                            class="text-white hover:text-white/80 transition-colors"
                        >
                            <i class="fa-solid fa-info-circle mr-1"></i>About
                        </router-link>
                        <router-link
                            to="/our-work"
                            class="text-white hover:text-white/80 transition-colors"
                        >
                            <i class="fa-solid fa-briefcase mr-1"></i>Our Work
                        </router-link>
                        <router-link
                            to="/resources"
                            class="text-white hover:text-white/80 transition-colors"
                        >
                            <i class="fa-solid fa-newspaper mr-1"></i>Resources
                        </router-link>
                        <router-link
                            to="/careers"
                            class="text-white hover:text-white/80 transition-colors"
                        >
                            <i class="fa-solid fa-users mr-1"></i>Careers
                        </router-link>
                        <router-link
                            to="/contact"
                            class="text-white hover:text-white/80 transition-colors"
                        >
                            <i class="fa-solid fa-envelope mr-1"></i>Contact
                        </router-link>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="text-white hover:text-white/80"
                        >
                            <i class="fa-solid fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div
                    v-if="mobileMenuOpen"
                    class="md:hidden py-4 border-t border-white/20"
                >
                    <div class="flex flex-col space-y-4">
                        <router-link
                            to="/"
                            class="text-white hover:text-white/80 transition-colors"
                            @click="mobileMenuOpen = false"
                        >
                            <i class="fa-solid fa-home mr-2"></i>Home
                        </router-link>
                        <router-link
                            to="/about"
                            class="text-white hover:text-white/80 transition-colors"
                            @click="mobileMenuOpen = false"
                        >
                            <i class="fa-solid fa-info-circle mr-2"></i>About
                        </router-link>
                        <router-link
                            to="/our-work"
                            class="text-white hover:text-white/80 transition-colors"
                            @click="mobileMenuOpen = false"
                        >
                            <i class="fa-solid fa-briefcase mr-2"></i>Our Work
                        </router-link>
                        <router-link
                            to="/resources"
                            class="text-white hover:text-white/80 transition-colors"
                            @click="mobileMenuOpen = false"
                        >
                            <i class="fa-solid fa-newspaper mr-2"></i>Resources
                        </router-link>
                        <router-link
                            to="/careers"
                            class="text-white hover:text-white/80 transition-colors"
                            @click="mobileMenuOpen = false"
                        >
                            <i class="fa-solid fa-users mr-2"></i>Careers
                        </router-link>
                        <router-link
                            to="/contact"
                            class="text-white hover:text-white/80 transition-colors"
                            @click="mobileMenuOpen = false"
                        >
                            <i class="fa-solid fa-envelope mr-2"></i>Contact
                        </router-link>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main>
            <router-view />
        </main>

        <!-- Footer -->
        <footer class="bg-slate-800 text-white py-12">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid md:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <div
                                class="w-8 h-8 bg-white rounded-lg flex items-center justify-center"
                            >
                                <i
                                    class="fa-solid fa-seedling text-lg brand-text"
                                ></i>
                            </div>
                            <span class="font-bold text-xl">HMI</span>
                        </div>
                        <p class="text-slate-300 text-sm">
                            Hassel Microfinance Institution - Advancing
                            financial inclusion for sustainable growth.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <router-link
                                    to="/about"
                                    class="text-slate-300 hover:text-white transition-colors"
                                    >About Us</router-link
                                >
                            </li>
                            <li>
                                <router-link
                                    to="/our-work"
                                    class="text-slate-300 hover:text-white transition-colors"
                                    >Our Work</router-link
                                >
                            </li>
                            <li>
                                <router-link
                                    to="/resources"
                                    class="text-slate-300 hover:text-white transition-colors"
                                    >Resources</router-link
                                >
                            </li>
                            <li>
                                <router-link
                                    to="/careers"
                                    class="text-slate-300 hover:text-white transition-colors"
                                    >Careers</router-link
                                >
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="font-semibold mb-4">Contact</h3>
                        <div class="space-y-2 text-sm text-slate-300">
                            <p>
                                <i class="fa-solid fa-envelope mr-2"></i
                                >info@hasselmfi.org
                            </p>
                            <p>
                                <i class="fa-solid fa-phone mr-2"></i>+93 123
                                456 789
                            </p>
                            <p>
                                <i class="fa-solid fa-map-marker-alt mr-2"></i
                                >Kabul, Afghanistan
                            </p>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h3 class="font-semibold mb-4">Follow Us</h3>
                        <div class="flex space-x-4">
                            <a
                                href="#"
                                class="w-10 h-10 bg-slate-700 rounded-lg flex items-center justify-center hover:bg-slate-600 transition-colors"
                            >
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a
                                href="#"
                                class="w-10 h-10 bg-slate-700 rounded-lg flex items-center justify-center hover:bg-slate-600 transition-colors"
                            >
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                            <a
                                href="#"
                                class="w-10 h-10 bg-slate-700 rounded-lg flex items-center justify-center hover:bg-slate-600 transition-colors"
                            >
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    class="border-t border-slate-700 mt-8 pt-8 text-center text-sm text-slate-400"
                >
                    <p>
                        &copy; 2024 Hassel Microfinance Institution. All rights
                        reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref } from "vue";

const mobileMenuOpen = ref(false);
</script>
