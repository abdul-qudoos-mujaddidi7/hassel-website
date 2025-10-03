<template>
  <div class="min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Background Gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 via-purple-400 to-pink-400"></div>
    
    <!-- Decorative Shapes -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute -top-20 -left-20 w-40 h-40 bg-gradient-to-br from-orange-400 to-pink-500 rounded-3xl transform rotate-12 opacity-80"></div>
      <div class="absolute top-1/4 -right-16 w-32 h-32 bg-gradient-to-br from-pink-400 to-purple-500 rounded-2xl transform -rotate-12 opacity-70"></div>
      <div class="absolute bottom-1/4 left-1/4 w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl transform rotate-45 opacity-60"></div>
      <div class="absolute bottom-10 right-1/4 w-36 h-36 bg-gradient-to-br from-purple-400 to-pink-500 rounded-3xl transform -rotate-6 opacity-50"></div>
    </div>

    <!-- Main Login Card -->
    <div class="relative z-10 w-full max-w-5xl mx-4">
      <div class="bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[600px] flex">
        <!-- Left Panel - Welcome Section -->
        <div class="hidden md:flex md:w-1/2 relative overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-purple-500 via-purple-400 to-pink-400"></div>
          
          <!-- Decorative shapes overlay -->
          <div class="absolute inset-0">
            <div class="absolute top-8 left-8 w-24 h-24 bg-gradient-to-br from-orange-400 to-pink-500 rounded-2xl transform rotate-12 opacity-90"></div>
            <div class="absolute top-32 right-6 w-20 h-20 bg-gradient-to-br from-pink-400 to-purple-500 rounded-xl transform -rotate-12 opacity-80"></div>
            <div class="absolute bottom-24 left-6 w-28 h-28 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl transform rotate-45 opacity-70"></div>
            <div class="absolute bottom-32 right-8 w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg transform -rotate-6 opacity-60"></div>
            <div class="absolute top-48 left-1/4 w-12 h-12 bg-gradient-to-br from-orange-300 to-pink-400 rounded-lg transform rotate-30 opacity-50"></div>
          </div>
          
          <!-- Content -->
          <div class="relative z-10 flex flex-col justify-center items-center text-center p-16 text-white">
            <h1 class="text-5xl font-bold mb-8 leading-tight">
              Welcome to<br>
              <span class="text-6xl font-black">website</span>
            </h1>
            <p class="text-lg opacity-90 leading-relaxed max-w-sm">
              Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            </p>
          </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center">
          <div class="max-w-sm mx-auto w-full">
            <!-- Header -->
            <div class="text-center mb-10">
              <h2 class="text-3xl font-bold text-purple-800 mb-2">USER LOGIN</h2>
            </div>

            <!-- Login Form -->
            <v-form @submit.prevent="handleLogin" class="space-y-6">
              <div class="space-y-6">
                <!-- Email Field -->
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <v-icon color="#8b5cf6" size="20">mdi-account</v-icon>
                  </div>
                  <v-text-field
                    v-model="form.email"
                    label="Email Address"
                    type="email"
                    :rules="emailRules"
                    required
                    variant="outlined"
                    class="custom-input"
                    hide-details="auto"
                  />
                </div>
                
                <!-- Password Field -->
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <v-icon color="#8b5cf6" size="20">mdi-lock</v-icon>
                  </div>
                  <v-text-field
                    v-model="form.password"
                    label="Password"
                    :type="showPassword ? 'text' : 'password'"
                    :rules="passwordRules"
                    required
                    variant="outlined"
                    class="custom-input"
                    hide-details="auto"
                    :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append-inner="showPassword = !showPassword"
                  />
                </div>
              </div>
              
              <!-- Remember & Forgot -->
              <div class="flex items-center justify-between mt-8">
                <div class="flex items-center">
                  <v-checkbox
                    v-model="form.remember"
                    color="purple"
                    hide-details
                    class="custom-checkbox"
                  />
                  <span class="ml-2 text-sm text-purple-700 font-medium">Remember</span>
                </div>
                
                <a href="#" class="text-sm text-purple-500 hover:text-purple-700 font-medium transition-colors">
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
                class="custom-login-btn mt-8"
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
        <p class="text-white text-sm opacity-80">
          designed by <span class="font-semibold">freepik</span>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthRepository } from '../../../stores/Auth.js';

const router = useRouter();
const authStore = useAuthRepository();

const form = ref({
  email: '',
  password: '',
  remember: false
});

const showPassword = ref(false);

const emailRules = [
  v => !!v || 'Email is required',
  v => /.+@.+\..+/.test(v) || 'Email must be valid'
];

const passwordRules = [
  v => !!v || 'Password is required',
  v => (v && v.length >= 6) || 'Password must be at least 6 characters'
];

const isFormValid = computed(() => {
  return form.value.email && 
         form.value.password && 
         /.+@.+\..+/.test(form.value.email) && 
         form.value.password.length >= 6;
});

const handleLogin = async () => {
  try {
    await authStore.login(form.value);
    // Redirect will be handled by the auth store
  } catch (error) {
    console.error('Login error:', error);
  }
};
</script>

<style scoped>
/* Custom Input Styles - Exact match to image */
:deep(.custom-input .v-field) {
  background-color: #f3e8ff !important;
  border: 2px solid #e9d5ff !important;
  border-radius: 12px !important;
  padding-left: 48px !important;
  height: 56px !important;
}

:deep(.custom-input .v-field--focused) {
  border-color: #8b5cf6 !important;
  box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1) !important;
}

:deep(.custom-input .v-field__input) {
  padding: 16px 12px !important;
  font-size: 16px !important;
  color: #6b46c1 !important;
}

:deep(.custom-input .v-label) {
  color: #6b46c1 !important;
  font-weight: 500 !important;
  font-size: 14px !important;
}

:deep(.custom-input .v-field--focused .v-label) {
  color: #8b5cf6 !important;
}

/* Custom Checkbox Styles - Exact match */
:deep(.custom-checkbox .v-selection-control__input) {
  color: #8b5cf6 !important;
}

:deep(.custom-checkbox .v-selection-control__input .v-icon) {
  color: #8b5cf6 !important;
}

:deep(.custom-checkbox .v-selection-control__input .v-selection-control__wrapper) {
  background-color: #f3e8ff !important;
  border: 2px solid #e9d5ff !important;
  border-radius: 4px !important;
  width: 20px !important;
  height: 20px !important;
}

:deep(.custom-checkbox .v-selection-control__input .v-selection-control__wrapper .v-icon) {
  color: white !important;
  font-size: 14px !important;
}

/* Custom Login Button - Exact gradient match */
.custom-login-btn {
  background: linear-gradient(90deg, #ec4899 0%, #8b5cf6 100%) !important;
  color: white !important;
  font-weight: 700 !important;
  font-size: 16px !important;
  text-transform: uppercase !important;
  letter-spacing: 1px !important;
  border-radius: 12px !important;
  height: 56px !important;
  box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3) !important;
  transition: all 0.3s ease !important;
}

.custom-login-btn:hover {
  transform: translateY(-2px) !important;
  box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4) !important;
}

.custom-login-btn:active {
  transform: translateY(0) !important;
}

.custom-login-btn.v-btn--disabled {
  background: #d1d5db !important;
  color: #9ca3af !important;
  box-shadow: none !important;
  transform: none !important;
}

/* Typography adjustments */
h1 {
  font-family: 'Inter', sans-serif !important;
}

h2 {
  font-family: 'Inter', sans-serif !important;
  letter-spacing: 0.5px !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .min-h-screen {
    padding: 20px 0;
  }
  
  .max-w-5xl {
    margin: 0 16px;
  }
  
  .bg-white {
    border-radius: 24px;
  }
  
  .text-5xl {
    font-size: 2.5rem !important;
  }
  
  .text-6xl {
    font-size: 3rem !important;
  }
}

/* Animation for decorative shapes */
@keyframes float {
  0%, 100% {
    transform: translateY(0px) rotate(12deg);
  }
  50% {
    transform: translateY(-10px) rotate(12deg);
  }
}

@keyframes floatReverse {
  0%, 100% {
    transform: translateY(0px) rotate(-12deg);
  }
  50% {
    transform: translateY(-8px) rotate(-12deg);
  }
}

.absolute:nth-child(1) {
  animation: float 6s ease-in-out infinite;
}

.absolute:nth-child(2) {
  animation: floatReverse 8s ease-in-out infinite;
}

.absolute:nth-child(3) {
  animation: float 7s ease-in-out infinite;
}

.absolute:nth-child(4) {
  animation: floatReverse 9s ease-in-out infinite;
}

.absolute:nth-child(5) {
  animation: float 5s ease-in-out infinite;
}

/* Ensure proper spacing and alignment */
.space-y-6 > * + * {
  margin-top: 1.5rem;
}

.space-y-4 > * + * {
  margin-top: 1rem;
}
</style>
