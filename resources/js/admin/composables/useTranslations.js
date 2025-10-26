import { ref, reactive, computed } from 'vue'
import { useI18n } from 'vue-i18n'

export function useTranslations(translatableFields = []) {
  const { t } = useI18n()
  
  // Translation form data structure
  const translations = reactive({
    farsi: {},
    pashto: {}
  })

  // Initialize empty translation objects for each field
  const initializeTranslations = () => {
    translatableFields.forEach(field => {
      // Initialize array fields as empty arrays, other fields as empty strings
      if (field === 'target_crops' || field === 'partner_organizations' || field === 'features') {
        translations.farsi[field] = []
        translations.pashto[field] = []
      } else {
        translations.farsi[field] = ''
        translations.pashto[field] = ''
      }
    })
  }

  // Load translations from API response (JSON format)
  const loadTranslations = (apiData = {}) => {
    console.log('=== LOAD TRANSLATIONS DEBUG ===');
    console.log('API Data received:', apiData);
    console.log('Farsi translations:', apiData.farsi_translations);
    console.log('Pashto translations:', apiData.pashto_translations);
    console.log('Translatable fields:', translatableFields);
    
    // If translations already have values (edit mode), do not wipe them first
    const isEmpty = (obj) => {
      if (!obj) return true
      return Object.values(obj).every(v => {
        // For strings, check if empty after trim
        if (typeof v === 'string') {
          return !v || v === ''
        }
        // For arrays, check if empty
        if (Array.isArray(v)) {
          return v.length === 0
        }
        // For other types, check if falsy
        return !v
      })
    }
    if (isEmpty(translations.farsi) && isEmpty(translations.pashto)) {
      initializeTranslations()
    }
    
    // Helper function to parse value - convert JSON strings back to arrays if needed
    const parseValue = (value, fieldName) => {
      // Check if field is target_crops, partner_organizations, or features (which should be arrays)
      if ((fieldName === 'target_crops' || fieldName === 'partner_organizations' || fieldName === 'features') && typeof value === 'string') {
        try {
          const parsed = JSON.parse(value)
          if (Array.isArray(parsed)) {
            return parsed
          }
        } catch (e) {
          console.warn(`Failed to parse JSON for field ${fieldName}:`, e)
        }
      }
      return value || ''
    }
    
    // Load from JSON translation fields
    if (apiData.farsi_translations) {
      console.log('Loading Farsi translations...');
      Object.keys(apiData.farsi_translations).forEach(field => {
        if (translations.farsi[field] !== undefined) {
          translations.farsi[field] = parseValue(apiData.farsi_translations[field], field)
          console.log(`Set farsi.${field}:`, apiData.farsi_translations[field])
        }
      })
    } else {
      console.log('No Farsi translations found in API data');
    }
    
    if (apiData.pashto_translations) {
      console.log('Loading Pashto translations...');
      Object.keys(apiData.pashto_translations).forEach(field => {
        if (translations.pashto[field] !== undefined) {
          translations.pashto[field] = parseValue(apiData.pashto_translations[field], field)
          console.log(`Set pashto.${field}:`, apiData.pashto_translations[field])
        }
      })
    } else {
      console.log('No Pashto translations found in API data');
    }
    
    console.log('Final translations state:', translations);
    console.log('================================');
  }

  // Clear specific translation field
  const clearTranslation = (language, field) => {
    if (translations[language] && translations[language][field] !== undefined) {
      translations[language][field] = ''
    }
  }

  // Clear all translations for a language
  const clearLanguageTranslations = (language) => {
    if (translations[language]) {
      Object.keys(translations[language]).forEach(field => {
        translations[language][field] = ''
      })
    }
  }

  // Get translation coverage for a language
  const getTranslationCoverage = (language) => {
    if (!translations[language]) return 0
    
    const totalFields = translatableFields.length
    const translatedFields = Object.values(translations[language]).filter(value => {
      // For strings, check if trimmed value is not empty
      if (typeof value === 'string') {
        return value && value.trim() !== ''
      }
      // For arrays, check if not empty
      if (Array.isArray(value)) {
        return value.length > 0
      }
      // For other types, check if truthy
      return !!value
    }).length
    
    return totalFields > 0 ? Math.round((translatedFields / totalFields) * 100) : 0
  }

  // Get translation coverage for all languages
  const getTranslationCoverages = computed(() => ({
    farsi: getTranslationCoverage('farsi'),
    pashto: getTranslationCoverage('pashto')
  }))

  // Check if a field has translation
  const hasTranslation = (language, field) => {
    if (!translations[language] || !translations[language][field]) {
      return false
    }
    const value = translations[language][field]
    
    // For strings, check if trimmed value is not empty
    if (typeof value === 'string') {
      return value.trim() !== ''
    }
    
    // For arrays, check if not empty
    if (Array.isArray(value)) {
      return value.length > 0
    }
    
    // For other types, check if truthy
    return !!value
  }

  // Get translation badge color based on coverage
  const getCoverageBadgeColor = (coverage) => {
    if (coverage === 100) return 'success'
    if (coverage >= 50) return 'warning'
    return 'error'
  }

  // Prepare translations for API submission
  const prepareTranslationsForApi = () => {
    const result = { farsi: {}, pashto: {} }
    
    // Helper function to check if a value is non-empty
    const isNonEmpty = (value) => {
      // For strings, check if trimmed value is not empty
      if (typeof value === 'string') {
        return value.trim() !== ''
      }
      // For arrays, check if it's not empty
      if (Array.isArray(value)) {
        return value.length > 0
      }
      // For other types, check if truthy
      return !!value
    }
    
    // Only include non-empty translations
    Object.keys(translations.farsi).forEach(field => {
      if (isNonEmpty(translations.farsi[field])) {
        // Convert arrays to JSON strings for API
        if (Array.isArray(translations.farsi[field])) {
          result.farsi[field] = JSON.stringify(translations.farsi[field])
        } else {
          result.farsi[field] = translations.farsi[field]
        }
      }
    })
    
    Object.keys(translations.pashto).forEach(field => {
      if (isNonEmpty(translations.pashto[field])) {
        // Convert arrays to JSON strings for API
        if (Array.isArray(translations.pashto[field])) {
          result.pashto[field] = JSON.stringify(translations.pashto[field])
        } else {
          result.pashto[field] = translations.pashto[field]
        }
      }
    })
    
    
    return result
  }

  // Language labels
  const languageLabels = {
    farsi: t('dari'),
    pashto: t('pashto')
  }

  // Tab configuration for forms
  const translationTabs = computed(() => [
    {
      key: 'base',
      title: t('english'),
      icon: 'mdi-translate'
    },
    {
      key: 'farsi',
      title: t('dari'),
      icon: 'mdi-flag',
      coverage: getTranslationCoverages.value.farsi
    },
    {
      key: 'pashto',
      title: t('pashto'),
      icon: 'mdi-flag',
      coverage: getTranslationCoverages.value.pashto
    }
  ])

  return {
    translations,
    initializeTranslations,
    loadTranslations,
    clearTranslation,
    clearLanguageTranslations,
    getTranslationCoverage,
    getTranslationCoverages,
    hasTranslation,
    getCoverageBadgeColor,
    prepareTranslationsForApi,
    languageLabels,
    translationTabs
  }
}
