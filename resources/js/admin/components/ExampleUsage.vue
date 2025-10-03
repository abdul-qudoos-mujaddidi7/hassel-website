<template>
  <div class="example-component">
    <h2>Example: Using Function Files</h2>
    
    <form @submit.prevent="handleSubmit">
      <div>
        <label>Email:</label>
        <input v-model="form.email" type="email" />
        <span v-if="errors.email" class="error">{{ errors.email }}</span>
      </div>
      
      <div>
        <label>Password:</label>
        <input v-model="form.password" type="password" />
        <span v-if="errors.password" class="error">{{ errors.password }}</span>
      </div>
      
      <button type="submit" :disabled="submitting">
        {{ submitting ? 'Processing...' : 'Submit' }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { loginUser } from '../../functions/authFunctions.js';
import { validateLoginForm, clearFormErrors } from '../../functions/formFunctions.js';
import { isFormValid } from '../../functions/utilityFunctions.js';

// Component state
const form = reactive({
  email: '',
  password: '',
});

const errors = reactive({});
const submitting = ref(false);

// Handle form submission
const handleSubmit = async () => {
  if (!isFormValid(form)) {
    return;
  }

  submitting.value = true;
  clearFormErrors(errors);

  const validation = validateLoginForm(form);
  if (!validation.isValid) {
    Object.assign(errors, validation.errors);
    submitting.value = false;
    return;
  }

  const result = await loginUser(form);
  if (!result.success) {
    Object.assign(errors, result.errors);
  }
  
  submitting.value = false;
};
</script>

<style scoped>
.example-component {
  padding: 1rem;
  border: 1px solid #ccc;
  margin: 1rem 0;
}

.error {
  color: red;
  font-size: 0.875rem;
}
</style>
