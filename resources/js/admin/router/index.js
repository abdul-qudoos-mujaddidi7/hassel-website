import { createRouter, createWebHistory } from 'vue-router';
import DashboardLayout from '../layouts/DashboardLayout.vue';
import DashboardHome from '../views/DashboardHome.vue';
import AnalyticsView from '../views/AnalyticsView.vue';

const router = createRouter({
  history: createWebHistory('/admin'),
  routes: [
    {
      path: '/',
      component: DashboardLayout,
      children: [
        {
          path: '',
          name: 'admin.dashboard',
          component: DashboardHome,
        },
        {
          path: 'analytics',
          name: 'admin.analytics',
          component: AnalyticsView,
        },
      ],
    },
  ],
});

export default router;

