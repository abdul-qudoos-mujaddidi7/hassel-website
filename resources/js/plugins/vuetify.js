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
                    primary: "#134124", // Professional vibrant green
                    secondary: "#375f1f", // Darker green
                    accent: "#10B981", // Lighter green accent
                    error: "#F44336",
                    info: "#2196F3",
                    success: "#4CAF50",
                    warning: "#FF9800",
                    // Custom colors for admin table styling
                    tableRowBg: "#F0F9F6", // Very light green-tinted background for table rows
                    background: "#FFFFFF", // White background
                    lightSectionBg: "#F0F9F6", // Light green-tinted section bg
                    primaryOld: "#059669", // Professional vibrant green for buttons
                    tealColor: "#047857", // Darker green for icons
                },
            },
        },
    },
    defaults: {
        VTextField: {
            variant: "outlined",
            density: "compact",
        },
        VBtn: {
            style: "text-transform: none;",
        },
    },
});
