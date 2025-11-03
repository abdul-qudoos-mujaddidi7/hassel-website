<template>
    <TranslatableForm
        v-model="TrainingProgramsRepository.createDialog"
        :form-title="formTitle"
        :button-text="buttonText"
        :translatable-fields="translatableFields"
        :form-data="formData"
        :rules="rules"
        :saving="saving"
        :is-edit-mode="TrainingProgramsRepository.isEditMode"
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
                    :items="TrainingProgramsRepository.statusOptions"
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
                    :items="TrainingProgramsRepository.programTypeOptions"
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

            <!-- Location and Instructor Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.location"
                    variant="outlined"
                    :label="$t('location')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                    :rules="[rules.required]"
                ></v-text-field>

                <v-text-field
                    v-model="formData.instructor"
                    variant="outlined"
                    :label="$t('instructor')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                ></v-text-field>
            </div>

            <!-- Duration and Max Participants Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.duration"
                    variant="outlined"
                    :label="$t('duration')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                    :hint="$t('hint_duration')"
                    persistent-hint
                ></v-text-field>

                <v-text-field
                    v-model.number="formData.max_participants"
                    variant="outlined"
                    :label="$t('max_participants')"
                    density="compact"
                    type="number"
                    min="1"
                    class="pb-4 pl-2 w-50"
                    :hint="$t('hint_max_participants')"
                    persistent-hint
                ></v-text-field>
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
                    :rules="[rules.required, rules.startDate]"
                ></v-text-field>

                <v-text-field
                    v-model="formData.end_date"
                    variant="outlined"
                    :label="$t('end_date')"
                    density="compact"
                    type="date"
                    class="pb-4 pl-2 w-50"
                    :rules="[rules.required, rules.endDate]"
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
                    :hint="$t('hint_training_description')"
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
                v-model="translations.program_type"
                field-name="program_type"
                field-type="input"
                :field-label="$t('program_type')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('program_type')"
                @clear="clearTranslation"
            />
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
                v-model="translations.instructor"
                field-name="instructor"
                :field-label="$t('instructor')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('instructor')"
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
                v-model="translations.program_type"
                field-name="program_type"
                field-type="input"
                :field-label="$t('program_type')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('program_type')"
                @clear="clearTranslation"
            />
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
                v-model="translations.instructor"
                field-name="instructor"
                :field-label="$t('instructor')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('instructor')"
                @clear="clearTranslation"
            />
        </template>
    </TranslatableForm>
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { useTrainingProgramsRepository } from "../../stores/TrainingProgramsRepository";
import { useI18n } from "vue-i18n";
import TranslatableForm from "../../components/TranslatableForm.vue";
import TranslationField from "../../components/TranslationField.vue";
const { t } = useI18n();

const TrainingProgramsRepository = useTrainingProgramsRepository();
const formTitle = computed(() => TrainingProgramsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => TrainingProgramsRepository.isEditMode ? t('update') : t('submit'));
const saving = ref(false);

// Translatable fields for TrainingProgram model
const translatableFields = ['title', 'description', 'program_type', 'location', 'instructor'];

const formData = reactive({
    id: null,
    title: '',
    slug: '',
    description: '',
    cover_image: '',
    thumbnail_image: '',
    program_type: '',
    duration: '',
    location: '',
    instructor: '',
    max_participants: null,
    start_date: '',
    end_date: '',
    status: 'draft'
});

// Watch for changes in currentProgram to populate form (including translations)
watch(() => TrainingProgramsRepository.currentProgram, (newProgram) => {
    if (newProgram && Object.keys(newProgram).length > 0) {
        formData.id = newProgram.id;
        formData.title = newProgram.title || '';
        formData.slug = newProgram.slug || '';
        formData.description = newProgram.description || '';
        formData.cover_image = newProgram.cover_image || '';
        formData.thumbnail_image = newProgram.thumbnail_image || '';
        formData.program_type = newProgram.program_type || '';
        formData.duration = newProgram.duration || '';
        formData.location = newProgram.location || '';
        formData.instructor = newProgram.instructor || '';
        formData.max_participants = newProgram.max_participants || null;
        formData.start_date = newProgram.start_date ? newProgram.start_date.split('T')[0] : '';
        formData.end_date = newProgram.end_date ? newProgram.end_date.split('T')[0] : '';
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
    required: (value) => !!value || t('field_required'),
    startDate: (value) => {
        if (!value) return true;
        const startDate = new Date(value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        return startDate >= today || t('start_date_validation');
    },
    endDate: (value) => {
        if (!value) return true;
        const endDate = new Date(value);
        const startDate = new Date(formData.start_date);
        return endDate > startDate || t('end_date_validation');
    }
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
        // Convert dates to ISO if provided
        if (apiData.start_date) apiData.start_date = new Date(apiData.start_date).toISOString();
        if (apiData.end_date) apiData.end_date = new Date(apiData.end_date).toISOString();

        if (TrainingProgramsRepository.isEditMode) {
            await TrainingProgramsRepository.updateTrainingProgram(formData.id, apiData);
        } else {
            await TrainingProgramsRepository.createTrainingProgram(apiData);
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

