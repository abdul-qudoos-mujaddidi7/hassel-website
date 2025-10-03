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
const MarketAccessProgramDetail = () => import("./MarketAccessProgramDetail.vue");
const SmartFarming = () => import("./SmartFarming.vue");
const SmartFarmingDetail = () => import("./SmartFarmingDetail.vue");
const SeedSupply = () => import("./SeedSupply.vue");
const SeedSupplyDetail = () => import("./SeedSupplyDetail.vue");

const router = createRouter({
    history: createWebHistory(),
    routes: [
        // Main Website Routes
        { path: "/", component: Home },
        { path: "/our-work", component: Work },
        { path: "/training-programs", component: TrainingPrograms },
        { path: "/training-programs/:idOrSlug", component: TrainingProgramDetail },
        { path: "/agri-tech", component: AgriTechTools },
        { path: "/agri-tech/:idOrSlug", component: AgriTechToolDetail },
        { path: "/market-access", component: MarketAccessPrograms },
        { path: "/market-access/:idOrSlug", component: MarketAccessProgramDetail },
        { path: "/smart-farming", component: SmartFarming },
        { path: "/smart-farming/:idOrSlug", component: SmartFarmingDetail },
        { path: "/seed-supply", component: SeedSupply },
        { path: "/seed-supply/:idOrSlug", component: SeedSupplyDetail },
        { path: "/agri-tech-tools", component: AgriTechTools },
        { path: "/resources", component: Resources },
        { path: "/careers", component: Careers },
        { path: "/contact", component: Contact },
    ]
});

export default router;