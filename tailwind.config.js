module.exports = {
  content: [
    './includes/**/*.{php,html}', // Chemin vers les fichiers PHP
    './pages/**/*.{php,html}',    // Chemin vers les fichiers PHP
    './*.{php,html}',             // Chemin vers les fichiers à la racine
  ],
  theme: {
    extend: {
      colors: {
        'primary-bg': '#f8f9fa',
        'secondary-bg': '#343a40',
        'primary-text': '#212529',
        'secondary-text': '#adb5bd',
        'accent': '#007bff',
        'button-bg': '#007bff',
        'button-hover-bg': '#0056b3',
        'header-bg': '#343a40',
        'footer-bg': '#343a40',
        'form-bg': '#ffffff',
      },
      boxShadow: {
        'custom': '0 4px 8px rgba(0, 0, 0, 0.2)',
      },
      borderRadius: {
        'custom': '0.375rem',
      },
      transitionDuration: {
        'custom': '0.3s',
      }
    },
  },
  plugins: [],
}

