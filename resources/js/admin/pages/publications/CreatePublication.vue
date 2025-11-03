<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="60rem"
            v-model="PublicationsRepository.createDialog"
            class="rtl-dialog"
        >
            <template v-slot:default="{ isActive }">
                <v-card class="px-3">
                    <v-card-title
                        class="px-2 pt-4 d-flex justify-space-between"
                    >
                        <h2 class="font-weight-bold pl-4">
                            {{ formTitle }}
                        </h2>
                        <v-btn variant="text" @click="isActive.value = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-divider class="border-opacity-100 mx-6"></v-divider>

                    <v-card-text>
                        <v-form ref="formRef" class="pt-4">
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
                                    :items="PublicationsRepository.statusOptions"
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

                            <!-- Slug and File Type Row -->
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
                                    v-model="formData.file_type"
                                    :items="PublicationsRepository.fileTypeOptions"
                                    variant="outlined"
                                    density="compact"
                                    item-value="value"
                                    item-title="label"
                                    :return-object="false"
                                    :label="$t('file_type')"
                                    class="pb-4 pl-2 w-50"
                                >
                                </v-select>
                            </div>

                            <!-- File Path Row -->
                            <div class="flex w-100">
                                <v-text-field
                                    v-model="formData.file_path"
                                    variant="outlined"
                                    :label="$t('file_path')"
                                    density="compact"
                                    class="pb-4 pr-2 w-75"
                                    :hint="$t('hint_file_path')"
                                    persistent-hint
                                ></v-text-field>

                                <v-text-field
                                    v-model="formData.published_at"
                                    variant="outlined"
                                    :label="$t('published_date')"
                                    density="compact"
                                    type="datetime-local"
                                    class="pb-4 pl-2 w-25"
                                    v-if="formData.status === 'published'"
                                ></v-text-field>
                            </div>

                            <!-- File Upload Section -->
                            <div class="w-100 mb-4">
                                <v-file-input
                                    v-model="fileInput"
                                    :label="$t('upload_file')"
                                    variant="outlined"
                                    density="compact"
                                    :accept="getAcceptedFileTypes()"
                                    @change="handleFileUpload"
                                    show-size
                                    counter
                                ></v-file-input>
                                <div class="text-caption text-grey mt-1">
                                    {{ $t('hint_supported_formats') }}
                                </div>
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
                                    :hint="$t('hint_publication_description')"
                                    persistent-hint
                                ></v-textarea>
                            </div>
                        </v-form>
                    </v-card-text>

                    <div class="d-flex flex-row-reverse mb-6 mx-6">
                        <v-btn class="create-btn-gradient px-4" @click="save">
                            <v-icon>mdi-content-save</v-icon>
                            {{ buttonText }}
                        </v-btn>
                    </div>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import { usePublicationsRepository } from "../../stores/PublicationsRepository";
import { useI18n } from "vue-i18n";
const { t } = useI18n();

const PublicationsRepository = usePublicationsRepository();
const formTitle = computed(() => PublicationsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => PublicationsRepository.isEditMode ? t('update') : t('submit'));
const formRef = ref(null);
const fileInput = ref(null);

const formData = reactive({
    id: null,
    title: '',
    slug: '',
    description: '',
    file_path: '',
    file_type: '',
    status: 'draft',
    published_at: null
});

// Watch for changes in currentPublication to populate form
watch(() => PublicationsRepository.currentPublication, (newPublication) => {
    if (newPublication && Object.keys(newPublication).length > 0) {
        formData.id = newPublication.id;
        formData.title = newPublication.title || '';
        formData.slug = newPublication.slug || '';
        formData.description = newPublication.description || '';
        formData.file_path = newPublication.file_path || '';
        formData.file_type = newPublication.file_type || '';
        formData.status = newPublication.status || 'draft';
        formData.published_at = newPublication.published_at ? new Date(newPublication.published_at).toISOString().slice(0, 16) : null;
    }
}, { deep: true, immediate: true });

// Watch for status changes to set published_at
watch(() => formData.status, (newStatus) => {
    if (newStatus === 'published' && !formData.published_at) {
        formData.published_at = new Date().toISOString().slice(0, 16);
    }
});

const rules = {
    required: (value) => !!value || t('field_required')
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

// Get accepted file types for file input
const getAcceptedFileTypes = () => {
    return '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt';
};

// Handle file upload
const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Auto-detect file type based on extension
        const extension = file.name.split('.').pop().toLowerCase();
        const typeMap = {
            'pdf': 'pdf',
            'doc': 'doc',
            'docx': 'docx',
            'xls': 'xls',
            'xlsx': 'xlsx',
            'ppt': 'ppt',
            'pptx': 'pptx',
            'txt': 'txt'
        };
        
        formData.file_type = typeMap[extension] || 'other';
        
        // In a real application, you would upload the file to a server
        // For now, we'll just set a placeholder path
        formData.file_path = `/uploads/publications/${file.name}`;
        
        console.log('File selected:', file.name, 'Type:', formData.file_type);
    }
};

const save = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        // Prepare data for submission
        const submitData = { ...formData };
        
        // Convert published_at to proper format if provided
        if (submitData.published_at) {
            submitData.published_at = new Date(submitData.published_at).toISOString();
        } else if (submitData.status === 'published') {
            submitData.published_at = new Date().toISOString();
        }

        if (PublicationsRepository.isEditMode) {
            await PublicationsRepository.updatePublication(formData.id, submitData);
        } else {
            await PublicationsRepository.createPublication(submitData);
        }
    }
};
</script>

<style scoped>
.rtl-dialog .v-dialog {
    direction: rtl;
}
</style>

