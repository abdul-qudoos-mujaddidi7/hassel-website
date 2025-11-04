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
                    :hint="$t('hint_url_friendly')"
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
watch(() => JobAnnouncementRepository.currentJob, async (newJob, oldJob) => {
    // Only skip if it's the exact same object reference (not just same ID)
    // This allows updates when getJob() fetches fresh data for the same ID
    if (oldJob === newJob) {
        return;
    }
    
    if (newJob && Object.keys(newJob).length > 0 && newJob.id) {
        console.log('=== JOB ANNOUNCEMENT DATA LOADED ===');
        console.log('Full job data:', newJob);
        console.log('Has ID:', newJob.id);
        console.log('Farsi translations:', newJob.farsi_translations);
        console.log('Pashto translations:', newJob.pashto_translations);
        console.log('====================================');
        
        // Populate base fields
        formData.id = newJob.id || null;
        formData.title = newJob.title || '';
        formData.slug = newJob.slug || '';
        formData.description = newJob.description || '';
        formData.requirements = newJob.requirements || '';
        formData.location = newJob.location || '';
        formData.salary_range = newJob.salary_range || '';
        
        // Format deadline date properly
        if (newJob.deadline) {
            // Handle both date string and Date object
            const deadlineDate = new Date(newJob.deadline);
            if (!isNaN(deadlineDate.getTime())) {
                formData.deadline = deadlineDate.toISOString().split('T')[0];
            } else {
                formData.deadline = newJob.deadline;
            }
        } else {
            formData.deadline = '';
        }
        
        formData.status = newJob.status || 'draft';
        
        // Process translations - handle both JSON string and object formats
        let farsiTranslationsData = {};
        let pashtoTranslationsData = {};
        
        if (newJob.farsi_translations) {
            try {
                farsiTranslationsData = typeof newJob.farsi_translations === 'string' 
                    ? JSON.parse(newJob.farsi_translations) 
                    : newJob.farsi_translations;
            } catch (e) {
                console.error('Error parsing farsi_translations:', e);
                farsiTranslationsData = {};
            }
        }
        
        if (newJob.pashto_translations) {
            try {
                pashtoTranslationsData = typeof newJob.pashto_translations === 'string'
                    ? JSON.parse(newJob.pashto_translations)
                    : newJob.pashto_translations;
            } catch (e) {
                console.error('Error parsing pashto_translations:', e);
                pashtoTranslationsData = {};
            }
        }
        
        // Store in formData
        formData.farsi_translations = farsiTranslationsData;
        formData.pashto_translations = pashtoTranslationsData;
        
        // Set translationData for TranslatableForm component
        formData.translationData = {
            ...newJob,
            farsi_translations: farsiTranslationsData,
            pashto_translations: pashtoTranslationsData
        };
        
        // Populate translation reactive objects
        farsiTranslations.title = farsiTranslationsData.title || '';
        farsiTranslations.location = farsiTranslationsData.location || '';
        farsiTranslations.description = farsiTranslationsData.description || '';
        farsiTranslations.requirements = farsiTranslationsData.requirements || '';
        
        pashtoTranslations.title = pashtoTranslationsData.title || '';
        pashtoTranslations.location = pashtoTranslationsData.location || '';
        pashtoTranslations.description = pashtoTranslationsData.description || '';
        pashtoTranslations.requirements = pashtoTranslationsData.requirements || '';
        
        console.log('=== FORM DATA POPULATED ===');
        console.log('Form data:', formData);
        console.log('Translation data:', formData.translationData);
        console.log('Farsi translations reactive:', farsiTranslations);
        console.log('Pashto translations reactive:', pashtoTranslations);
        console.log('===========================');
        
        // Small delay to ensure DOM updates
        await new Promise(resolve => setTimeout(resolve, 100));
    } else if (newJob && Object.keys(newJob).length === 0) {
        // Reset form if job is cleared
        resetForm();
    }
}, { deep: true, immediate: true });

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
const handleSave = async (saveEvent) => {
    saving.value = true;
    try {
        // Prepare translation data in the format expected by the API
        const translations = {
            farsi: {
                title: farsiTranslations.title || '',
                location: farsiTranslations.location || '',
                description: farsiTranslations.description || '',
                requirements: farsiTranslations.requirements || ''
            },
            pashto: {
                title: pashtoTranslations.title || '',
                location: pashtoTranslations.location || '',
                description: pashtoTranslations.description || '',
                requirements: pashtoTranslations.requirements || ''
            }
        };
        
        // Prepare data object with translations
        const dataToSend = {
            ...formData,
            translations: translations
        };
        
        // Remove translationData from the payload (it's only for frontend use)
        delete dataToSend.translationData;
        
        console.log('=== SAVING JOB ANNOUNCEMENT ===');
        console.log('Data to send:', dataToSend);
        console.log('Translations:', translations);
        console.log('Is Edit Mode:', JobAnnouncementRepository.isEditMode);
        console.log('==============================');
        
        if (JobAnnouncementRepository.isEditMode) {
            await JobAnnouncementRepository.updateJob(formData.id, dataToSend);
        } else {
            await JobAnnouncementRepository.createJob(dataToSend);
        }
    } catch (error) {
        console.error("Error saving job announcement:", error);
        console.error("Error response:", error.response?.data);
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