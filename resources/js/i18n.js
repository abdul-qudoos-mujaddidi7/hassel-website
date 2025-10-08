// src/i18n/index.js or plugins/i18n.js
import { createI18n } from "vue-i18n";
import en from "./locales/en.json";
import fa from "./locales/fa.json";
import ps from "./locales/ps.json";

const i18n = createI18n({
  legacy: false,
  locale: "en", // or load from localStorage
  messages: {
    en,
    fa,
    ps,
  },
});

export default i18n;
