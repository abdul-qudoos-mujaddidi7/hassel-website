import { createApp } from "vue";
import "./bootstrap.js";
import "../css/admin.css";
import { createPinia } from "pinia";
import "vuetify/styles";
import vuetify from "./plugins/vuetify";
import router from "./admin/router.js";
import AdminApp from "./admin/App.vue";
import i18n from './i18n';

// i18n configuration (external JSON)


const pinia = createPinia();
const app = createApp(AdminApp);

app.use(pinia);
app.use(router);
app.use(vuetify);
app.use(i18n);

app.mount("#admin-app");
