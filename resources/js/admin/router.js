import { createRouter, createWebHistory } from "vue-router";
import { useAuthRepository } from "../stores/Auth.js";

// Admin Components
const AdminLayout = () => import("./layouts/AdminLayout.vue");
const Dashboard = () => import("./pages/Dashboard.vue");
const NewsManagement = () => import("./pages/news/News.vue");
const TrainingProgramsManagement = () => import("./pages/training-programs/TrainingPrograms.vue");
const SmartFarmingProgramsManagement = () => import("./pages/smart-farming-programs/SmartFarmingPrograms.vue");
const SeedSupplyProgramsManagement = () => import("./pages/seed-supply-programs/SeedSupplyPrograms.vue");
const MarketAccessProgramsManagement = () => import("./pages/market-access-programs/MarketAccessPrograms.vue");
const EnvironmentalProjectsManagement = () => import("./pages/environmental-projects/EnvironmentalProjects.vue");
const CommunityProgramsManagement = () => import("./pages/community-programs/CommunityPrograms.vue");
const AgriTechToolsManagement = () => import("./pages/agri-tech-tools/AgriTechTools.vue");
const PublicationsManagement = () => import("./pages/publications/Publications.vue");
const SuccessStoriesManagement = () => import("./pages/success-stories/SuccessStories.vue");
const JobAnnouncementsManagement = () => import("./pages/job-announcements/JobAnnouncements.vue");
const BeneficiariesStats = () => import("./pages/states/BeneficiariesStats.vue");
const AdminLogin = () => import("./pages/auth/AdminLogin.vue");

const router = createRouter({
    history: createWebHistory(),
    routes: [
        // Admin Login Route
        {
            path: "/admin/login",
            name: "admin.login",
            component: AdminLogin,
            meta: { requiresGuest: true }
        },
        // Admin Dashboard and Management Routes
        {
            path: "/admin",
            component: AdminLayout,
            
            meta: { requiresAuth: true },
            children: [
                {
                    path: "",
                    name: "admin.dashboard",
                    component: Dashboard,
                    meta: { title: "Dashboard" }
                },
                // Content Management Routes
                { path: "news", name: "admin.news", component: NewsManagement, meta: { title: "news_management" } },
                // Program Management Routes
                { path: "training-programs", name: "admin.training-programs", component: TrainingProgramsManagement, meta: { title: "training_programs_management" } },
                { path: "smart-farming-programs", name: "admin.smart-farming-programs", component: SmartFarmingProgramsManagement, meta: { title: "smart_farming_programs_management" } },
                { path: "seed-supply-programs", name: "admin.seed-supply-programs", component: SeedSupplyProgramsManagement, meta: { title: "seed_supply_programs_management" } },
                { path: "market-access-programs", name: "admin.market-access-programs", component: MarketAccessProgramsManagement, meta: { title: "market_access_programs_management" } },
                { path: "environmental-projects", name: "admin.environmental-projects", component: EnvironmentalProjectsManagement, meta: { title: "environmental_projects_management" } },
                { path: "community-programs", name: "admin.community-programs", component: CommunityProgramsManagement, meta: { title: "community_programs_management" } },
                { path: "agri-tech-tools", name: "admin.agri-tech-tools", component: AgriTechToolsManagement, meta: { title: "agri_tech_tools_management" } },
                // Other Content Routes
                { path: "publications", name: "admin.publications", component: PublicationsManagement, meta: { title: "publications_management" } },
                { path: "success-stories", name: "admin.success-stories", component: SuccessStoriesManagement, meta: { title: "success_stories_management" } },
                { path: "job-announcements", name: "admin.job-announcements", component: JobAnnouncementsManagement, meta: { title: "job_announcements_management" } },
                // Statistics Routes
                { path: "beneficiaries-stats", name: "admin.beneficiaries-stats", component: BeneficiariesStats, meta: { title: "beneficiaries_stats_management" } },
            ]
        }
    ]
});

// Navigation guard for authentication
router.beforeEach((to, from, next) => {
    const authStore = useAuthRepository();
    
    // Check if route requires authentication
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next('/admin/login');
        return;
    }
    
    // Check if route requires guest (like login page)
    if (to.meta.requiresGuest && authStore.isAuthenticated) {
        next('/admin');
        return;
    }
    
    next();
});

export default router;
