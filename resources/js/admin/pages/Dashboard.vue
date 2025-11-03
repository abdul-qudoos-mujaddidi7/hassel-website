<template>
    <div class="rounded-xl">
      <Header :pageTitle="$t('dashboard')" />

        <v-divider
            :thickness="1"
            class="border-opacity-100"
            color="success"
        ></v-divider>

        <v-row class="pt-6">
            <v-col>
                <v-card variant="elevated" rounded="lg" hover class="stat-card">
                    <template v-slot:title>
                        <div class="d-flex">
                            <v-avatar size="40" class="mr-4">
                                <v-icon size="24" color="primary">mdi-newspaper-variant-outline</v-icon>
                            </v-avatar>
                            <div class="pt-1">
                                <div class="font-weight-black">
                                    {{ DashboardRepository.dashboardReport.publishedNews }}
          </div>
        </div>
      </div>
                    </template>
                    <v-card-text class="text-h6 d-flex justify-start ml-14 stat-card-text">
                        {{ t("news") }} ({{ t("published") }})
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col>
                <v-card variant="elevated" rounded="lg" hover class="stat-card">
                    <template v-slot:title>
                        <div class="d-flex align-center justify-start">
                            <v-avatar size="40" class="mr-4">
                                <v-icon size="24" color="primary">mdi-book-outline</v-icon>
                            </v-avatar>
                            <div class="font-weight-black">
                                {{ DashboardRepository.dashboardReport.publishedPublications }}
                            </div>
                        </div>
                    </template>
                    <v-card-text class="text-h6 d-flex justify-start ml-14 stat-card-text">
                        {{ t("publications") }} ({{ t("published") }})
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col>
                <v-card variant="elevated" rounded="lg" hover class="stat-card">
                    <template v-slot:title>
                        <div class="d-flex align-center justify-start">
                            <v-avatar size="40" class="mr-4">
                                <v-icon size="24" color="primary">mdi-trophy-outline</v-icon>
                            </v-avatar>
                            <div class="font-weight-black" :dir="dir">
                                {{ DashboardRepository.dashboardReport.publishedSuccessStories }}
                            </div>
                        </div>
                    </template>
                    <v-card-text class="text-h6 d-flex justify-start ml-14 stat-card-text">
                        {{ t("success_stories") }} ({{ t("published") }})
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col>
                <v-card variant="elevated" rounded="lg" hover class="stat-card">
                    <template v-slot:title>
                        <div class="d-flex align-center justify-start">
                            <v-avatar size="40" class="mr-4">
                                <v-icon size="24" color="primary">mdi-school-outline</v-icon>
                            </v-avatar>
                            <div class="font-weight-black">
                                {{ DashboardRepository.dashboardReport.activeTrainingPrograms }}
                            </div>
                        </div>
                    </template>
                    <v-card-text class="text-h6 d-flex justify-start ml-14 stat-card-text">
                        {{ t("training_programs") }} ({{ t("active") }})
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <v-row :dir="dir">
            <v-col>
                <v-card class="pt-4 bg-background rounded-xl pr-4">
                    <div class="pa-3 px-4 py-5 mr-4 ml-6">
                        <!-- Header -->
                        <div class="d-flex justify-space-between mb-6">
                            <span>
                                <p class="text-lg font-bold">
                                    {{ totalContent }}
                                </p>
                                <p class="text-subtitle-2">
                                    {{ t("contentBasedOnAmountAndPercentage") }}
                                </p>
                            </span>
                            <span class="flex flex-col gap-1">
                                <!-- Filter buttons for switching between time views -->
                                <v-btn
                                    size="x-small"
                                    :style="{
                                        backgroundColor: activeButton === 'black' ? '#112F53' : '',
                                        color: activeButton === 'black' ? '#fff' : '',
                                    }"
                                    @click="updateExpenses(DashboardRepository.dashboardReport.yearlyContent, 'black')"
                                >
                                    {{ t("thisYear") }}
                                </v-btn>
                                <v-btn
                                    size="x-small"
                                    :style="{
                                        backgroundColor: activeButton === 'red' ? '#112F53' : '',
                                        color: activeButton === 'red' ? '#fff' : '',
                                    }"
                                    @click="updateExpenses(DashboardRepository.dashboardReport.monthlyContent, 'red')"
                                >
                                    {{ t("thisMonth") }}
                                </v-btn>
                                <v-btn
                                    size="x-small"
                                    :style="{
                                        backgroundColor: activeButton === 'green' ? '#112F53' : '',
                                        color: activeButton === 'green' ? '#fff' : '',
                                    }"
                                    @click="updateExpenses(DashboardRepository.dashboardReport.dailyContent, 'green')"
                                >
                                    {{ t("today") }}
                                </v-btn>
                            </span>
    </div>

                        <!-- List of content with percentages and progress bars -->
                        <div
                            v-for="expense in DashboardRepository.expensesList"
                            :key="expense.id"
                            class="mb-4"
                        >
                            <div class="d-flex justify-space-between" :dir="dir">
                                <span class="text-sm font-bold">{{ expense.percentage }}%</span>
                                <span class="text-sm font-bold text-gray-700">
                                    {{ translateCategoryName(expense.categoryName) }} ({{ expense.totalExpense }})
                                </span>
        </div>

                            <v-progress-linear
                                :model-value="Number(expense.percentage)"
                                height="6"
                                :color="randomColor()"
                                class="rounded-lg"
                            ></v-progress-linear>
          </div>
        </div>
                </v-card>
            </v-col>

            <v-col>
                <v-card class="bg-background rounded-xl mr-3 px-4 mt-0 h-100">
                    <h2 class="pl-2 py-4">{{ t("recentContacts") }}</h2>
                    <div class="flex justify-center">
                        <v-table class="rounded w-100">
                            <template v-slot:default>
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="text-left font-medium text-gray-700">
                                            {{ t("name") }}
                                        </th>
                                        <th class="text-center font-medium text-gray-700">
                                            {{ t("time") }}
                                        </th>
                                        <th class="text-center font-medium text-gray-700">
                                            {{ t("phone") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="item in DashboardRepository.dashboardReport.recentContacts"
                                        :key="item.id"
                                        class="border-b border-gray-200"
                                    >
                                        <td class="text-left">
                                            {{ item.name }}
                                        </td>
                                        <td class="text-center">
                                            {{ item.time }}
                                        </td>
                                        <td class="text-center">
                                            {{ item.phone || '—' }}
                                        </td>
                                    </tr>
                                    <tr v-if="DashboardRepository.dashboardReport.recentContacts.length === 0">
                                        <td colspan="3" class="text-center text-gray-500 py-4">
                                            {{ t("noRecentContacts") }}
                                        </td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-table>
      </div>
                </v-card>
            </v-col>
        </v-row>

        <!-- Graphs Section -->
        <v-row class="pt-4" style="align-items: stretch;">
            <v-col cols="12" md="6">
                <v-card class="bg-background rounded-xl px-4 py-4 chart-card">
                    <h2 class="pl-2 py-4">{{ t("contentTrends") }}</h2>
                    <div class="chart-container">
                        <div class="bar-chart">
                            <div 
                                v-for="(item, index) in chartData" 
                                :key="index"
                                class="bar-item"
                            >
                                <div class="bar-label">{{ item.label }}</div>
                                <div class="bar-wrapper">
                                    <div 
                                        class="bar-fill" 
                                        :style="{ 
                                            width: item.percentage + '%',
                                            backgroundColor: item.color 
                                        }"
                                    ></div>
                                    <span class="bar-value">{{ item.value }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </v-card>
            </v-col>

            <v-col cols="12" md="6">
                <v-card class="bg-background rounded-xl px-4 py-4 chart-card">
                    <h2 class="pl-2 py-4">{{ t("contentStatus") }}</h2>
                    <div class="chart-container">
                        <div class="pie-chart-container">
                            <div class="pie-chart-wrapper">
                                <svg class="pie-chart" viewBox="0 0 200 200">
                                    <circle
                                        cx="100"
                                        cy="100"
                                        r="80"
                                        fill="none"
                                        stroke="#e5e7eb"
                                        stroke-width="40"
                                    />
                                    <circle
                                        cx="100"
                                        cy="100"
                                        r="80"
                                        fill="none"
                                        :stroke="statusChartData.publishedColor"
                                        stroke-width="40"
                                        :stroke-dasharray="statusChartData.publishedDasharray"
                                        stroke-dashoffset="0"
                                        transform="rotate(-90 100 100)"
                                    />
                                    <circle
                                        cx="100"
                                        cy="100"
                                        r="80"
                                        fill="none"
                                        :stroke="statusChartData.draftColor"
                                        stroke-width="40"
                                        :stroke-dasharray="statusChartData.draftDasharray"
                                        :stroke-dashoffset="statusChartData.draftOffset"
                                        transform="rotate(-90 100 100)"
                                    />
                                </svg>
                                <div class="pie-chart-center">
                                    <div class="pie-chart-number">{{ totalContentItems }}</div>
                                    <div class="pie-chart-label">{{ t("totalItems") }}</div>
                                </div>
                            </div>
                            <div class="pie-legend">
                                <div class="legend-item">
                                    <span class="legend-color" style="background-color: #10b981;"></span>
                                    <span>{{ t("published") }}: {{ publishedCount }}</span>
          </div>
                                <div class="legend-item">
                                    <span class="legend-color" style="background-color: #f59e0b;"></span>
                                    <span>{{ t("draft") }}: {{ draftCount }}</span>
            </div>
          </div>
        </div>
      </div>
                </v-card>
            </v-col>
        </v-row>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from "vue";
import Header from "../components/Header.vue";
import { useI18n } from "vue-i18n";
import { useDashboardRepository } from "../stores/DashboardRepository.js";

const { t, locale } = useI18n();

// Sync locale with localStorage on component creation
// Only update if localStorage has a different value (to avoid overriding current locale)
const savedLang = localStorage.getItem("locale");
if (savedLang && savedLang !== locale.value) {
    locale.value = savedLang;
}

// Watch for locale changes and sync with localStorage
watch(() => locale.value, (newLocale) => {
    const currentLocalStorage = localStorage.getItem("locale");
    if (newLocale && newLocale !== currentLocalStorage) {
        localStorage.setItem("locale", newLocale);
    }
});

// Direction
const dir = computed(() => {
    return locale.value === "fa" || locale.value === "ps" ? "rtl" : "ltr";
});

let DashboardRepository = useDashboardRepository();

onMounted(async () => {
    // Ensure language is set from localStorage when component mounts
    const savedLang = localStorage.getItem("locale");
    if (savedLang && savedLang !== locale.value) {
        locale.value = savedLang;
    }
    
    // Then fetch dashboard data
    await DashboardRepository.fetchDashboardData();
});

const activeButton = ref("black");

// Method to update expenses based on button clicks
const updateExpenses = (expenses, color) => {
    DashboardRepository.updateExpenses(expenses, color);
    activeButton.value = color; // Set the active button to the clicked color
};

// Total content count
const totalContent = computed(() => {
    return DashboardRepository.expensesList.reduce(
        (sum, item) => sum + (item.totalExpense || 0),
        0
    );
});

// Chart data for bar chart
const chartData = computed(() => {
    const data = [
        {
            label: t("news"),
            value: DashboardRepository.dashboardReport.publishedNews,
            color: "#10b981",
        },
        {
            label: t("publications"),
            value: DashboardRepository.dashboardReport.publishedPublications,
            color: "#3b82f6",
        },
        {
            label: t("success_stories"),
            value: DashboardRepository.dashboardReport.publishedSuccessStories,
            color: "#f59e0b",
        },
        {
            label: t("training_programs"),
            value: DashboardRepository.dashboardReport.activeTrainingPrograms,
            color: "#8b5cf6",
        },
        {
            label: t("contacts"),
            value: DashboardRepository.dashboardReport.totalContacts,
            color: "#ef4444",
        },
    ];
    
    const maxValue = Math.max(...data.map(item => item.value), 1);
    
    return data.map(item => ({
        ...item,
        percentage: maxValue > 0 ? Math.round((item.value / maxValue) * 100) : 0,
    }));
});

// Status chart data (pie chart)
const totalContentItems = computed(() => {
    return DashboardRepository.dashboardReport.publishedNews +
           DashboardRepository.dashboardReport.publishedPublications +
           DashboardRepository.dashboardReport.publishedSuccessStories +
           DashboardRepository.dashboardReport.activeTrainingPrograms +
           DashboardRepository.dashboardReport.draftNews +
           DashboardRepository.dashboardReport.draftPublications;
});

const publishedCount = computed(() => {
    return DashboardRepository.dashboardReport.publishedNews +
           DashboardRepository.dashboardReport.publishedPublications +
           DashboardRepository.dashboardReport.publishedSuccessStories +
           DashboardRepository.dashboardReport.activeTrainingPrograms;
});

const draftCount = computed(() => {
    return DashboardRepository.dashboardReport.draftNews +
           DashboardRepository.dashboardReport.draftPublications;
});

const statusChartData = computed(() => {
    const total = totalContentItems.value;
    const published = publishedCount.value;
    const draft = draftCount.value;
    
    if (total === 0) {
        return {
            publishedDasharray: "0 502.65",
            draftDasharray: "0 502.65",
            draftOffset: 0,
            publishedColor: "#e5e7eb",
            draftColor: "#e5e7eb",
        };
    }
    
    const circumference = 2 * Math.PI * 80; // radius = 80
    const publishedPercentage = (published / total) * 100;
    const draftPercentage = (draft / total) * 100;
    
    const publishedDasharray = `${(publishedPercentage / 100) * circumference} ${circumference}`;
    const draftDasharray = `${(draftPercentage / 100) * circumference} ${circumference}`;
    const draftOffset = -((publishedPercentage / 100) * circumference);
    
    return {
        publishedDasharray,
        draftDasharray,
        draftOffset,
        publishedColor: "#10b981",
        draftColor: "#f59e0b",
    };
});

// Array of colors to choose from
const colors = [
    "blue",
    "primary",
    "green",
    "success",
    "info",
    "warning",
];

// Function to select a random color
const randomColor = () => {
    return colors[Math.floor(Math.random() * colors.length)];
};

// Function to translate category names from backend
const translateCategoryName = (categoryName) => {
    if (!categoryName) return 'Unknown';
    
    const categoryMap = {
        'News': t('news'),
        'Publications': t('publications'),
        'Success Stories': t('success_stories'),
        'Training Programs': t('training_programs'),
        'Contacts': t('contacts'),
        'Published': t('published'),
        'Draft': t('draft'),
        'Uncategorized': t('uncategorized') || 'Uncategorized',
        'General': t('general') || 'General',
        'Unknown': t('unknown') || 'Unknown',
    };
    
    // Try exact match first
    if (categoryMap[categoryName]) {
        return categoryMap[categoryName];
    }
    
    // Try case-insensitive match
    const lowerName = categoryName.toLowerCase();
    for (const [key, value] of Object.entries(categoryMap)) {
        if (key.toLowerCase() === lowerName) {
            return value;
        }
    }
    
    // If no translation found, return original
    return categoryName;
};
</script>

<style scoped>
.bg-background {
    background-color: #fafafa;
}

.flex {
    display: flex;
}

.flex-col {
    flex-direction: column;
}

.gap-1 {
    gap: 0.25rem;
}

.gap-2 {
    gap: 0.5rem;
}

/* Ensure all stat cards have the same height */
.stat-card {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.stat-card-text {
    flex: 1;
    display: flex;
    align-items: flex-end;
    min-height: 48px;
}

/* Chart Styles */
.chart-card {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.chart-container {
    padding: 1rem 0;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 300px;
}

/* Bar Chart Styles */
.bar-chart {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.bar-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    min-height: 48px;
    height: 48px;
}

.bar-label {
    min-width: 120px;
    width: 120px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    display: flex;
    align-items: center;
}

.bar-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    height: 32px;
}

.bar-fill {
    height: 32px;
    min-height: 32px;
    border-radius: 4px;
    transition: width 0.5s ease;
    min-width: 4px;
    display: flex;
    align-items: center;
}

.bar-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    min-width: 30px;
    text-align: left;
}

/* Pie Chart Styles */
.pie-chart-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
}

.pie-chart-wrapper {
    position: relative;
    width: 200px;
    height: 200px;
}

.pie-chart {
    width: 100%;
    height: 100%;
    transform: rotate(-90deg);
}

.pie-chart-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.pie-chart-number {
    font-size: 2rem;
    font-weight: 700;
    color: rgb(var(--v-theme-primary));
    line-height: 1;
}

.pie-chart-label {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.pie-legend {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    color: #374151;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
    display: inline-block;
}
</style>
