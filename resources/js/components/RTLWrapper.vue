<template>
    <div :class="wrapperClasses">
        <slot />
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useI18n } from '../composables/useI18n.js';

const { isRTL } = useI18n();

const props = defineProps({
    // Text alignment
    textAlign: {
        type: String,
        default: 'auto', // 'auto', 'left', 'right', 'center'
        validator: (value) => ['auto', 'left', 'right', 'center'].includes(value)
    },
    // Direction
    direction: {
        type: String,
        default: 'auto', // 'auto', 'ltr', 'rtl'
        validator: (value) => ['auto', 'ltr', 'rtl'].includes(value)
    },
    // Additional classes
    class: {
        type: String,
        default: ''
    }
});

const wrapperClasses = computed(() => {
    const classes = [props.class];
    
    // Handle text alignment
    if (props.textAlign === 'auto') {
        // Auto-adjust based on RTL
        if (isRTL.value) {
            classes.push('text-right');
        } else {
            classes.push('text-left');
        }
    } else {
        classes.push(`text-${props.textAlign}`);
    }
    
    // Handle direction
    if (props.direction === 'auto') {
        // Auto-adjust based on RTL
        if (isRTL.value) {
            classes.push('rtl-text');
        } else {
            classes.push('ltr-text');
        }
    } else if (props.direction === 'rtl') {
        classes.push('rtl-text');
    } else if (props.direction === 'ltr') {
        classes.push('ltr-text');
    }
    
    return classes.join(' ');
});
</script>

<style scoped>
.rtl-text {
    direction: rtl;
    text-align: right;
}

.ltr-text {
    direction: ltr;
    text-align: left;
}
</style>
