<template>
  <div class="bar-chart">
    <div
      v-for="(value, label) in data"
      :key="label"
      class="bar-chart__row"
    >
      <div class="bar-chart__label">
        <span>{{ formatLabel(label) }}</span>
        <span>{{ value }}</span>
      </div>
      <div class="bar-chart__track">
        <div
          class="bar-chart__bar"
          :class="barClass"
          :style="{ width: `${percentage(value)}%` }"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
  variant: {
    type: String,
    default: null,
  },
});

const maxValue = computed(() => {
  const values = Object.values(props.data);
  if (!values.length) return 1;
  return Math.max(...values);
});

const percentage = (value) => Math.round((value / maxValue.value) * 100);

const formatLabel = (label) => label.replace('_', ' ');

const barClass = computed(() => {
  switch (props.variant) {
    case 'sky':
      return 'bar-chart__bar--sky';
    case 'amber':
      return 'bar-chart__bar--amber';
    default:
      return null;
  }
});
</script>




