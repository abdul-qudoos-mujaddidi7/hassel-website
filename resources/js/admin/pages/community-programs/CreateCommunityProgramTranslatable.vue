<template>
    <TranslatableForm
        v-model="CommunityProgramsRepository.createDialog"
        :form-title="formTitle"
        :button-text="buttonText"
        :translatable-fields="translatableFields"
        :form-data="formData"
        :rules="rules"
        :saving="saving"
        :is-edit-mode="CommunityProgramsRepository.isEditMode"
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
                    :items="CommunityProgramsRepository.statusOptions"
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
                    hint="URL-friendly version of the title"
                    persistent-hint
                ></v-text-field>

                <v-select
                    v-model="formData.program_type"
                    :items="CommunityProgramsRepository.programTypeOptions"
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

            <!-- Target Group and Location Row -->
            <div class="flex w-100">
                <v-select
                    v-model="formData.target_group"
                    :items="CommunityProgramsRepository.targetGroupOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('target_group')"
                    class="pb-4 pr-2 w-50"
                    :rules="[rules.required]"
                ></v-select>

                <v-text-field
                    v-model="formData.location"
                    variant="outlined"
                    :label="$t('location')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                ></v-text-field>
            </div>

            <!-- Featured Image and Cover Image Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.featured_image"
                    variant="outlined"
                    :label="$t('featured_image')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                    hint="URL of the featured image"
                    persistent-hint
                ></v-text-field>

                <v-text-field
                    v-model="formData.cover_image"
                    variant="outlined"
                    :label="$t('cover_image')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                    hint="URL of the cover image"
                    persistent-hint
                ></v-text-field>
            </div>

            <!-- Thumbnail Image Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.thumbnail_image"
                    variant="outlined"
                    :label="$t('thumbnail_image')"
                    density="compact"
                    class="pb-4 w-100"
                    hint="URL of the thumbnail image"
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
                    hint="Enter partner organization names"
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
                    hint="Detailed description of the community program"
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
            <TranslationField
                v-model="translations.target_group"
                field-name="target_group"
                :field-label="$t('target_group')"
                language="farsi"
                :language-label="$t('dari')"
                :has-translation="hasTranslation('target_group')"
                @clear="clearTranslation"
            />
            <div class="translation-field mb-4">
                <v-combobox
                    v-model="translations.partner_organizations"
                    variant="outlined"
                    :label="$t('partner_organizations')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    hint="Enter partner organization names"
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
            <TranslationField
                v-model="translations.target_group"
                field-name="target_group"
                :field-label="$t('target_group')"
                language="pashto"
                :language-label="$t('pashto')"
                :has-translation="hasTranslation('target_group')"
                @clear="clearTranslation"
            />
            <div class="translation-field mb-4">
                <v-combobox
                    v-model="translations.partner_organizations"
                    variant="outlined"
                    :label="$t('partner_organizations')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    hint="Enter partner organization names"
                    persistent-hint
                ></v-combobox>
            </div>
        </template>
    </TranslatableForm>
    
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { useCommunityProgramsRepository } from "../../stores/CommunityProgramsRepository";
import { useI18n } from "vue-i18n";
import TranslatableForm from "../../components/TranslatableForm.vue";
import TranslationField from "../../components/TranslationField.vue";
const { t } = useI18n();

const CommunityProgramsRepository = useCommunityProgramsRepository();
const formTitle = computed(() => CommunityProgramsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => CommunityProgramsRepository.isEditMode ? t('update') : t('submit'));
const saving = ref(false);

// Translatable fields for CommunityProgram model
const translatableFields = ['title', 'description', 'target_group', 'partner_organizations'];

const formData = reactive({
    id: null,
    title: '',
    slug: '',
    description: '',
    target_group: 'general_community',
    program_type: 'education',
    location: '',
    partner_organizations: [],
    status: 'draft',
    featured_image: '',
    cover_image: '',
    thumbnail_image: ''
});

// Populate form on edit
watch(() => CommunityProgramsRepository.currentCommunityProgram, (newProgram) => {
    if (newProgram && Object.keys(newProgram).length > 0) {
        formData.id = newProgram.id;
        formData.title = newProgram.title || '';
        formData.slug = newProgram.slug || '';
        formData.description = newProgram.description || '';
        formData.target_group = newProgram.target_group || 'general_community';
        formData.program_type = newProgram.program_type || 'education';
        formData.location = newProgram.location || '';
        formData.partner_organizations = newProgram.partner_organizations || [];
        formData.status = newProgram.status || 'draft';
        formData.featured_image = newProgram.featured_image || '';
        formData.cover_image = newProgram.cover_image || '';
        formData.thumbnail_image = newProgram.thumbnail_image || '';

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

        if (CommunityProgramsRepository.isEditMode) {
            await CommunityProgramsRepository.updateCommunityProgram(formData.id, apiData);
        } else {
            await CommunityProgramsRepository.createCommunityProgram(apiData);
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
