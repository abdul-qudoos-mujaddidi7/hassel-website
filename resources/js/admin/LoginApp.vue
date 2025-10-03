<template>
  <div class="admin-login">
    <div class="admin-login__card">
      <div class="admin-login__brand">
        <span class="admin-login__logo">MA</span>
        <div>
          <p class="admin-login__brand-label">Mount Agro</p>
          <h1 class="admin-login__title">Administrator Access</h1>
        </div>
      </div>
      <form class="admin-login__form" @submit.prevent="submit">
        <InputField
          label="Email address"
          name="email"
          type="email"
          placeholder="you@mountagro.af"
          v-model="form.email"
          :error="errors.email"
          autocomplete="email"
          required
          autofocus
        />

        <InputField
          label="Password"
          name="password"
          type="password"
          placeholder="Enter your password"
          v-model="form.password"
          :error="errors.password"
          autocomplete="current-password"
          required
        />

        <div class="admin-login__actions">
          <label class="admin-login__remember">
            <input v-model="form.remember" type="checkbox" />
            Remember me
          </label>
        </div>

        <button class="admin-login__submit" type="submit" :disabled="submitting">
          <span v-if="submitting" class="admin-login__spinner" />
          <span>{{ submitting ? 'Signing in…' : 'Sign in' }}</span>
        </button>

        <p v-if="errors.message" class="admin-login__error">
          {{ errors.message }}
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import InputField from './components/InputField.vue';

const form = reactive({
  email: '',
  password: '',
  remember: false,
});

const errors = reactive({});
const submitting = ref(false);

const submit = async () => {
  submitting.value = true;
  Object.keys(errors).forEach((key) => delete errors[key]);

  try {
    await axios.post('/admin/login', {
      email: form.email,
      password: form.password,
      remember: form.remember,
    });

    window.location.href = '/admin';
  } catch (error) {
    if (error.response?.status === 422) {
      Object.assign(errors, error.response.data.errors ?? {});
      if (error.response.data.errors?.email) {
        errors.message = error.response.data.errors.email.join(' ');
      }
    } else {
      errors.message = 'Unable to sign in. Please try again.';
    }
  } finally {
    submitting.value = false;
  }
};
</script>