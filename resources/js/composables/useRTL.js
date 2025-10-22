import { computed } from 'vue';
import { useI18n } from './useI18n.js';

export function useRTL() {
    const { isRTL, currentLanguage } = useI18n();

    // RTL-aware text alignment
    const textAlign = computed(() => {
        return isRTL.value ? 'right' : 'left';
    });

    // RTL-aware margin/padding utilities
    const marginLeft = (value) => {
        return isRTL.value ? `mr-${value}` : `ml-${value}`;
    };

    const marginRight = (value) => {
        return isRTL.value ? `ml-${value}` : `mr-${value}`;
    };

    const paddingLeft = (value) => {
        return isRTL.value ? `pr-${value}` : `pl-${value}`;
    };

    const paddingRight = (value) => {
        return isRTL.value ? `pl-${value}` : `pr-${value}`;
    };

    // RTL-aware positioning
    const left = (value) => {
        return isRTL.value ? `right-${value}` : `left-${value}`;
    };

    const right = (value) => {
        return isRTL.value ? `left-${value}` : `right-${value}`;
    };

    // RTL-aware border radius
    const roundedLeft = (value) => {
        return isRTL.value ? `rounded-r-${value}` : `rounded-l-${value}`;
    };

    const roundedRight = (value) => {
        return isRTL.value ? `rounded-l-${value}` : `rounded-r-${value}`;
    };

    // RTL-aware border styles
    const borderLeft = (value) => {
        return isRTL.value ? `border-r-${value}` : `border-l-${value}`;
    };

    const borderRight = (value) => {
        return isRTL.value ? `border-l-${value}` : `border-r-${value}`;
    };

    // RTL-aware flex direction
    const flexDirection = computed(() => {
        return isRTL.value ? 'flex-row-reverse' : 'flex-row';
    });

    // RTL-aware space utilities
    const spaceX = (value) => {
        return isRTL.value ? `space-x-reverse space-x-${value}` : `space-x-${value}`;
    };

    // RTL-aware transform
    const transform = (value) => {
        if (isRTL.value && value.includes('scaleX')) {
            return value.replace('scaleX(1)', 'scaleX(-1)');
        }
        return value;
    };

    // RTL-aware icon classes
    const iconClasses = (baseClasses = '') => {
        if (isRTL.value) {
            return baseClasses.replace('ml-', 'mr-').replace('mr-', 'ml-');
        }
        return baseClasses;
    };

    // RTL-aware dropdown positioning
    const dropdownPosition = computed(() => {
        return isRTL.value ? 'left-0' : 'right-0';
    });

    // RTL-aware arrow direction
    const arrowDirection = computed(() => {
        return isRTL.value ? 'left' : 'right';
    });

    // RTL-aware chevron rotation
    const chevronRotation = (isOpen) => {
        if (isRTL.value) {
            return isOpen ? 'rotate-180' : '';
        }
        return isOpen ? 'rotate-180' : '';
    };

    // RTL-aware breadcrumb separator
    const breadcrumbSeparator = computed(() => {
        return isRTL.value ? '\\' : '/';
    });

    // RTL-aware language code
    const languageCode = computed(() => {
        return currentLanguage.value;
    });

    // RTL-aware font family
    const fontFamily = computed(() => {
        if (isRTL.value) {
            return 'font-sans'; // You can add RTL-specific fonts here
        }
        return 'font-sans';
    });

    // RTL-aware text direction class
    const textDirection = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware container classes
    const containerClasses = computed(() => {
        const base = 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8';
        return isRTL.value ? `${base} rtl-text` : `${base} ltr-text`;
    });

    // RTL-aware card classes
    const cardClasses = computed(() => {
        const base = 'bg-white rounded-lg shadow-md p-6';
        return isRTL.value ? `${base} rtl-text` : `${base} ltr-text`;
    });

    // RTL-aware button classes
    const buttonClasses = (variant = 'primary') => {
        const base = `btn btn-${variant}`;
        return isRTL.value ? `${base} rtl-text` : `${base} ltr-text`;
    };

    // RTL-aware form classes
    const formClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware table classes
    const tableClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware navigation classes
    const navClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware modal classes
    const modalClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware alert classes
    const alertClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware badge classes
    const badgeClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware list classes
    const listClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware pagination classes
    const paginationClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware carousel classes
    const carouselClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware tooltip classes
    const tooltipClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware popover classes
    const popoverClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware progress classes
    const progressClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware jumbotron classes
    const jumbotronClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware media classes
    const mediaClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware grid classes
    const gridClasses = computed(() => {
        return isRTL.value ? 'rtl-text' : 'ltr-text';
    });

    // RTL-aware responsive classes
    const responsiveClasses = (breakpoint, property, value) => {
        const base = `${breakpoint}:${property}-${value}`;
        if (isRTL.value && (property === 'text-left' || property === 'text-right')) {
            return property === 'text-left' ? `${breakpoint}:text-right` : `${breakpoint}:text-left`;
        }
        return base;
    };

    return {
        // State
        isRTL,
        currentLanguage,
        languageCode,
        
        // Computed
        textAlign,
        flexDirection,
        dropdownPosition,
        arrowDirection,
        breadcrumbSeparator,
        fontFamily,
        textDirection,
        
        // Utility functions
        marginLeft,
        marginRight,
        paddingLeft,
        paddingRight,
        left,
        right,
        roundedLeft,
        roundedRight,
        borderLeft,
        borderRight,
        spaceX,
        transform,
        iconClasses,
        chevronRotation,
        responsiveClasses,
        
        // Component classes
        containerClasses,
        cardClasses,
        buttonClasses,
        formClasses,
        tableClasses,
        navClasses,
        modalClasses,
        alertClasses,
        badgeClasses,
        listClasses,
        paginationClasses,
        carouselClasses,
        tooltipClasses,
        popoverClasses,
        progressClasses,
        jumbotronClasses,
        mediaClasses,
        gridClasses,
    };
}







