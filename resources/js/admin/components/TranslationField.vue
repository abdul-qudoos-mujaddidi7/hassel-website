<template>
  <div class="translation-field mb-4">
    <div class="d-flex justify-space-between align-center mb-2">
      <label class="text-subtitle-2 font-weight-medium">
        {{ fieldLabel }}
      </label>
    </div>
    
    <component
      :is="fieldComponent"
      v-model="fieldValue"
      :variant="variant"
      :density="density"
      :label="placeholder"
      :rules="rules"
      :rows="rows"
      :type="type"
      :items="items"
      :item-title="itemTitle"
      :item-value="itemValue"
      :multiple="multiple"
      :chips="chips"
      :closable-chips="closableChips"
      :disabled="disabled"
      :readonly="readonly"
      :hint="hint"
      :persistent-hint="persistentHint"
      :class="fieldClass"
      @update:model-value="handleInput"
    ></component>
    
    <div v-if="hint && !persistentHint" class="text-caption text-grey mt-1">
      {{ hint }}
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const props = defineProps({
  // Field configuration
  fieldName: {
    type: String,
    required: true
  },
  fieldLabel: {
    type: String,
    required: true
  },
  language: {
    type: String,
    required: true
  },
  languageLabel: {
    type: String,
    required: true
  },
  
  // Field value
  modelValue: {
    type: [String, Number, Array],
    default: ''
  },
  
  // Field type and configuration
  fieldType: {
    type: String,
    default: 'text', // text, textarea, select, multiselect, date, number
    validator: (value) => ['text', 'textarea', 'select', 'multiselect', 'date', 'number'].includes(value)
  },
  
  // Vuetify props
  variant: {
    type: String,
    default: 'outlined'
  },
  density: {
    type: String,
    default: 'compact'
  },
  placeholder: {
    type: String,
    default: ''
  },
  rules: {
    type: Array,
    default: () => []
  },
  rows: {
    type: [String, Number],
    default: 3
  },
  type: {
    type: String,
    default: 'text'
  },
  items: {
    type: Array,
    default: () => []
  },
  itemTitle: {
    type: String,
    default: 'title'
  },
  itemValue: {
    type: String,
    default: 'value'
  },
  multiple: {
    type: Boolean,
    default: false
  },
  chips: {
    type: Boolean,
    default: false
  },
  closableChips: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  },
  readonly: {
    type: Boolean,
    default: false
  },
  hint: {
    type: String,
    default: ''
  },
  persistentHint: {
    type: Boolean,
    default: false
  },
  fieldClass: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['update:modelValue', 'clear'])

const { t } = useI18n()

// Computed field component
const fieldComponent = computed(() => {
  switch (props.fieldType) {
    case 'textarea':
      return 'v-textarea'
    case 'select':
    case 'multiselect':
      return 'v-select'
    case 'date':
      return 'v-text-field'
    case 'number':
      return 'v-text-field'
    default:
      return 'v-text-field'
  }
})

// Computed field value
const fieldValue = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})

// Check if field has translation
const hasTranslation = computed(() => {
  if (Array.isArray(props.modelValue)) {
    return props.modelValue.length > 0
  }
  return props.modelValue && props.modelValue.toString().trim() !== ''
})

// Handle input
const handleInput = (value) => {
  emit('update:modelValue', value)
}

// Clear translation
const clearTranslation = () => {
  emit('clear', props.fieldName)
}
</script>

<style scoped>
.translation-field {
  position: relative;
}

.v-chip {
  font-size: 0.7rem;
}
</style>

