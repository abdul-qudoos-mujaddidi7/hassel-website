<template>
    <TranslatableForm
        v-model="SeedSupplyProgramsRepository.createDialog"
        :form-title="formTitle"
        :button-text="buttonText"
        :translatable-fields="translatableFields"
        :form-data="formData"
        :rules="rules"
        :saving="saving"
        :is-edit-mode="SeedSupplyProgramsRepository.isEditMode"
        @save="handleSave"
    >
        <!-- Base Language Tab (English) -->
        <template #base-fields="{ formData, rules }">
            <!-- Name and Status Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.name"
                    variant="outlined"
                    :label="$t('name')"
                    density="compact"
                    class="pb-4 pr-2 w-75"
                    :rules="[rules.required]"
                    @input="generateSlug"
                ></v-text-field>

                <v-select
                    v-model="formData.status"
                    :items="SeedSupplyProgramsRepository.statusOptions"
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

            <!-- Slug and Input Type Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.slug"
                    variant="outlined"
                    :label="$t('slug')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                    :hint="$t('hint_url_friendly_name')"
                    persistent-hint
                ></v-text-field>

                <v-select
                    v-model="formData.input_type"
                    :items="SeedSupplyProgramsRepository.inputTypeOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('input_type')"
                    class="pb-4 pl-2 w-50"
                    :rules="[rules.required]"
                >
                </v-select>
            </div>

            <!-- Quality Grade and Availability Row -->
            <div class="flex w-100">
                <v-select
                    v-model="formData.quality_grade"
                    :items="SeedSupplyProgramsRepository.qualityGradeOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('quality_grade')"
                    class="pb-4 pr-2 w-50"
                ></v-select>

                <v-select
                    v-model="formData.availability"
                    :items="SeedSupplyProgramsRepository.availabilityOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('availability')"
                    class="pb-4 pl-2 w-50"
                    :rules="[rules.required]"
                >
                </v-select>
            </div>

            <!-- Price Range and Shelf Life Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.price_range"
                    variant="outlined"
                    :label="$t('price_range')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                    :hint="$t('hint_price_per_kg')"
                    persistent-hint
                ></v-text-field>

                <v-text-field
                    v-model="formData.shelf_life"
                    variant="outlined"
                    :label="$t('shelf_life')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                    :hint="$t('hint_warranty_period')"
                    persistent-hint
                ></v-text-field>
            </div>

            <!-- Supplier and Contact Info Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.supplier"
                    variant="outlined"
                    :label="$t('supplier')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                ></v-text-field>

                <v-text-field
                    v-model="formData.contact_info"
                    variant="outlined"
                    :label="$t('contact_info')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
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
                    :items="SeedSupplyProgramsRepository.targetCropsOptions"
                    item-value="value"
                    item-title="label"
                    variant="outlined"
                    :label="$t('target_crops')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    :hint="$t('hint_suitable_crops')"
                    persistent-hint
                ></v-combobox>
            </div>

            <!-- Distribution Centers Row -->
            <div class="w-100">
                <v-combobox
                    v-model="formData.distribution_centers"
                    variant="outlined"
                    :label="$t('distribution_centers')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    :hint="$t('hint_distribution_centers')"
                    persistent-hint
                ></v-combobox>
            </div>

            <!-- Short Description Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.short_description"
                    variant="outlined"
                    :label="$t('short_description')"
                    density="compact"
                    class="pb-4"
                    rows="3"
                    :hint="$t('hint_seed_brief')"
                    persistent-hint
                ></v-textarea>
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
                    :hint="$t('hint_seed_detailed')"
                    persistent-hint
                ></v-textarea>
            </div>

            <!-- Usage Instructions Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.usage_instructions"
                    variant="outlined"
                    :label="$t('usage_instructions')"
                    density="compact"
                    class="pb-4"
                    rows="6"
                    :hint="$t('hint_input_instructions')"
                    persistent-hint
                ></v-textarea>
            </div>

            <!-- Technical Specifications Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.technical_specifications"
                    variant="outlined"
                    :label="$t('technical_specifications')"
                    density="compact"
                    class="pb-4"
                    rows="4"
                    :hint="$t('hint_technical_details')"
                    persistent-hint
                ></v-textarea>
            </div>
        </template>

        <!-- Farsi Translation Tab -->
        <template #farsi-fields="{ translations, clearTranslation, hasTranslation }">
            <TranslationField
                v-model="translations.name"
                field-name="name"
                :field-label="$t('name')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('name')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.short_description"
                field-name="short_description"
                :field-label="$t('short_description')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="3"
                :has-translation="hasTranslation('short_description')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.description"
                field-name="description"
                :field-label="$t('description')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="6"
                :has-translation="hasTranslation('description')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.input_type"
                field-name="input_type"
                :field-label="$t('input_type')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('input_type')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.target_crops"
                field-name="target_crops"
                :field-label="$t('target_crops')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('target_crops')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.distribution_centers"
                field-name="distribution_centers"
                :field-label="$t('distribution_centers')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('distribution_centers')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.usage_instructions"
                field-name="usage_instructions"
                :field-label="$t('usage_instructions')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="6"
                :has-translation="hasTranslation('usage_instructions')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.technical_specifications"
                field-name="technical_specifications"
                :field-label="$t('technical_specifications')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('technical_specifications')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.supplier"
                field-name="supplier"
                :field-label="$t('supplier')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('supplier')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.contact_info"
                field-name="contact_info"
                :field-label="$t('contact_info')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('contact_info')"
                @clear="clearTranslation"
            />
        </template>

        <!-- Pashto Translation Tab -->
        <template #pashto-fields="{ translations, clearTranslation, hasTranslation }">
            <TranslationField
                v-model="translations.name"
                field-name="name"
                :field-label="$t('name')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('name')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.short_description"
                field-name="short_description"
                :field-label="$t('short_description')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="3"
                :has-translation="hasTranslation('short_description')"
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
            <TranslationField
                v-model="translations.input_type"
                field-name="input_type"
                :field-label="$t('input_type')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('input_type')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.target_crops"
                field-name="target_crops"
                :field-label="$t('target_crops')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('target_crops')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.distribution_centers"
                field-name="distribution_centers"
                :field-label="$t('distribution_centers')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('distribution_centers')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.usage_instructions"
                field-name="usage_instructions"
                :field-label="$t('usage_instructions')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="6"
                :has-translation="hasTranslation('usage_instructions')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.technical_specifications"
                field-name="technical_specifications"
                :field-label="$t('technical_specifications')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('technical_specifications')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.supplier"
                field-name="supplier"
                :field-label="$t('supplier')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('supplier')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.contact_info"
                field-name="contact_info"
                :field-label="$t('contact_info')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('contact_info')"
                @clear="clearTranslation"
            />
        </template>
    </TranslatableForm>
    
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { useSeedSupplyProgramsRepository } from "../../stores/SeedSupplyProgramsRepository";
import { useI18n } from "vue-i18n";
import TranslatableForm from "../../components/TranslatableForm.vue";
import TranslationField from "../../components/TranslationField.vue";
const { t } = useI18n();

const SeedSupplyProgramsRepository = useSeedSupplyProgramsRepository();
const formTitle = computed(() => SeedSupplyProgramsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => SeedSupplyProgramsRepository.isEditMode ? t('update') : t('submit'));
const saving = ref(false);

// Translatable fields for SeedSupplyProgram model
const translatableFields = ['name', 'short_description', 'description', 'input_type', 'target_crops', 'distribution_centers', 'usage_instructions', 'technical_specifications', 'supplier', 'contact_info'];

const formData = reactive({
    id: null,
    name: '',
    slug: '',
    description: '',
    short_description: '',
    input_type: 'seeds',
    target_crops: [],
    quality_grade: 'standard',
    price_range: '',
    availability: 'In Stock',
    shelf_life: '',
    distribution_centers: [],
    usage_instructions: '',
    technical_specifications: '',
    supplier: '',
    contact_info: '',
    cover_image: '',
    thumbnail_image: '',
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
watch(() => SeedSupplyProgramsRepository.currentSeedSupplyProgram, (newProgram) => {
    if (newProgram && Object.keys(newProgram).length > 0) {
        formData.id = newProgram.id;
        formData.name = newProgram.name || '';
        formData.slug = newProgram.slug || '';
        formData.description = newProgram.description || '';
        formData.short_description = newProgram.short_description || '';
        formData.input_type = newProgram.input_type || 'seeds';
        formData.target_crops = newProgram.target_crops || [];
        formData.quality_grade = newProgram.quality_grade || 'standard';
        formData.price_range = newProgram.price_range || '';
        formData.availability = newProgram.availability || 'In Stock';
        formData.shelf_life = newProgram.shelf_life || '';
        formData.distribution_centers = newProgram.distribution_centers || [];
        formData.usage_instructions = newProgram.usage_instructions || '';
        formData.technical_specifications = newProgram.technical_specifications || '';
        formData.supplier = newProgram.supplier || '';
        formData.contact_info = newProgram.contact_info || '';
        formData.cover_image = newProgram.cover_image || '';
        formData.thumbnail_image = newProgram.thumbnail_image || '';
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

// Generate slug from name
const generateSlug = () => {
    if (formData.name && !formData.slug) {
        formData.slug = formData.name
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
                } else if ((key === 'target_crops' || key === 'distribution_centers') && Array.isArray(data[key])) {
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
        } else if (SeedSupplyProgramsRepository.isEditMode && !coverImageSrc.value && !coverImageFile.value && originalCoverImage.value) {
            formDataToSend.append('cover_image', '');
        } else if (formData.cover_image && !formData.cover_image.startsWith('data:') && !coverImageFile.value) {
            formDataToSend.append('cover_image', formData.cover_image);
        } else if (!SeedSupplyProgramsRepository.isEditMode) {
            formDataToSend.append('cover_image', '');
        }
        
        // Handle thumbnail image
        if (thumbnailImageFile.value) {
            formDataToSend.append('thumbnail_image', thumbnailImageFile.value);
        } else if (SeedSupplyProgramsRepository.isEditMode && !thumbnailImageSrc.value && !thumbnailImageFile.value && originalThumbnailImage.value) {
            formDataToSend.append('thumbnail_image', '');
        } else if (formData.thumbnail_image && !formData.thumbnail_image.startsWith('data:') && !thumbnailImageFile.value) {
            formDataToSend.append('thumbnail_image', formData.thumbnail_image);
        } else if (!SeedSupplyProgramsRepository.isEditMode) {
            formDataToSend.append('thumbnail_image', '');
        }

        if (SeedSupplyProgramsRepository.isEditMode) {
            const response = await SeedSupplyProgramsRepository.updateSeedSupplyProgram(formData.id, formDataToSend);
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
            await SeedSupplyProgramsRepository.createSeedSupplyProgram(formDataToSend);
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
