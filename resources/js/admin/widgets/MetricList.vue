<template>
  <ul class="metric-list">
    <li v-for="metric in metrics" :key="metric.title" class="metric-list__item">
      <div>
        <p class="metric-list__label">{{ metric.title }}</p>
        <p class="metric-list__value">{{ formattedValue(metric.value) }}</p>
      </div>
      <span class="metric-list__change" :class="changeClass(metric.trend)">
        {{ metric.change }}
      </span>
    </li>
  </ul>
</template>

<script setup>
const props = defineProps({
  metrics: {
    type: Array,
    default: () => [],
  },
});

const formattedValue = (value) =>
  typeof value === 'number' ? new Intl.NumberFormat().format(value) : value;

const changeClass = (trend) => {
  switch (trend) {
    case 'positive':
      return 'metric-list__change--positive';
    case 'negative':
      return 'metric-list__change--negative';
    default:
      return 'metric-list__change--neutral';
  }
};
</script>




