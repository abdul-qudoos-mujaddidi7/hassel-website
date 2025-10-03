<template>
  <ul class="activity-list">
    <li
      v-for="item in items"
      :key="item.title"
      class="activity-list__item"
    >
      <span class="activity-list__badge" :class="badgeClass(item.type)" />
      <div class="activity-list__content">
        <p class="activity-list__title">{{ item.title }}</p>
        <p class="activity-list__description">{{ item.description }}</p>
      </div>
      <span class="activity-list__timestamp">{{ item.timestamp }}</span>
    </li>
  </ul>
</template>

<script setup>
const props = defineProps({
  items: {
    type: Array,
    default: () => [],
  },
});

const badgeClass = (type) => {
  switch (type) {
    case 'success':
      return 'activity-list__badge--success';
    case 'warning':
      return 'activity-list__badge--warning';
    default:
      return 'activity-list__badge--info';
  }
};
</script>




