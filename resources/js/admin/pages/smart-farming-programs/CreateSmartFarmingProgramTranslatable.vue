<template>
    <TranslatableForm
        v-model="SmartFarmingProgramsRepository.createDialog"
        :form-title="formTitle"
        :button-text="buttonText"
        :translatable-fields="translatableFields"
        :form-data="formData"
        :rules="rules"
        :saving="saving"
        :is-edit-mode="SmartFarmingProgramsRepository.isEditMode"
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
                    :items="SmartFarmingProgramsRepository.statusOptions"
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

            <!-- Slug and Farming Type Row -->
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
                    v-model="formData.farming_type"
                    :items="SmartFarmingProgramsRepository.farmingTypeOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('farming_type')"
                    class="pb-4 pl-2 w-50"
                    :rules="[rules.required]"
                >
                </v-select>
            </div>

            <!-- Sustainability Level and Duration Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.sustainability_level"
                    variant="outlined"
                    :label="$t('sustainability_level')"
                    density="compact"
                    type="number"
                    min="0"
                    max="100"
                    class="pb-4 pr-2 w-50"
                    hint="Percentage (0-100)"
                    persistent-hint
                ></v-text-field>

                <v-text-field
                    v-model="formData.duration"
                    variant="outlined"
                    :label="$t('duration')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                    hint="e.g., 6 months, 1 year"
                    persistent-hint
                ></v-text-field>
            </div>

            <!-- Location and Application Deadline Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.location"
                    variant="outlined"
                    :label="$t('location')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                ></v-text-field>

                <v-text-field
                    v-model="formData.application_deadline"
                    variant="outlined"
                    :label="$t('application_deadline')"
                    density="compact"
                    type="date"
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
                    :items="SmartFarmingProgramsRepository.targetCropsOptions"
                    item-value="value"
                    item-title="label"
                    variant="outlined"
                    :label="$t('target_crops')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    hint="Select crops this program targets"
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
                    hint="Brief description of the smart farming program"
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
                    hint="Detailed description of the smart farming program"
                    persistent-hint
                ></v-textarea>
            </div>

            <!-- Implementation Guide Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.implementation_guide"
                    variant="outlined"
                    :label="$t('implementation_guide')"
                    density="compact"
                    class="pb-4"
                    rows="6"
                    hint="Step-by-step guide for implementing this farming method"
                    persistent-hint
                ></v-textarea>
            </div>

            <!-- Sustainability Impact Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.sustainability_impact"
                    variant="outlined"
                    :label="$t('sustainability_impact')"
                    density="compact"
                    class="pb-4"
                    rows="4"
                    hint="Description of environmental and sustainability benefits"
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
                v-model="translations.farming_type"
                field-name="farming_type"
                :field-label="$t('farming_type')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('farming_type')"
                @clear="clearTranslation"
            />
            <div class="translation-field mb-4">
                <v-combobox
                    v-model="translations.target_crops"
                    :items="SmartFarmingProgramsRepository.targetCropsOptions"
                    item-value="value"
                    item-title="label"
                    variant="outlined"
                    :label="$t('target_crops')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    hint="Select crops this program targets"
                    persistent-hint
                ></v-combobox>
            </div>
            <TranslationField
                v-model="translations.location"
                field-name="location"
                :field-label="$t('location')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('location')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.implementation_guide"
                field-name="implementation_guide"
                :field-label="$t('implementation_guide')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="6"
                :has-translation="hasTranslation('implementation_guide')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.sustainability_impact"
                field-name="sustainability_impact"
                :field-label="$t('sustainability_impact')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('sustainability_impact')"
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
                v-model="translations.farming_type"
                field-name="farming_type"
                :field-label="$t('farming_type')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('farming_type')"
                @clear="clearTranslation"
            />
            <div class="translation-field mb-4">
                <v-combobox
                    v-model="translations.target_crops"
                    :items="SmartFarmingProgramsRepository.targetCropsOptions"
                    item-value="value"
                    item-title="label"
                    variant="outlined"
                    :label="$t('target_crops')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    hint="Select crops this program targets"
                    persistent-hint
                ></v-combobox>
            </div>
            <TranslationField
                v-model="translations.location"
                field-name="location"
                :field-label="$t('location')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('location')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.implementation_guide"
                field-name="implementation_guide"
                :field-label="$t('implementation_guide')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="6"
                :has-translation="hasTranslation('implementation_guide')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.sustainability_impact"
                field-name="sustainability_impact"
                :field-label="$t('sustainability_impact')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('sustainability_impact')"
                @clear="clearTranslation"
            />
        </template>
    </TranslatableForm>
    
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { useSmartFarmingProgramsRepository } from "../../stores/SmartFarmingProgramsRepository";
import { useI18n } from "vue-i18n";
import TranslatableForm from "../../components/TranslatableForm.vue";
import TranslationField from "../../components/TranslationField.vue";
const { t } = useI18n();

const SmartFarmingProgramsRepository = useSmartFarmingProgramsRepository();
const formTitle = computed(() => SmartFarmingProgramsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => SmartFarmingProgramsRepository.isEditMode ? t('update') : t('submit'));
const saving = ref(false);

// Translatable fields for SmartFarmingProgram model
const translatableFields = ['name', 'short_description', 'description', 'farming_type', 'target_crops', 'location', 'implementation_guide', 'sustainability_impact'];

const formData = reactive({
    id: null,
    name: '',
    slug: '',
    description: '',
    short_description: '',
    farming_type: 'organic',
    target_crops: [],
    sustainability_level: null,
    implementation_guide: '',
    sustainability_impact: '',
    duration: '',
    location: '',
    application_deadline: null,
    cover_image: '',
    thumbnail_image: '',
    status: 'draft'
});

// Populate form on edit
watch(() => SmartFarmingProgramsRepository.currentSmartFarmingProgram, (newProgram) => {
    if (newProgram && Object.keys(newProgram).length > 0) {
        formData.id = newProgram.id;
        formData.name = newProgram.name || '';
        formData.slug = newProgram.slug || '';
        formData.description = newProgram.description || '';
        formData.short_description = newProgram.short_description || '';
        formData.farming_type = newProgram.farming_type || 'organic';
        formData.target_crops = newProgram.target_crops || [];
        formData.sustainability_level = newProgram.sustainability_level || null;
        formData.implementation_guide = newProgram.implementation_guide || '';
        formData.sustainability_impact = newProgram.sustainability_impact || '';
        formData.duration = newProgram.duration || '';
        formData.location = newProgram.location || '';
        formData.application_deadline = newProgram.application_deadline ? new Date(newProgram.application_deadline).toISOString().slice(0, 10) : null;
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
        
        // Convert date to proper format
        if (apiData.application_deadline) {
            apiData.application_deadline = new Date(apiData.application_deadline).toISOString().split('T')[0];
        }

        if (SmartFarmingProgramsRepository.isEditMode) {
            await SmartFarmingProgramsRepository.updateSmartFarmingProgram(formData.id, apiData);
        } else {
            await SmartFarmingProgramsRepository.createSmartFarmingProgram(apiData);
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
