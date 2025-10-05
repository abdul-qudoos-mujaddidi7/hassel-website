<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="60rem"
            v-model="NewsRepository.createDialog"
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
                                    :items="NewsRepository.statusOptions"
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
                                    persistent-hint
                                ></v-text-field>

                                <v-text-field
                                    v-model="formData.excerpt"
                                    variant="outlined"
                                    :label="$t('excerpt')"
                                    density="compact"
                                    class="pb-4 pl-2 w-50"
                                    :counter="500"
                                    :rules="[rules.maxLength]"
                                    hint="Brief description of the article"
                                    persistent-hint
                                ></v-text-field>
                            </div>

                            <!-- Featured Image Row -->
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
                                    v-model="formData.published_at"
                                    variant="outlined"
                                    :label="$t('published_date')"
                                    density="compact"
                                    type="datetime-local"
                                    class="pb-4 pl-2 w-50"
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
                                    hint="Main content of the news article"
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
import { useNewsRepository } from "../../stores/NewsRepository";
import { useI18n } from "vue-i18n";
const { t } = useI18n();

const NewsRepository = useNewsRepository();
const formTitle = computed(() => NewsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => NewsRepository.isEditMode ? t('update') : t('submit'));
const formRef = ref(null);

const formData = reactive({
    id: null,
    title: '',
    slug: '',
    excerpt: '',
    content: '',
    featured_image: '',
    status: 'draft',
    published_at: null
});

// Watch for changes in currentNews to populate form
watch(() => NewsRepository.currentNews, (newNews) => {
    if (newNews && Object.keys(newNews).length > 0) {
        formData.id = newNews.id;
        formData.title = newNews.title || '';
        formData.slug = newNews.slug || '';
        formData.excerpt = newNews.excerpt || '';
        formData.content = newNews.content || '';
        formData.featured_image = newNews.featured_image || '';
        formData.status = newNews.status || 'draft';
        formData.published_at = newNews.published_at ? new Date(newNews.published_at).toISOString().slice(0, 16) : null;
    }
}, { deep: true, immediate: true });

// Watch for status changes to set published_at
watch(() => formData.status, (newStatus) => {
    if (newStatus === 'published' && !formData.published_at) {
        formData.published_at = new Date().toISOString().slice(0, 16);
    }
});

const rules = {
    required: (value) => !!value || "This field is required.",
    maxLength: (value) => 
        !value || value.length <= 500 || 
        "Excerpt must be 500 characters or less."
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

        if (NewsRepository.isEditMode) {
            await NewsRepository.updateNews(formData.id, submitData);
        } else {
            await NewsRepository.createNews(submitData);
        }
    }
};
</script>

<style scoped>
.rtl-dialog .v-dialog {
    direction: rtl;
}
</style>

