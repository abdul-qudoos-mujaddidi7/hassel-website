<template>
  <label class="input-field">
    <span class="input-field__label">{{ label }}</span>
    <div class="input-field__control" :class="{ 'input-field__control--error': error }">
      <input
        v-bind="$attrs"
        v-model="model"
        :type="type"
        :name="name"
        class="input-field__input"
      />
    </div>
    <span v-if="error" class="input-field__error">{{ error }}</span>
  </label>
</template>

<script setup>
const props = defineProps({
  label: String,
  name: String,
  type: {
    type: String,
    default: 'text',
  },
  error: {
    type: String,
    default: null,
  },
});

const model = defineModel({
  type: String,
  default: '',
});
</script>




