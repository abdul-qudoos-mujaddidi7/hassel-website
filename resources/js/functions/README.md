# Functions Directory

This directory contains reusable JavaScript functions organized by purpose.

## File Structure

### `authFunctions.js`
Authentication-related functions:
- `loginUser(credentials)` - Handle user login
- `handleLoginError(error)` - Process login errors
- `logoutUser()` - Handle user logout
- `checkAuth()` - Check authentication status

### `formFunctions.js`
Form validation and management functions:
- `validateEmail(email)` - Validate email format
- `validatePassword(password)` - Validate password strength
- `validateLoginForm(form)` - Validate complete login form
- `clearFormErrors(errors)` - Clear form error messages
- `resetForm()` - Reset form to initial state

### `utilityFunctions.js`
General utility functions:
- `formatErrorMessage(error)` - Format error messages
- `debounce(func, wait)` - Debounce function calls
- `getLoadingMessage(loading, message)` - Get loading message
- `isFormValid(form)` - Check if form is valid
- `generateId(length)` - Generate random ID

## Usage Example

```javascript
// In any Vue component
import { loginUser } from '../functions/authFunctions.js';
import { validateLoginForm } from '../functions/formFunctions.js';
import { isFormValid } from '../functions/utilityFunctions.js';

// Use the functions
const result = await loginUser({ email, password, remember });
const validation = validateLoginForm(form);
const isValid = isFormValid(form);
```

## Benefits

- **Reusable**: Functions can be used across multiple components
- **Testable**: Easy to unit test individual functions
- **Maintainable**: Changes in one place affect all usage
- **Simple**: No complex state management, just pure functions
