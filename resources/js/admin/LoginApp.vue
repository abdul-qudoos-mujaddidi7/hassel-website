<template>
    <div class="login-container">
        <!-- Left Welcome Section -->
        <div class="welcome-section">
            <div class="welcome-content">
                <h1 class="welcome-title">
                    Welcome to Hassel
                </h1>
                <p class="welcome-description">
                    Your gateway to agricultural innovation and sustainable farming solutions. Join our community of farmers, researchers, and agricultural experts.
                </p>
            </div>
            <div class="decorative-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
        </div>

        <!-- Right Login Form Section -->
        <div class="login-section">
            <div class="login-card">
                <h2 class="form-title">USER LOGIN</h2>
                <v-form
                    @submit.prevent="loginFunc"
                    ref="formRef"
                    :validate-on="'submit'"
                >
                    <div class="login-form-content">

                        <v-text-field
                            v-model="formData.email"
                            label="Email ID"
                            prepend-inner-icon="mdi-account-outline"
                            variant="outlined"
                            color="primary"
                            density="comfortable"
                            class="form-input"
                            rounded="lg"
                            bg-color="#f8f9fa"
                            flat
                            :rules="emailRules"
                            required
                            placeholder="Enter your email"
                            ref="emailField"
                        />

                        <v-text-field
                            v-model="formData.password"
                            label="Password"
                            :type="visible ? 'text' : 'password'"
                            prepend-inner-icon="mdi-lock-outline"
                            :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                            variant="outlined"
                            density="comfortable"
                            @click:append-inner="visible = !visible"
                            color="primary"
                            class="form-input"
                            rounded="lg"
                            bg-color="#f8f9fa"
                            flat
                            :rules="passwordRules"
                            required
                            placeholder="Enter your password"
                            ref="passwordField"
                        />

                        <div class="form-options">
                            <v-checkbox
                                v-model="rememberMe"
                                label="Remember"
                                color="primary"
                                hide-details
                                class="remember-checkbox"
                            />
                            <a href="#" class="forgot-link">Forgot password?</a>
                        </div>

                        <v-btn
                            type="submit"
                            color="primary"
                            size="large"
                            class="login-button"
                            elevation="0"
                            rounded="lg"
                            :loading="AuthRepository.loading"
                            :disabled="AuthRepository.loading"
                        >
                            LOGIN
                        </v-btn>
                    </div>
                </v-form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed, nextTick } from "vue";
import { useAuthRepository } from "../stores/Auth.js";
const AuthRepository = useAuthRepository();
const formData = reactive({
    email: "",
    password: "",
});
const visible = ref(false);
const rememberMe = ref(false);
const formRef = ref(null);
const emailField = ref(null);
const passwordField = ref(null);


const emailRules = [
    (v) => !!v || "Email is required",
    (v) => /.+@.+\..+/.test(v) || "Email must be valid",
];

const passwordRules = [
    (v) => !!v || "Password is required",
    (v) => (v && v.length >= 6) || "Password must be at least 6 characters",
];

const checkFormTampering = () => {
    try {
        // Check if the input elements are still in the DOM
        if (
            !document.contains(emailField.value?.$el) ||
            !document.contains(passwordField.value?.$el)
        ) {
            return true;
        }

        // Check if the inputs have been disabled or hidden
        const emailEl = emailField.value?.$el.querySelector("input");
        const passwordEl = passwordField.value?.$el.querySelector("input");

        if (!emailEl || !passwordEl) return true;

        if (
            emailEl.disabled ||
            passwordEl.disabled ||
            emailEl.readOnly ||
            passwordEl.readOnly
        ) {
            return true;
        }

        const emailStyle = window.getComputedStyle(emailEl);
        const passwordStyle = window.getComputedStyle(passwordEl);

        if (
            emailStyle.display === "none" ||
            emailStyle.visibility === "hidden" ||
            passwordStyle.display === "none" ||
            passwordStyle.visibility === "hidden"
        ) {
            return true;
        }

        return false;
    } catch (error) {
        console.error("Error checking form tampering:", error);
        return true;
    }
};

const loginFunc = async () => {
    // First check for form tampering
    if (checkFormTampering()) {
        alert(
            "Security violation detected. Please refresh the page and try again."
        );
        return;
    }

    // Reset any previous validation
    formRef.value?.resetValidation();

    // Validate form
    const { valid } = await formRef.value?.validate();

    if (!valid) {
        return; // Stop if validation fails
    }

    try {
        await AuthRepository.login(formData);
    } catch (error) {
        console.error("Login failed", error);
    }
};
</script>

<style scoped>
/* Global styles to ensure full page coverage */
:global(html), :global(body) {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
}
.login-container {
    height: 100vh;
    width: 100vw;
    display: flex;
    background: #f8f9fa;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

/* Left Welcome Section */
.welcome-section {
    flex: 2;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 60px;
    position: relative;
    overflow: hidden;
    height: 100vh;
}

.welcome-content {
    z-index: 2;
    position: relative;
}

.welcome-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    margin: 0 0 30px 0;
    line-height: 1.1;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.welcome-description {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
    margin: 0;
    max-width: 500px;
}

/* Decorative Shapes */
.decorative-shapes {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.shape {
    position: absolute;
    border-radius: 20px;
    background: linear-gradient(45deg, #ff6b6b, #ffa500);
    opacity: 0.8;
}

.shape-1 {
    width: 200px;
    height: 80px;
    bottom: 100px;
    right: 50px;
    transform: rotate(-15deg);
    animation: float 6s ease-in-out infinite;
}

.shape-2 {
    width: 150px;
    height: 60px;
    bottom: 200px;
    right: 150px;
    transform: rotate(25deg);
    animation: float 8s ease-in-out infinite reverse;
}

.shape-3 {
    width: 100px;
    height: 40px;
    bottom: 50px;
    right: 200px;
    transform: rotate(-30deg);
    animation: float 7s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(var(--rotation, 0deg)); }
    50% { transform: translateY(-20px) rotate(var(--rotation, 0deg)); }
}

/* Right Login Section */
.login-section {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
    background: white;
    height: 100vh;
}

.login-card {
    width: 100%;
    max-width: 400px;
    padding: 40px 30px;
}

.form-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2d3748;
    text-align: center;
    margin: 0 0 40px 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.login-form-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-input {
    width: 100%;
}

.form-input :deep(.v-field__input) {
    padding: 16px 14px;
    font-size: 16px;
}

.form-input :deep(.v-field__outline) {
    border-radius: 12px;
    border-width: 1px;
    border-color: #e2e8f0;
}

.form-input :deep(.v-field--focused .v-field__outline) {
    border-color: #667eea;
    border-width: 2px;
}

.form-input :deep(.v-label) {
    color: #718096;
    font-weight: 500;
}

.form-input :deep(.v-field--focused .v-label) {
    color: #667eea;
}

.form-input :deep(.v-field__input) {
    color: #2d3748;
    font-weight: 500;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 10px 0;
}

.remember-checkbox {
    margin: 0;
}

.remember-checkbox :deep(.v-label) {
    color: #718096;
    font-size: 14px;
}

.forgot-link {
    color: #667eea;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: color 0.3s ease;
}

.forgot-link:hover {
    color: #5a67d8;
    text-decoration: underline;
}

.login-button {
    width: 100%;
    height: 56px;
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
    margin-top: 20px;
}

.login-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.login-button:active {
    transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 768px) {
    .login-container {
        flex-direction: column;
    }
    
    .welcome-section {
        flex: 1;
        padding: 40px 30px;
    }
    
    .welcome-title {
        font-size: 2.5rem;
    }
    
    .welcome-description {
        font-size: 1rem;
    }
    
    .login-section {
        flex: 1;
        padding: 30px 20px;
    }
    
    .shape-1, .shape-2, .shape-3 {
        display: none;
    }
}

@media (max-width: 480px) {
    .welcome-section {
        padding: 30px 20px;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .login-card {
        padding: 30px 20px;
    }
    
    .form-title {
        font-size: 1.5rem;
    }
}

/* Animation for form elements */
.login-form-content > * {
    animation: fadeInUp 0.6s ease-out;
}

.login-form-content > *:nth-child(1) { animation-delay: 0.1s; }
.login-form-content > *:nth-child(2) { animation-delay: 0.2s; }
.login-form-content > *:nth-child(3) { animation-delay: 0.3s; }
.login-form-content > *:nth-child(4) { animation-delay: 0.4s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>