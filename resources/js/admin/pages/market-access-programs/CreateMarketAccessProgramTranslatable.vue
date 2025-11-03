<template>
    <TranslatableForm
        v-model="MarketAccessProgramsRepository.createDialog"
        :form-title="formTitle"
        :button-text="buttonText"
        :translatable-fields="translatableFields"
        :form-data="formData"
        :rules="rules"
        :saving="saving"
        :is-edit-mode="MarketAccessProgramsRepository.isEditMode"
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
                    :items="MarketAccessProgramsRepository.statusOptions"
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

            <!-- Slug and Program Type Row -->
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
                    v-model="formData.program_type"
                    :items="MarketAccessProgramsRepository.programTypeOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('program_type')"
                    class="pb-4 pl-2 w-50"
                    :rules="[rules.required]"
                >
                </v-select>
            </div>

            <!-- Location Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.location"
                    variant="outlined"
                    :label="$t('location')"
                    density="compact"
                    class="pb-4 w-100"
                ></v-text-field>
            </div>

            <!-- Cover Image and Thumbnail Image Row -->
            <div class="flex w-100 image-upload-row mb-4">
                <!-- Cover Image -->
                <div class="w-50 image-upload-wrapper">
                    <label class="image-upload-label mb-3 d-block">{{ $t('cover_image') }}</label>
                    <div class="photo-upload-container">
                        <input
                            ref="coverImageInputRef"
                            type="file"
                            accept="image/png, image/jpeg, image/jpg, image/webp"
                            style="display: none"
                            @change="handleCoverImageUpload"
                        />
                        <img
                            :src="computedCoverImageSrc"
                            class="photo-preview"
                            v-show="computedCoverImageSrc !== null"
                        />
                        <div class="photo-overlay">
                            <button
                                v-if="!computedCoverImageSrc"
                                type="button"
                                @click="openCoverImageInput"
                                class="overlay-button"
                            >
                                <v-icon
                                    size="x-large"
                                    color="blue-grey-lighten-2"
                                >mdi-camera</v-icon>
                            </button>
                            <button
                                v-if="computedCoverImageSrc"
                                type="button"
                                @click="removeCoverImage"
                                class="close-button"
                            >
                                <v-icon size="lg" color="red">mdi-close</v-icon>
                            </button>
                            <button
                                v-if="computedCoverImageSrc"
                                type="button"
                                @click="openCoverImageInput"
                                class="edit-button"
                            >
                                <v-icon size="small">mdi-pencil</v-icon>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Thumbnail Image -->
                <div class="w-50 image-upload-wrapper">
                    <label class="image-upload-label mb-3 d-block">{{ $t('thumbnail_image') }}</label>
                    <div class="photo-upload-container">
                        <input
                            ref="thumbnailImageInputRef"
                            type="file"
                            accept="image/png, image/jpeg, image/jpg, image/webp"
                            style="display: none"
                            @change="handleThumbnailImageUpload"
                        />
                        <img
                            :src="computedThumbnailImageSrc"
                            class="photo-preview"
                            v-show="computedThumbnailImageSrc !== null"
                        />
                        <div class="photo-overlay">
                            <button
                                v-if="!computedThumbnailImageSrc"
                                type="button"
                                @click="openThumbnailImageInput"
                                class="overlay-button"
                            >
                                <v-icon
                                    size="x-large"
                                    color="blue-grey-lighten-2"
                                >mdi-camera</v-icon>
                            </button>
                            <button
                                v-if="computedThumbnailImageSrc"
                                type="button"
                                @click="removeThumbnailImage"
                                class="close-button"
                            >
                                <v-icon size="lg" color="red">mdi-close</v-icon>
                            </button>
                            <button
                                v-if="computedThumbnailImageSrc"
                                type="button"
                                @click="openThumbnailImageInput"
                                class="edit-button"
                            >
                                <v-icon size="small">mdi-pencil</v-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Target Crops Row -->
            <div class="w-100">
                <v-combobox
                    v-model="formData.target_crops"
                    :items="MarketAccessProgramsRepository.targetCropsOptions"
                    item-value="value"
                    item-title="label"
                    variant="outlined"
                    :label="$t('target_crops')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    :hint="$t('hint_target_crops')"
                    persistent-hint
                ></v-combobox>
            </div>

            <!-- Partner Organizations Row -->
            <div class="w-100">
                <v-combobox
                    v-model="formData.partner_organizations"
                    variant="outlined"
                    :label="$t('partner_organizations')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    :hint="$t('hint_partner_organizations')"
                    persistent-hint
                ></v-combobox>
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
                    rows="8"
                    :hint="$t('hint_market_program_description')"
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
                v-model="translations.description"
                field-name="description"
                :field-label="$t('description')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="8"
                :has-translation="hasTranslation('description')"
                @clear="clearTranslation"
            />
            <div class="translation-field mb-4">
                <v-combobox
                    v-model="translations.target_crops"
                    :items="MarketAccessProgramsRepository.targetCropsOptions"
                    item-value="value"
                    item-title="label"
                    variant="outlined"
                    :label="$t('target_crops')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    :hint="$t('hint_target_crops')"
                    persistent-hint
                ></v-combobox>
            </div>
            <div class="translation-field mb-4">
                <v-combobox
                    v-model="translations.partner_organizations"
                    variant="outlined"
                    :label="$t('partner_organizations')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    :hint="$t('hint_partner_organizations')"
                    persistent-hint
                ></v-combobox>
            </div>
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
                :rows="8"
                :has-translation="hasTranslation('description')"
                @clear="clearTranslation"
            />
            <div class="translation-field mb-4">
                <v-combobox
                    v-model="translations.target_crops"
                    :items="MarketAccessProgramsRepository.targetCropsOptions"
                    item-value="value"
                    item-title="label"
                    variant="outlined"
                    :label="$t('target_crops')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    :hint="$t('hint_target_crops')"
                    persistent-hint
                ></v-combobox>
            </div>
            <div class="translation-field mb-4">
                <v-combobox
                    v-model="translations.partner_organizations"
                    variant="outlined"
                    :label="$t('partner_organizations')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    :hint="$t('hint_partner_organizations')"
                    persistent-hint
                ></v-combobox>
            </div>
        </template>
    </TranslatableForm>
    
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { useMarketAccessProgramsRepository } from "../../stores/MarketAccessProgramsRepository";
import { useI18n } from "vue-i18n";
import TranslatableForm from "../../components/TranslatableForm.vue";
import TranslationField from "../../components/TranslationField.vue";
const { t } = useI18n();

const MarketAccessProgramsRepository = useMarketAccessProgramsRepository();
const formTitle = computed(() => MarketAccessProgramsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => MarketAccessProgramsRepository.isEditMode ? t('update') : t('submit'));
const saving = ref(false);

// Translatable fields for MarketAccessProgram model
const translatableFields = ['title', 'description', 'target_crops', 'partner_organizations'];

const formData = reactive({
    id: null,
    title: '',
    slug: '',
    description: '',
    cover_image: '',
    thumbnail_image: '',
    program_type: 'export',
    target_crops: [],
    location: '',
    partner_organizations: [],
    status: 'draft'
});

// Image upload state for cover image
const coverImageFile = ref(null);
const coverImageSrc = ref(null);
const coverImageInputRef = ref(null);
const originalCoverImage = ref(null);

// Image upload state for thumbnail image
const thumbnailImageFile = ref(null);
const thumbnailImageSrc = ref(null);
const thumbnailImageInputRef = ref(null);
const originalThumbnailImage = ref(null);

// Computed image sources
const computedCoverImageSrc = computed(() => {
    return coverImageSrc.value || formData.cover_image || null;
});

const computedThumbnailImageSrc = computed(() => {
    return thumbnailImageSrc.value || formData.thumbnail_image || null;
});

// Watch coverImageFile to update preview
watch(coverImageFile, (newFile) => {
    if (newFile && newFile instanceof File) {
        const validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
        if (!validTypes.includes(newFile.type)) {
            alert(t('please_select_image') || 'Please select a valid image file');
            coverImageFile.value = null;
            coverImageSrc.value = null;
            return;
        }
        if (newFile.size > 3 * 1024 * 1024) {
            alert(t('image_too_large') || 'Image size must be less than 3MB');
            coverImageFile.value = null;
            coverImageSrc.value = null;
            return;
        }
        formData.cover_image = '';
        const reader = new FileReader();
        reader.onload = (e) => {
            coverImageSrc.value = e.target.result;
        };
        reader.onerror = () => {
            console.error('Error reading file');
            coverImageSrc.value = null;
        };
        reader.readAsDataURL(newFile);
    } else if (!newFile) {
        if (!formData.cover_image) {
            coverImageSrc.value = null;
        }
    }
});

// Watch thumbnailImageFile to update preview
watch(thumbnailImageFile, (newFile) => {
    if (newFile && newFile instanceof File) {
        const validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
        if (!validTypes.includes(newFile.type)) {
            alert(t('please_select_image') || 'Please select a valid image file');
            thumbnailImageFile.value = null;
            thumbnailImageSrc.value = null;
            return;
        }
        if (newFile.size > 3 * 1024 * 1024) {
            alert(t('image_too_large') || 'Image size must be less than 3MB');
            thumbnailImageFile.value = null;
            thumbnailImageSrc.value = null;
            return;
        }
        formData.thumbnail_image = '';
        const reader = new FileReader();
        reader.onload = (e) => {
            thumbnailImageSrc.value = e.target.result;
        };
        reader.onerror = () => {
            console.error('Error reading file');
            thumbnailImageSrc.value = null;
        };
        reader.readAsDataURL(newFile);
    } else if (!newFile) {
        if (!formData.thumbnail_image) {
            thumbnailImageSrc.value = null;
        }
    }
});

// Populate form on edit
watch(() => MarketAccessProgramsRepository.currentMarketAccessProgram, (newProgram) => {
    if (newProgram && Object.keys(newProgram).length > 0) {
        formData.id = newProgram.id;
        formData.title = newProgram.title || '';
        formData.slug = newProgram.slug || '';
        formData.description = newProgram.description || '';
        formData.cover_image = newProgram.cover_image || '';
        formData.thumbnail_image = newProgram.thumbnail_image || '';
        formData.program_type = newProgram.program_type || 'export';
        formData.target_crops = newProgram.target_crops || [];
        formData.location = newProgram.location || '';
        formData.partner_organizations = newProgram.partner_organizations || [];
        formData.status = newProgram.status || 'draft';

        // Reset image upload state
        coverImageFile.value = null;
        coverImageSrc.value = formData.cover_image || null;
        originalCoverImage.value = formData.cover_image || null;
        
        thumbnailImageFile.value = null;
        thumbnailImageSrc.value = formData.thumbnail_image || null;
        originalThumbnailImage.value = formData.thumbnail_image || null;

        // Provide translationData so TranslatableForm loads JSON translations
        formData.translationData = {
            ...newProgram,
            farsi_translations: newProgram.farsi_translations || {},
            pashto_translations: newProgram.pashto_translations || {}
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

// Image upload handlers
const openCoverImageInput = () => {
    coverImageInputRef.value?.click();
};

const handleCoverImageUpload = (event) => {
    if (event && event.target && event.target.files && event.target.files.length > 0) {
        coverImageFile.value = event.target.files[0];
    }
};

const removeCoverImage = () => {
    coverImageFile.value = null;
    coverImageSrc.value = null;
    formData.cover_image = '';
    if (coverImageInputRef.value) {
        coverImageInputRef.value.value = '';
    }
};

const openThumbnailImageInput = () => {
    thumbnailImageInputRef.value?.click();
};

const handleThumbnailImageUpload = (event) => {
    if (event && event.target && event.target.files && event.target.files.length > 0) {
        thumbnailImageFile.value = event.target.files[0];
    }
};

const removeThumbnailImage = () => {
    thumbnailImageFile.value = null;
    thumbnailImageSrc.value = null;
    formData.thumbnail_image = '';
    if (thumbnailImageInputRef.value) {
        thumbnailImageInputRef.value.value = '';
    }
};

// Handle save from TranslatableForm - save everything at once
const handleSave = async ({ data }) => {
    saving.value = true;
    try {
        // Prepare FormData for file uploads
        const formDataToSend = new FormData();
        
        // Add all form data except images (handled separately)
        Object.keys(data).forEach(key => {
            if (key !== 'cover_image' && key !== 'thumbnail_image') {
                if (key === 'translations') {
                    formDataToSend.append(key, JSON.stringify(data[key]));
                } else if ((key === 'target_crops' || key === 'partner_organizations') && Array.isArray(data[key])) {
                    data[key].forEach((item, index) => {
                        formDataToSend.append(`${key}[${index}]`, item);
                    });
                } else if (data[key] !== null && data[key] !== undefined) {
                    formDataToSend.append(key, data[key]);
                }
            }
        });
        
        // Handle cover image
        if (coverImageFile.value) {
            formDataToSend.append('cover_image', coverImageFile.value);
        } else if (MarketAccessProgramsRepository.isEditMode && !coverImageSrc.value && !coverImageFile.value && originalCoverImage.value) {
            formDataToSend.append('cover_image', '');
        } else if (formData.cover_image && !formData.cover_image.startsWith('data:') && !coverImageFile.value) {
            formDataToSend.append('cover_image', formData.cover_image);
        } else if (!MarketAccessProgramsRepository.isEditMode) {
            formDataToSend.append('cover_image', '');
        }
        
        // Handle thumbnail image
        if (thumbnailImageFile.value) {
            formDataToSend.append('thumbnail_image', thumbnailImageFile.value);
        } else if (MarketAccessProgramsRepository.isEditMode && !thumbnailImageSrc.value && !thumbnailImageFile.value && originalThumbnailImage.value) {
            formDataToSend.append('thumbnail_image', '');
        } else if (formData.thumbnail_image && !formData.thumbnail_image.startsWith('data:') && !thumbnailImageFile.value) {
            formDataToSend.append('thumbnail_image', formData.thumbnail_image);
        } else if (!MarketAccessProgramsRepository.isEditMode) {
            formDataToSend.append('thumbnail_image', '');
        }

        if (MarketAccessProgramsRepository.isEditMode) {
            const response = await MarketAccessProgramsRepository.updateMarketAccessProgram(formData.id, formDataToSend);
            // Update image URLs from response if uploaded
            const updatedData = response?.data?.data || response?.data || {};
            if (coverImageFile.value && updatedData.cover_image) {
                formData.cover_image = updatedData.cover_image;
                coverImageSrc.value = updatedData.cover_image;
                coverImageFile.value = null;
            }
            if (thumbnailImageFile.value && updatedData.thumbnail_image) {
                formData.thumbnail_image = updatedData.thumbnail_image;
                thumbnailImageSrc.value = updatedData.thumbnail_image;
                thumbnailImageFile.value = null;
            }
        } else {
            await MarketAccessProgramsRepository.createMarketAccessProgram(formDataToSend);
        }
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
}

.image-upload-row {
    gap: 1.5rem;
    margin-bottom: 1rem;
}

.image-upload-wrapper {
    flex: 0 0 calc(50% - 0.75rem);
}

.image-upload-wrapper:first-child {
    padding-right: 0.75rem;
}

.image-upload-wrapper:last-child {
    padding-left: 0.75rem;
}

.photo-upload-container {
    position: relative;
    width: 100%;
    height: 250px;
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
    width: 44px;
    height: 44px;
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
    top: 8px;
    right: 8px;
    width: 32px;
    height: 32px;
    background: rgba(244, 67, 54, 0.9);
}

.close-button:hover {
    background: rgba(244, 67, 54, 1);
    transform: scale(1.1);
}

.edit-button {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 36px;
    height: 36px;
}

.edit-button .v-icon {
    color: rgba(0, 0, 0, 0.87);
}

.close-button .v-icon {
    color: white;
}
</style>
