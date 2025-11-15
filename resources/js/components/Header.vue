<template>
    <header
        class="bg-white shadow-professional sticky top-0 left-0 right-0 z-50"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-24">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <router-link to="/" class="flex items-center">
                        <img
                            :src="'/mountagro-logo.jpg'"
                            alt="Mount Agro Logo"
                            width="112"
                            height="112"
                            decoding="async"
                            fetchpriority="high"
                            class="w-24 h-32 md:w-28 md:h-28 rounded-lg object-contain"
                        />
                    </router-link>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-6">
                    <!-- Static items -->
                    <router-link
                        v-for="item in menuItems"
                        :key="item.name"
                        :to="item.path"
                        @mouseenter="prefetchChunk(item.path)"
                        @focus="prefetchChunk(item.path)"
                        class="flex items-center text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 group"
                        :class="{
                            'text-green-600 bg-green-50':
                                $route.path === item.path,
                        }"
                    >
                        <component
                            :is="item.icon"
                            class="block w-4 h-4 mr-2 rtl:mr-0 rtl:ml-2 group-hover:scale-110 transition-transform duration-200 mt-px"
                        />
                        <span>{{ item.name }}</span>
                    </router-link>

                    <!-- Programs dropdown (click to open and stays open) -->
                    <div class="relative" ref="programsMenuRef">
                        <button
                            type="button"
                            @click="isProgramsOpen = !isProgramsOpen"
                            @keydown.escape="isProgramsOpen = false"
                            :aria-expanded="isProgramsOpen"
                            class="flex items-center text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 cursor-pointer"
                        >
                            <span>{{ t("nav.programs") }}</span>
                            <svg
                                class="w-4 h-4 ml-1 rtl:ml-0 rtl:mr-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>
                        <div
                            v-show="isProgramsOpen"
                            class="absolute left-0 mt-2 w-72 rounded-lg bg-white shadow-lg ring-1 ring-black/5 z-50"
                        >
                            <div class="py-2">
                                <router-link
                                    to="/training-programs"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700"
                                    @click="isProgramsOpen = false"
                                    >{{ t("nav.training") }}</router-link
                                >
                                <router-link
                                    to="/agri-tech"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700"
                                    @click="isProgramsOpen = false"
                                    >{{ t("nav.agri_tech") }}</router-link
                                >
                                <router-link
                                    to="/smart-farming"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700"
                                    @click="isProgramsOpen = false"
                                    >{{ t("nav.smart_farming") }}</router-link
                                >
                                <router-link
                                    to="/seed-supply"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700"
                                    @click="isProgramsOpen = false"
                                    >{{ t("nav.seed_supply") }}</router-link
                                >
                                <router-link
                                    to="/market-access"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700"
                                    @click="isProgramsOpen = false"
                                    >{{ t("nav.market_access") }}</router-link
                                >
                                <router-link
                                    to="/environmental-projects"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700"
                                    @click="isProgramsOpen = false"
                                    >{{ t("nav.environmental") }}</router-link
                                >
                                <router-link
                                    to="/community-programs"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700"
                                    @click="isProgramsOpen = false"
                                    >{{ t("nav.community") }}</router-link
                                >
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Language Switcher -->
                <div class="hidden md:block">
                    <LanguageSwitcher />
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button
                        @click="toggleMobileMenu"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-green-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500"
                        aria-expanded="false"
                    >
                        <span class="sr-only">Open main menu</span>
                        <!-- Hamburger icon -->
                        <svg
                            v-if="!isMobileMenuOpen"
                            class="block h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                        <!-- Close icon -->
                        <svg
                            v-else
                            class="block h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div
            v-if="isMobileMenuOpen"
            class="md:hidden fixed inset-0 z-50"
            @click="closeMobileMenu"
        >
            <!-- Backdrop -->
            <div
                class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
            ></div>

            <!-- Drawer -->
            <div
                class="fixed top-0 right-0 h-full w-80 max-w-sm bg-white shadow-xl transform transition-transform duration-300 ease-in-out flex flex-col"
                @click.stop
            >
                <!-- Drawer Header -->
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200"
                >
                    <div class="flex items-center">
                        <img
                            :src="'/mountagro-logo.jpg'"
                            alt="Mount Agro Logo"
                            width="80"
                            height="80"
                            decoding="async"
                            class="w-16 h-16 rounded-lg object-contain"
                        />
                    </div>
                    <div>
                        <LanguageSwitcher />
                    </div>
                    <button
                        @click="closeMobileMenu"
                        class="p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100"
                    >
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Drawer Navigation -->
                <nav class="px-6 py-4 space-y-2 flex-1 overflow-y-auto">
                    <router-link
                        v-for="item in menuItems"
                        :key="item.name"
                        :to="item.path"
                        @click="closeMobileMenu"
                        @mouseenter="prefetchChunk(item.path)"
                        @focus="prefetchChunk(item.path)"
                        class="flex items-center px-4 py-3 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200 group"
                        :class="{
                            'text-green-600 bg-green-50':
                                $route.path === item.path,
                        }"
                    >
                        <component
                            :is="item.icon"
                            class="w-5 h-5 mr-3 rtl:mr-0 rtl:ml-3"
                        />
                        <span class="font-medium">{{ item.name }}</span>
                    </router-link>

                    <!-- Programs expandable -->
                    <details class="px-2">
                        <summary
                            class="px-4 py-3 cursor-pointer text-gray-700 hover:text-green-600 rounded-lg"
                        >
                            {{ t("nav.programs") }}
                        </summary>
                        <div class="pl-4 py-2 space-y-1">
                            <router-link
                                to="/training-programs"
                                class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-md"
                                @click="closeMobileMenu"
                                >{{ t("nav.training") }}</router-link
                            >
                            <router-link
                                to="/agri-tech-tools"
                                class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-md"
                                @click="closeMobileMenu"
                                >{{ t("nav.agri_tech") }}</router-link
                            >
                            <router-link
                                to="/smart-farming"
                                class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-md"
                                @click="closeMobileMenu"
                                >{{ t("nav.smart_farming") }}</router-link
                            >
                            <router-link
                                to="/seed-supply"
                                class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-md"
                                @click="closeMobileMenu"
                                >{{ t("nav.seed_supply") }}</router-link
                            >
                            <router-link
                                to="/market-access"
                                class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-md"
                                @click="closeMobileMenu"
                                >{{ t("nav.market_access") }}</router-link
                            >
                            <router-link
                                to="/environmental-projects"
                                class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-md"
                                @click="closeMobileMenu"
                                >{{ t("nav.environmental") }}</router-link
                            >
                            <router-link
                                to="/community-programs"
                                class="block px-3 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-md"
                                @click="closeMobileMenu"
                                >{{ t("nav.community") }}</router-link
                            >
                        </div>
                    </details>
                </nav>

                <!-- Drawer Footer -->
                <div
                    class="p-6 border-t border-gray-200 bg-gray-50 flex-shrink-0"
                >
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Professional Solutions
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            Building Tomorrow Today
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref, watch, h, onMounted, onUnmounted, computed } from "vue";
import { useRoute } from "vue-router";
import LanguageSwitcher from "./LanguageSwitcher.vue";
import { useI18n } from "../composables/useI18n.js";

const { t } = useI18n();

// Icons (you can replace these with your preferred icon library)
const HomeIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            viewBox: "0 0 24 24",
            stroke: "currentColor",
        },
        [
            h("path", {
                "stroke-linecap": "round",
                "stroke-linejoin": "round",
                "stroke-width": "2",
                d: "M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6",
            }),
        ]
    );

const AboutIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            viewBox: "0 0 24 24",
            stroke: "currentColor",
        },
        [
            h("path", {
                "stroke-linecap": "round",
                "stroke-linejoin": "round",
                "stroke-width": "2",
                d: "M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z",
            }),
        ]
    );

const WorkIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            viewBox: "0 0 24 24",
            stroke: "currentColor",
        },
        [
            h("path", {
                "stroke-linecap": "round",
                "stroke-linejoin": "round",
                "stroke-width": "2",
                d: "M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z",
            }),
        ]
    );

const ResourcesIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            viewBox: "0 0 24 24",
            stroke: "currentColor",
        },
        [
            h("path", {
                "stroke-linecap": "round",
                "stroke-linejoin": "round",
                "stroke-width": "2",
                d: "M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253",
            }),
        ]
    );

const CareersIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            viewBox: "0 0 24 24",
            stroke: "currentColor",
        },
        [
            h("path", {
                "stroke-linecap": "round",
                "stroke-linejoin": "round",
                "stroke-width": "2",
                d: "M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6",
            }),
        ]
    );

const ContactIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            viewBox: "0 0 24 24",
            stroke: "currentColor",
        },
        [
            h("path", {
                "stroke-linecap": "round",
                "stroke-linejoin": "round",
                "stroke-width": "2",
                d: "M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z",
            }),
        ]
    );

const route = useRoute();
const isMobileMenuOpen = ref(false);
const isProgramsOpen = ref(false);
const programsMenuRef = ref(null);

const menuItems = computed(() => [
    { name: t("nav.home"), path: "/", icon: HomeIcon },
    { name: t("nav.resources"), path: "/resources", icon: ResourcesIcon },
    { name: t("nav.careers"), path: "/careers", icon: CareersIcon },
    { name: t("nav.contact"), path: "/contact", icon: ContactIcon },
]);

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
    isMobileMenuOpen.value = false;
};

// Prefetch lazy route chunks on hover/focus for instant navigation
const prefetchers = {
    "/resources": () => import("../Resources.vue"),
    "/careers": () => import("../Careers.vue"),
    "/contact": () => import("../Contact.vue"),
};

const prefetchChunk = (path) => {
    const load = prefetchers[path];
    if (typeof load === "function") {
        load();
    }
};

// Close mobile menu when route changes
watch(
    () => route.path,
    () => {
        closeMobileMenu();
    }
);

// Close Programs when clicking outside
const handleClickOutside = (event) => {
    if (!isProgramsOpen.value) return;
    const root = programsMenuRef.value;
    if (root && !root.contains(event.target)) {
        isProgramsOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener("click", handleClickOutside, true);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside, true);
});
</script>
