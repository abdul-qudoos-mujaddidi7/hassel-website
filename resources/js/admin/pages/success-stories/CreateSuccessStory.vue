<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="60rem"
            v-model="SuccessStoriesRepository.createDialog"
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

                            <!-- Slug and Author Row -->
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
                                    v-model="formData.author_name"
                                    variant="outlined"
                                    :label="$t('author_name')"
                                    density="compact"
                                    class="pb-4 pl-2 w-50"
                                ></v-text-field>
                            </div>

                            <!-- Author Title and Location Row -->
                            <div class="flex w-100">
                                <v-text-field
                                    v-model="formData.author_title"
                                    variant="outlined"
                                    :label="$t('author_title')"
                                    density="compact"
                                    class="pb-4 pr-2 w-50"
                                ></v-text-field>

                                <v-text-field
                                    v-model="formData.location"
                                    variant="outlined"
                                    :label="$t('location')"
                                    density="compact"
                                    class="pb-4 pl-2 w-50"
                                ></v-text-field>
                            </div>

                            <!-- Featured Image and Published Date Row -->
                            <div class="flex w-100">
                                <v-text-field
                                    v-model="formData.featured_image"
                                    variant="outlined"
                                    :label="$t('featured_image')"
                                    density="compact"
                                    class="pb-4 pr-2 w-75"
                                    hint="URL of the featured image"
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

                            <!-- Content Row -->
                            <div class="w-100">
                                <v-textarea
                                    v-model="formData.content"
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
import { useSuccessStoriesRepository } from "../../stores/SuccessStoriesRepository";
import { useI18n } from "vue-i18n";
const { t } = useI18n();

const SuccessStoriesRepository = useSuccessStoriesRepository();
const formTitle = computed(() => SuccessStoriesRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => SuccessStoriesRepository.isEditMode ? t('update') : t('submit'));
const formRef = ref(null);

const formData = reactive({
    id: null,
    title: '',
    slug: '',
    content: '',
    featured_image: '',
    author_name: '',
    author_title: '',
    location: '',
    status: 'draft',
    published_at: null
});

// Watch for changes in currentSuccessStory to populate form
watch(() => SuccessStoriesRepository.currentSuccessStory, (newStory) => {
    if (newStory && Object.keys(newStory).length > 0) {
        formData.id = newStory.id;
        formData.title = newStory.title || '';
        formData.slug = newStory.slug || '';
        formData.content = newStory.content || '';
        formData.featured_image = newStory.featured_image || '';
        formData.author_name = newStory.author_name || '';
        formData.author_title = newStory.author_title || '';
        formData.location = newStory.location || '';
        formData.status = newStory.status || 'draft';
        formData.published_at = newStory.published_at ? new Date(newStory.published_at).toISOString().slice(0, 16) : null;
    }
}, { deep: true, immediate: true });

// Watch for status changes to set published_at
watch(() => formData.status, (newStatus) => {
    if (newStatus === 'published' && !formData.published_at) {
        formData.published_at = new Date().toISOString().slice(0, 16);
    }
});

const rules = {
    required: (value) => !!value || "This field is required."
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

        if (SuccessStoriesRepository.isEditMode) {
            await SuccessStoriesRepository.updateSuccessStory(formData.id, submitData);
        } else {
            await SuccessStoriesRepository.createSuccessStory(submitData);
        }
    }
};
</script>

<style scoped>
.rtl-dialog .v-dialog {
    direction: rtl;
}
</style>

