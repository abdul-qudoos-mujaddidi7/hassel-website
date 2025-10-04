import { ref, computed } from "vue";

// Global loading state
const globalLoading = ref(false);
const loadingStates = ref(new Map());

export function useLoading(key = null) {
    // If no key provided, use global loading
    if (!key) {
        return {
            loading: globalLoading,
            setLoading: (value) => {
                globalLoading.value = value;
            },
            isLoading: computed(() => globalLoading.value),
        };
    }

    // Initialize loading state for this key
    if (!loadingStates.value.has(key)) {
        loadingStates.value.set(key, ref(false));
    }

    const loading = loadingStates.value.get(key);

    return {
        loading,
        setLoading: (value) => {
            loading.value = value;
        },
        isLoading: computed(() => loading.value),
        // Helper methods
        start: () => {
            loading.value = true;
        },
        stop: () => {
            loading.value = false;
        },
        toggle: () => {
            loading.value = !loading.value;
        },
    };
}

// Global loading helpers
export function setGlobalLoading(value) {
    globalLoading.value = value;
}

export function startGlobalLoading() {
    globalLoading.value = true;
}

export function stopGlobalLoading() {
    globalLoading.value = false;
}

export function toggleGlobalLoading() {
    globalLoading.value = !globalLoading.value;
}

// Loading state for specific keys
export function setLoadingState(key, value) {
    if (!loadingStates.value.has(key)) {
        loadingStates.value.set(key, ref(false));
    }
    loadingStates.value.get(key).value = value;
}

export function getLoadingState(key) {
    return loadingStates.value.get(key)?.value || false;
}

// Clear all loading states
export function clearAllLoadingStates() {
    loadingStates.value.clear();
    globalLoading.value = false;
}
