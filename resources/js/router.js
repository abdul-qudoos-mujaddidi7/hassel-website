import { createRouter, createWebHistory } from "vue-router";
// Eager-load Home for fastest first paint
import Home from "./Home.vue";
// Lazy-load all other routes to reduce initial bundle size
const Work = () => import("./Work.vue");
const Resources = () => import("./Resources.vue");
const Careers = () => import("./Careers.vue");
const Contact = () => import("./Contact.vue");
// New: Training Programs (list + detail)
const TrainingPrograms = () => import("./TrainingPrograms.vue");
const TrainingProgramDetail = () => import("./TrainingProgramDetail.vue");
// Admin routes
const AdminLogin = () => import("./admin/LoginApp.vue");
const AdminDashboard = () => import("./admin/AdminApp.vue");
const AgriTechTools = () => import("./AgriTechTools.vue");
const AgriTechToolDetail = () => import("./AgriTechToolDetail.vue");
const MarketAccessPrograms = () => import("./MarketAccessPrograms.vue");
const MarketAccessProgramDetail = () =>
    import("./MarketAccessProgramDetail.vue");
const SmartFarming = () => import("./SmartFarming.vue");
const SmartFarmingDetail = () => import("./SmartFarmingDetail.vue");
const SeedSupply = () => import("./SeedSupply.vue");
const SeedSupplyDetail = () => import("./SeedSupplyDetail.vue");
const CommunityPrograms = () => import("./CommunityPrograms.vue");
const CommunityProgramDetail = () => import("./CommunityProgramDetail.vue");
const EnvironmentalProjects = () => import("./EnvironmentalProjects.vue");
const EnvironmentalProjectDetail = () =>
    import("./EnvironmentalProjectDetail.vue");
const NewsDetail = () => import("./NewsDetail.vue");
const NotFound = () => import("./NotFound.vue");

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: "/", component: Home },
        // About removed; content consolidated into Home
        { path: "/our-work", component: Work },
        { path: "/training-programs", component: TrainingPrograms },
        {
            path: "/training-programs/:idOrSlug",
            component: TrainingProgramDetail,
        },
        { path: "/agri-tech", component: AgriTechTools },
        {
            path: "/agri-tech/:idOrSlug",
            component: AgriTechToolDetail,
        },
        { path: "/market-access", component: MarketAccessPrograms },
        {
            path: "/market-access/:idOrSlug",
            component: MarketAccessProgramDetail,
        },
        { path: "/smart-farming", component: SmartFarming },
        {
            path: "/smart-farming/:idOrSlug",
            component: SmartFarmingDetail,
        },
        { path: "/seed-supply", component: SeedSupply },
        {
            path: "/seed-supply/:idOrSlug",
            component: SeedSupplyDetail,
        },
        { path: "/community-programs", component: CommunityPrograms },
        {
            path: "/community-programs/:idOrSlug",
            component: CommunityProgramDetail,
        },
        { path: "/environmental-projects", component: EnvironmentalProjects },
        {
            path: "/environmental-projects/:idOrSlug",
            component: EnvironmentalProjectDetail,
        },
        { path: "/agri-tech-tools", component: AgriTechTools },
        { path: "/resources", component: Resources },
        { path: "/careers", component: Careers },
        { path: "/contact", component: Contact },
        // Admin routes
        { path: "/admin/login", component: AdminLogin },
        { path: "/admin", component: AdminDashboard },
        { path: "/admin/*", component: AdminDashboard },
        // News detail route
        { path: "/news/:slug", component: NewsDetail, name: "news-detail" },
        // 404 catch-all route
        { path: "/:pathMatch(.*)*", component: NotFound },
    ],
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { left: 0, top: 0, behavior: "smooth" };
        }
    },
});

// Map for prefetching dynamic imports
export const routePrefetchMap = {
    "/our-work": () => import("./Work.vue"),
    "/resources": () => import("./Resources.vue"),
    "/careers": () => import("./Careers.vue"),
    "/contact": () => import("./Contact.vue"),
    "/training-programs": () => import("./TrainingPrograms.vue"),
    "/training-programs/:idOrSlug": () => import("./TrainingProgramDetail.vue"),
    "/agri-tech": () => import("./AgriTechTools.vue"),
    "/agri-tech/:idOrSlug": () => import("./AgriTechToolDetail.vue"),
    "/market-access": () => import("./MarketAccessPrograms.vue"),
    "/market-access/:idOrSlug": () => import("./MarketAccessProgramDetail.vue"),
    "/smart-farming": () => import("./SmartFarming.vue"),
    "/smart-farming/:idOrSlug": () => import("./SmartFarmingDetail.vue"),
    "/seed-supply": () => import("./SeedSupply.vue"),
    "/seed-supply/:idOrSlug": () => import("./SeedSupplyDetail.vue"),
    "/community-programs": () => import("./CommunityPrograms.vue"),
    "/community-programs/:idOrSlug": () =>
        import("./CommunityProgramDetail.vue"),
    "/environmental-projects": () => import("./EnvironmentalProjects.vue"),
    "/environmental-projects/:idOrSlug": () =>
        import("./EnvironmentalProjectDetail.vue"),
    "/agri-tech-tools": () => import("./AgriTechTools.vue"),
};

export default router;
