import { createApp } from "vue";
import "./bootstrap.js";
import "../css/app.css";
import { createPinia } from "pinia";
import "vuetify/styles";
import vuetify from "./plugins/vuetify";
import router from "./router.js";
import App from "./App.vue";
import { createI18n } from 'vue-i18n';

// i18n configuration
const i18n = createI18n({
    locale: 'en',
    fallbackLocale: 'en',
    messages: {
        en: {
            welcome: 'Welcome',
            login_with_email: 'Login with your email',
            email_id: 'Email',
            password: 'Password',
            login: 'Login',
            select_language: 'Select Language',
            language_switcher: 'Language Switcher',
            english: 'English',
            dari: 'Dari',
            pashto: 'Pashto',
            validations: {
                email_required: 'Email is required',
                email_invalid: 'Email must be valid',
                password_required: 'Password is required',
                password_min: 'Password must be at least 6 characters'
            }
        },
        fa: {
            welcome: 'خوش آمدید',
            login_with_email: 'با ایمیل خود وارد شوید',
            email_id: 'ایمیل',
            password: 'رمز عبور',
            login: 'ورود',
            select_language: 'انتخاب زبان',
            language_switcher: 'تغییر زبان',
            english: 'انگلیسی',
            dari: 'دری',
            pashto: 'پشتو',
            validations: {
                email_required: 'ایمیل الزامی است',
                email_invalid: 'ایمیل باید معتبر باشد',
                password_required: 'رمز عبور الزامی است',
                password_min: 'رمز عبور باید حداقل 6 کاراکتر باشد'
            }
        },
        ps: {
            welcome: 'ښه راغلاست',
            login_with_email: 'د خپل ایمیل سره ننوځئ',
            email_id: 'ایمیل',
            password: 'پټنوم',
            login: 'ننوتل',
            select_language: 'ژبه وټاکئ',
            language_switcher: 'د ژبې بدلون',
            english: 'انګلیسي',
            dari: 'دری',
            pashto: 'پښتو',
            validations: {
                email_required: 'ایمیل اړین دی',
                email_invalid: 'ایمیل باید سم وي',
                password_required: 'پټنوم اړین دی',
                password_min: 'پټنوم باید لږ تر لږه 6 حروف وي'
            }
        }
    }
});

const pinia = createPinia();
const app = createApp(App);

app.use(pinia);
app.use(router);
app.use(vuetify);
app.use(i18n);

app.mount("#app");
