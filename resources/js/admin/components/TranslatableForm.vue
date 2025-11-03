<template>
  <div :dir="dir">
    <v-dialog
      :transition="transition"
      :width="width"
      v-model="isVisible"
      :class="dialogClass"
    >
      <template v-slot:default="{ isActive }">
        <v-card class="px-3">
          <v-card-title class="px-2 pt-4 d-flex justify-space-between">
            <h2 class="font-weight-bold pl-4">
              {{ formTitle }}
            </h2>
            <v-btn variant="text" @click="isActive.value = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-title>
          <v-divider class="border-opacity-100 mx-6"></v-divider>

          <v-card-text>
            <v-form ref="formRef" class="pt-4">

              <!-- Translation Tabs -->
              <v-tabs
                v-model="activeTab"
                color="primary"
                class="mb-4"
                align-tabs="start"
              >
                <v-tab
                    v-for="tab in translationTabs"
                    :key="tab.key"
                    :value="tab.key"
                    class="text-capitalize"
                >
                    <v-icon :icon="tab.icon" class="me-2"></v-icon>
                    {{ tab.title }}
                </v-tab>
              </v-tabs>

              <v-window v-model="activeTab">
                <!-- Base Language Tab -->
                <v-window-item value="base">
                  <slot name="base-fields" :form-data="formData" :rules="rules"></slot>
                </v-window-item>

                <!-- Farsi Tab -->
                <v-window-item value="farsi">
                  <div class="translation-tab">
                    <slot 
                      name="farsi-fields" 
                      :translations="translations.farsi" 
                      :clear-translation="(field) => clearTranslation('farsi', field)"
                      :has-translation="(field) => hasTranslation('farsi', field)"
                    ></slot>
                  </div>
                </v-window-item>

                <!-- Pashto Tab -->
                <v-window-item value="pashto">
                  <div class="translation-tab">
                    <slot 
                      name="pashto-fields" 
                      :translations="translations.pashto" 
                      :clear-translation="(field) => clearTranslation('pashto', field)"
                      :has-translation="(field) => hasTranslation('pashto', field)"
                    ></slot>
                  </div>
                </v-window-item>
              </v-window>
            </v-form>
          </v-card-text>

          <div class="d-flex flex-row-reverse mb-6 mx-6">
            <v-btn 
              :class="buttonClass" 
              :loading="saving"
              :disabled="saving"
              @click="handleSave"
            >
              <v-icon>mdi-content-save</v-icon>
              {{ getButtonText() }}
            </v-btn>
          </div>
        </v-card>
      </template>
    </v-dialog>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, nextTick } from 'vue'
import { useI18n } from 'vue-i18n'
import { useTranslations } from '../composables/useTranslations'

const props = defineProps({
  // Dialog visibility
  modelValue: {
    type: Boolean,
    default: false
  },
  
  // Form configuration
  formTitle: {
    type: String,
    required: true
  },
  buttonText: {
    type: String,
    default: 'Save'
  },
  buttonClass: {
    type: String,
    default: 'action-btn action-btn-success px-4'
  },
  
  // Dialog configuration
  width: {
    type: String,
    default: '60rem'
  },
  transition: {
    type: String,
    default: 'dialog-top-transition'
  },
  dialogClass: {
    type: String,
    default: 'rtl-dialog'
  },
  
  // Translation configuration
  translatableFields: {
    type: Array,
    required: true
  },
  
  // Form data
  formData: {
    type: Object,
    required: true
  },
  
  // Validation rules
  rules: {
    type: Object,
    default: () => ({})
  },
  
  // Loading state
  saving: {
    type: Boolean,
    default: false
  },
  
  // Direction (auto-computed from locale if not provided)
  dir: {
    type: String,
    default: null
  },
  
  // Whether this is edit mode (has existing record)
  isEditMode: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits([
  'update:modelValue',
  'save',
  'load-translations'
])

const { t, locale } = useI18n()

// Compute direction from locale if not provided
const dir = computed(() => {
  if (props.dir !== null) {
    return props.dir
  }
  return ['fa', 'ps'].includes(locale.value) ? 'rtl' : 'ltr'
})

// Translation composable
const {
  translations,
  initializeTranslations,
  loadTranslations,
  clearTranslation,
  clearLanguageTranslations,
  hasTranslation,
  getCoverageBadgeColor,
  prepareTranslationsForApi,
  translationTabs
} = useTranslations(props.translatableFields)

// Form ref
const formRef = ref(null)

// Active tab
const activeTab = ref('base')

// Track form completion status
const isBaseFilled = ref(false)
const isFarsiFilled = ref(false)
const isPashtoFilled = ref(false)

// Dialog visibility
const isVisible = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})

// Check if base content is filled
const checkBaseFilled = () => {
  const requiredFields = ['title'] // Add other required fields as needed
  isBaseFilled.value = requiredFields.every(field => 
    props.formData[field] && props.formData[field].toString().trim() !== ''
  )
}

// Check if Farsi content is filled
const checkFarsiFilled = () => {
  const hasAnyTranslation = Object.values(translations.farsi).some(value => 
    value && value.toString().trim() !== ''
  )
  isFarsiFilled.value = hasAnyTranslation
}

// Check if Pashto content is filled
const checkPashtoFilled = () => {
  const hasAnyTranslation = Object.values(translations.pashto).some(value => 
    value && value.toString().trim() !== ''
  )
  isPashtoFilled.value = hasAnyTranslation
}

// Function to apply RTL styles to inputs
const applyRTLStyles = () => {
  if (dir.value === 'rtl') {
    nextTick(() => {
      setTimeout(() => {
        // Target all Vuetify input elements within this form
        const formElement = formRef.value?.$el || document
        const inputs = formElement.querySelectorAll?.('.v-field__input, .v-text-field input, .v-textarea textarea, input[type="text"], input[type="number"], textarea') || []
        inputs.forEach((input) => {
          if (input && input.tagName) {
            input.style.setProperty('text-align', 'right', 'important')
            input.style.setProperty('direction', 'rtl', 'important')
          }
        })
      }, 150)
    })
  }
}

// Initialize translations when component mounts
// Only initialize for create mode without incoming translation data
onMounted(() => {
  if (!props.isEditMode && !props.formData?.translationData) {
    initializeTranslations()
  }
  // Apply RTL styles on mount
  applyRTLStyles()
})

// Watch for form data changes to load translations
watch(() => props.formData, (newData, oldData) => {
  console.log('=== TRANSLATABLE FORM WATCHER ===');
  console.log('Form data changed:', newData);
  console.log('Has translations:', !!newData?.translations);
  console.log('Has translationData:', !!newData?.translationData);
  console.log('TranslationData content:', newData?.translationData);
  
  // Prevent unnecessary re-loading if translation data hasn't changed
  if (newData?.translationData && oldData?.translationData && 
      newData.translationData.id === oldData.translationData.id) {
    console.log('Skipping reload - same translation data');
    return;
  }
  
  if (newData && newData.translations) {
    console.log('Loading from old translations format');
    loadTranslations(newData.translations)
  } else if (newData && newData.translationData) {
    console.log('Loading from new JSON translation format');
    console.log('Translation data:', newData.translationData);
    loadTranslations(newData.translationData)
  }
  checkBaseFilled()
}, { deep: true, immediate: true })

// Watch for translation changes
watch(() => translations.farsi, () => {
  checkFarsiFilled()
}, { deep: true })

watch(() => translations.pashto, () => {
  checkPashtoFilled()
}, { deep: true })

// Watch for direction changes
watch(() => dir.value, () => {
  applyRTLStyles()
}, { immediate: true })

// Watch for dialog visibility to apply styles when it opens
watch(() => isVisible.value, (visible) => {
  if (visible) {
    applyRTLStyles()
  }
})

// Get current step for stepper
const getCurrentStep = () => {
  if (activeTab.value === 'base') {
    return 1
  } else if (activeTab.value === 'farsi') {
    return 2
  } else {
    return 3
  }
}

// Get button text based on current state
const getButtonText = () => {
  if (isAllFilled()) {
    return props.isEditMode ? 'Update All Content' : 'Save All Content'
  } else {
    return 'Save All Content'
  }
}

// Check if all sections are filled
const isAllFilled = () => {
  return isBaseFilled.value && (isFarsiFilled.value || isPashtoFilled.value)
}

// Handle save - save everything at once
const handleSave = async () => {
  // Validate form
  const { valid } = await formRef.value.validate()
  if (!valid) return

  // Prepare complete data with base content and translations
  const apiData = {
    ...props.formData,
    translations: prepareTranslationsForApi()
  }

  emit('save', { data: apiData, type: 'complete' })
}

// Expose methods for parent components
defineExpose({
  formRef,
  clearTranslation,
  clearLanguageTranslations,
  loadTranslations
})
</script>

<style scoped>
.translation-tab {
  min-height: 400px;
}

.v-tab {
  text-transform: none !important;
}

.v-chip {
  font-size: 0.7rem;
}

.translation-stepper {
  background: transparent !important;
}

.translation-stepper .v-stepper-item {
  padding: 8px 16px;
}

.translation-stepper .v-stepper-item__title {
  font-size: 0.9rem;
  font-weight: 600;
}

.translation-stepper .v-stepper-item__subtitle {
  font-size: 0.8rem;
  color: #666;
}
</style>

<style>
/* RTL placeholder and input alignment for admin forms */
[dir="rtl"] .v-field__input,
[dir="rtl"] .v-field__input::placeholder,
[dir="rtl"] .v-text-field input,
[dir="rtl"] .v-text-field input::placeholder,
[dir="rtl"] .v-textarea textarea,
[dir="rtl"] .v-textarea textarea::placeholder {
    text-align: right !important;
    direction: rtl !important;
}

[dir="rtl"] .v-field__field input,
[dir="rtl"] .v-field__field textarea {
    text-align: right !important;
    direction: rtl !important;
}

/* Additional RTL support for body class */
body.rtl .v-field__input,
body.rtl .v-field__input::placeholder,
body.rtl .v-text-field input,
body.rtl .v-text-field input::placeholder,
body.rtl .v-textarea textarea,
body.rtl .v-textarea textarea::placeholder {
    text-align: right !important;
    direction: rtl !important;
}

body.rtl .v-field__field input,
body.rtl .v-field__field textarea {
    text-align: right !important;
    direction: rtl !important;
}

/* Universal fallback */
.rtl input::placeholder,
.rtl textarea::placeholder,
.rtl input,
.rtl textarea {
    text-align: right !important;
    direction: rtl !important;
}
</style>
