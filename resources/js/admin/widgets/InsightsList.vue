<template>
  <ul class="insights-list">
    <li v-for="item in items" :key="item.label" class="insights-list__item">
      <span class="insights-list__label">{{ item.label }}</span>
      <span class="insights-list__value">{{ item.value }}</span>
      <p class="insights-list__description">{{ item.description }}</p>
    </li>
  </ul>
</template>

<script setup>
defineProps({
  items: {
    type: Array,
    default: () => [],
  },
});
</script>




