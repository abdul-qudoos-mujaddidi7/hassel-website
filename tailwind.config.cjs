/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./resources/**/*.ts",
  ],
  theme: {
    extend: {
      // RTL support
      direction: {
        'rtl': 'rtl',
        'ltr': 'ltr',
      },
    },
  },
  plugins: [
    // RTL plugin for Tailwind CSS
    function({ addUtilities, addVariant }) {
      // Add RTL utilities
      addUtilities({
        '.rtl-text': {
          direction: 'rtl',
          textAlign: 'right',
        },
        '.ltr-text': {
          direction: 'ltr',
          textAlign: 'left',
        },
        '.rtl-text-left': {
          direction: 'rtl',
          textAlign: 'left',
        },
        '.rtl-text-center': {
          direction: 'rtl',
          textAlign: 'center',
        },
        '.rtl-text-right': {
          direction: 'rtl',
          textAlign: 'right',
        },
      });

      // Add RTL variant
      addVariant('rtl', 'html[dir="rtl"] &');
      addVariant('ltr', 'html[dir="ltr"] &');
    }
  ],
}

