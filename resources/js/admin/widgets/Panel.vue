<template>
  <section class="panel">
    <header class="panel__header" v-if="hasHeader">
      <h3>{{ title }}</h3>
      <p v-if="description">{{ description }}</p>
    </header>
    <div class="panel__body">
      <slot />
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  title: {
    type: String,
    default: null,
  },
  description: {
    type: String,
    default: null,
  },
});

const hasHeader = computed(() => props.title || props.description);
</script>




