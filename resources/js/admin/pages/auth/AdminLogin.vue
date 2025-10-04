<template>
    <div
        class="min-h-screen flex items-center justify-center relative overflow-hidden"
    >
        <!-- Clean Background Gradient -->
        <div
            class="absolute inset-0 bg-gradient-to-br from-[#f0fdf4] via-[#f9fafb] to-[#f0fdf4]"
        ></div>

        <!-- Subtle Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute -top-20 -left-20 w-40 h-40 bg-gradient-to-br from-[#134124] to-[#375f1f] rounded-full opacity-10 transform rotate-12"
            ></div>
            <div
                class="absolute top-1/4 -right-16 w-32 h-32 bg-gradient-to-br from-[#eaaa03] to-[#fbf5df] rounded-full opacity-20 transform -rotate-12"
            ></div>
            <div
                class="absolute bottom-1/4 left-1/4 w-24 h-24 bg-gradient-to-br from-[#134124] to-[#375f1f] rounded-full opacity-15 transform rotate-45"
            ></div>
        </div>

        <!-- Main Login Card -->
        <div class="relative z-10 w-full max-w-4xl mx-4">
            <div
                class="bg-white rounded-2xl shadow-2xl overflow-hidden min-h-[500px] flex"
            >
                <!-- Left Panel - Welcome Section -->
                <div class="hidden md:flex md:w-1/2 relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-[#134124] to-[#375f1f]"
                    ></div>

                    <!-- Subtle decorative elements -->
                    <div class="absolute inset-0">
                        <div
                            class="absolute top-8 left-8 w-20 h-20 bg-white rounded-full opacity-10"
                        ></div>
                        <div
                            class="absolute top-32 right-6 w-16 h-16 bg-white rounded-full opacity-15"
                        ></div>
                        <div
                            class="absolute bottom-24 left-6 w-24 h-24 bg-white rounded-full opacity-10"
                        ></div>
                    </div>

                    <!-- Content -->
                    <div
                        class="relative z-10 flex flex-col justify-center items-center text-center p-12 text-white"
                    >
                        <div
                            class="w-20 h-20 bg-white rounded-2xl mb-6 flex items-center justify-center"
                        >
                            <svg
                                class="w-10 h-10 text-[#134124]"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
                                />
                            </svg>
                        </div>
                        <h1 class="text-4xl font-bold mb-6 leading-tight">
                            Welcome to<br />
                            <span class="text-5xl font-black">Mount Agro</span>
                        </h1>
                        <p class="text-lg opacity-90 leading-relaxed max-w-sm">
                            Empowering agricultural communities through
                            innovation, education, and sustainable development
                            practices.
                        </p>
                    </div>
                </div>

                <!-- Right Panel - Login Form -->
                <div class="w-full md:w-1/2 p-12 flex flex-col justify-center">
                    <div class="max-w-sm mx-auto w-full">
                        <!-- Header -->
                        <div class="text-center mb-10">
                            <h2 class="text-3xl font-bold text-[#134124] mb-2">
                                ADMIN LOGIN
                            </h2>
                            <p class="text-[#6b7280] text-sm">
                                Access the Mount Agro administration panel
                            </p>
                        </div>

                        <!-- Login Form -->
                        <v-form @submit.prevent="handleLogin" class="space-y-6">
                            <div class="space-y-8">
                                <!-- Email Field -->
                                <div class="relative">
                                    <div
                                        class="absolute top-0 left-0 pl-4 flex items-center pointer-events-none z-10"
                                        style="height: 56px"
                                    >
                                        <v-icon color="#134124" size="20"
                                            >mdi-account</v-icon
                                        >
                                    </div>
                                    <v-text-field
                                        v-model="form.email"
                                        label="Email Address"
                                        type="email"
                                        :rules="emailRules"
                                        required
                                        variant="outlined"
                                        class="clean-input"
                                        :error-messages="emailErrors"
                                        @blur="validateField('email')"
                                        @input="clearError('email')"
                                    />
                                </div>

                                <!-- Password Field -->
                                <div class="relative">
                                    <div
                                        class="absolute top-0 left-0 pl-4 flex items-center pointer-events-none z-10"
                                        style="height: 56px"
                                    >
                                        <v-icon color="#134124" size="20"
                                            >mdi-lock</v-icon
                                        >
                                    </div>
                                    <v-text-field
                                        v-model="form.password"
                                        label="Password"
                                        :type="
                                            showPassword ? 'text' : 'password'
                                        "
                                        :rules="passwordRules"
                                        required
                                        variant="outlined"
                                        class="clean-input"
                                        :error-messages="passwordErrors"
                                        @blur="validateField('password')"
                                        @input="clearError('password')"
                                        :append-inner-icon="
                                            showPassword
                                                ? 'mdi-eye'
                                                : 'mdi-eye-off'
                                        "
                                        @click:append-inner="
                                            showPassword = !showPassword
                                        "
                                    />
                                </div>
                            </div>

                            <!-- Remember & Forgot -->
                            <div class="flex items-center justify-between mt-8">
                                <div class="flex items-center">
                                    <v-checkbox
                                        v-model="form.remember"
                                        color="#134124"
                                        hide-details
                                        class="clean-checkbox"
                                    />
                                    <span
                                        class="ml-2 text-sm text-[#134124] font-medium"
                                        >Remember</span
                                    >
                                </div>

                                <a
                                    href="#"
                                    class="text-sm text-[#134124] hover:text-[#375f1f] font-medium transition-colors"
                                >
                                    Forgot password?
                                </a>
                            </div>

                            <!-- Login Button -->
                            <v-btn
                                type="submit"
                                size="x-large"
                                block
                                :loading="authStore.loading"
                                :disabled="!isFormValid"
                                class="clean-login-btn mt-8"
                                elevation="0"
                            >
                                LOGIN
                            </v-btn>
                        </v-form>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-[#6b7280] text-sm opacity-80">
                    Mount Agro Administration Panel
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, reactive } from "vue";
import { useRouter } from "vue-router";
import { useAuthRepository } from "../../../stores/Auth.js";

const router = useRouter();
const authStore = useAuthRepository();

const form = ref({
    email: "",
    password: "",
    remember: false,
});

const showPassword = ref(false);

// Reactive errors object
const errors = reactive({
    email: "",
    password: "",
});

const emailRules = [
    (v) => !!v || "Email is required",
    (v) => /.+@.+\..+/.test(v) || "Email must be valid",
];

const passwordRules = [
    (v) => !!v || "Password is required",
    (v) => (v && v.length >= 6) || "Password must be at least 6 characters",
];

// Computed error messages
const emailErrors = computed(() => (errors.email ? [errors.email] : []));
const passwordErrors = computed(() =>
    errors.password ? [errors.password] : []
);

const isFormValid = computed(() => {
    return (
        form.value.email &&
        form.value.password &&
        /.+@.+\..+/.test(form.value.email) &&
        form.value.password.length >= 6 &&
        !errors.email &&
        !errors.password
    );
});

// Validation functions
const validateField = (field) => {
    if (field === "email") {
        if (!form.value.email) {
            errors.email = "Email is required";
        } else if (!/.+@.+\..+/.test(form.value.email)) {
            errors.email = "Email must be valid";
        } else {
            errors.email = "";
        }
    } else if (field === "password") {
        if (!form.value.password) {
            errors.password = "Password is required";
        } else if (form.value.password.length < 6) {
            errors.password = "Password must be at least 6 characters";
        } else {
            errors.password = "";
        }
    }
};

const clearError = (field) => {
    errors[field] = "";
};

const handleLogin = async () => {
    // Validate all fields before submission
    validateField("email");
    validateField("password");

    if (!isFormValid.value) return;

    try {
        await authStore.login(form.value);
        // Redirect will be handled by the auth store
    } catch (error) {
        console.error("Login error:", error);
    }
};
</script>

<style scoped>
/* Clean Professional Input Styles */
:deep(.clean-input .v-field) {
    background-color: #ffffff !important;
    padding-left: 48px !important;
    min-height: 56px !important;
    height: auto !important;
    transition: all 0.3s ease !important;
    position: relative !important;
}

:deep(.clean-input .v-field--focused) {
    border-color: #134124 !important;
    box-shadow: 0 0 0 3px rgba(19, 65, 36, 0.1) !important;
    background-color: #ffffff !important;
}

:deep(.clean-input .v-field__input) {
    padding: 16px 12px 16px 0 !important;
    font-size: 16px !important;
    color: #134124 !important;
    font-weight: 500 !important;
}

:deep(.clean-input .v-label) {
    color: #6b7280 !important;
    font-weight: 500 !important;
    font-size: 14px !important;
    background-color: transparent !important;
}

:deep(.clean-input .v-field--focused .v-label),
:deep(.clean-input .v-field--active .v-label) {
    color: #134124 !important;
}

/* Error message styling */
:deep(.clean-input .v-messages__message) {
    color: #dc2626 !important;
    font-size: 12px !important;
    line-height: 1.2 !important;
    margin-top: 4px !important;
    min-height: 16px !important;
    padding-left: 0 !important;
    margin-left: 0 !important;
}

/* Ensure consistent height for input with errors */
:deep(.clean-input .v-field__outline) {
    min-height: 56px !important;
}

/* Input slot styling for proper alignment */
:deep(.clean-input .v-field__input) {
    align-items: center !important;
}

:deep(.clean-input .v-field__field) {
    align-items: stretch !important;
}

/* Clean Checkbox */
:deep(.clean-checkbox .v-selection-control__input) {
    color: #134124 !important;
}

:deep(.clean-checkbox .v-selection-control__input .v-icon) {
    color: #134124 !important;
}

/* Clean Login Button */
.clean-login-btn {
    background: linear-gradient(135deg, #134124 0%, #375f1f 100%) !important;
    color: white !important;
    font-weight: 700 !important;
    font-size: 16px !important;
    text-transform: uppercase !important;
    letter-spacing: 1px !important;
    border-radius: 12px !important;
    height: 56px !important;
    box-shadow: 0 4px 15px rgba(19, 65, 36, 0.3) !important;
    transition: all 0.3s ease !important;
}

.clean-login-btn:hover {
    background: linear-gradient(135deg, #0f2a1a 0%, #134124 100%) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(19, 65, 36, 0.4) !important;
}

.clean-login-btn:active {
    transform: translateY(0) !important;
}

.clean-login-btn.v-btn--disabled {
    background: #d1d5db !important;
    color: #9ca3af !important;
    box-shadow: none !important;
    transform: none !important;
}

/* Form spacing - increased for error messages */
.space-y-8 > * + * {
    margin-top: 2rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .min-h-screen {
        padding: 20px 0;
    }

    .max-w-4xl {
        margin: 0 16px;
    }

    .bg-white {
        border-radius: 24px;
    }
}
</style>
