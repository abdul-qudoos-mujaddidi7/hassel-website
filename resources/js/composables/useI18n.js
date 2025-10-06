import { ref, computed } from "vue";
import en from "../i18n/en.js";
import fa from "../i18n/fa.js";
import ps from "../i18n/ps.js";

// Current language state
const currentLanguage = ref("en");
const translations = ref({});
const isLoading = ref(false);

// Supported languages
export const supportedLanguages = [
    { code: "en", name: "English", nativeName: "English" },
    { code: "farsi", name: "Farsi", nativeName: "دری" },
    { code: "pashto", name: "Pashto", nativeName: "پښتو" },
];

// Static translations loaded from separate files
const defaultTranslations = {
    en,
    farsi: fa,
    pashto: ps,
};

export function useI18n() {
    // Get translation for a key
    const t = (key, params = {}) => {
        const translation =
            translations.value[currentLanguage.value]?.[key] ||
            defaultTranslations[currentLanguage.value]?.[key] ||
            defaultTranslations.en[key] ||
            key;

        // Debug logging removed

        // Replace parameters in translation
        return Object.keys(params).reduce((str, param) => {
            return str.replace(`{${param}}`, params[param]);
        }, translation);
    };

    // Change language
    const setLanguage = async (lang) => {
        if (!supportedLanguages.find((l) => l.code === lang)) {
            console.warn(`Language ${lang} is not supported`);
            return;
        }

        currentLanguage.value = lang;

        // Store in localStorage
        localStorage.setItem("preferred_language", lang);

        // Load translations for the language
        await loadTranslations(lang);

        // Update document language
        document.documentElement.lang = lang;
        // Direction: set RTL for Farsi/Pashto
        const isRtl = ["farsi", "pashto"].includes(lang);
        document.documentElement.dir = isRtl ? "rtl" : "ltr";

        // Notify app to refetch data as needed
        try {
            window.dispatchEvent(
                new CustomEvent("language:changed", { detail: { lang } })
            );
        } catch (_) {}
    };

    // Subscribe utility
    const onLanguageChange = (handler) => {
        window.addEventListener("language:changed", handler);
        return () => window.removeEventListener("language:changed", handler);
    };

    // Load translations (simplified - no API calls)
    const loadTranslations = async (lang) => {
        isLoading.value = true;
        // Use default translations directly
        translations.value[lang] =
            defaultTranslations[lang] || defaultTranslations.en;
        isLoading.value = false;
    };

    // Initialize i18n
    const init = async () => {
        // Get language from localStorage or browser
        const savedLang = localStorage.getItem("preferred_language");
        const browserLang = navigator.language.split("-")[0];

        const lang =
            savedLang ||
            supportedLanguages.find((l) => l.code === browserLang)?.code ||
            "en";

        await setLanguage(lang);
    };

    // Get current language info
    const currentLangInfo = computed(() => {
        return (
            supportedLanguages.find((l) => l.code === currentLanguage.value) ||
            supportedLanguages[0]
        );
    });

    // Check if RTL language (temporarily disabled to prevent layout issues)
    const isRTL = computed(() => {
        return false; // Disable RTL for now to prevent layout issues
        // return ["farsi", "pashto"].includes(currentLanguage.value);
    });

    return {
        // State
        currentLanguage: computed(() => currentLanguage.value),
        currentLangInfo,
        isLoading: computed(() => isLoading.value),
        isRTL,
        supportedLanguages,

        // Methods
        t,
        setLanguage,
        loadTranslations,
        init,
        onLanguageChange,
    };
}
