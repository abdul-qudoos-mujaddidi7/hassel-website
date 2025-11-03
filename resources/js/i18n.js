// src/i18n/index.js or plugins/i18n.js
import { createI18n } from "vue-i18n";
import en from "./locales/en.json";
import fa from "./locales/fa.json";
import ps from "./locales/ps.json";

// Load locale from localStorage or default to "en"
const savedLocale = localStorage.getItem("locale") || "en";

const i18n = createI18n({
  legacy: false,
  locale: savedLocale,
  fallbackLocale: "en",
  messages: {
    en,
    fa,
    ps,
  },
});

export default i18n;
