<template>
    <v-list class="flex flex-col min-h-screen" @update:model="handleDrawerState">
        <router-link to="/dashboard">
            <div class="flex items-center justify-center py-4">
                <img
                    :src="logo"
                    alt="Logo"
                    class="w-[4rem] h-[4rem] rounded-full object-cover transition-all duration-300"
                />
            </div>
        </router-link>

        <!-- Scrollable content -->
        <div class="scrollable-content overflow-y-auto max-h-[80vh]">
            <router-link to="/dashboard">
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

            <router-link to="/appointments">
                <v-list-item
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi mdi-calendar-clock"
                    value="appointment"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    Appointments
                </v-list-item>
            </router-link>

            <router-link to="/cure">
                <v-list-item
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi-tooth-outline"
                    value="cure"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    Cure Cycle
                </v-list-item>
            </router-link>

            <router-link to="/mainLaboratory">
                <v-list-item
                    active-class="bg-primaryOld text-white"
                    prepend-icon="mdi-microscope"
                    value="in lab"
                    class="transition-all duration-300 cursor-pointer py-3 borderRadius"
                >
                    Inbound Laboratory
                </v-list-item>
            </router-link>

            <router-link to="/laboratory">
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

        <!-- Profile Section -->
        <div class="mt-auto">
            <hr />
            <v-list-item
                :prepend-avatar="user.photo"
                :title="user.name"
                :subtitle="user.email"
                nav
                class="px-4 py-2 cursor-pointer"
                @click="dialog = true"
            />

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
    </v-list>
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
    { to: "/expense", title: "All Expenses", icon: "mdi mdi-circle-medium", value: "AllExpenses" },
    { to: "/billExpense", title: "Bill Expense", icon: "mdi mdi-circle-medium", value: "billExpense" },
    { to: "/expenseProducts", title: "Products", icon: "mdi mdi-circle-medium", value: "expense product" },
    { to: "/expenseCat", title: "Categories", icon: "mdi mdi-circle-medium", value: "categories" }
];

const peopleItems = [
    { to: "/employee", title: "Employee", icon: "mdi mdi-circle-medium", value: "employee" },
    { to: "/patients", title: "Patients", icon: "mdi mdi-circle-medium", value: "patients" },
    { to: "/user", title: "User", icon: "mdi mdi-circle-medium", value: "user" },
    { to: "/owners", title: "Owners", icon: "mdi mdi-circle-medium", value: "owners" },
    { to: "/supplier", title: "Supplier", icon: "mdi mdi-circle-medium", value: "supplier" },
    { to: "/customer", title: "Customer", icon: "mdi mdi-circle-medium", value: "customer" },
    { to: "/doctors", title: "Doctors", icon: "mdi mdi-circle-medium", value: "doctors" }
];

const leadItems = [
    { to: "/lead", title: "Leads", icon: "mdi mdi-circle-medium", value: "lead" },
    { to: "/leadCategory", title: "Lead Category", icon: "mdi mdi-circle-medium", value: "leadCategory" },
    { to: "/leadStage", title: "Lead Stage", icon: "mdi mdi-circle-medium", value: "leadStage" }
];

const settingItems = [
    { to: "/systemSetting", title: "System Settings", icon: "mdi mdi-circle-medium", value: "system" },
    { to: "/moneyAcc", title: "Money Account", icon: "mdi mdi-circle-medium", value: "moneyAcc" },
    { to: "/rolePermissions", title: "Role & Permissions", icon: "mdi mdi-circle-medium", value: "roles" },
    { to: "/service", title: "Service", icon: "mdi mdi-circle-medium", value: "service" },
    { to: "/dental-types", title: "Dental Types", icon: "mdi mdi-circle-medium", value: "Dental" }
];

const reportItems = [
    { to: "/profitLoss", title: "Profit & Loss", icon: "mdi mdi-circle-medium", value: "profit" },
    { to: "/patientsReport", title: "Patients Report", icon: "mdi mdi-circle-medium", value: "patientsReport" },
    { to: "/categoryReport", title: "Expense Category", icon: "mdi mdi-circle-medium", value: "catReport" },
    { to: "/productReport", title: "Expense Product", icon: "mdi mdi-circle-medium", value: "expenseProReport" },
    { to: "/serviceReport", title: "Service Report", icon: "mdi mdi-circle-medium", value: "serviceReport" }
];

function handleDrawerState(isOpen) {
    document.body.style.overflow = isOpen ? "hidden" : "";
}
</script>

<style scoped>
.scrollable-content {
    max-height: 80vh;
    overflow-y: auto;
}
.scrollable-content::-webkit-scrollbar {
    display: none;
}
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
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
</style>
