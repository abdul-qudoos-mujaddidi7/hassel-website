<template>
    <div class="dashboard-container">
        <Header :pageTitle="$t('dashboard')" />

        <v-divider
            :thickness="2"
            class="border-opacity-100 dashboard-divider"
            color="success"
        ></v-divider>

        <!-- Stats Cards Row -->
        <v-row class="stats-row pt-6">
            <v-col cols="12" sm="6" md="3">
                <v-card 
                    class="stat-card news-card" 
                    elevation="2"
                    :class="{ 'hover-elevation': true }"
                >
                    <div class="stat-card-content">
                        <div class="stat-icon-wrapper news-icon">
                            <v-icon size="32" color="white">mdi-newspaper-variant-outline</v-icon>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">
                                {{ DashboardRepository.dashboardReport.publishedNews }}
                            </div>
                            <div class="stat-label">
                                {{ t("news") }}
                            </div>
                            <div class="stat-subtitle">
                                {{ t("published") }}
                            </div>
                        </div>
                    </div>
                </v-card>
            </v-col>

            <v-col cols="12" sm="6" md="3">
                <v-card 
                    class="stat-card publications-card" 
                    elevation="2"
                    :class="{ 'hover-elevation': true }"
                >
                    <div class="stat-card-content">
                        <div class="stat-icon-wrapper publications-icon">
                            <v-icon size="32" color="white">mdi-book-outline</v-icon>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">
                                {{ DashboardRepository.dashboardReport.publishedPublications }}
                            </div>
                            <div class="stat-label">
                                {{ t("publications") }}
                            </div>
                            <div class="stat-subtitle">
                                {{ t("published") }}
                            </div>
                        </div>
                    </div>
                </v-card>
            </v-col>

            <v-col cols="12" sm="6" md="3">
                <v-card 
                    class="stat-card success-stories-card" 
                    elevation="2"
                    :class="{ 'hover-elevation': true }"
                >
                    <div class="stat-card-content">
                        <div class="stat-icon-wrapper success-stories-icon">
                            <v-icon size="32" color="white">mdi-trophy-outline</v-icon>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">
                                {{ DashboardRepository.dashboardReport.publishedSuccessStories }}
                            </div>
                            <div class="stat-label">
                                {{ t("success_stories") }}
                            </div>
                            <div class="stat-subtitle">
                                {{ t("published") }}
                            </div>
                        </div>
                    </div>
                </v-card>
            </v-col>

            <v-col cols="12" sm="6" md="3">
                <v-card 
                    class="stat-card training-card" 
                    elevation="2"
                    :class="{ 'hover-elevation': true }"
                >
                    <div class="stat-card-content">
                        <div class="stat-icon-wrapper training-icon">
                            <v-icon size="32" color="white">mdi-school-outline</v-icon>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">
                                {{ DashboardRepository.dashboardReport.activeTrainingPrograms }}
                            </div>
                            <div class="stat-label">
                                {{ t("training_programs") }}
                            </div>
                            <div class="stat-subtitle">
                                {{ t("active") }}
                            </div>
                        </div>
                    </div>
                </v-card>
            </v-col>
        </v-row>

        <!-- Content Analysis and Recent Contacts Row -->
        <v-row class="pt-6" :dir="dir">
            <v-col cols="12" lg="7">
                <v-card class="content-analysis-card" elevation="2">
                    <v-card-title class="card-title">
                        <div class="title-content">
                            <v-icon class="title-icon" color="primary">mdi-chart-box-outline</v-icon>
                            <span>{{ t("contentBasedOnAmountAndPercentage") }}</span>
                        </div>
                        <div class="time-filter-buttons">
                            <v-btn
                                size="small"
                                variant="text"
                                :class="['time-filter-btn', { 'active': activeButton === 'black' }]"
                                @click="updateExpenses(DashboardRepository.dashboardReport.yearlyContent, 'black')"
                            >
                                {{ t("thisYear") }}
                            </v-btn>
                            <v-btn
                                size="small"
                                variant="text"
                                :class="['time-filter-btn', { 'active': activeButton === 'red' }]"
                                @click="updateExpenses(DashboardRepository.dashboardReport.monthlyContent, 'red')"
                            >
                                {{ t("thisMonth") }}
                            </v-btn>
                            <v-btn
                                size="small"
                                variant="text"
                                :class="['time-filter-btn', { 'active': activeButton === 'green' }]"
                                @click="updateExpenses(DashboardRepository.dashboardReport.dailyContent, 'green')"
                            >
                                {{ t("today") }}
                            </v-btn>
                        </div>
                    </v-card-title>
                    <v-card-text class="content-analysis-body">
                        <div class="total-content-display">
                            <span class="total-label">{{ t("totalItems") }}:</span>
                            <span class="total-value">{{ totalContent }}</span>
                        </div>
                        <div class="expenses-list">
                            <div
                                v-for="expense in DashboardRepository.expensesList"
                                :key="expense.id"
                                class="expense-item"
                            >
                                <div class="expense-header">
                                    <div class="expense-label">
                                        <span class="expense-category">{{ translateCategoryName(expense.categoryName) }}</span>
                                        <span class="expense-count">({{ expense.totalExpense }})</span>
                                    </div>
                                    <span class="expense-percentage">{{ expense.percentage }}%</span>
                                </div>
                                <v-progress-linear
                                    :model-value="Number(expense.percentage)"
                                    height="10"
                                    :color="getExpenseColor(expense.categoryName)"
                                    class="expense-progress"
                                    rounded
                                ></v-progress-linear>
                            </div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="5">
                <v-card class="recent-contacts-card" elevation="2">
                    <v-card-title class="card-title">
                        <div class="title-content">
                            <v-icon class="title-icon" color="primary">mdi-account-group-outline</v-icon>
                            <span>{{ t("recentContacts") }}</span>
                        </div>
                    </v-card-title>
                    <v-card-text class="contacts-table-wrapper">
                        <div class="contacts-table">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>{{ t("name") }}</th>
                                        <th>{{ t("time") }}</th>
                                        <th>{{ t("phone") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="item in DashboardRepository.dashboardReport.recentContacts"
                                        :key="item.id"
                                    >
                                        <td>
                                            <div class="contact-name">
                                                <v-icon size="16" class="contact-icon">mdi-account-circle</v-icon>
                                                {{ item.name }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="time-badge">{{ item.time }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="phone-text">{{ item.phone || '—' }}</span>
                                        </td>
                                    </tr>
                                    <tr v-if="DashboardRepository.dashboardReport.recentContacts.length === 0">
                                        <td colspan="3" class="empty-state">
                                            <v-icon size="48" color="grey-lighten-1">mdi-inbox</v-icon>
                                            <p>{{ t("noRecentContacts") }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <!-- Charts Section -->
        <v-row class="pt-6 charts-row">
            <v-col cols="12" md="6">
                <v-card class="chart-card" elevation="2">
                    <v-card-title class="card-title">
                        <div class="title-content">
                            <v-icon class="title-icon" color="primary">mdi-chart-bar</v-icon>
                            <span>{{ t("contentTrends") }}</span>
                        </div>
                    </v-card-title>
                    <v-card-text class="chart-container">
                        <div class="bar-chart">
                            <div 
                                v-for="(item, index) in chartData" 
                                :key="index"
                                class="bar-item"
                            >
                                <div class="bar-label-wrapper">
                                    <div class="bar-color-dot" :style="{ backgroundColor: item.color }"></div>
                                    <span class="bar-label">{{ item.label }}</span>
                                </div>
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
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="6">
                <v-card class="chart-card" elevation="2">
                    <v-card-title class="card-title">
                        <div class="title-content">
                            <v-icon class="title-icon" color="primary">mdi-chart-pie</v-icon>
                            <span>{{ t("contentStatus") }}</span>
                        </div>
                    </v-card-title>
                    <v-card-text class="chart-container">
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
                                    <div class="legend-info">
                                        <span class="legend-label">{{ t("published") }}</span>
                                        <span class="legend-value">{{ publishedCount }}</span>
                                    </div>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color" style="background-color: #f59e0b;"></span>
                                    <div class="legend-info">
                                        <span class="legend-label">{{ t("draft") }}</span>
                                        <span class="legend-value">{{ draftCount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-card-text>
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
    const savedLang = localStorage.getItem("locale");
    if (savedLang && savedLang !== locale.value) {
        locale.value = savedLang;
    }
    await DashboardRepository.fetchDashboardData();
});

const activeButton = ref("black");

const updateExpenses = (expenses, color) => {
    DashboardRepository.updateExpenses(expenses, color);
    activeButton.value = color;
};

const totalContent = computed(() => {
    return DashboardRepository.expensesList.reduce(
        (sum, item) => sum + (item.totalExpense || 0),
        0
    );
});

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
    
    const circumference = 2 * Math.PI * 80;
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

// Get color for expense category
const getExpenseColor = (categoryName) => {
    const colorMap = {
        'News': '#10b981',
        'Publications': '#3b82f6',
        'Success Stories': '#f59e0b',
        'Training Programs': '#8b5cf6',
        'Contacts': '#ef4444',
    };
    
    return colorMap[categoryName] || 'primary';
};

const translateCategoryName = (categoryName) => {
    if (!categoryName) return t('unknown');
    
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
    
    if (categoryMap[categoryName]) {
        return categoryMap[categoryName];
    }
    
    const lowerName = categoryName.toLowerCase();
    for (const [key, value] of Object.entries(categoryMap)) {
        if (key.toLowerCase() === lowerName) {
            return value;
        }
    }
    
    return categoryName;
};
</script>

<style scoped>
.dashboard-container {
    padding: 0;
    background: #f5f7fa;
    min-height: 100vh;
}

.dashboard-divider {
    margin: 0;
}

/* Stats Cards */
.stats-row {
    margin-bottom: 0;
}

.stat-card {
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
}

.stat-card.hover-elevation {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card.hover-elevation:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
}

.stat-card-content {
    display: flex;
    align-items: center;
    padding: 24px;
    gap: 20px;
}

.stat-icon-wrapper {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.news-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.publications-icon {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.success-stories-icon {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.training-icon {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.stat-info {
    flex: 1;
    min-width: 0;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1.2;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #4b5563;
    margin-bottom: 2px;
}

.stat-subtitle {
    font-size: 0.75rem;
    color: #9ca3af;
    font-weight: 500;
}

/* Content Analysis Card */
.content-analysis-card,
.recent-contacts-card,
.chart-card {
    border-radius: 16px;
    border: none;
    height: 100%;
}

.card-title {
    padding: 20px 24px;
    border-bottom: 1px solid #e5e7eb;
    background: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.title-content {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
}

.title-icon {
    font-size: 24px;
}

.time-filter-buttons {
    display: flex;
    gap: 8px;
}

.time-filter-btn {
    min-width: auto;
    padding: 6px 16px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: none;
    transition: all 0.2s ease;
}

.time-filter-btn.active {
    background: #112F53 !important;
    color: white !important;
}

.content-analysis-body {
    padding: 24px;
}

.total-content-display {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    margin-bottom: 24px;
    color: white;
}

.total-label {
    font-size: 0.875rem;
    font-weight: 500;
    opacity: 0.9;
}

.total-value {
    font-size: 1.5rem;
    font-weight: 700;
}

.expenses-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.expense-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.expense-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.expense-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.875rem;
}

.expense-category {
    font-weight: 600;
    color: #1f2937;
}

.expense-count {
    color: #6b7280;
    font-weight: 400;
}

.expense-percentage {
    font-weight: 700;
    color: #1f2937;
    font-size: 0.875rem;
}

.expense-progress {
    border-radius: 8px;
}

/* Recent Contacts Card */
.contacts-table-wrapper {
    padding: 0;
}

.contacts-table {
    overflow-x: auto;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
}

.custom-table thead {
    background: #f9fafb;
}

.custom-table th {
    padding: 16px 20px;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #e5e7eb;
}

.custom-table td {
    padding: 16px 20px;
    border-bottom: 1px solid #f3f4f6;
}

.custom-table tbody tr:hover {
    background: #f9fafb;
}

.contact-name {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    color: #1f2937;
}

.contact-icon {
    color: #9ca3af;
}

.time-badge {
    display: inline-block;
    padding: 4px 12px;
    background: #eff6ff;
    color: #3b82f6;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
}

.phone-text {
    color: #6b7280;
    font-size: 0.875rem;
}

.empty-state {
    text-align: center;
    padding: 48px 20px !important;
    color: #9ca3af;
}

.empty-state p {
    margin-top: 16px;
    font-size: 0.875rem;
}

/* Charts */
.chart-card {
    min-height: 400px;
}

.chart-container {
    padding: 24px;
    min-height: 350px;
}

.bar-chart {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.bar-item {
    display: flex;
    align-items: center;
    gap: 16px;
}

.bar-label-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 140px;
    width: 140px;
}

.bar-color-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}

.bar-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
}

.bar-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    height: 36px;
    background: #f3f4f6;
    border-radius: 8px;
    padding: 0 4px;
}

.bar-fill {
    height: 28px;
    border-radius: 6px;
    transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    min-width: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.bar-value {
    font-size: 0.875rem;
    font-weight: 700;
    color: #1f2937;
    min-width: 40px;
    text-align: right;
    padding-right: 8px;
}

.pie-chart-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 32px;
    padding: 20px 0;
}

.pie-chart-wrapper {
    position: relative;
    width: 220px;
    height: 220px;
}

.pie-chart {
    width: 100%;
    height: 100%;
}

.pie-chart-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.pie-chart-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
}

.pie-chart-label {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 8px;
    font-weight: 500;
}

.pie-legend {
    display: flex;
    flex-direction: column;
    gap: 16px;
    width: 100%;
    max-width: 200px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f9fafb;
    border-radius: 8px;
}

.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 4px;
    flex-shrink: 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.legend-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex: 1;
}

.legend-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
}

.legend-value {
    font-size: 0.875rem;
    font-weight: 700;
    color: #1f2937;
}

/* Responsive */
@media (max-width: 960px) {
    .stat-card-content {
        padding: 20px;
    }
    
    .stat-icon-wrapper {
        width: 56px;
        height: 56px;
    }
    
    .stat-value {
        font-size: 1.75rem;
    }
}

@media (max-width: 600px) {
    .stat-card-content {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }
    
    .title-content {
        font-size: 1rem;
    }
    
    .time-filter-buttons {
        flex-direction: column;
        gap: 4px;
    }
    
    .bar-label-wrapper {
        min-width: 100px;
        width: 100px;
    }
}
</style>