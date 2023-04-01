/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'dark-mode',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    borderWidth:{
      '1px':'1px',
      '3px':'3px'
    },
    borderRadius: {
      'none': '0',
      'sm': '0.125rem',
      DEFAULT: '0.25rem',
      DEFAULT: '4px',
      'md': '0.375rem',
      'lg': '0.5rem',
      'full': '9999px',
      'large': '12px',
    },
    width:{
      "w10":"10%",
      "w20":"20%",
      "w30":"30%",
      "w40":"40%",
      "w50":"50%",
      "w60":"60%",
      "w70":"70%",
      "w80":"80%",
      "w90":"90%",
      "w100":"100%"
    },
    colors:{
      'darkBtnPrimary':'#3f6791',
      'whitePrincipal': '#ffffff',
      'signUsaPrimary': {
        general: '#007D59',
        hover: '#00A370',
      },
      primary: {
        50: '#eff6ff',
        100: '#dbeafe',
        200: '#bfdbfe',
        300: '#93c5fd',
        400: '#60a5fa',
        500: '#3b82f6',
        600: '#2563eb',
        700: '#1d4ed8',
        800: '#1e40af',
        900: '#1e3a8a',
      },
      secondary: {
        50: '#f8fafc',
        100: '#f1f5f9',
        200: '#e2e8f0',
        300: '#cbd5e1',
        400: '#94a3b8',
        500: '#64748b',
        600: '#475569',
        700: '#334155',
        800: '#1e293b',
        900: '#0f172a',
      },
    },
    fontSize: {
      sm: '0.8rem',
      base: '1rem',
      xl: '1.25rem',
      '2xl': '1.563rem',
      '3xl': '1.953rem',
      '4xl': '2.441rem',
      '5xl': '3.052rem',
    },
   
    extend: {},
  },
  plugins: [],
}
