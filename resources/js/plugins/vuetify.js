import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "vuetify/styles";
import "@mdi/font/css/materialdesignicons.css";

export default createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: "light",
        themes: {
            light: {
                colors: {
                    // Brand colors from app.css
                    primary: "#134124", // Deep green - main brand color
                    secondary: "#375f1f", // Olive green - secondary brand color
                    accent: "#eaaa03", // Golden accent - brand accent color
                    cream: "#fbf5df", // Light cream - brand cream color

                    // Standard colors
                    error: "#dc2626", // Red for errors
                    info: "#3b82f6", // Blue for info
                    success: "#059669", // Green for success
                    warning: "#f59e0b", // Amber for warnings

                    // Admin panel specific colors
                    background: "#ffffff", // White background
                    surface: "#f8fafc", // Light gray surface
                    surfaceVariant: "#f1f5f9", // Lighter gray for variants

                    // Table and component colors
                    tableHeader: "#134124", // Deep green for table headers
                    tableRow: "#f8fafc", // Light background for table rows
                    tableRowHover: "#f0f9f6", // Light green tint for hover
                    sidebar: "#134124", // Deep green for sidebar
                    sidebarHover: "#375f1f", // Olive green for sidebar hover
                    sidebarActive: "#eaaa03", // Golden accent for active items
                },
            },
        },
    },
    defaults: {
        VTextField: {
            variant: "outlined",
            density: "compact",
            color: "primary",
        },
        VBtn: {
            style: "text-transform: none;",
            color: "primary",
        },
        VCard: {
            color: "surface",
        },
        VDataTable: {
            color: "primary",
        },
        VChip: {
            color: "primary",
        },
    },
});
