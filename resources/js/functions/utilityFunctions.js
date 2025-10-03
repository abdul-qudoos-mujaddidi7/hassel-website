/**
 * Format error message for display
 * @param {Object} error - Error object
 * @returns {string} - Formatted error message
 */
export function formatErrorMessage(error) {
  if (error.response?.status === 401) {
    return 'Invalid credentials. Please check your email and password.';
  }
  
  if (error.response?.status === 422) {
    const errors = error.response.data.errors;
    if (errors.email) {
      return errors.email.join(' ');
    }
    if (errors.password) {
      return errors.password.join(' ');
    }
  }
  
  if (error.response?.status === 429) {
    return 'Too many login attempts. Please try again later.';
  }
  
  return 'An unexpected error occurred. Please try again.';
}

/**
 * Debounce function to limit function calls
 * @param {Function} func - Function to debounce
 * @param {number} wait - Wait time in milliseconds
 * @returns {Function} - Debounced function
 */
export function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

/**
 * Show loading state
 * @param {boolean} loading - Loading state
 * @param {string} message - Loading message
 * @returns {string} - Loading message
 */
export function getLoadingMessage(loading, message = 'Loading...') {
  return loading ? message : '';
}

/**
 * Check if form is valid
 * @param {Object} form - Form data
 * @returns {boolean} - Is form valid
 */
export function isFormValid(form) {
  return form.email.trim() !== '' && form.password.trim() !== '';
}

/**
 * Generate random ID
 * @param {number} length - ID length
 * @returns {string} - Random ID
 */
export function generateId(length = 8) {
  const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  let result = '';
  for (let i = 0; i < length; i++) {
    result += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  return result;
}
