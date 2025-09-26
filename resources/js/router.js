import { createRouter, createWebHistory } from "vue-router";
// Eager-load Home for fastest first paint
import Home from "./Home.vue";
// Lazy-load all other routes to reduce initial bundle size
const About = () => import("./About.vue");
const Work = () => import("./Work.vue");
const Resources = () => import("./Resources.vue");
const Careers = () => import("./Careers.vue");
const Contact = () => import("./Contact.vue");
// New: Training Programs (list + detail)
const TrainingPrograms = () => import("./TrainingPrograms.vue");
const TrainingProgramDetail = () => import("./TrainingProgramDetail.vue");

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: "/", component: Home },
        { path: "/about", component: About },
        { path: "/our-work", component: Work },
        { path: "/training-programs", component: TrainingPrograms },
        {
            path: "/training-programs/:idOrSlug",
            component: TrainingProgramDetail,
        },
        { path: "/resources", component: Resources },
        { path: "/careers", component: Careers },
        { path: "/contact", component: Contact },
    ],
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { left: 0, top: 0, behavior: "smooth" };
        }
    },
});

export default router;
