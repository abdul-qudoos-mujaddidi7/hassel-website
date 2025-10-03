/**
 * Validate email format
 * @param {string} email - Email to validate
 * @returns {boolean} - Is valid email
 */
export function validateEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

/**
 * Validate password strength
 * @param {string} password - Password to validate
 * @returns {Object} - Validation result
 */
export function validatePassword(password) {
  if (password.length < 8) {
    return { isValid: false, message: 'Password must be at least 8 characters long' };
  }
  
  if (!/(?=.*[a-z])/.test(password)) {
    return { isValid: false, message: 'Password must contain at least one lowercase letter' };
  }
  
  if (!/(?=.*[A-Z])/.test(password)) {
    return { isValid: false, message: 'Password must contain at least one uppercase letter' };
  }
  
  if (!/(?=.*\d)/.test(password)) {
    return { isValid: false, message: 'Password must contain at least one number' };
  }
  
  return { isValid: true, message: 'Password is valid' };
}

/**
 * Validate login form
 * @param {Object} form - Form data
 * @returns {Object} - Validation result
 */
export function validateLoginForm(form) {
  const errors = {};
  
  if (!form.email || !validateEmail(form.email)) {
    errors.email = 'Please enter a valid email address';
  }
  
  if (!form.password || form.password.length < 6) {
    errors.password = 'Password must be at least 6 characters long';
  }
  
  return {
    isValid: Object.keys(errors).length === 0,
    errors
  };
}

/**
 * Clear form errors
 * @param {Object} errors - Errors object
 * @returns {Object} - Empty errors object
 */
export function clearFormErrors(errors) {
  Object.keys(errors).forEach(key => delete errors[key]);
  return errors;
}

/**
 * Reset form data
 * @returns {Object} - Empty form object
 */
export function resetForm() {
  return {
    email: '',
    password: '',
    remember: false,
  };
}
