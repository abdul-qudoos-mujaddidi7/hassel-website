<template>
    <div class="sidebar-container" :dir="dir">
        <!-- Logo Section -->
        <div class="logo-section">
            <router-link to="/admin-zaki/dashboard" class="logo-link">
                <div class="logo-container">
                    <v-avatar size="60" class="logo-avatar">
                        <img :src="logo" alt="Logo" class="logo-image" />
                    </v-avatar>
                </div>
            </router-link>
        </div>

        <!-- Navigation Section -->
        <div class="navigation-section">
            <router-link to="/admin-zaki/dashboard" exact @click="closeAllMenus">
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
                to="/admin-zaki/beneficiaries-stats"
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
            <router-link to="/admin-zaki/news" exact @click="closeAllMenus">
                <v-list-item
                    active-class="active-item"
                    prepend-icon="mdi-newspaper-variant-outline"
                    value="news"
                    class="nav-item"
                >
                    {{ $t('news') }}
                </v-list-item>
            </router-link>

            <!-- Programs Section -->
            <v-list-item
                active-class="active-item"
                prepend-icon="mdi-format-list-bulleted"
                value="programs"
                @click="toggleMenu('programs')"
                class="nav-item"
            >
                {{ $t('programs') }}
                <template v-slot:append>
                    <v-icon
                        :class="{ 'rotate-180': activeMenu === 'programs' }"
                        class="transition-transform duration-300"
                    >
                        mdi-chevron-down
                    </v-icon>
                </template>
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="activeMenu === 'programs'" class="submenu programs-submenu">
                    <!-- Training Programs -->
                    <router-link
                        to="/admin-zaki/training-programs"
                        exact
                    >
                        <v-list-item
                            active-class="active-subitem"
                            prepend-icon="mdi mdi-circle-medium"
                            value="training-programs"
                            class="submenu-item"
                        >
                            {{ $t('training_programs') }}
                        </v-list-item>
                    </router-link>

                    <!-- Smart Farming Programs -->
                    <router-link
                        to="/admin-zaki/smart-farming-programs"
                        exact
                    >
                        <v-list-item
                            active-class="active-subitem"
                            prepend-icon="mdi mdi-circle-medium"
                            value="smart-farming-programs"
                            class="submenu-item"
                        >
                            {{ $t('smart_farming_programs') }}
                        </v-list-item>
                    </router-link>

                    <!-- Seed Supply Programs -->
                    <router-link
                        to="/admin-zaki/seed-supply-programs"
                        exact
                    >
                        <v-list-item
                            active-class="active-subitem"
                            prepend-icon="mdi mdi-circle-medium"
                            value="seed-supply-programs"
                            class="submenu-item"
                        >
                            {{ $t('seed_supply_programs') }}
                        </v-list-item>
                    </router-link>

                    <!-- Market Access Programs -->
                    <router-link
                        to="/admin-zaki/market-access-programs"
                        exact
                    >
                        <v-list-item
                            active-class="active-subitem"
                            prepend-icon="mdi mdi-circle-medium"
                            value="market-access-programs"
                            class="submenu-item"
                        >
                            {{ $t('market_access_programs') }}
                        </v-list-item>
                    </router-link>

                    <!-- Environmental Projects -->
                    <router-link
                        to="/admin-zaki/environmental-projects"
                        exact
                    >
                        <v-list-item
                            active-class="active-subitem"
                            prepend-icon="mdi mdi-circle-medium"
                            value="environmental-projects"
                            class="submenu-item"
                        >
                            {{ $t('environmental_projects') }}
                        </v-list-item>
                    </router-link>

                    <!-- Community Programs -->
                    <router-link
                        to="/admin-zaki/community-programs"
                        exact
                    >
                        <v-list-item
                            active-class="active-subitem"
                            prepend-icon="mdi mdi-circle-medium"
                            value="community-programs"
                            class="submenu-item"
                        >
                            {{ $t('community_programs') }}
                        </v-list-item>
                    </router-link>

                    <!-- Agri-Tech Tools -->
                    <router-link
                        to="/admin-zaki/agri-tech-tools"
                        exact
                    >
                        <v-list-item
                            active-class="active-subitem"
                            prepend-icon="mdi mdi-circle-medium"
                            value="agri-tech-tools"
                            class="submenu-item"
                        >
                            {{ $t('agri_tech_tools') }}
                        </v-list-item>
                    </router-link>
                </v-list>
            </transition>

            <!-- Publications -->
            <router-link to="/admin-zaki/publications" exact @click="closeAllMenus">
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
                to="/admin-zaki/success-stories"
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
                to="/admin-zaki/job-announcements"
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
            <router-link to="/admin-zaki/contacts" exact @click="closeAllMenus">
                <v-list-item
                    active-class="active-item"
                    prepend-icon="mdi-account-group-outline"
                    value="contacts"
                    class="nav-item"
                >
                    {{ $t('contacts') }}
                </v-list-item>
            </router-link>

            
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useAuthRepository } from "../../stores/Auth.js";
import { useI18n } from "vue-i18n";
import { useRoute } from "vue-router";
const { t, locale } = useI18n();
const authStore = useAuthRepository();
const route = useRoute();

// Load user data from session when component mounts
onMounted(() => {
    authStore.loadFromSession();
    // Check if current route is a program page and open Programs menu
    checkProgramRoute();
});

const logo = "https://via.placeholder.com/150"; // replace with your logo

const activeMenu = ref(null);

// Check if current route is a program page
const checkProgramRoute = () => {
    const programRoutes = [
        '/admin-zaki/training-programs',
        '/admin-zaki/smart-farming-programs', 
        '/admin-zaki/seed-supply-programs',
        '/admin-zaki/market-access-programs',
        '/admin-zaki/environmental-projects',
        '/admin-zaki/community-programs',
        '/admin-zaki/agri-tech-tools'
    ];
    
    if (programRoutes.includes(route.path)) {
        activeMenu.value = 'programs';
    }
};

// Watch for route changes to auto-open Programs menu
watch(() => route.path, () => {
    checkProgramRoute();
});

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





/* Navigation Items */
.nav-item {
    border-radius: 8px !important;
    margin: 4px 8px !important;
    transition: all 0.3s ease !important;
    color: rgb(var(--v-theme-on-surface)) !important;
    position: relative;
}

/* RTL languages (Dari, Pashto) - move left on hover */
[dir="rtl"] .nav-item:hover {
    background-color: #f4f4f5  !important;
    transform: translateX(-2px);
}

/* LTR languages (English) - move right on hover */
[dir="ltr"] .nav-item:hover {
    background-color: #f4f4f5  !important;
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
    top: 0;
    bottom: 0;
    width: 4px;
    background: rgb(var(--v-theme-accent));
}

/* RTL languages (Dari, Pashto) - border on right */
[dir="rtl"] .active-item::before {
    right: 0;
    border-radius: 2px 0 0 2px;
}

/* LTR languages (English) - border on left */
[dir="ltr"] .active-item::before {
    left: 0;
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
    top: 0;
    bottom: 0;
    width: 4px;
    background: #388e3c;
}

/* RTL languages (Dari, Pashto) - border on right */
[dir="rtl"] .router-link-active .nav-item::before {
    right: 0;
    border-radius: 2px 0 0 2px;
}

/* LTR languages (English) - border on left */
[dir="ltr"] .router-link-active .nav-item::before {
    left: 0;
    border-radius: 0 2px 2px 0;
}

.router-link-active .nav-item .v-icon {
    color: #388e3c !important;
}

/* Submenus */
[dir="rtl"] .submenu {
    padding-right: 1.5rem;
}

[dir="ltr"] .submenu {
    padding-left: 1.5rem;
}

.submenu {
    margin: 0.25rem 0;
}

.submenu-item {
    border-radius: 6px !important;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    color: rgb(var(--v-theme-on-surface)) !important;
    font-weight: 490;
}

[dir="rtl"] .submenu-item {
    padding-right: 0.5rem !important;
}

[dir="ltr"] .submenu-item {
    padding-left: 0.5rem !important;
}




/* Submenu hover - conditional based on direction */
/* RTL languages (Dari, Pashto) - move left on hover */
[dir="rtl"] .submenu-item:hover {
    background-color: #f4f4f5 !important;
    transform: translateX(-2px);
}

/* LTR languages (English) - move right on hover */
[dir="ltr"] .submenu-item:hover {
    background-color: #f4f4f5 !important;
    transform: translateX(2px);
}

.submenu-item:hover .v-icon {
    color: rgb(var(--v-theme-primary)) !important;
}

/* Submenu active - exact copy from parent router-link-active .nav-item */
.active-subitem {
    background: #f4f4f5 !important;
    color: #388e3c !important;
    position: relative;
}

.active-subitem::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #388e3c;
}

/* RTL languages (Dari, Pashto) - border on right */
[dir="rtl"] .active-subitem::before {
    right: 0;
    border-radius: 2px 0 0 2px;
}

/* LTR languages (English) - border on left */
[dir="ltr"] .active-subitem::before {
    left: 0;
    border-radius: 0 2px 2px 0;
}

.active-subitem .v-icon {
    color: #388e3c !important;
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
