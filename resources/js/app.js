import { createApp } from "vue";
import "./bootstrap.js";
import "../css/app.css";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";
import "vuetify/styles";
import vuetify from "../plugins/vuetify";
import router from "./router.js";
import App from "./App.vue";

const app = createApp(App);
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

app.use(router);
app.use(vuetify);
app.use(pinia);

app.mount("#app");
