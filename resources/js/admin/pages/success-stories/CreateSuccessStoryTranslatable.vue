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
                    hint="URL-friendly version of the title"
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

            <!-- Featured Image and Published At Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.image"
                    variant="outlined"
                    :label="$t('featured_image')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                    hint="URL of the featured image"
                    persistent-hint
                ></v-text-field>

                <v-text-field
                    v-if="formData.status === 'published'"
                    v-model="formData.published_at"
                    variant="outlined"
                    :label="$t('published_date')"
                    density="compact"
                    type="datetime-local"
                    class="pb-4 pl-2 w-50"
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
                    hint="Main content of the success story"
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

        // Provide translationData so TranslatableForm loads JSON translations
        formData.translationData = {
            ...newStory,
            farsi_translations: newStory.farsi_translations || {},
            pashto_translations: newStory.pashto_translations || {}
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
        // Normalize published_at
        if (apiData.status === 'published') {
            apiData.published_at = apiData.published_at
                ? new Date(apiData.published_at).toISOString()
                : new Date().toISOString();
        } else {
            apiData.published_at = null;
        }

        if (SuccessStoriesRepository.isEditMode) {
            await SuccessStoriesRepository.updateSuccessStory(formData.id, apiData);
        } else {
            await SuccessStoriesRepository.createSuccessStory(apiData);
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





