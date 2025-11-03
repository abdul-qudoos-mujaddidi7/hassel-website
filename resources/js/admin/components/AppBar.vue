<template>
    <div class="app-bar">
        <div class="app-bar-content">
            <h1 class="main-title">{{ $t(mainTitle) }}</h1>
            
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const props = defineProps({
    mainTitle: {
        type: String,
        default: "dashboard"
    },
    subTitle: {
        type: String,
        default: ""
    }
});
</script>

<style scoped>
.app-bar {
    padding: 1rem 0;
}

.app-bar-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.main-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: rgb(var(--v-theme-primary));
    margin: 0;
    line-height: 1.2;
}

.sub-title {
    font-size: 0.875rem;
    color: rgb(var(--v-theme-on-surface-variant));
    margin: 0;
}
</style>

