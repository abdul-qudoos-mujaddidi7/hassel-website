<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="70rem"
            v-model="TrainingProgramsRepository.createDialog"
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
                                    hint="URL-friendly version of the title"
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
                                    hint="e.g., 3 days, 2 weeks"
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
                                    hint="Leave empty for unlimited"
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
                                    hint="URL of the cover image"
                                    persistent-hint
                                ></v-text-field>

                                <v-text-field
                                    v-model="formData.thumbnail_image"
                                    variant="outlined"
                                    :label="$t('thumbnail_image')"
                                    density="compact"
                                    class="pb-4 pl-2 w-50"
                                    hint="URL of the thumbnail image"
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
                                    hint="Detailed description of the training program"
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
import { useTrainingProgramsRepository } from "../../stores/TrainingProgramsRepository";
import { useI18n } from "vue-i18n";
const { t } = useI18n();

const TrainingProgramsRepository = useTrainingProgramsRepository();
const formTitle = computed(() => TrainingProgramsRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => TrainingProgramsRepository.isEditMode ? t('update') : t('submit'));
const formRef = ref(null);

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

// Watch for changes in currentProgram to populate form
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
    }
}, { deep: true, immediate: true });

const rules = {
    required: (value) => !!value || "This field is required.",
    startDate: (value) => {
        if (!value) return true;
        const startDate = new Date(value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        return startDate >= today || "Start date must be today or later.";
    },
    endDate: (value) => {
        if (!value) return true;
        const endDate = new Date(value);
        const startDate = new Date(formData.start_date);
        return endDate > startDate || "End date must be after start date.";
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

const save = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        // Prepare data for submission
        const submitData = { ...formData };
        
        // Convert dates to proper format
        if (submitData.start_date) {
            submitData.start_date = new Date(submitData.start_date).toISOString();
        }
        if (submitData.end_date) {
            submitData.end_date = new Date(submitData.end_date).toISOString();
        }

        if (TrainingProgramsRepository.isEditMode) {
            await TrainingProgramsRepository.updateTrainingProgram(formData.id, submitData);
        } else {
            await TrainingProgramsRepository.createTrainingProgram(submitData);
        }
    }
};
</script>

<style scoped>
.rtl-dialog .v-dialog {
    direction: rtl;
}
</style>

