import { createRouter, createWebHistory } from "vue-router";

// Main Website Components
import Home from "./Home.vue";
// Lazy-load all other routes to reduce initial bundle size
const Work = () => import("./Work.vue");
const Resources = () => import("./Resources.vue");
const Careers = () => import("./Careers.vue");
const Contact = () => import("./Contact.vue");
const TrainingPrograms = () => import("./TrainingPrograms.vue");
const TrainingProgramDetail = () => import("./TrainingProgramDetail.vue");
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
const SuccessStoryDetail = () => import("./SuccessStoryDetail.vue");
const NotFound = () => import("./NotFound.vue");

const router = createRouter({
    history: createWebHistory(),
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        }
        if (to.hash) {
            return { el: to.hash, top: 0, behavior: "smooth" };
        }
        return { top: 0 };
    },
    routes: [
        // Main Website Routes
        { path: "/", component: Home },
        { path: "/our-work", component: Work },
        { path: "/training-programs", component: TrainingPrograms },
        {
            path: "/training-programs/:idOrSlug",
            component: TrainingProgramDetail,
        },
        { path: "/agri-tech", component: AgriTechTools },
        { path: "/agri-tech/:idOrSlug", component: AgriTechToolDetail },
        { path: "/market-access", component: MarketAccessPrograms },
        {
            path: "/market-access/:idOrSlug",
            component: MarketAccessProgramDetail,
        },
        { path: "/smart-farming", component: SmartFarming },
        { path: "/smart-farming/:idOrSlug", component: SmartFarmingDetail },
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
        {
            path: "/success-stories/:slug",
            component: SuccessStoryDetail,
            name: "success-story-detail",
        },
        { path: "/news/:slug", component: NewsDetail, name: "news-detail" },
        { path: "/careers", component: Careers },
        { path: "/contact", component: Contact },
    ],
});

export default router;
