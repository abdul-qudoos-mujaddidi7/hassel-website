<template>
    <footer class="bg-brand-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <img
                        :src="'/mountagro-logo.jpg'"
                        alt="Mount Agro Logo"
                        width="72"
                        height="72"
                        decoding="async"
                        fetchpriority="high"
                        class="object-contain rounded-xl mb-2"
                    />

                    <p class="text-brand-cream mb-4 max-w-md pr-4">
                        {{ t("footer.company_tagline") }}
                    </p>
                    <div class="flex space-x-4 rtl:space-x-6 ltr:space-x-4">
                        <a
                            href="https://www.facebook.com/share/1EXcKty2vX/?mibextid=wwXIfr"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-brand-cream hover:text-white transition-colors rtl:ml-2 ltr:mr-2"
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
                        <a
                            href="https://www.linkedin.com/in/mount-agro-afghanistan-ab6388396/"
                            class="text-brand-cream hover:text-white transition-colors rtl:ml-2 ltr:mr-2"
                        >
                            <span class="sr-only">LinkedIn</span>
                            <svg
                                class="h-6 w-6"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"
                                />
                            </svg>
                        </a>
                        <a
                            href="https://x.com/MountAgroAfg"
                            class="text-brand-cream hover:text-white transition-colors rtl:ml-2 ltr:mr-2"
                        >
                            <span class="sr-only">Twitter</span>
                            <svg
                                class="h-6 w-6"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"
                                />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">
                        {{ t("footer.quick_links") }}
                    </h3>
                    <ul class="space-y-2">
                        <li>
                            <router-link
                                to="/"
                                class="text-brand-cream hover:text-white transition-colors"
                                >{{ t("nav.home") }}</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/resources"
                                class="text-brand-cream hover:text-white transition-colors"
                                >{{ t("nav.resources") }}</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/careers"
                                class="text-brand-cream hover:text-white transition-colors"
                                >{{ t("nav.careers") }}</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/contact"
                                class="text-brand-cream hover:text-white transition-colors"
                                >{{ t("nav.contact") }}</router-link
                            >
                        </li>
                    </ul>
                </div>

                <!-- Programs Column -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">
                        {{ t("footer.programs") }}
                    </h3>
                    <ul class="space-y-2">
                        <li>
                            <router-link
                                to="/training-programs"
                                class="text-brand-cream hover:text-white transition-colors"
                                >{{ t("nav.training") }}</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/agri-tech-tools"
                                class="text-brand-cream hover:text-white transition-colors"
                                >{{ t("nav.agri_tech") }}</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/smart-farming"
                                class="text-brand-cream hover:text-white transition-colors"
                                >{{ t("nav.smart_farming") }}</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/seed-supply"
                                class="text-brand-cream hover:text-white transition-colors"
                                >{{ t("nav.seed_supply") }}</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/market-access"
                                class="text-brand-cream hover:text-white transition-colors"
                                >{{ t("nav.market_access") }}</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/environmental-projects"
                                class="text-brand-cream hover:text-white transition-colors"
                                >{{ t("nav.environmental") }}</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/community-programs"
                                class="text-brand-cream hover:text-white transition-colors"
                                >{{ t("nav.community") }}</router-link
                            >
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">
                        {{ t("footer.contact") }}
                    </h3>
                    <div class="space-y-2 text-brand-cream">
                        <p>{{ t("footer.address") }}</p>
                        <!-- <p>{{ t("footer.city_state") }}</p> -->
                        <p>{{ t("footer.phone") }}</p>
                        <p>{{ t("footer.email") }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-brand-secondary mt-8 pt-8">
                <div
                    class="flex flex-col md:flex-row justify-between items-center"
                >
                    <p class="text-brand-cream text-sm">
                        © {{ currentYear }} Mount Agro.
                        {{ t("footer.copyright") }}
                    </p>
                    <!-- <div class="flex space-x-6 mt-4 md:mt-0">
                        <a
                            href="#"
                            class="text-brand-cream hover:text-white text-sm transition-colors"
                            >{{ t("footer.privacy_policy") }}</a
                        >
                        <a
                            href="#"
                            class="text-brand-cream hover:text-white text-sm transition-colors"
                            >{{ t("footer.terms_of_service") }}</a
                        >
                    </div> -->
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { computed } from "vue";
import { useI18n } from "../composables/useI18n";

const { t } = useI18n();
const currentYear = computed(() => new Date().getFullYear());
</script>
