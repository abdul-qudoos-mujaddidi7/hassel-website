import { createVuetify } from 'vuetify';
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';

export default createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: 'light',
        themes: {
            light: {
                colors: {
                    primary: '#FF8C00', // Professional vibrant orange
                    secondary: '#E67300', // Darker orange
                    accent: '#FFA500', // Lighter orange accent
                    error: '#F44336',
                    info: '#2196F3',
                    success: '#4CAF50',
                    warning: '#FF9800',
                    // Custom colors for admin table styling
                    tableRowBg: "#FFF8F0", // Very light orange-tinted background for table rows
                    background: "#FFFFFF", // White background
                    lightSectionBg: "#FFF5E6", // Light orange-tinted section bg
                    primaryOld: '#FF8C00', // Professional vibrant orange for buttons
                    tealColor: '#E67300', // Darker orange for icons
                },
            },
        },
    },
    defaults: {
        VTextField: {
            variant: 'outlined',
            density: 'compact',
        },
        VBtn: {
            style: 'text-transform: none;',
        },
    },
});
