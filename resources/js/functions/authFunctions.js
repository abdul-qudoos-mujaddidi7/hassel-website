import axios from 'axios';

/**
 * Handle user login
 * @param {Object} credentials - Login credentials
 * @param {string} credentials.email - User email
 * @param {string} credentials.password - User password
 * @param {boolean} credentials.remember - Remember user
 * @returns {Promise<Object>} - Login result
 */
export async function loginUser(credentials) {
  try {
    const response = await axios.post('/admin/login', {
      email: credentials.email,
      password: credentials.password,
      remember: credentials.remember,
    });

    // Store user data if needed
    if (response.data.user) {
      localStorage.setItem('admin_user', JSON.stringify(response.data.user));
    }
    
    // Redirect to admin dashboard on success
    window.location.href = '/admin';
    
    return { success: true, data: response.data };
  } catch (error) {
    return handleLoginError(error);
  }
}

/**
 * Handle login errors
 * @param {Object} error - Error object
 * @returns {Object} - Error result
 */
export function handleLoginError(error) {
  const errors = {};
  
  if (error.response?.status === 422) {
    // Validation errors
    const responseErrors = error.response.data.errors ?? {};
    Object.assign(errors, responseErrors);
    
    // Set general message from email errors if available
    if (responseErrors.email) {
      errors.message = responseErrors.email.join(' ');
    }
  } else {
    // General error
    errors.message = 'Unable to sign in. Please try again.';
  }
  
  return { success: false, errors };
}

/**
 * Logout user
 * @returns {Promise<Object>} - Logout result
 */
export async function logoutUser() {
  try {
    // Clear stored user data
    localStorage.removeItem('admin_user');
    
    await axios.post('/admin/logout');
    window.location.href = '/admin/login';
    return { success: true };
  } catch (error) {
    console.error('Logout error:', error);
    // Still clear local storage and redirect even if API call fails
    localStorage.removeItem('admin_user');
    window.location.href = '/admin/login';
    return { success: false, error: error.message };
  }
}

/**
 * Check if user is authenticated
 * @returns {Promise<Object>} - Auth check result
 */
export async function checkAuth() {
  try {
    // First check localStorage
    const storedUser = localStorage.getItem('admin_user');
    if (storedUser) {
      return { success: true, user: JSON.parse(storedUser) };
    }
    
    // Then check with server
    const response = await axios.get('/admin/user');
    if (response.data.user) {
      localStorage.setItem('admin_user', JSON.stringify(response.data.user));
      return { success: true, user: response.data.user };
    }
    
    return { success: false, user: null };
  } catch (error) {
    // Clear invalid stored data
    localStorage.removeItem('admin_user');
    return { success: false, user: null };
  }
}
