<template>
    <v-card :dir="isRtl ? 'rtl' : 'ltr'" :elevation="0" class="rounded-xl">
        <template v-slot:prepend>
            <h1 class="header-title">
                {{ $t(pageTitle) }}
            </h1>
        </template>

        <template v-slot:append>
            <div class="d-flex align-center gap-4">
                <!-- Language Switcher -->
                <v-menu transition="scale-transition">
                    <template #activator="{ props }">
                        <v-btn
                            :icon="$t('mdi-web')"
                            flat
                            class="icon bg-head mx-4"
                            size="small"
                            height="4.7vh"
                            width="4.7vh"
                            v-bind="props"
                            :title="$t('language_switcher')"
                        ></v-btn>
                    </template>

                    <v-list>
                        <v-list-item
                            v-for="item in items"
                            :key="$t(item.title)"
                            @click="changeLanguage(item.lang)"
                        >
                            <div class="flex items-center gap-4">
                                <div class="mr-2">
                                    <v-list-item-icon>
                                        <img
                                            :src="item.icon"
                                            :alt="$t('language_icon')"
                                            class="icon-size"
                                            height="22"
                                            width="22"
                                        />
                                    </v-list-item-icon>
                                </div>
                                <v-list-item-title>{{
                                    $t(item.title)
                                }}</v-list-item-title>
                            </div>
                        </v-list-item>
                    </v-list>
                </v-menu>

                <!-- User Profile & Logout -->
                <v-menu transition="scale-transition" offset="8">
                    <template #activator="{ props }">
                        <v-btn
                            flat
                            class="profile-btn"
                            v-bind="props"
                            :title="user.name"
                            size="large"
                        >
                            <v-avatar size="40" class="profile-avatar">
                                <img :src="user.photo" :alt="user.name" />
                            </v-avatar>
                            <span class="profile-name ml-3">{{ user.name }}</span>
                        </v-btn>
                    </template>

                    <v-card class="profile-card" elevation="8">
                        <v-card-text class="profile-card-content">
                            <div class="profile-header">
                                <v-avatar size="70" class="profile-avatar-large">
                                    <img :src="user.photo" :alt="user.name" />
                                </v-avatar>
                                <div class="profile-info">
                                    <h3 class="profile-name-large">{{ user.name }}</h3>
                                    <p class="profile-email">{{ user.email }}</p>
                                </div>
                            </div>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions class="profile-actions">
                            <v-btn
                                @click="handleLogout"
                                class="logout-btn"
                                variant="text"
                                block
                            >
                                <v-icon class="mr-2">mdi-logout</v-icon>
                                {{ $t("logout") }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-menu>
            </div>
        </template>
    </v-card>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useI18n } from "vue-i18n";
import { useAuthRepository } from '../../stores/Auth.js';

const { t, locale } = useI18n();
const authStore = useAuthRepository();

const props = defineProps({
    pageTitle: { type: String, default: "" },
   
});

// Use actual user data from auth store
const user = computed(() => {
    if (authStore.user && authStore.user.name) {
        return {
            name: authStore.user.name,
            email: authStore.user.email,
            photo: authStore.user.photo || "https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?semt=ais_hybrid&w=740"
        };
    }
    // Fallback for when user data isn't loaded yet
    return {
        name: "Admin User",
        email: "admin@example.com",
        photo: "https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?semt=ais_hybrid&w=740"
    };
});

const items = ref([
    { title: t("English"), lang: "en", icon: "/assets/english.png" },
    { title: t("Dari"), lang: "fa", icon: "/assets/dari.png" },
    { title: t("Pashto"), lang: "ps", icon: "/assets/dari.png" },
]);

const isRtl = ref(false);

// Initialize language from localStorage
onMounted(() => {
    const savedLang = localStorage.getItem("locale");
    if (savedLang) {
        locale.value = savedLang;
        isRtl.value = savedLang !== "en";
    }
});

const changeLanguage = (lang) => {
    locale.value = lang;
    localStorage.setItem("locale", lang);
    isRtl.value = lang !== "en";
};

const handleLogout = async () => {
    console.log(t("logging_out_message"));
    try {
        await authStore.logout();
    } catch (error) {
        console.error('Logout error:', error);
    }
};
</script>

<style scoped>
.icon {
    border-radius: 8px !important;
    background: transparent !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(var(--v-theme-outline), 0.2) !important;
}

.icon .v-icon {
    color: rgb(var(--v-theme-on-surface)) !important;
    font-weight: bold;
}

.icon:hover .v-icon {
    color: rgb(var(--v-theme-primary)) !important;
}

.icon:hover {
    background: rgba(var(--v-theme-primary), 0.08) !important;
    color: rgb(var(--v-theme-primary)) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(var(--v-theme-primary), 0.15) !important;
}

.drag {
    background-color: inherit;
    padding: 12px !important;
}

.drag:hover {
    background-color: inherit;
}

.icon-size {
    border-radius: 50%;
    /* Make it circular */
    object-fit: cover;
}

.logout-avatar {
    padding: 0 !important;
    min-width: auto;
}

/* Profile Button Styles */
.profile-btn {
    border-radius: 8px !important;
    background: transparent !important;
    color: rgb(var(--v-theme-on-surface)) !important;
    transition: all 0.3s ease !important;
    text-transform: none !important;
    font-weight: 500 !important;
    padding: 8px 16px !important;
    min-height: 48px !important;
}

.profile-btn:hover {
    background: rgba(var(--v-theme-primary), 0.08) !important;
    color: rgb(var(--v-theme-primary)) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(var(--v-theme-primary), 0.15) !important;
}

.profile-avatar {
    border: 2px solid rgb(var(--v-theme-on-primary)) !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
}

.profile-avatar-large {
    border: 3px solid rgb(var(--v-theme-primary)) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
}

.profile-name {
    color: rgb(var(--v-theme-on-surface)) !important;
    font-weight: 600 !important;
    font-size: 0.95rem !important;
}

.profile-name-large {
    color: rgb(var(--v-theme-primary)) !important;
    font-weight: 600 !important;
    margin-bottom: 0.25rem !important;
}

.profile-email {
    color: rgb(var(--v-theme-on-surface-variant)) !important;
    font-size: 0.9rem !important;
}

/* Profile Card Styles */
.profile-card {
    border-radius: 16px !important;
    overflow: hidden !important;
    min-width: 280px !important;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12) !important;
}

.profile-card-content {
    padding: 1.5rem !important;
}

.profile-header {
    display: flex !important;
    align-items: center !important;
    gap: 1rem !important;
}

.profile-info {
    flex: 1 !important;
}

.profile-name-large {
    color: rgb(var(--v-theme-on-surface)) !important;
    font-weight: 600 !important;
    font-size: 1.1rem !important;
    margin-bottom: 0.25rem !important;
    line-height: 1.2 !important;
}

.profile-email {
    color: rgb(var(--v-theme-on-surface-variant)) !important;
    font-size: 0.9rem !important;
    margin: 0 !important;
    line-height: 1.3 !important;
}

.profile-actions {
    padding: 0.75rem 1.5rem 1.5rem !important;
}

.logout-btn {
    color: rgb(var(--v-theme-error)) !important;
    font-weight: 500 !important;
    text-transform: none !important;
    border-radius: 8px !important;
    transition: all 0.2s ease !important;
}

.logout-btn:hover {
    background-color: rgba(var(--v-theme-error), 0.08) !important;
    color: rgb(var(--v-theme-error)) !important;
}


.header-title {
    font-size: 1.5rem !important;
    font-weight: 700 !important;
    color: rgb(var(--v-theme-primary)) !important;
    margin: 0 !important;
    line-height: 1.2 !important;
}
</style>
