<template>
    <TranslatableForm
        v-model="SuccessStoriesRepository.createDialog"
        :form-title="formTitle"
        :button-text="buttonText"
        :translatable-fields="translatableFields"
        :form-data="formData"
        :rules="rules"
        :saving="saving"
        :is-edit-mode="SuccessStoriesRepository.isEditMode"
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
                    :items="SuccessStoriesRepository.statusOptions"
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

            <!-- Slug and Client Name Row -->
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

                <v-text-field
                    v-model="formData.client_name"
                    variant="outlined"
                    :label="$t('client_name')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
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

            <!-- Story Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.story"
                    variant="outlined"
                    :label="$t('content')"
                    density="compact"
                    class="pb-4"
                    :rules="[rules.required]"
                    rows="8"
                    :hint="$t('hint_success_story_content')"
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
                v-model="translations.client_name"
                field-name="client_name"
                :field-label="$t('client_name')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('client_name')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.story"
                field-name="story"
                :field-label="$t('content')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="8"
                :has-translation="hasTranslation('story')"
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
                v-model="translations.client_name"
                field-name="client_name"
                :field-label="$t('client_name')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('client_name')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.story"
                field-name="story"
                :field-label="$t('content')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="8"
                :has-translation="hasTranslation('story')"
                @clear="clearTranslation"
            />
        </template>
    </TranslatableForm>
    
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { useSuccessStoriesRepository } from "../../stores/SuccessStoriesRepository";
import { useI18n } from "vue-i18n";
import TranslatableForm from "../../components/TranslatableForm.vue";
import TranslationField from "../../components/TranslationField.vue";
const { t } = useI18n();

const SuccessStoriesRepository = useSuccessStoriesRepository();
const formTitle = computed(() => SuccessStoriesRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => SuccessStoriesRepository.isEditMode ? t('update') : t('submit'));
const saving = ref(false);

// Translatable fields for SuccessStory model
const translatableFields = ['title', 'client_name', 'story'];

const formData = reactive({
    id: null,
    title: '',
    slug: '',
    client_name: '',
    story: '',
    image: '',
    status: 'draft',
    published_at: null
});

// Image upload state
const imageFile = ref(null);
const imageSrc = ref(null);
const fileInputRef = ref(null);

// Computed image source - shows preview if uploaded, otherwise shows existing image
const computedImageSrc = computed(() => {
    return imageSrc.value || formData.image || null;
});

// Track original featured image URL for edit mode
const originalFeaturedImage = ref(null);

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
        
        // Clear old image URL when new file is uploaded
        formData.image = '';
        
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
        if (!formData.image) {
            imageSrc.value = null;
        }
    }
});

// Watch formData.image to show existing image
watch(() => formData.image, (newUrl) => {
    if (newUrl && !imageSrc.value && !imageFile.value) {
        imageSrc.value = newUrl;
    }
}, { immediate: true });

// Populate form on edit
watch(() => SuccessStoriesRepository.currentSuccessStory, (newStory) => {
    if (newStory && Object.keys(newStory).length > 0) {
        formData.id = newStory.id;
        formData.title = newStory.title || '';
        formData.slug = newStory.slug || '';
        formData.client_name = newStory.client_name || '';
        formData.story = newStory.story || '';
        formData.image = newStory.image || '';
        formData.status = newStory.status || 'draft';
        formData.published_at = newStory.published_at ? new Date(newStory.published_at).toISOString().slice(0, 16) : null;

        // Reset image upload state and store original image
        imageFile.value = null;
        imageSrc.value = formData.image || null;
        originalFeaturedImage.value = formData.image || null;

        // Provide translationData so TranslatableForm loads JSON translations
        formData.translationData = {
            ...newStory,
            farsi_translations: newStory.farsi_translations || {},
            pashto_translations: newStory.pashto_translations || {}
        };
    }
}, { deep: true, immediate: true });

const rules = {
    required: (value) => !!value || t('field_required'),
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
    formData.image = '';
    if (fileInputRef.value) {
        fileInputRef.value.value = '';
    }
};

// Handle save from TranslatableForm - save everything at once
const handleSave = async (saveData) => {
    saving.value = true;
    try {
        if (saveData.type === 'complete') {
            // Prepare FormData for file upload
            const formDataToSend = new FormData();
            
            // Add all form data except image (handled separately)
            // Map form field names to backend expected names
            Object.keys(saveData.data).forEach(key => {
                if (key !== 'image') {
                    if (key === 'translations') {
                        // Send translations as JSON string - backend will parse it
                        const translations = saveData.data[key] || {};
                        formDataToSend.append(key, JSON.stringify(translations));
                    } else if (key === 'story') {
                        // Backend expects 'content', but form uses 'story'
                        formDataToSend.append('content', saveData.data[key]);
                    } else if (key === 'client_name') {
                        // Backend expects 'author_name', but form uses 'client_name'
                        formDataToSend.append('author_name', saveData.data[key]);
                    } else if (saveData.data[key] !== null && saveData.data[key] !== undefined) {
                        formDataToSend.append(key, saveData.data[key]);
                    }
                }
            });
            
            // Handle featured image properly - backend expects 'featured_image'
            if (imageFile.value) {
                // When a new file is uploaded, send ONLY the file
                formDataToSend.append('featured_image', imageFile.value);
            } else if (SuccessStoriesRepository.isEditMode && !imageSrc.value && !imageFile.value && originalFeaturedImage.value) {
                // In edit mode: if image was removed (was there before, but now cleared)
                // Send empty string to clear the existing image
                formDataToSend.append('featured_image', '');
            } else if (formData.image && !formData.image.startsWith('data:') && !imageFile.value) {
                // If URL provided and no new file uploaded (keep existing URL)
                formDataToSend.append('featured_image', formData.image);
            } else if (!SuccessStoriesRepository.isEditMode) {
                // For create mode with no image
                formDataToSend.append('featured_image', '');
            }
            // For edit mode with no changes to image, don't send featured_image field
            // The backend will keep the existing value
            
            // Convert published_at to proper format if provided
            if (formData.published_at) {
                formDataToSend.set('published_at', new Date(formData.published_at).toISOString());
            } else if (formData.status === 'published') {
                formDataToSend.set('published_at', new Date().toISOString());
            }

            if (SuccessStoriesRepository.isEditMode) {
                const response = await SuccessStoriesRepository.updateSuccessStory(formData.id, formDataToSend);
                // If image was uploaded, update formData.image with the new URL from response
                // Response structure: response.data.data.image or response.data.image
                const updatedImage = response?.data?.data?.image || response?.data?.image;
                if (imageFile.value && updatedImage) {
                    formData.image = updatedImage;
                    imageSrc.value = updatedImage;
                    imageFile.value = null; // Clear the file since it's now saved
                    // Also update currentSuccessStory in repository so it shows the new image if form is reopened
                    if (SuccessStoriesRepository.currentSuccessStory) {
                        SuccessStoriesRepository.currentSuccessStory.image = updatedImage;
                    }
                }
            } else {
                await SuccessStoriesRepository.createSuccessStory(formDataToSend);
            }
        }
    } catch (error) {
        console.error('Error saving success story:', error);
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












