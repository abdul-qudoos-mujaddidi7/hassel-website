<template>
  <article class="stat-card">
    <div class="stat-card__inner">
      <p class="stat-card__title">{{ title }}</p>
      <p class="stat-card__value">{{ formattedValue }}</p>
      <p v-if="subValue" class="stat-card__sub">{{ subValue }}</p>
    </div>
  </article>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  value: {
    type: [String, Number],
    required: true,
  },
  subValue: {
    type: String,
    default: null,
  },
});

const formattedValue = computed(() =>
  typeof props.value === 'number' ? new Intl.NumberFormat().format(props.value) : props.value,
);
</script>




