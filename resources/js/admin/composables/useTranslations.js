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
      translations.farsi[field] = ''
      translations.pashto[field] = ''
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
    const isEmpty = (obj) => !obj || Object.values(obj).every(v => !v || v === '');
    if (isEmpty(translations.farsi) && isEmpty(translations.pashto)) {
      initializeTranslations()
    }
    
    // Load from JSON translation fields
    if (apiData.farsi_translations) {
      console.log('Loading Farsi translations...');
      Object.keys(apiData.farsi_translations).forEach(field => {
        if (translations.farsi[field] !== undefined) {
          translations.farsi[field] = apiData.farsi_translations[field] || ''
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
          translations.pashto[field] = apiData.pashto_translations[field] || ''
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
    const translatedFields = Object.values(translations[language]).filter(value => value && value.trim() !== '').length
    
    return totalFields > 0 ? Math.round((translatedFields / totalFields) * 100) : 0
  }

  // Get translation coverage for all languages
  const getTranslationCoverages = computed(() => ({
    farsi: getTranslationCoverage('farsi'),
    pashto: getTranslationCoverage('pashto')
  }))

  // Check if a field has translation
  const hasTranslation = (language, field) => {
    return translations[language] && 
           translations[language][field] && 
           translations[language][field].trim() !== ''
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
    
    // Only include non-empty translations
    Object.keys(translations.farsi).forEach(field => {
      if (translations.farsi[field] && translations.farsi[field].trim() !== '') {
        result.farsi[field] = translations.farsi[field]
      }
    })
    
    Object.keys(translations.pashto).forEach(field => {
      if (translations.pashto[field] && translations.pashto[field].trim() !== '') {
        result.pashto[field] = translations.pashto[field]
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
