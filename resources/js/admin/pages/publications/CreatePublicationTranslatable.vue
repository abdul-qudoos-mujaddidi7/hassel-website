<template>
    <TranslatableForm
        v-model="PublicationsRepository.createDialog"
        :form-title="formTitle"
        :button-text="buttonText"
        :translatable-fields="translatableFields"
        :form-data="formData"
        :rules="rules"
        :saving="saving"
        :is-edit-mode="PublicationsRepository.isEditMode"
        @save="handleSave"
    >
        <!-- Base Language Tab (English) -->
        <template #base-fields="{ formData, rules }">
            <!-- Title and Status Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.title"
                    variant="outlined"
                    :label="$t('title')"
                    density="compact"
                    class="pb-4 pr-2 w-75"
                    :rules="[rules.required]"
                    @input="generateSlug"
                ></v-text-field>

                <v-select
                    v-model="formData.status"
                    :items="PublicationsRepository.statusOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('status')"
                    class="pb-4 pl-2 w-25"
                    :rules="[rules.required]"
                >
                </v-select>
            </div>

            <!-- Slug and File Type Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.slug"
                    variant="outlined"
                    :label="$t('slug')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                    :hint="$t('hint_url_friendly')"
                    persistent-hint
                ></v-text-field>

                <v-select
                    v-model="formData.file_type"
                    :items="PublicationsRepository.fileTypeOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('file_type')"
                    class="pb-4 pl-2 w-50"
                >
                </v-select>
            </div>

            <!-- File Path Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.file_path"
                    variant="outlined"
                    :label="$t('file_path')"
                    density="compact"
                    class="pb-4 pr-2 w-75"
                    :hint="$t('hint_file_path')"
                    persistent-hint
                ></v-text-field>

                <v-text-field
                    v-model="formData.published_at"
                    variant="outlined"
                    :label="$t('published_date')"
                    density="compact"
                    type="datetime-local"
                    class="pb-4 pl-2 w-25"
                    v-if="formData.status === 'published'"
                ></v-text-field>
            </div>

            <!-- File Upload Section -->
            <div class="w-100 mb-4">
                <v-file-input
                    v-model="fileInput"
                    :label="$t('upload_file')"
                    variant="outlined"
                    density="compact"
                    :accept="getAcceptedFileTypes()"
                    @change="handleFileUpload"
                    show-size
                    counter
                ></v-file-input>
                <div class="text-caption text-grey mt-1">
                    Supported formats: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT
                </div>
            </div>

            <!-- Description Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.description"
                    variant="outlined"
                    :label="$t('description')"
                    density="compact"
                    class="pb-4"
                    :rules="[rules.required]"
                    rows="6"
                    :hint="$t('hint_publication_description')"
                    persistent-hint
                ></v-textarea>
            </div>
        </template>

        <!-- Farsi Translation Tab -->
        <template #farsi-fields="{ translations, clearTranslation, hasTranslation }">
            <TranslationField
                v-model="translations.title"
                field-name="title"
                :field-label="$t('title')"
                language="farsi"
                :language-label="$t('farsi')"
                :has-translation="hasTranslation('title')"
                @clear="clearTranslation"
            />

            <TranslationField
                v-model="translations.description"
                field-name="description"
                :field-label="$t('description')"
                language="farsi"
                :language-label="$t('farsi')"
                field-type="textarea"
                :rows="6"
                :has-translation="hasTranslation('description')"
                @clear="clearTranslation"
            />
        </template>

        <!-- Pashto Translation Tab -->
        <template #pashto-fields="{ translations, clearTranslation, hasTranslation }">
            <TranslationField
                v-model="translations.title"
                field-name="title"
                :field-label="$t('title')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('title')"
                @clear="clearTranslation"
            />

            <TranslationField
                v-model="translations.description"
                field-name="description"
                :field-label="$t('description')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="6"
                :has-translation="hasTranslation('description')"
                @clear="clearTranslation"
            />
        </template>
    </TranslatableForm>
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { usePublicationsRepository } from "../../stores/PublicationsRepository";
import { useI18n } from "vue-i18n";
import TranslatableForm from "../../components/TranslatableForm.vue";
import TranslationField from "../../components/TranslationField.vue";

const { t } = useI18n();

const PublicationsRepository = usePublicationsRepository();
const formTitle = computed(() => PublicationsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => PublicationsRepository.isEditMode ? t('update') : t('submit'));

// Translatable fields for Publication model
const translatableFields = ['title', 'description'];

const formData = reactive({
    id: null,
    title: '',
    slug: '',
    description: '',
    file_path: '',
    file_type: '',
    status: 'draft',
    published_at: null
});

// File upload
const fileInput = ref(null);

// Loading state
const saving = ref(false);

// Watch for changes in currentPublication to populate form
watch(() => PublicationsRepository.currentPublication, async (newPublication) => {
    if (newPublication && Object.keys(newPublication).length > 0) {
        formData.id = newPublication.id;
        formData.title = newPublication.title || '';
        formData.slug = newPublication.slug || '';
        formData.description = newPublication.description || '';
        formData.file_path = newPublication.file_path || '';
        formData.file_type = newPublication.file_type || '';
        formData.status = newPublication.status || 'draft';
        formData.published_at = newPublication.published_at ? new Date(newPublication.published_at).toISOString().slice(0, 16) : null;
        
        // Process translations - handle both JSON format and translations array format
        let farsiTranslations = {};
        let pashtoTranslations = {};
        
        // If translations come as JSON objects (from JSON columns)
        if (newPublication.farsi_translations) {
            farsiTranslations = typeof newPublication.farsi_translations === 'string' 
                ? JSON.parse(newPublication.farsi_translations) 
                : newPublication.farsi_translations;
        }
        
        if (newPublication.pashto_translations) {
            pashtoTranslations = typeof newPublication.pashto_translations === 'string'
                ? JSON.parse(newPublication.pashto_translations)
                : newPublication.pashto_translations;
        }
        
        // If translations come as an array (from translations table)
        if (newPublication.translations && Array.isArray(newPublication.translations)) {
            newPublication.translations.forEach(translation => {
                const field = translation.field_name;
                const content = translation.content;
                
                if (translation.language === 'farsi' || translation.language === 'fa') {
                    farsiTranslations[field] = content;
                } else if (translation.language === 'pashto' || translation.language === 'ps') {
                    pashtoTranslations[field] = content;
                }
            });
        }
        
        // Set translation data for the form
        formData.translationData = {
            ...newPublication,
            farsi_translations: farsiTranslations,
            pashto_translations: pashtoTranslations
        };
        
        console.log('=== FORM DATA UPDATED ===');
        console.log('Form data:', formData);
        console.log('Translation data:', formData.translationData);
        console.log('Farsi translations:', formData.translationData.farsi_translations);
        console.log('Pashto translations:', formData.translationData.pashto_translations);
        console.log('Raw publication translations array:', newPublication.translations);
        console.log('Is Edit Mode:', PublicationsRepository.isEditMode);
        console.log('========================');
        
        // Force a small delay to ensure TranslatableForm has processed the translationData
        await new Promise(resolve => setTimeout(resolve, 100));
    }
}, { deep: true, immediate: true });

// Watch for status changes to set published_at
watch(() => formData.status, (newStatus) => {
    if (newStatus === 'published' && !formData.published_at) {
        formData.published_at = new Date().toISOString().slice(0, 16);
    }
});

const rules = {
    required: (value) => !!value || t('field_required'),
    maxLength: (value) => 
        !value || value.length <= 1000 || 
        t('max_length_1000')
};

// Generate slug from title
const generateSlug = () => {
    if (formData.title && !formData.slug) {
        formData.slug = formData.title
            .toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
    }
};

// File upload handling
const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Handle file upload logic here
        console.log('File selected:', file);
    }
};

const getAcceptedFileTypes = () => {
    return '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt';
};

// Handle save with translation support
const handleSave = async (saveEvent) => {
    saving.value = true;
    try {
        if (saveEvent?.type !== 'complete') {
            return;
        }
        
        // Prepare FormData for file upload
        const formDataToSend = new FormData();
        
        // Log save event data for debugging
        console.log('=== SAVE EVENT DATA ===');
        console.log('Full saveEvent.data:', saveEvent.data);
        console.log('Translations in saveEvent:', saveEvent.data.translations);
        console.log('FormData id:', formData.id);
        console.log('Is Edit Mode:', PublicationsRepository.isEditMode);
        console.log('========================');
        
        // Add all form data (excluding file-related keys that need special handling)
        Object.keys(saveEvent.data).forEach(key => {
            if (key !== 'file' && key !== 'featured_image' && key !== 'translationData') {
                if (key === 'translations') {
                    // Stringify translations for FormData
                    const translationsStr = JSON.stringify(saveEvent.data[key] || {});
                    formDataToSend.append(key, translationsStr);
                    console.log('Added translations to FormData:', translationsStr);
                } else if (saveEvent.data[key] !== null && saveEvent.data[key] !== undefined) {
                    formDataToSend.append(key, saveEvent.data[key]);
                }
            }
        });
        
        // Ensure ID is included for edit mode
        if (PublicationsRepository.isEditMode && formData.id) {
            formDataToSend.set('id', formData.id);
        }
        
        // Handle file upload if provided
        if (fileInput.value && fileInput.value.length > 0) {
            formDataToSend.append('file', fileInput.value[0]);
        }
        
        // Convert published_at to proper format if provided
        if (formData.published_at) {
            formDataToSend.set('published_at', new Date(formData.published_at).toISOString());
        } else if (formData.status === 'published') {
            formDataToSend.set('published_at', new Date().toISOString());
        }
        
        // Log FormData contents before sending
        console.log('=== FORM DATA TO SEND ===');
        console.log('FormData entries:');
        for (let pair of formDataToSend.entries()) {
            console.log(pair[0] + ': ' + (pair[0] === 'translations' ? pair[1] : pair[1]));
        }
        console.log('========================');

        if (PublicationsRepository.isEditMode) {
            await PublicationsRepository.updatePublication(formData.id, formDataToSend);
        } else {
            await PublicationsRepository.createPublication(formDataToSend);
        }
    } catch (error) {
        console.error('Error saving publication:', error);
        console.error('Error details:', error.response?.data);
        // Handle error (show notification, etc.)
    } finally {
        saving.value = false;
    }
};
</script>

<style scoped>
.rtl-dialog .v-dialog {
    direction: rtl;
}
</style>



