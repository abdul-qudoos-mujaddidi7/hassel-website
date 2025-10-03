<template>
  <RouterLink
    :to="to"
    class="sidebar-link"
    :class="{ 'sidebar-link--active': isActive }"
  >
    <span class="sidebar-link__icon" v-html="iconSvg" />
    <span class="sidebar-link__label">{{ label }}</span>
  </RouterLink>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { icons } from './icons';

const props = defineProps({
  to: {
    type: [String, Object],
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  icon: {
    type: String,
    default: null,
  },
});

const route = useRoute();
const router = useRouter();

const resolvedPath = computed(() => {
  if (typeof props.to === 'string') return props.to;
  return router.resolve(props.to).fullPath;
});

const isActive = computed(() => route.path === resolvedPath.value);

const iconSvg = computed(() => (props.icon && icons[props.icon] ? icons[props.icon] : ''));
</script>

