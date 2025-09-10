import { createRouter, createWebHistory } from "vue-router";
import Home from "./Home.vue";
import About from "./About.vue";
import Work from "./Work.vue";
import Resources from "./Resources.vue";
import Careers from "./Careers.vue";
import Contact from "./Contact.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: "/", component: Home },
        { path: "/about", component: About },
        { path: "/our-work", component: Work },
        { path: "/resources", component: Resources },
        { path: "/careers", component: Careers },
        { path: "/contact", component: Contact },
    ],
});

export default router;
