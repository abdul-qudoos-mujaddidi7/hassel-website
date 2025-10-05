<template>
    <div dir="rtl">
        <v-dialog
            transition="dialog-top-transition"
            width="50rem"
            v-model="BeneficiariesRepository.createDialog"
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
                            <div class="flex w-100">
                                <v-select
                                    v-model="formData.stat_type"
                                    :items="BeneficiariesRepository.statTypes"
                                    variant="outlined"
                                    density="compact"
                                    item-value="value"
                                    item-title="label"
                                    :return-object="false"
                                    :label="$t('stat_type')"
                                    class="pb-4 pr-2 w-50"
                                    :rules="[rules.required]"
                                >
                                </v-select>

                                <v-text-field
                                    v-model.number="formData.value"
                                    variant="outlined"
                                    :label="$t('value')"
                                    density="compact"
                                    type="number"
                                    min="0"
                                    class="pb-4 pl-2 w-50"
                                    :rules="[rules.required, rules.positiveNumber]"
                                ></v-text-field>
                            </div>
                            
                            <div class="flex w-100">
                                <v-text-field
                                    v-model.number="formData.year"
                                    variant="outlined"
                                    :label="$t('year')"
                                    density="compact"
                                    type="number"
                                    :min="2000"
                                    :max="2100"
                                    class="pb-4 pr-2 w-50"
                                    :rules="[rules.year]"
                                ></v-text-field>
                                
                                <div class="w-50 pl-2">
                                    <v-text-field
                                        v-model="formData.description"
                                        variant="outlined"
                                        :label="$t('description')"
                                        density="compact"
                                        class="pb-4"
                                        :counter="500"
                                        :rules="[rules.maxLength]"
                                    ></v-text-field>
                                </div>
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
import { useBeneficiariesRepository } from "../../stores/BeneficiariesRepository";
import { useI18n } from "vue-i18n";
const { t } = useI18n();

const BeneficiariesRepository = useBeneficiariesRepository();
const formTitle = computed(() => BeneficiariesRepository.isEditMode ? t('update') : t('create'));
const buttonText = computed(() => BeneficiariesRepository.isEditMode ? t('update') : t('submit'));
const formRef = ref(null);

const formData = reactive({
    id: null,
    stat_type: '',
    value: 0,
    description: '',
    year: new Date().getFullYear()
});

// Watch for changes in currentStat to populate form
watch(() => BeneficiariesRepository.currentStat, (newStat) => {
    if (newStat && Object.keys(newStat).length > 0) {
        formData.id = newStat.id;
        formData.stat_type = newStat.stat_type || '';
        formData.value = newStat.value || 0;
        formData.description = newStat.description || '';
        formData.year = newStat.year || new Date().getFullYear();
    }
}, { deep: true, immediate: true });

const rules = {
    required: (value) => !!value || "This field is required.",
    positiveNumber: (value) => 
        (value !== null && value !== undefined && value >= 0) || 
        "Value must be a positive number.",
    year: (value) => {
        if (!value) return true;
        const year = parseInt(value);
        return (year >= 2000 && year <= 2100) || "Year must be between 2000 and 2100.";
    },
    maxLength: (value) => 
        !value || value.length <= 500 || 
        "Description must be 500 characters or less."
};

const save = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        if (BeneficiariesRepository.isEditMode) {
            await BeneficiariesRepository.updateBeneficiariesStat(formData.id, formData);
        } else {
            await BeneficiariesRepository.createBeneficiariesStat(formData);
        }
    }
};
</script>

<style scoped>
.rtl-dialog .v-dialog {
    direction: rtl;
}
</style>