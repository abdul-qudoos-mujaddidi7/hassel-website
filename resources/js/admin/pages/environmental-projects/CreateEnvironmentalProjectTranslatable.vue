<template>
    <TranslatableForm
        v-model="EnvironmentalProjectsRepository.createDialog"
        :form-title="formTitle"
        :button-text="buttonText"
        :translatable-fields="translatableFields"
        :form-data="formData"
        :rules="rules"
        :saving="saving"
        :is-edit-mode="EnvironmentalProjectsRepository.isEditMode"
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
                    :items="EnvironmentalProjectsRepository.statusOptions"
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

            <!-- Slug and Project Type Row -->
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
                    v-model="formData.project_type"
                    :items="EnvironmentalProjectsRepository.projectTypeOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('project_type')"
                    class="pb-4 pl-2 w-50"
                    :rules="[rules.required]"
                >
                </v-select>
            </div>

            <!-- Location and Impact Level Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.location"
                    variant="outlined"
                    :label="$t('location')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                ></v-text-field>

                <v-select
                    v-model="formData.impact_level"
                    :items="EnvironmentalProjectsRepository.impactLevelOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('impact_level')"
                    class="pb-4 pl-2 w-50"
                ></v-select>
            </div>

            <!-- Start Date and End Date Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.start_date"
                    variant="outlined"
                    :label="$t('start_date')"
                    density="compact"
                    type="date"
                    class="pb-4 pr-2 w-50"
                ></v-text-field>

                <v-text-field
                    v-model="formData.end_date"
                    variant="outlined"
                    :label="$t('end_date')"
                    density="compact"
                    type="date"
                    class="pb-4 pl-2 w-50"
                ></v-text-field>
            </div>

            <!-- Budget Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.budget"
                    variant="outlined"
                    :label="$t('budget')"
                    density="compact"
                    type="number"
                    class="pb-4 w-100"
                    :hint="$t('hint_budget_usd')"
                    persistent-hint
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
                    :hint="$t('hint_cover_image')"
                    persistent-hint
                ></v-text-field>

                <v-text-field
                    v-model="formData.thumbnail_image"
                    variant="outlined"
                    :label="$t('thumbnail_image')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                    :hint="$t('hint_thumbnail_image')"
                    persistent-hint
                ></v-text-field>
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
                    rows="6"
                    :hint="$t('hint_environmental_description')"
                    persistent-hint
                ></v-textarea>
            </div>

            <!-- Objectives Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.objectives"
                    variant="outlined"
                    :label="$t('objectives')"
                    density="compact"
                    class="pb-4"
                    rows="4"
                    :hint="$t('hint_project_objectives')"
                    persistent-hint
                ></v-textarea>
            </div>

            <!-- Methodology Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.methodology"
                    variant="outlined"
                    :label="$t('methodology')"
                    density="compact"
                    class="pb-4"
                    rows="4"
                    :hint="$t('hint_project_methodology')"
                    persistent-hint
                ></v-textarea>
            </div>

            <!-- Expected Outcomes Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.expected_outcomes"
                    variant="outlined"
                    :label="$t('expected_outcomes')"
                    density="compact"
                    class="pb-4"
                    rows="4"
                    :hint="$t('hint_project_outcomes')"
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
                :rows="6"
                :has-translation="hasTranslation('description')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.objectives"
                field-name="objectives"
                :field-label="$t('objectives')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('objectives')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.methodology"
                field-name="methodology"
                :field-label="$t('methodology')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('methodology')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.expected_outcomes"
                field-name="expected_outcomes"
                :field-label="$t('expected_outcomes')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('expected_outcomes')"
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
            <TranslationField
                v-model="translations.objectives"
                field-name="objectives"
                :field-label="$t('objectives')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('objectives')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.methodology"
                field-name="methodology"
                :field-label="$t('methodology')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('methodology')"
                @clear="clearTranslation"
            />
            <TranslationField
                v-model="translations.expected_outcomes"
                field-name="expected_outcomes"
                :field-label="$t('expected_outcomes')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('expected_outcomes')"
                @clear="clearTranslation"
            />
        </template>
    </TranslatableForm>
    
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { useEnvironmentalProjectsRepository } from "../../stores/EnvironmentalProjectsRepository";
import { useI18n } from "vue-i18n";
import TranslatableForm from "../../components/TranslatableForm.vue";
import TranslationField from "../../components/TranslationField.vue";
const { t } = useI18n();

const EnvironmentalProjectsRepository = useEnvironmentalProjectsRepository();
const formTitle = computed(() => EnvironmentalProjectsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => EnvironmentalProjectsRepository.isEditMode ? t('update') : t('submit'));
const saving = ref(false);

// Translatable fields for EnvironmentalProject model
const translatableFields = ['title', 'description', 'objectives', 'methodology', 'expected_outcomes'];

const formData = reactive({
    id: null,
    title: '',
    slug: '',
    description: '',
    project_type: 'conservation',
    location: '',
    start_date: null,
    end_date: null,
    budget: null,
    impact_level: 'medium',
    objectives: '',
    methodology: '',
    expected_outcomes: '',
    partner_organizations: [],
    cover_image: '',
    thumbnail_image: '',
    status: 'draft'
});

// Populate form on edit
watch(() => EnvironmentalProjectsRepository.currentEnvironmentalProject, (newProject) => {
    if (newProject && Object.keys(newProject).length > 0) {
        formData.id = newProject.id;
        formData.title = newProject.title || '';
        formData.slug = newProject.slug || '';
        formData.description = newProject.description || '';
        formData.project_type = newProject.project_type || 'conservation';
        formData.location = newProject.location || '';
        formData.start_date = newProject.start_date ? new Date(newProject.start_date).toISOString().slice(0, 10) : null;
        formData.end_date = newProject.end_date ? new Date(newProject.end_date).toISOString().slice(0, 10) : null;
        formData.budget = newProject.budget || null;
        formData.impact_level = newProject.impact_level || 'medium';
        formData.objectives = newProject.objectives || '';
        formData.methodology = newProject.methodology || '';
        formData.expected_outcomes = newProject.expected_outcomes || '';
        formData.partner_organizations = newProject.partner_organizations || [];
        formData.cover_image = newProject.cover_image || '';
        formData.thumbnail_image = newProject.thumbnail_image || '';
        formData.status = newProject.status || 'draft';

        // Provide translationData so TranslatableForm loads JSON translations
        formData.translationData = {
            ...newProject,
            farsi_translations: newProject.farsi_translations || {},
            pashto_translations: newProject.pashto_translations || {}
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

// Handle save from TranslatableForm - save everything at once
const handleSave = async ({ data }) => {
    saving.value = true;
    try {
        const apiData = { ...data };
        
        // Convert dates to proper format
        if (apiData.start_date) {
            apiData.start_date = new Date(apiData.start_date).toISOString().split('T')[0];
        }
        if (apiData.end_date) {
            apiData.end_date = new Date(apiData.end_date).toISOString().split('T')[0];
        }

        if (EnvironmentalProjectsRepository.isEditMode) {
            await EnvironmentalProjectsRepository.updateEnvironmentalProject(formData.id, apiData);
        } else {
            await EnvironmentalProjectsRepository.createEnvironmentalProject(apiData);
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
