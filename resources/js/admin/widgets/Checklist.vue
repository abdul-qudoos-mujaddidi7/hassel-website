<template>
  <ul class="checklist">
    <li v-for="(item, index) in items" :key="item" class="checklist__item">
      <span class="checklist__marker">{{ index + 1 }}</span>
      <span>{{ item }}</span>
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




