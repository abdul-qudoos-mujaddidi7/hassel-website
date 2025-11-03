import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import axios from "../../../axios.js";

export const useDashboardRepository = defineStore("DashboardRepository", {
    state() {
        return {
            loading: ref(false),
            dashboardReport: reactive({
                // Main stats
                totalNews: 0,
                totalPublications: 0,
                totalSuccessStories: 0,
                totalTrainingPrograms: 0,
                totalContacts: 0,
                
                // Published counts
                publishedNews: 0,
                publishedPublications: 0,
                publishedSuccessStories: 0,
                activeTrainingPrograms: 0,
                
                // Draft counts
                draftNews: 0,
                draftPublications: 0,
                
                // Content breakdown by type
                newsBreakdown: [],
                publicationsBreakdown: [],
                trainingBreakdown: [],
                
                // Time-based expenses/stats (adapted for content types)
                dailyContent: [],
                monthlyContent: [],
                yearlyContent: [],
                
                // Recent contacts/appointments (adapted)
                recentContacts: [],
                upcomingAppointments: [], // We'll adapt this for recent contacts
            }),
            
            // Expenses list (adapted for content breakdown)
            expensesList: reactive([]),
        };
    },
    
    actions: {
        async fetchDashboardData() {
            this.loading = true;
            try {
                const { data } = await axios.get('dashboard/stats');
                
                if (data.success && data.data) {
                    const stats = data.data;
                    
                    // Main counts
                    this.dashboardReport.totalNews = stats.news?.total || 0;
                    this.dashboardReport.totalPublications = stats.publications?.total || 0;
                    this.dashboardReport.totalSuccessStories = stats.success_stories?.total || 0;
                    this.dashboardReport.totalTrainingPrograms = stats.training_programs?.total || 0;
                    this.dashboardReport.totalContacts = stats.contacts?.total || 0;
                    
                    // Published counts
                    this.dashboardReport.publishedNews = stats.news?.published || 0;
                    this.dashboardReport.publishedPublications = stats.publications?.published || 0;
                    this.dashboardReport.publishedSuccessStories = stats.success_stories?.published || 0;
                    this.dashboardReport.activeTrainingPrograms = stats.training_programs?.active || 0;
                    
                    // Draft counts
                    this.dashboardReport.draftNews = stats.news?.draft || 0;
                    this.dashboardReport.draftPublications = stats.publications?.draft || 0;
                    
                    // Content breakdowns
                    this.dashboardReport.newsBreakdown = stats.news_breakdown || [];
                    this.dashboardReport.publicationsBreakdown = stats.publications_breakdown || [];
                    this.dashboardReport.trainingBreakdown = stats.training_breakdown || [];
                    
                    // Time-based content
                    this.dashboardReport.dailyContent = stats.daily_content || [];
                    this.dashboardReport.monthlyContent = stats.monthly_content || [];
                    this.dashboardReport.yearlyContent = stats.yearly_content || [];
                    
                    // Recent contacts
                    this.dashboardReport.recentContacts = stats.recent_contacts || [];
                    
                    // Initialize with yearly content
                    this.updateExpenses(this.dashboardReport.yearlyContent, 'black');
                }
            } catch (error) {
                console.error('Error fetching dashboard data:', error);
            } finally {
                this.loading = false;
            }
        },
        
        updateExpenses(expenses, color) {
            if (!expenses || !Array.isArray(expenses)) {
                this.expensesList = [];
                return;
            }
            
            // Calculate total
            const total = expenses.reduce((sum, item) => sum + (item.count || item.total || 0), 0);
            
            // Calculate percentages and format
            this.expensesList = expenses.map((item, index) => {
                const value = item.count || item.total || 0;
                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                
                return {
                    id: item.id || index,
                    categoryName: item.category || item.type || item.name || 'Unknown',
                    totalExpense: value,
                    percentage: percentage,
                };
            }).sort((a, b) => b.totalExpense - a.totalExpense);
        },
    },
});

