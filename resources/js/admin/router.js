import { createRouter, createWebHistory } from "vue-router";
import { useAuthRepository } from "../stores/Auth.js";

// Admin Components
const AdminLayout = () => import("./layouts/AdminLayout.vue");
const Dashboard = () => import("./pages/Dashboard.vue");
const NewsManagement = () => import("./pages/content/NewsManagement.vue");
const ProgramsManagement = () => import("./pages/content/ProgramsManagement.vue");
const TrainingProgramsManagement = () => import("./pages/content/TrainingProgramsManagement.vue");
const AgriTechToolsManagement = () => import("./pages/content/AgriTechToolsManagement.vue");
const MarketAccessManagement = () => import("./pages/content/MarketAccessManagement.vue");
const SmartFarmingManagement = () => import("./pages/content/SmartFarmingManagement.vue");
const SeedSupplyManagement = () => import("./pages/content/SeedSupplyManagement.vue");
const CommunityProgramsManagement = () => import("./pages/content/CommunityProgramsManagement.vue");
const EnvironmentalProjectsManagement = () => import("./pages/content/EnvironmentalProjectsManagement.vue");
const PublicationsManagement = () => import("./pages/content/PublicationsManagement.vue");
const SuccessStoriesManagement = () => import("./pages/content/SuccessStoriesManagement.vue");
const GalleriesManagement = () => import("./pages/content/GalleriesManagement.vue");
const JobsManagement = () => import("./pages/content/JobsManagement.vue");
const UsersManagement = () => import("./pages/users/UsersManagement.vue");
const ContactsManagement = () => import("./pages/system/ContactsManagement.vue");
const RegistrationsManagement = () => import("./pages/system/RegistrationsManagement.vue");
const SettingsManagement = () => import("./pages/system/SettingsManagement.vue");
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
                { path: "news", name: "admin.news", component: NewsManagement, meta: { title: "News Management" } },
                { path: "programs", name: "admin.programs", component: ProgramsManagement, meta: { title: "Programs Management" } },
                { path: "training-programs", name: "admin.training-programs", component: TrainingProgramsManagement, meta: { title: "Training Programs" } },
                { path: "agri-tech-tools", name: "admin.agri-tech-tools", component: AgriTechToolsManagement, meta: { title: "Agri-Tech Tools" } },
                { path: "market-access", name: "admin.market-access", component: MarketAccessManagement, meta: { title: "Market Access Programs" } },
                { path: "smart-farming", name: "admin.smart-farming", component: SmartFarmingManagement, meta: { title: "Smart Farming Programs" } },
                { path: "seed-supply", name: "admin.seed-supply", component: SeedSupplyManagement, meta: { title: "Seed Supply Programs" } },
                { path: "community-programs", name: "admin.community-programs", component: CommunityProgramsManagement, meta: { title: "Community Programs" } },
                { path: "environmental-projects", name: "admin.environmental-projects", component: EnvironmentalProjectsManagement, meta: { title: "Environmental Projects" } },
                { path: "publications", name: "admin.publications", component: PublicationsManagement, meta: { title: "Publications" } },
                { path: "success-stories", name: "admin.success-stories", component: SuccessStoriesManagement, meta: { title: "Success Stories" } },
                { path: "galleries", name: "admin.galleries", component: GalleriesManagement, meta: { title: "Galleries" } },
                { path: "jobs", name: "admin.jobs", component: JobsManagement, meta: { title: "Job Announcements" } },
                // User Management Routes
                { path: "users", name: "admin.users", component: UsersManagement, meta: { title: "Users Management" } },
                // System Management Routes
                { path: "contacts", name: "admin.contacts", component: ContactsManagement, meta: { title: "Contacts Management" } },
                { path: "registrations", name: "admin.registrations", component: RegistrationsManagement, meta: { title: "Registrations Management" } },
                { path: "settings", name: "admin.settings", component: SettingsManagement, meta: { title: "Settings Management" } },
                // Statistics Routes
                { path: "beneficiaries-stats", name: "admin.beneficiaries-stats", component: BeneficiariesStats, meta: { title: "Beneficiaries Statistics" } },
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
