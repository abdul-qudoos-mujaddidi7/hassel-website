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
                    hint="URL-friendly version of the name"
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
                    hint="e.g., $10-20 per kg"
                    persistent-hint
                ></v-text-field>

                <v-text-field
                    v-model="formData.shelf_life"
                    variant="outlined"
                    :label="$t('shelf_life')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                    hint="e.g., 2 years, 18 months"
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
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.cover_image"
                    variant="outlined"
                    :label="$t('cover_image')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                    hint="URL of the cover image"
                    persistent-hint
                ></v-text-field>

                <v-text-field
                    v-model="formData.thumbnail_image"
                    variant="outlined"
                    :label="$t('thumbnail_image')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                    hint="URL of the thumbnail image"
                    persistent-hint
                ></v-text-field>
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
                    hint="Select crops this input is suitable for"
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
                    hint="Enter distribution center locations"
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
                    hint="Brief description of the seed/input"
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
                    hint="Detailed description of the seed/input"
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
                    hint="Step-by-step instructions for using this input"
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
                    hint="Technical details and specifications"
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

        // Provide translationData so TranslatableForm loads JSON translations
        formData.translationData = {
            ...newProgram,
            farsi_translations: newProgram.farsi_translations || {},
            pashto_translations: newProgram.pashto_translations || {}
        };
    }
}, { deep: true, immediate: true });

const rules = {
    required: (value) => !!value || "This field is required.",
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

// Handle save from TranslatableForm - save everything at once
const handleSave = async ({ data }) => {
    saving.value = true;
    try {
        const apiData = { ...data };

        if (SeedSupplyProgramsRepository.isEditMode) {
            await SeedSupplyProgramsRepository.updateSeedSupplyProgram(formData.id, apiData);
        } else {
            await SeedSupplyProgramsRepository.createSeedSupplyProgram(apiData);
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
</style>
