<template>
    <TranslatableForm
        v-model="NewsRepository.createDialog"
        :form-title="formTitle"
        :button-text="buttonText"
        :translatable-fields="translatableFields"
        :form-data="formData"
        :rules="rules"
        :saving="saving"
        :is-edit-mode="NewsRepository.isEditMode"
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
                    :items="statusOptions"
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

            <!-- Slug Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.slug"
                    variant="outlined"
                    :label="$t('slug')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                    persistent-hint
                ></v-text-field>

                <v-text-field
                    v-model="formData.excerpt"
                    variant="outlined"
                    :label="$t('excerpt')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                    :counter="500"
                    :rules="[rules.maxLength]"
                    persistent-hint
                ></v-text-field>
            </div>

            <!-- Featured Image Section -->
            <div class="w-100 mb-4">
                <label class="image-upload-label mb-2 d-block">{{ $t('featured_image') }}</label>
                
                <div class="photo-upload-container">
                    <input
                        ref="fileInputRef"
                        type="file"
                        accept="image/png, image/jpeg, image/jpg, image/webp"
                        style="display: none"
                        @change="handleImageUpload"
                    />
                    
                    <img
                        :src="computedImageSrc"
                        class="photo-preview"
                        v-show="computedImageSrc !== null"
                    />
                    
                    <div class="photo-overlay">
                        <button
                            v-if="!computedImageSrc"
                            type="button"
                            @click="openFileInput"
                            class="overlay-button"
                        >
                            <v-icon
                                size="x-large"
                                color="blue-grey-lighten-2"
                            >mdi-camera</v-icon>
                        </button>
                        
                        <button
                            v-if="computedImageSrc"
                            type="button"
                            @click="removeImage"
                            class="close-button"
                        >
                            <v-icon size="lg" color="red">mdi-close</v-icon>
                        </button>
                        
                        <button
                            v-if="computedImageSrc"
                            type="button"
                            @click="openFileInput"
                            class="edit-button"
                        >
                            <v-icon size="small">mdi-pencil</v-icon>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Published Date Row -->
            <div class="w-100" v-if="formData.status === 'published'">
                <v-text-field
                    v-model="formData.published_at"
                    variant="outlined"
                    :label="$t('published_date')"
                    density="compact"
                    type="datetime-local"
                    class="pb-4"
                ></v-text-field>
            </div>

            <!-- Content Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.content"
                    variant="outlined"
                    :label="$t('content')"
                    density="compact"
                    class="pb-4"
                    :rules="[rules.required]"
                    rows="8"
                    
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
                :language-label="$t('dari')"
                :has-translation="hasTranslation('title')"
                @clear="clearTranslation"
            />

            <TranslationField
                v-model="translations.excerpt"
                field-name="excerpt"
                :field-label="$t('excerpt')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="3"
                :has-translation="hasTranslation('excerpt')"
                @clear="clearTranslation"
            />

            <TranslationField
                v-model="translations.content"
                field-name="content"
                :field-label="$t('content')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="8"
                :has-translation="hasTranslation('content')"
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
                v-model="translations.excerpt"
                field-name="excerpt"
                :field-label="$t('excerpt')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="3"
                :has-translation="hasTranslation('excerpt')"
                @clear="clearTranslation"
            />

            <TranslationField
                v-model="translations.content"
                field-name="content"
                :field-label="$t('content')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="8"
                :has-translation="hasTranslation('content')"
                @clear="clearTranslation"
            />
        </template>
    </TranslatableForm>
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { useNewsRepository } from "../../stores/NewsRepository";
import { useI18n } from "vue-i18n";
import TranslatableForm from "../../components/TranslatableForm.vue";
import TranslationField from "../../components/TranslationField.vue";

const { t } = useI18n();

const NewsRepository = useNewsRepository();

// Computed status options with translations
const statusOptions = computed(() => {
    return NewsRepository.statusOptionsBase.map(option => ({
        value: option.value,
        label: t(option.labelKey)
    }));
});

const formTitle = computed(() => NewsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => NewsRepository.isEditMode ? t('update') : t('submit'));

// Translatable fields for News model
const translatableFields = ['title', 'excerpt', 'content'];

const formData = reactive({
    id: null,
    title: '',
    slug: '',
    excerpt: '',
    content: '',
    featured_image: '',
    status: 'draft',
    published_at: null
});

// Image upload state
const imageFile = ref(null);
const imageSrc = ref(null);
const fileInputRef = ref(null);

// Computed image source - shows preview if uploaded, otherwise shows existing image
const computedImageSrc = computed(() => {
    return imageSrc.value || formData.featured_image || null;
});

// Watch imageFile to update preview when changed
watch(imageFile, (newFile) => {
    if (newFile && newFile instanceof File) {
        // Validate file type
        const validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
        if (!validTypes.includes(newFile.type)) {
            alert(t('please_select_image') || 'Please select a valid image file (PNG, JPEG, JPG, or WebP)');
            imageFile.value = null;
            imageSrc.value = null;
            return;
        }
        
        // Validate file size (3MB max)
        if (newFile.size > 3 * 1024 * 1024) {
            alert(t('image_too_large') || 'Image size must be less than 3MB');
            imageFile.value = null;
            imageSrc.value = null;
            return;
        }
        
        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imageSrc.value = e.target.result;
        };
        reader.onerror = () => {
            console.error('Error reading file');
            imageSrc.value = null;
        };
        reader.readAsDataURL(newFile);
    } else if (!newFile) {
        // File was removed, but keep existing image if any
        if (!formData.featured_image) {
            imageSrc.value = null;
        }
    }
});

// Watch formData.featured_image to show existing image
watch(() => formData.featured_image, (newUrl) => {
    if (newUrl && !imageSrc.value && !imageFile.value) {
        imageSrc.value = newUrl;
    }
}, { immediate: true });

// Loading state
const saving = ref(false);


// Track original featured image URL for edit mode
const originalFeaturedImage = ref(null);

// Watch for changes in currentNews to populate form
watch(() => NewsRepository.currentNews, async (newNews) => {
    if (newNews && Object.keys(newNews).length > 0) {
        formData.id = newNews.id;
        formData.title = newNews.title || '';
        formData.slug = newNews.slug || '';
        formData.excerpt = newNews.excerpt || '';
        formData.content = newNews.content || '';
        formData.featured_image = newNews.featured_image || '';
        formData.status = newNews.status || 'draft';
        formData.published_at = newNews.published_at ? new Date(newNews.published_at).toISOString().slice(0, 16) : null;
        
        // Reset image upload state and store original image
        imageFile.value = null;
        imageSrc.value = formData.featured_image || null;
        originalFeaturedImage.value = formData.featured_image || null;
        
        // Process translations - handle both JSON format and translations array format
        let farsiTranslations = {};
        let pashtoTranslations = {};
        
        // If translations come as JSON objects (from JSON columns)
        if (newNews.farsi_translations) {
            farsiTranslations = typeof newNews.farsi_translations === 'string' 
                ? JSON.parse(newNews.farsi_translations) 
                : newNews.farsi_translations;
        }
        
        if (newNews.pashto_translations) {
            pashtoTranslations = typeof newNews.pashto_translations === 'string'
                ? JSON.parse(newNews.pashto_translations)
                : newNews.pashto_translations;
        }
        
        // If translations come as an array (from translations table)
        if (newNews.translations && Array.isArray(newNews.translations)) {
            newNews.translations.forEach(translation => {
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
            ...newNews,
            farsi_translations: farsiTranslations,
            pashto_translations: pashtoTranslations
        };
        
        console.log('=== FORM DATA UPDATED ===');
        console.log('Form data:', formData);
        console.log('Translation data:', formData.translationData);
        console.log('Farsi translations:', formData.translationData.farsi_translations);
        console.log('Pashto translations:', formData.translationData.pashto_translations);
        console.log('Raw news translations array:', newNews.translations);
        console.log('========================');
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
        !value || value.length <= 500 || 
        t('excerpt_max_length')
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

// Open file input
const openFileInput = () => {
    fileInputRef.value?.click();
};

// Handle image upload from native file input
const handleImageUpload = (event) => {
    if (event && event.target && event.target.files && event.target.files.length > 0) {
        const file = event.target.files[0];
        // Set the file - the watcher will handle the preview
        imageFile.value = file;
    }
};

// Remove image
const removeImage = () => {
    imageFile.value = null;
    imageSrc.value = null;
    formData.featured_image = '';
    if (fileInputRef.value) {
        fileInputRef.value.value = '';
    }
};


// Handle save - save everything at once
const handleSave = async (saveData) => {
    saving.value = true;
    try {
        if (saveData.type === 'complete') {
            // Prepare FormData for file upload
            const formDataToSend = new FormData();
            
            // Add all form data
            Object.keys(saveData.data).forEach(key => {
                if (key !== 'featured_image') {
                    if (key === 'translations') {
                        formDataToSend.append(key, JSON.stringify(saveData.data[key]));
                    } else if (saveData.data[key] !== null && saveData.data[key] !== undefined) {
                        formDataToSend.append(key, saveData.data[key]);
                    }
                }
            });
            
            // Handle featured image properly
            console.log('Image state:', {
                imageFile: imageFile.value,
                imageSrc: imageSrc.value,
                formDataFeaturedImage: formData.featured_image,
                originalFeaturedImage: originalFeaturedImage.value,
                isEditMode: NewsRepository.isEditMode
            });
            
            if (imageFile.value) {
                // When a new file is uploaded, send ONLY the file
                // The backend will handle the file upload
                console.log('Sending new file:', imageFile.value.name);
                formDataToSend.append('featured_image', imageFile.value);
            } else if (NewsRepository.isEditMode && !imageSrc.value && !imageFile.value && originalFeaturedImage.value) {
                // In edit mode: if image was removed (was there before, but now cleared)
                // Send empty string to clear the existing image
                console.log('Clearing existing image');
                formDataToSend.append('featured_image', '');
            } else if (formData.featured_image && !formData.featured_image.startsWith('data:') && !imageFile.value) {
                // If URL provided and no new file uploaded (keep existing URL)
                console.log('Keeping existing image URL');
                formDataToSend.append('featured_image', formData.featured_image);
            } else if (!NewsRepository.isEditMode) {
                // For create mode with no image
                console.log('Create mode - no image');
                formDataToSend.append('featured_image', '');
            } else {
                console.log('Edit mode - keeping existing image (not sending featured_image field)');
            }
            // For edit mode with no changes to image, don't send featured_image field
            // The backend will keep the existing value
            
            // Convert published_at to proper format if provided
            if (formData.published_at) {
                formDataToSend.set('published_at', new Date(formData.published_at).toISOString());
            } else if (formData.status === 'published') {
                formDataToSend.set('published_at', new Date().toISOString());
            }

            // Log translations before sending
            const translationsData = saveData.data.translations || {};
            console.log('=== SAVING TRANSLATIONS ===');
            console.log('Translations object:', translationsData);
            console.log('Farsi translations:', translationsData.farsi);
            console.log('Pashto translations:', translationsData.pashto);
            console.log('Translations JSON string:', JSON.stringify(translationsData));
            console.log('===========================');

            if (NewsRepository.isEditMode) {
                await NewsRepository.updateNews(formData.id, formDataToSend);
            } else {
                await NewsRepository.createNews(formDataToSend);
            }
        }
    } catch (error) {
        console.error('Error saving news:', error);
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

/* Image Upload Styles */
.image-upload-label {
    font-weight: 500;
    color: rgba(0, 0, 0, 0.87);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.photo-upload-container {
    position: relative;
    width: 100%;
    height: 300px;
    border: 2px dashed rgba(0, 0, 0, 0.38);
    border-radius: 8px;
    overflow: hidden;
    background: #fafafa;
    cursor: pointer;
    transition: all 0.3s ease;
}

.photo-upload-container:hover {
    border-color: rgba(25, 118, 210, 0.5);
    background: #f5f5f5;
}

.photo-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.3);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.photo-upload-container:hover .photo-overlay {
    opacity: 1;
}

.overlay-button,
.close-button,
.edit-button {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.overlay-button:hover,
.edit-button:hover {
    background: rgba(255, 255, 255, 1);
    transform: scale(1.1);
}

.close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 36px;
    height: 36px;
    background: rgba(244, 67, 54, 0.9);
}

.close-button:hover {
    background: rgba(244, 67, 54, 1);
    transform: scale(1.1);
}

.edit-button {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 40px;
    height: 40px;
}

.edit-button .v-icon {
    color: rgba(0, 0, 0, 0.87);
}

.close-button .v-icon {
    color: white;
}

/* Form spacing improvements */
.flex.w-100 {
    gap: 1rem;
}

.pb-4 {
    margin-bottom: 0;
}
</style>

