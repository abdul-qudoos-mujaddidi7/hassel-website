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
                    // Primary Greens - Main brand colors
                    primary: "#1b5e20", // Dark green for primary actions
                    secondary: "#2e7d32", // Medium green for secondary elements
                    // Supporting Greens
                    success: "#4caf50", // Success states
                    info: "#2196F3", // Keep blue for info
                    warning: "#ff9800", // Keep orange for warnings
                    error: "#f44336", // Keep red for errors
                    surface: "#ffffff", // White for cards/surfaces

                    // Additional Green Shades
                    accent: "#81c784", // Light green accent
                    "on-primary": "#ffffff", // Text on primary colors
                    "on-secondary": "#ffffff", // Text on secondary colors

                    // Custom colors for specific components
                    "table-row-bg": "#f0fdf4", // Very light green for table rows
                    "light-section": "#e8f5e9", // Light green section background
                    "sidebar-bg": "#f8fdf8", // Sidebar background

                    // Legacy colors for compatibility
                    primaryOld: "#134124",
                    tealColor: "#375f1f",
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
