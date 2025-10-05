import { createRouter, createWebHistory } from "vue-router";
import { useAuthRepository } from "../stores/Auth.js";

// Admin Components
const AdminLayout = () => import("./layouts/AdminLayout.vue");
const Dashboard = () => import("./pages/Dashboard.vue");
const NewsManagement = () => import("./pages/news/News.vue");
const TrainingProgramsManagement = () => import("./pages/training/TrainingPrograms.vue");
const PublicationsManagement = () => import("./pages/publications/Publications.vue");
const SuccessStoriesManagement = () => import("./pages/success-stories/SuccessStories.vue");
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
                { path: "training-programs", name: "admin.training-programs", component: TrainingProgramsManagement, meta: { title: "Training Programs" } },
                { path: "publications", name: "admin.publications", component: PublicationsManagement, meta: { title: "Publications" } },
                { path: "success-stories", name: "admin.success-stories", component: SuccessStoriesManagement, meta: { title: "Success Stories" } },
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
