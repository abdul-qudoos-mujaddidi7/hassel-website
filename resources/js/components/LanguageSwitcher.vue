<template>
    <div class="language-switcher">
        <div class="relative">
            <!-- Language Button -->
            <button
                @click="toggleDropdown"
                class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary"
            >
                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"
                    ></path>
                </svg>
                <span>{{ currentLangInfo.nativeName }}</span>
                <svg
                    class="w-4 h-4 transition-transform duration-200"
                    :class="{ 'rotate-180': isOpen }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    ></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div
                v-if="isOpen"
                class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50"
                @click.stop
            >
                <div class="py-1">
                    <button
                        v-for="lang in supportedLanguages"
                        :key="lang.code"
                        @click="changeLanguage(lang.code)"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors"
                        :class="{
                            'bg-brand-light text-brand-primary':
                                currentLanguage === lang.code,
                        }"
                    >
                        <span class="flex-1 text-left">{{
                            lang.nativeName
                        }}</span>
                        <span class="text-xs text-gray-500 ml-2">{{
                            lang.name
                        }}</span>
                        <svg
                            v-if="currentLanguage === lang.code"
                            class="w-4 h-4 ml-2 text-brand-primary"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Backdrop -->
        <div
            v-if="isOpen"
            @click="closeDropdown"
            class="fixed inset-0 z-40"
        ></div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useI18n } from "../composables/useI18n.js";

const { currentLanguage, currentLangInfo, supportedLanguages, setLanguage } =
    useI18n();

const isOpen = ref(false);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const closeDropdown = () => {
    isOpen.value = false;
};

const changeLanguage = async (langCode) => {
    if (langCode !== currentLanguage.value) {
        await setLanguage(langCode);
        // Don't reload the page - let Vue handle the updates
    }
    closeDropdown();
};

// Close dropdown when clicking outside
onMounted(() => {
    document.addEventListener("click", (e) => {
        if (!e.target.closest(".language-switcher")) {
            closeDropdown();
        }
    });
});
</script>

<style scoped>
.language-switcher {
    position: relative;
}

/* RTL Support */
[dir="rtl"] .language-switcher .absolute {
    right: auto;
    left: 0;
}

[dir="rtl"] .language-switcher .flex-1 {
    text-align: right;
}
</style>
