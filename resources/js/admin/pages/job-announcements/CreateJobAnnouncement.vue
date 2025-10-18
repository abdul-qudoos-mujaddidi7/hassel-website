<template>
    <TranslatableForm
        v-model="JobAnnouncementRepository.createDialog"
        :form-title="formTitle"
        :button-text="buttonText"
        :translatable-fields="translatableFields"
        :form-data="formData"
        :rules="rules"
        :saving="saving"
        :is-edit-mode="JobAnnouncementRepository.isEditMode"
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
                    :items="JobAnnouncementRepository.statusOptions"
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
                    hint="URL-friendly version of the title"
                ></v-text-field>

                <v-text-field
                    v-model="formData.location"
                    variant="outlined"
                    :label="$t('location')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                    :rules="[rules.required]"
                ></v-text-field>
            </div>

            <!-- Description Row -->
            <div class="flex w-100">
                <v-textarea
                    v-model="formData.description"
                    variant="outlined"
                    :label="$t('description')"
                    density="compact"
                    class="pb-4 w-100"
                    :rules="[rules.required]"
                    rows="4"
                ></v-textarea>
            </div>

            <!-- Requirements Row -->
            <div class="flex w-100">
                <v-textarea
                    v-model="formData.requirements"
                    variant="outlined"
                    :label="$t('requirements')"
                    density="compact"
                    class="pb-4 w-100"
                    rows="3"
                ></v-textarea>
            </div>

            <!-- Salary Range and Deadline Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.salary_range"
                    variant="outlined"
                    :label="$t('salary_range')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                ></v-text-field>

                <v-text-field
                    v-model="formData.deadline"
                    variant="outlined"
                    :label="$t('application_deadline')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                    type="date"
                    :rules="[rules.required]"
                ></v-text-field>
            </div>
        </template>

        <!-- Farsi Translation Tab -->
        <template #farsi-fields="{ formData, rules }">
            <TranslationField
                v-model="farsiTranslations.title"
                field-name="title"
                :field-label="$t('title')"
                language="farsi"
                :language-label="$t('farsi')"
                :has-translation="hasFarsiTranslation('title')"
                @clear="clearFarsiTranslation"
            />
            <TranslationField
                v-model="farsiTranslations.location"
                field-name="location"
                :field-label="$t('location')"
                language="farsi"
                :language-label="$t('farsi')"
                :has-translation="hasFarsiTranslation('location')"
                @clear="clearFarsiTranslation"
            />
            <TranslationField
                v-model="farsiTranslations.description"
                field-name="description"
                :field-label="$t('description')"
                language="farsi"
                :language-label="$t('farsi')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasFarsiTranslation('description')"
                @clear="clearFarsiTranslation"
            />
            <TranslationField
                v-model="farsiTranslations.requirements"
                field-name="requirements"
                :field-label="$t('requirements')"
                language="farsi"
                :language-label="$t('farsi')"
                field-type="textarea"
                :rows="3"
                :has-translation="hasFarsiTranslation('requirements')"
                @clear="clearFarsiTranslation"
            />
        </template>

        <!-- Pashto Translation Tab -->
        <template #pashto-fields="{ formData, rules }">
            <TranslationField
                v-model="pashtoTranslations.title"
                field-name="title"
                :field-label="$t('title')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasPashtoTranslation('title')"
                @clear="clearPashtoTranslation"
            />
            <TranslationField
                v-model="pashtoTranslations.location"
                field-name="location"
                :field-label="$t('location')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasPashtoTranslation('location')"
                @clear="clearPashtoTranslation"
            />
            <TranslationField
                v-model="pashtoTranslations.description"
                field-name="description"
                :field-label="$t('description')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasPashtoTranslation('description')"
                @clear="clearPashtoTranslation"
            />
            <TranslationField
                v-model="pashtoTranslations.requirements"
                field-name="requirements"
                :field-label="$t('requirements')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="3"
                :has-translation="hasPashtoTranslation('requirements')"
                @clear="clearPashtoTranslation"
            />
        </template>
    </TranslatableForm>
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { useJobAnnouncementRepository } from "../../stores/JobAnnouncementRepository.js";
import { useI18n } from "vue-i18n";
import TranslatableForm from "../../components/TranslatableForm.vue";
import TranslationField from "../../components/TranslationField.vue";

const { t } = useI18n();
const JobAnnouncementRepository = useJobAnnouncementRepository();

const formTitle = computed(() => {
    return JobAnnouncementRepository.isEditMode ? t("edit_job_announcement") : t("create_job_announcement");
});

const buttonText = computed(() => {
    return JobAnnouncementRepository.isEditMode ? t("update") : t("create");
});

const saving = ref(false);

// Translatable fields for JobAnnouncement model
const translatableFields = ['title', 'location', 'description', 'requirements'];

const formData = reactive({
    id: null,
    title: '',
    slug: '',
    description: '',
    requirements: '',
    location: '',
    salary_range: '',
    deadline: '',
    status: 'draft',
    farsi_translations: {},
    pashto_translations: {}
});

// Translation data for the form
const farsiTranslations = reactive({
    title: '',
    location: '',
    description: '',
    requirements: ''
});

const pashtoTranslations = reactive({
    title: '',
    location: '',
    description: '',
    requirements: ''
});

// Populate form on edit
watch(() => JobAnnouncementRepository.currentJob, (newJob) => {
    if (newJob && Object.keys(newJob).length > 0) {
        // Populate base fields
        formData.id = newJob.id || null;
        formData.title = newJob.title || '';
        formData.slug = newJob.slug || '';
        formData.description = newJob.description || '';
        formData.requirements = newJob.requirements || '';
        formData.location = newJob.location || '';
        formData.salary_range = newJob.salary_range || '';
        formData.deadline = newJob.deadline || '';
        formData.status = newJob.status || 'draft';
        
        // Populate translations
        formData.farsi_translations = newJob.farsi_translations || {};
        formData.pashto_translations = newJob.pashto_translations || {};
        
        // Set current translation values
        farsiTranslations.title = newJob.farsi_translations?.title || '';
        farsiTranslations.location = newJob.farsi_translations?.location || '';
        farsiTranslations.description = newJob.farsi_translations?.description || '';
        farsiTranslations.requirements = newJob.farsi_translations?.requirements || '';
        
        pashtoTranslations.title = newJob.pashto_translations?.title || '';
        pashtoTranslations.location = newJob.pashto_translations?.location || '';
        pashtoTranslations.description = newJob.pashto_translations?.description || '';
        pashtoTranslations.requirements = newJob.pashto_translations?.requirements || '';
    }
});

// Reset form when dialog closes
watch(() => JobAnnouncementRepository.createDialog, (isOpen) => {
    if (!isOpen) {
        resetForm();
    }
});

// Reset form data
const resetForm = () => {
    formData.id = null;
    formData.title = '';
    formData.slug = '';
    formData.description = '';
    formData.requirements = '';
    formData.location = '';
    formData.salary_range = '';
    formData.deadline = '';
    formData.status = 'draft';
    formData.farsi_translations = {};
    formData.pashto_translations = {};
    
    farsiTranslations.title = '';
    farsiTranslations.location = '';
    farsiTranslations.description = '';
    farsiTranslations.requirements = '';
    
    pashtoTranslations.title = '';
    pashtoTranslations.location = '';
    pashtoTranslations.description = '';
    pashtoTranslations.requirements = '';
};

// Generate slug from title
const generateSlug = () => {
    if (formData.title && !formData.slug) {
        formData.slug = formData.title
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, "")
            .replace(/\s+/g, "-")
            .replace(/-+/g, "-")
            .trim("-");
    }
};

// Check if field has Farsi translation
const hasFarsiTranslation = (fieldName) => {
    return farsiTranslations[fieldName] && farsiTranslations[fieldName].trim() !== '';
};

// Check if field has Pashto translation
const hasPashtoTranslation = (fieldName) => {
    return pashtoTranslations[fieldName] && pashtoTranslations[fieldName].trim() !== '';
};

// Clear Farsi translation
const clearFarsiTranslation = (fieldName) => {
    farsiTranslations[fieldName] = '';
};

// Clear Pashto translation
const clearPashtoTranslation = (fieldName) => {
    pashtoTranslations[fieldName] = '';
};

// Handle save
const handleSave = async () => {
    saving.value = true;
    try {
        // Prepare translation data
        const farsiTranslationData = {
            title: farsiTranslations.title,
            location: farsiTranslations.location,
            description: farsiTranslations.description,
            requirements: farsiTranslations.requirements
        };
        
        const pashtoTranslationData = {
            title: pashtoTranslations.title,
            location: pashtoTranslations.location,
            description: pashtoTranslations.description,
            requirements: pashtoTranslations.requirements
        };
        
        // Update form data with translations
        formData.farsi_translations = farsiTranslationData;
        formData.pashto_translations = pashtoTranslationData;
        
        if (JobAnnouncementRepository.isEditMode) {
            await JobAnnouncementRepository.updateJob(formData.id, formData);
        } else {
            await JobAnnouncementRepository.createJob(formData);
        }
    } catch (error) {
        console.error("Error saving job announcement:", error);
    } finally {
        saving.value = false;
    }
};

// Validation rules
const rules = {
    required: (value) => !!value || t("field_required"),
};
</script>

<style scoped>
.flex {
    display: flex;
}

.w-100 {
    width: 100%;
}

.w-75 {
    width: 75%;
}

.w-50 {
    width: 50%;
}

.w-25 {
    width: 25%;
}

.pb-4 {
    padding-bottom: 16px;
}

.pr-2 {
    padding-right: 8px;
}

.pl-2 {
    padding-left: 8px;
}
</style>