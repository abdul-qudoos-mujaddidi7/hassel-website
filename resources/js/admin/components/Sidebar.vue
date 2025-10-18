<template>
    <div class="sidebar-container">
        <!-- Logo Section -->
        <div class="logo-section">
            <router-link to="/admin/dashboard" class="logo-link">
                <div class="logo-container">
                    <v-avatar size="60" class="logo-avatar">
                        <img :src="logo" alt="Logo" class="logo-image" />
                    </v-avatar>
                </div>
            </router-link>
        </div>

        <!-- Navigation Section -->
        <div class="navigation-section">
            <router-link to="/admin/dashboard" exact @click="closeAllMenus">
                <v-list-item
                    active-class="active-item"
                    value="home"
                    prepend-icon="mdi mdi-home-lightning-bolt-outline"
                    class="nav-item"
                >
                    {{ $t('dashboard') }}
                </v-list-item>
            </router-link>

            <router-link
                to="/admin/beneficiaries-stats"
                exact
                @click="closeAllMenus"
            >
                <v-list-item
                    active-class="active-item"
                    prepend-icon="mdi mdi-chart-line"
                    value="beneficiaries-stats"
                    class="nav-item"
                >
                    {{ $t('beneficiaries_stats') }}
                </v-list-item>
            </router-link>

            <!-- News -->
            <router-link to="/admin/news" exact @click="closeAllMenus">
                <v-list-item
                    active-class="active-item"
                    prepend-icon="mdi-newspaper-variant-outline"
                    value="news"
                    class="nav-item"
                >
                    {{ $t('news') }}
                </v-list-item>
            </router-link>

            <!-- Training Programs -->
            <router-link
                to="/admin/training-programs"
                exact
                @click="closeAllMenus"
            >
                <v-list-item
                    active-class="active-item"
                    prepend-icon="mdi-school-outline"
                    value="training-programs"
                    class="nav-item"
                >
                    {{ $t('training_programs') }}
                </v-list-item>
            </router-link>

            <!-- Publications -->
            <router-link to="/admin/publications" exact @click="closeAllMenus">
                <v-list-item
                    active-class="active-item"
                    prepend-icon="mdi-book-outline"
                    value="publications"
                    class="nav-item"
                >
                    {{ $t('publications') }}
                </v-list-item>
            </router-link>

            <!-- Success Stories -->
            <router-link
                to="/admin/success-stories"
                exact
                @click="closeAllMenus"
            >
                <v-list-item
                    active-class="active-item"
                    prepend-icon="mdi-trophy-outline"
                    value="success-stories"
                    class="nav-item"
                >
                    {{ $t('success_stories') }}
                </v-list-item>
            </router-link>

            <!-- Job Announcements -->
            <router-link
                to="/admin/job-announcements"
                exact
                @click="closeAllMenus"
            >
                <v-list-item
                    active-class="active-item"
                    prepend-icon="mdi-briefcase-outline"
                    value="job-announcements"
                    class="nav-item"
                >
                    {{ $t('job_announcements') }}
                </v-list-item>
            </router-link>

            <!-- Contacts -->
            <router-link to="/admin/contacts" exact @click="closeAllMenus">
                <v-list-item
                    active-class="active-item"
                    prepend-icon="mdi-account-group-outline"
                    value="contacts"
                    class="nav-item"
                >
                    {{ $t('contacts') }}
                </v-list-item>
            </router-link>

            <v-list-item
                active-class="active-item"
                prepend-icon="mdi-finance"
                value="Reports"
                @click="toggleMenu('reports')"
                class="nav-item"
            >
                {{ $t('reports') }}
                <template v-slot:append>
                    <v-icon
                        :class="{ 'rotate-180': activeMenu === 'reports' }"
                        class="transition-transform duration-300"
                    >
                        mdi-chevron-down
                    </v-icon>
                </template>
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="activeMenu === 'reports'" class="submenu">
                    <router-link
                        v-for="item in reportItems"
                        :key="item.to"
                        :to="item.to"
                        @click="closeAllMenus"
                    >
                        <v-list-item
                            :title="$t(item.title)"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            active-class="active-subitem"
                            class="submenu-item"
                        />
                    </router-link>
                </v-list>
            </transition>

            <v-list-item
                active-class="active-item"
                prepend-icon="mdi-cog-outline"
                value="Setting"
                @click="toggleMenu('setting')"
                class="nav-item"
            >
                {{ $t('settings') }}
                <template v-slot:append>
                    <v-icon
                        :class="{ 'rotate-180': activeMenu === 'setting' }"
                        class="transition-transform duration-300"
                    >
                        mdi-chevron-down
                    </v-icon>
                </template>
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="activeMenu === 'setting'" class="submenu">
                    <router-link
                        v-for="item in settingItems"
                        :key="item.to"
                        :to="item.to"
                        @click="closeAllMenus"
                    >
                        <v-list-item
                            :title="$t(item.title)"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            active-class="active-subitem"
                            class="submenu-item"
                        />
                    </router-link>
                </v-list>
            </transition>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useAuthRepository } from "../../stores/Auth.js";
import { useI18n } from "vue-i18n";
const { t, locale } = useI18n();
const authStore = useAuthRepository();

// Load user data from session when component mounts
onMounted(() => {
    authStore.loadFromSession();
});
const logo = "https://via.placeholder.com/150"; // replace with your logo

const activeMenu = ref(null);

const toggleMenu = (menu) => {
    // If clicking the same menu, toggle it
    if (activeMenu.value === menu) {
        activeMenu.value = null;
    } else {
        // If clicking a different menu, close all others and open this one
        activeMenu.value = menu;
    }
};

const closeAllMenus = () => {
    activeMenu.value = null;
};

const settingItems = [
    {
        to: "/admin/systemSetting",
        title: "System Settings",
        icon: "mdi mdi-circle-medium",
        value: "system",
    },
    {
        to: "/admin/moneyAcc",
        title: "Money Account",
        icon: "mdi mdi-circle-medium",
        value: "moneyAcc",
    },
    {
        to: "/admin/rolePermissions",
        title: "Role & Permissions",
        icon: "mdi mdi-circle-medium",
        value: "roles",
    },
    {
        to: "/admin/service",
        title: "Service",
        icon: "mdi mdi-circle-medium",
        value: "service",
    },
    {
        to: "/admin/dental-types",
        title: "Dental Types",
        icon: "mdi mdi-circle-medium",
        value: "Dental",
    },
];

const reportItems = [
    {
        to: "/admin/profitLoss",
        title: "Profit & Loss",
        icon: "mdi mdi-circle-medium",
        value: "profit",
    },
    {
        to: "/admin/patientsReport",
        title: "Patients Report",
        icon: "mdi mdi-circle-medium",
        value: "patientsReport",
    },
    {
        to: "/admin/categoryReport",
        title: "Expense Category",
        icon: "mdi mdi-circle-medium",
        value: "catReport",
    },
    {
        to: "/admin/productReport",
        title: "Expense Product",
        icon: "mdi mdi-circle-medium",
        value: "expenseProReport",
    },
    {
        to: "/admin/serviceReport",
        title: "Service Report",
        icon: "mdi mdi-circle-medium",
        value: "serviceReport",
    },
];

function handleDrawerState(isOpen) {
    document.body.style.overflow = isOpen ? "hidden" : "";
}

const dir = computed(() => {
    return ["fa", "ps"].includes(locale.value) ? "rtl" : "ltr";
});

</script>

<style scoped>
/* Use Vuetify theme colors */
.sidebar-container {
    display: flex;
    flex-direction: column;
    height: 100vh;
    min-height: 100vh;
    max-height: 100vh;
    background: rgb(var(--v-theme-sidebar-bg));
    overflow: hidden;
    color: rgb(var(--v-theme-on-surface));
    position: relative;
   
}




/* Logo Section */
.logo-section {
    padding: 1rem 0;
}

.logo-link {
    display: block;
    text-decoration: none;
}

.logo-container {
    display: flex;
    align-items: center;
    flex-direction: column;
}

.logo-avatar {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 3px solid #fff;
    background: #fff;
}

.logo-avatar:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

.logo-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.logo-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: rgb(var(--v-theme-primary));
    text-align: center;
}

/* Navigation Section */
.navigation-section {
    flex: 1;
    padding: 0.5rem 0.5rem;
    overflow-y: auto;
}

.navigation-section::-webkit-scrollbar {
    width: 4px;
}

.navigation-section::-webkit-scrollbar-track {
    background: transparent;
}

.navigation-section::-webkit-scrollbar-thumb {
    background: rgb(var(--v-theme-accent));
    border-radius: 4px;
}

.navigation-section::-webkit-scrollbar-thumb:hover {
    background: rgb(var(--v-theme-secondary));
}

/* Navigation Items */
.nav-item {
    border-radius: 8px !important;
    margin: 4px 8px !important;
    transition: all 0.3s ease !important;
    color: rgb(var(--v-theme-on-surface)) !important;
    position: relative;
}

.nav-item:hover {
    background-color: #f4f4f5  !important;
    /* color: rgb(var(--v-theme-primary)) !important; */
    transform: translateX(2px);
}

.nav-item:hover .v-icon {
    color: rgb(var(--v-theme-primary)) !important;
}

/* Active Item States */
.active-item {
    background: linear-gradient(
        135deg,
        rgb(var(--v-theme-primary)),
        rgb(var(--v-theme-secondary))
    ) !important;
    color: rgb(var(--v-theme-on-primary)) !important;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(var(--v-theme-primary), 0.3);
    position: relative;
}

.active-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: rgb(var(--v-theme-accent));
    border-radius: 0 2px 2px 0;
}

.active-item .v-icon {
    color: rgb(var(--v-theme-on-primary)) !important;
}

/* Router Link Active State */
.router-link-active .nav-item {
    background: #f4f4f5 !important;
    color: #388e3c !important;
    position: relative;
}

.router-link-active .nav-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #388e3c;
}

.router-link-active .nav-item .v-icon {
    color: #388e3c !important;
}

/* Submenus */
.submenu {
    padding-left: 1.5rem;
    margin: 0.25rem 0;
}

.submenu-item {
    border-radius: 6px !important;
    margin: 2px 0 !important;
    padding-left: 0.5rem !important;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    color: rgb(var(--v-theme-on-surface-variant)) !important;
}

.submenu-item:hover {
    background-color: rgba(var(--v-theme-accent), 0.2) !important;
    color: rgb(var(--v-theme-primary)) !important;
    transform: translateX(2px);
}

.active-subitem {
    background-color: rgb(var(--v-theme-accent)) !important;
    color: rgb(var(--v-theme-on-primary)) !important;
    font-weight: 500;
    border-left: 3px solid rgb(var(--v-theme-primary)) !important;
    position: relative;
}

.active-subitem::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: rgb(var(--v-theme-primary));
 
}

/* Menu Transitions */
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

.rotate-180 {
    transform: rotate(180deg);
}
</style>
