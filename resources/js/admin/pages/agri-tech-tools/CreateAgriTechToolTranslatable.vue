<template>
    <TranslatableForm
        v-model="AgriTechToolsRepository.createDialog"
        :form-title="formTitle"
        :button-text="buttonText"
        :translatable-fields="translatableFields"
        :form-data="formData"
        :rules="rules"
        :saving="saving"
        :is-edit-mode="AgriTechToolsRepository.isEditMode"
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
                    :items="AgriTechToolsRepository.statusOptions"
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

            <!-- Slug and Tool Type Row -->
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
                    v-model="formData.tool_type"
                    :items="AgriTechToolsRepository.toolTypeOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('tool_type')"
                    class="pb-4 pl-2 w-50"
                    :rules="[rules.required]"
                >
                </v-select>
            </div>

            <!-- Technology Level and Availability Row -->
            <div class="flex w-100">
                <v-select
                    v-model="formData.technology_level"
                    :items="AgriTechToolsRepository.technologyLevelOptions"
                    variant="outlined"
                    density="compact"
                    item-value="value"
                    item-title="label"
                    :return-object="false"
                    :label="$t('technology_level')"
                    class="pb-4 pr-2 w-50"
                ></v-select>

                <v-select
                    v-model="formData.availability"
                    :items="AgriTechToolsRepository.availabilityOptions"
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

            <!-- Price Range and Supplier Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.price_range"
                    variant="outlined"
                    :label="$t('price_range')"
                    density="compact"
                    class="pb-4 pr-2 w-50"
                    :hint="$t('hint_price_range')"
                    persistent-hint
                ></v-text-field>

                <v-text-field
                    v-model="formData.supplier"
                    variant="outlined"
                    :label="$t('supplier')"
                    density="compact"
                    class="pb-4 pl-2 w-50"
                ></v-text-field>
            </div>

            <!-- Contact Info Row -->
            <div class="flex w-100">
                <v-text-field
                    v-model="formData.contact_info"
                    variant="outlined"
                    :label="$t('contact_info')"
                    density="compact"
                    class="pb-4 w-100"
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

            <!-- Short Description Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.short_description"
                    variant="outlined"
                    :label="$t('short_description')"
                    density="compact"
                    class="pb-4"
                    rows="3"
                    :hint="$t('hint_agri_tool_description')"
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
                    :hint="$t('hint_agri_tool_detailed')"
                    persistent-hint
                ></v-textarea>
            </div>

            <!-- Features Row -->
            <div class="w-100">
                <v-combobox
                    v-model="formData.features"
                    variant="outlined"
                    :label="$t('features')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    :hint="$t('hint_features')"
                    persistent-hint
                ></v-combobox>
            </div>

            <!-- Specifications Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.specifications"
                    variant="outlined"
                    :label="$t('specifications')"
                    density="compact"
                    class="pb-4"
                    rows="4"
                    :hint="$t('hint_specifications')"
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
                    :hint="$t('hint_usage_instructions')"
                    persistent-hint
                ></v-textarea>
            </div>

            <!-- Maintenance Requirements Row -->
            <div class="w-100">
                <v-textarea
                    v-model="formData.maintenance_requirements"
                    variant="outlined"
                    :label="$t('maintenance_requirements')"
                    density="compact"
                    class="pb-4"
                    rows="4"
                    :hint="$t('hint_maintenance')"
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
            <div class="translation-field mb-4">
                <v-combobox
                    v-model="translations.features"
                    variant="outlined"
                    :label="$t('features')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    :hint="$t('hint_features')"
                    persistent-hint
                ></v-combobox>
            </div>
            <TranslationField
                v-model="translations.specifications"
                field-name="specifications"
                :field-label="$t('specifications')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('specifications')"
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
                v-model="translations.maintenance_requirements"
                field-name="maintenance_requirements"
                :field-label="$t('maintenance_requirements')"
                language="farsi"
                :language-label="$t('dari')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('maintenance_requirements')"
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
            <div class="translation-field mb-4">
                <v-combobox
                    v-model="translations.features"
                    variant="outlined"
                    :label="$t('features')"
                    density="compact"
                    class="pb-4"
                    multiple
                    chips
                    :hint="$t('hint_features')"
                    persistent-hint
                ></v-combobox>
            </div>
            <TranslationField
                v-model="translations.specifications"
                field-name="specifications"
                :field-label="$t('specifications')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('specifications')"
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
                v-model="translations.maintenance_requirements"
                field-name="maintenance_requirements"
                :field-label="$t('maintenance_requirements')"
                language="pashto"
                :language-label="$t('pashto')"
                field-type="textarea"
                :rows="4"
                :has-translation="hasTranslation('maintenance_requirements')"
                @clear="clearTranslation"
            />
        </template>
    </TranslatableForm>
    
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { useAgriTechToolsRepository } from "../../stores/AgriTechToolsRepository";
import { useI18n } from "vue-i18n";
import TranslatableForm from "../../components/TranslatableForm.vue";
import TranslationField from "../../components/TranslationField.vue";
const { t } = useI18n();

const AgriTechToolsRepository = useAgriTechToolsRepository();
const formTitle = computed(() => AgriTechToolsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => AgriTechToolsRepository.isEditMode ? t('update') : t('submit'));
const saving = ref(false);

// Translatable fields for AgriTechTool model
const translatableFields = ['name', 'short_description', 'description', 'features', 'specifications', 'usage_instructions', 'maintenance_requirements'];

const formData = reactive({
    id: null,
    name: '',
    slug: '',
    description: '',
    short_description: '',
    tool_type: 'mobile_app',
    technology_level: 'basic',
    features: [],
    specifications: '',
    usage_instructions: '',
    maintenance_requirements: '',
    availability: 'available',
    price_range: '',
    supplier: '',
    contact_info: '',
    cover_image: '',
    thumbnail_image: '',
    status: 'draft'
});

// Populate form on edit
watch(() => AgriTechToolsRepository.currentAgriTechTool, (newTool) => {
    if (newTool && Object.keys(newTool).length > 0) {
        formData.id = newTool.id;
        formData.name = newTool.name || '';
        formData.slug = newTool.slug || '';
        formData.description = newTool.description || '';
        formData.short_description = newTool.short_description || '';
        formData.tool_type = newTool.tool_type || 'mobile_app';
        formData.technology_level = newTool.technology_level || 'basic';
        // Handle features - could be array or JSON string
        if (newTool.features) {
            if (typeof newTool.features === 'string') {
                try {
                    formData.features = JSON.parse(newTool.features);
                } catch {
                    formData.features = newTool.features.split(',').map(f => f.trim()).filter(Boolean);
                }
            } else if (Array.isArray(newTool.features)) {
                formData.features = newTool.features;
            } else {
                formData.features = [];
            }
        } else {
            formData.features = [];
        }
        formData.specifications = newTool.specifications || '';
        formData.usage_instructions = newTool.usage_instructions || '';
        formData.maintenance_requirements = newTool.maintenance_requirements || '';
        formData.availability = newTool.availability || 'available';
        formData.price_range = newTool.price_range || '';
        formData.supplier = newTool.supplier || '';
        formData.contact_info = newTool.contact_info || '';
        formData.cover_image = newTool.cover_image || '';
        formData.thumbnail_image = newTool.thumbnail_image || '';
        formData.status = newTool.status || 'draft';

        // Provide translationData so TranslatableForm loads JSON translations
        formData.translationData = {
            ...newTool,
            farsi_translations: newTool.farsi_translations || {},
            pashto_translations: newTool.pashto_translations || {}
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

// Handle save from TranslatableForm - save everything at once
const handleSave = async ({ data }) => {
    saving.value = true;
    try {
        const apiData = { ...data };

        if (AgriTechToolsRepository.isEditMode) {
            await AgriTechToolsRepository.updateAgriTechTool(formData.id, apiData);
        } else {
            await AgriTechToolsRepository.createAgriTechTool(apiData);
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
