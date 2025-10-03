<template>
    <div class="sidebar-container">
        <!-- Logo Section -->
        <div class="logo-section">
            <router-link to="/admin/dashboard" class="logo-link">
                <div class="logo-container">
                    <v-avatar size="60" class="logo-avatar">
                        <img
                            :src="logo"
                            alt="Logo"
                            class="logo-image"
                        />
                    </v-avatar>
                </div>
            </router-link>
        </div>

        <!-- Navigation Section -->
        <div class="navigation-section">
            <router-link to="/admin/dashboard">
                <v-list-item
                    active-class="bg-primaryOld text-white"
                    value="home"
                    prepend-icon="mdi mdi-home-lightning-bolt-outline"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    Dashboard
                </v-list-item>
            </router-link>

            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi mdi-gauge"
                value="lead"
                @click="toggleMenu('lead')"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                Leads
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-show="activeMenu === 'lead'" class="pl-4">
                    <router-link v-for="item in leadItems" :key="item.to" :to="item.to">
                        <v-list-item
                            :title="item.title"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            color="primaryOld"
                            class="child rounded-lg"
                        />
                    </router-link>
                </v-list>
            </transition>

            <router-link to="/admin/beneficiaries-stats">
                <v-list-item
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi mdi-chart-line"
                    value="beneficiaries-stats"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    Beneficiaries Stats
                </v-list-item>
            </router-link>

            <router-link to="/admin/cure">
                <v-list-item
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi-tooth-outline"
                    value="cure"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    Cure Cycle
                </v-list-item>
            </router-link>

            <router-link to="/admin/mainLaboratory">
                <v-list-item
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi-microscope"
                    value="in lab"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    Inbound Laboratory
                </v-list-item>
            </router-link>

            <router-link to="/admin/laboratory">
                <v-list-item
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi-test-tube"
                    value="out lab"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    Outbound Laboratory
                </v-list-item>
            </router-link>

            <v-list-item
                @click="toggleMenu('expense')"
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi-currency-usd-off"
                value="expense"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                Expenses
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="activeMenu === 'expense'" class="pl-4">
                    <router-link v-for="item in navItems" :key="item.to" :to="item.to">
                        <v-list-item
                            :title="item.title"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            color="primaryOld"
                            class="child rounded-lg"
                        />
                    </router-link>
                </v-list>
            </transition>

            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi mdi-card-account-details-outline"
                value="people"
                @click="toggleMenu('people')"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                People
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="activeMenu === 'people'" class="pl-4">
                    <router-link v-for="item in peopleItems" :key="item.to" :to="item.to">
                        <v-list-item
                            :title="item.title"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            color="primaryOld"
                            class="child rounded-lg"
                        />
                    </router-link>
                </v-list>
            </transition>

            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi-finance"
                value="Reports"
                @click="toggleMenu('reports')"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                Reports
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="activeMenu === 'reports'" class="pl-4">
                    <router-link v-for="item in reportItems" :key="item.to" :to="item.to">
                        <v-list-item
                            :title="item.title"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            color="primaryOld"
                            class="child rounded-lg"
                        />
                    </router-link>
                </v-list>
            </transition>

            <v-list-item
                active-class="bg-primaryOld text-white"
                prepend-icon="mdi-cog-outline"
                value="Setting"
                @click="toggleMenu('setting')"
                class="transition-all duration-300 cursor-pointer py-3 borderRadius"
            >
                Settings
            </v-list-item>
            <transition name="slide-fade">
                <v-list v-if="activeMenu === 'setting'" class="pl-4">
                    <router-link v-for="item in settingItems" :key="item.to" :to="item.to">
                        <v-list-item
                            :title="item.title"
                            :prepend-icon="item.icon"
                            :value="item.value"
                            color="primaryOld"
                            class="child rounded-lg"
                        />
                    </router-link>
                </v-list>
            </transition>
        </div>

        <!-- Profile Section - Positioned at the very end -->
        <div class="profile-section mt-auto">
            <hr class="profile-divider" />
            <div class="user-profile-item">
                <v-list-item
                    :prepend-avatar="user.photo"
                    :title="user.name"
                    :subtitle="user.email"
                    nav
                    class="px-4 py-3 cursor-pointer user-profile-card"
                    @click="dialog = true"
                />
            </div>

            <v-dialog v-model="dialog" max-width="350">
                <v-card class="text-center">
                    <v-card-text>
                        <v-avatar size="80">
                            <img :src="user.photo" alt="Profile Photo" />
                        </v-avatar>
                        <h3 class="mt-3">{{ user.name }}</h3>
                        <p class="text-gray-500">{{ user.email }}</p>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="error" block @click="logout">Log Out</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const logo = "https://via.placeholder.com/150"; // replace with your logo

const dialog = ref(false);
const activeMenu = ref(null);

const user = ref({
    name: "Admin User",
    email: "admin@example.com",
    photo: "https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?semt=ais_hybrid&w=740"
});

const logout = () => {
    console.log("Logging out...");
};

const toggleMenu = (menu) => {
    activeMenu.value = activeMenu.value === menu ? null : menu;
};

const navItems = [
    { to: "/admin/expense", title: "All Expenses", icon: "mdi mdi-circle-medium", value: "AllExpenses" },
    { to: "/admin/billExpense", title: "Bill Expense", icon: "mdi mdi-circle-medium", value: "billExpense" },
    { to: "/admin/expenseProducts", title: "Products", icon: "mdi mdi-circle-medium", value: "expense product" },
    { to: "/admin/expenseCat", title: "Categories", icon: "mdi mdi-circle-medium", value: "categories" }
];

const peopleItems = [
    { to: "/admin/employee", title: "Employee", icon: "mdi mdi-circle-medium", value: "employee" },
    { to: "/admin/patients", title: "Patients", icon: "mdi mdi-circle-medium", value: "patients" },
    { to: "/admin/owners", title: "Owners", icon: "mdi mdi-circle-medium", value: "owners" },
    { to: "/admin/supplier", title: "Supplier", icon: "mdi mdi-circle-medium", value: "supplier" },
    { to: "/admin/customer", title: "Customer", icon: "mdi mdi-circle-medium", value: "customer" },
    { to: "/admin/doctors", title: "Doctors", icon: "mdi mdi-circle-medium", value: "doctors" },
    { to: "/admin/user", title: "User", icon: "mdi mdi-circle-medium", value: "user" }
];

const leadItems = [
    { to: "/admin/lead", title: "Leads", icon: "mdi mdi-circle-medium", value: "lead" },
    { to: "/admin/leadCategory", title: "Lead Category", icon: "mdi mdi-circle-medium", value: "leadCategory" },
    { to: "/admin/leadStage", title: "Lead Stage", icon: "mdi mdi-circle-medium", value: "leadStage" }
];

const settingItems = [
    { to: "/admin/systemSetting", title: "System Settings", icon: "mdi mdi-circle-medium", value: "system" },
    { to: "/admin/moneyAcc", title: "Money Account", icon: "mdi mdi-circle-medium", value: "moneyAcc" },
    { to: "/admin/rolePermissions", title: "Role & Permissions", icon: "mdi mdi-circle-medium", value: "roles" },
    { to: "/admin/service", title: "Service", icon: "mdi mdi-circle-medium", value: "service" },
    { to: "/admin/dental-types", title: "Dental Types", icon: "mdi mdi-circle-medium", value: "Dental" }
];

const reportItems = [
    { to: "/admin/profitLoss", title: "Profit & Loss", icon: "mdi mdi-circle-medium", value: "profit" },
    { to: "/admin/patientsReport", title: "Patients Report", icon: "mdi mdi-circle-medium", value: "patientsReport" },
    { to: "/admin/categoryReport", title: "Expense Category", icon: "mdi mdi-circle-medium", value: "catReport" },
    { to: "/admin/productReport", title: "Expense Product", icon: "mdi mdi-circle-medium", value: "expenseProReport" },
    { to: "/admin/serviceReport", title: "Service Report", icon: "mdi mdi-circle-medium", value: "serviceReport" }
];

function handleDrawerState(isOpen) {
    document.body.style.overflow = isOpen ? "hidden" : "";
}
</script>

<style scoped>

    /* Hide scrollbar across all browsers */
/* .child {
    font-size: 14px;
    transition: color 0.3s;
} */
.child > :nth-child(3) {
    /* background-color: red; */
    display: flex;
    justify-content: flex-start;
    width: 2rem;
}

.scrollable-content {
    max-height: 80vh;
    overflow-y: auto;
    /* direction: ltr; */
}
.scrollable-content::-webkit-scrollbar {
    width: 4px;
    display: none;
}

.scrollable-content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.scrollable-content::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.scrollable-content::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Smooth slide transition */
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

/* Styling for child items */
.child {
    font-size: 0.875rem;
    transition: color 0.3s ease;
}
.child:hover {
    color: #333;
}
.borderRadius {
    border-top-right-radius: 8px !important;
    border-bottom-right-radius: 8px !important;
}

/* Brand styling for navigation items */
.v-list-item {
    color: white !important;
    transition: all 0.3s ease;
}

.v-list-item:hover {
    background-color: rgba(255, 165, 0, 0.2) !important; /* Professional orange with opacity */
    color: #FFA500 !important; /* Light orange text */
    border-radius: 12px;
    margin: 3px 12px;
    transform: translateX(4px);
}

.v-list-item.v-list-item--active {
    background: linear-gradient(135deg, #FFA500, #FFB84D) !important; /* Professional orange gradient */
    color: white !important; /* White text */
    font-weight: 700;
    border-radius: 12px;
    margin: 3px 12px;
    box-shadow: 0 4px 12px rgba(255, 140, 0, 0.5);
    border-left: 4px solid #FFCC80;
}

.v-list-item.v-list-item--active .v-icon {
    color: white !important; /* White icon for active */
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.2));
}

.v-list-item:hover .v-icon {
    color: #FFA500 !important; /* Professional orange icon on hover */
}

.v-list-item .v-icon {
    color: white !important; /* Default white icons */
}

/* Profile Section Styling - Positioned at the very end */


.user-profile-item {
    padding: 8px 0;
}

.user-profile-card {
    border-radius: 8px !important;
    transition: all 0.2s ease;
    background-color: transparent;
    color: white !important;
}

.user-profile-card:hover {
    background-color: rgba(255, 165, 0, 0.2) !important; /* Professional orange with opacity */
    color: #FFA500 !important; /* Professional orange text */
    border-radius: 12px;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(255, 140, 0, 0.3);
}

/* Ensure the sidebar container uses flexbox for proper positioning */
.sidebar-container {
    display: flex;
    flex-direction: column;
    height: 100vh;
    max-height: 100vh;
    background: linear-gradient(180deg, #CC5500 0%, #E67300 50%, #FF8C00 100%); /* Professional orange gradient */
    overflow: hidden;
    color: white;
    box-shadow: 3px 0 15px rgba(255, 140, 0, 0.2);
}

/* Navigation section should take available space */
.navigation-section {
    flex: 1;
    overflow-y: auto;
    padding: 16px 0;
}



.logo-link {
    display: block;
    text-decoration: none;
}

.logo-container {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 8px;
    padding: 16px 0;
}

.logo-avatar {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    border: 3px solid #fff;
}

.logo-avatar:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.logo-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}



.logo-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    text-align: center;
}

</style>