/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './app/View/Components/**/*.php',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        brand: {
          50:  '#fafafa',
          100: '#f4f4f5',
          200: '#e4e4e7',
          300: '#d4d4d8',
          400: '#a1a1aa',
          500: '#18181b', // Main brand color (black/zinc-900)
          600: '#09090b', // Hover state
          700: '#000000',
          800: '#000000',
          900: '#000000',
        },
        accent: {
          50:  '#eef2ff',
          100: '#e0e7ff',
          200: '#c7d2fe',
          300: '#a5b4fc',
          400: '#818cf8',
          500: '#6366f1',
          600: '#4f46e5',
          700: '#4338ca',
          800: '#3730a3',
          900: '#312e81',
        },
        surface: {
          DEFAULT: '#ffffff',     /* White background */
          50:      '#f8fafc',     /* Off-white */
          100:     '#f1f5f9',     /* Soft gray */
          card:    '#ffffff',     /* Card background */
          border:  '#e2e8f0',     /* Borders */
        },
        content: {
          strong:  '#0f172a',     /* text-slate-900 equivalent */
          DEFAULT: '#334155',     /* text-slate-700 equivalent */
          muted:   '#64748b',     /* text-slate-500 equivalent */
          light:   '#94a3b8',     /* text-slate-400 equivalent */
        },
      },
      fontFamily: {
        display: ['"Syne"', 'sans-serif'],
        body:    ['"DM Sans"', 'sans-serif'],
        mono:    ['"JetBrains Mono"', 'monospace'],
      },
      animation: {
        'fade-in':       'fade-in 0.6s ease-out both',
        'slide-up':      'slide-up 0.6s ease-out both',
        'slide-down':    'slide-down 0.3s ease-out both',
        'scale-in':      'scale-in 0.3s ease-out both',
        'glow':          'glow 3s ease-in-out infinite',
        'hero-fade-up':  'hero-fade-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) both',
        'float-gentle':  'float-gentle 6s ease-in-out infinite',
        'float-gentle-reverse': 'float-gentle-reverse 7s ease-in-out infinite',
        'pulse-ring':    'pulse-ring 3s ease-out infinite',
        'bar-grow':      'bar-grow 2s ease-out both',
        'line-draw':     'line-draw 3s ease-in-out both',
        'gradient-shift':'gradient-shift 8s ease infinite',
      },
      keyframes: {
        'fade-in': {
          from: { opacity: '0' },
          to:   { opacity: '1' },
        },
        'slide-up': {
          from: { opacity: '0', transform: 'translateY(20px)' },
          to:   { opacity: '1', transform: 'translateY(0)' },
        },
        'slide-down': {
          from: { opacity: '0', transform: 'translateY(-10px)' },
          to:   { opacity: '1', transform: 'translateY(0)' },
        },
        'scale-in': {
          from: { opacity: '0', transform: 'scale(0.95)' },
          to:   { opacity: '1', transform: 'scale(1)' },
        },
        glow: {
          '0%, 100%': { opacity: '0.4' },
          '50%':      { opacity: '0.8' },
        },
        'hero-fade-up': {
          from: { opacity: '0', transform: 'translateY(30px)' },
          to:   { opacity: '1', transform: 'translateY(0)' },
        },
        'float-gentle': {
          '0%, 100%': { transform: 'translate3d(0, 0px, 0)' },
          '50%':      { transform: 'translate3d(0, -12px, 0)' },
        },
        'float-gentle-reverse': {
          '0%, 100%': { transform: 'translate3d(0, 0px, 0)' },
          '50%':      { transform: 'translate3d(0, 10px, 0)' },
        },
        'pulse-ring': {
          '0%':   { transform: 'scale(0.8)', opacity: '0.6' },
          '100%': { transform: 'scale(2.2)', opacity: '0' },
        },
        'bar-grow': {
          from: { transform: 'scaleY(0)' },
          to:   { transform: 'scaleY(1)' },
        },
        'line-draw': {
          from: { 'stroke-dashoffset': '200' },
          to:   { 'stroke-dashoffset': '0' },
        },
        'gradient-shift': {
          '0%':   { 'background-position': '0% 50%' },
          '50%':  { 'background-position': '100% 50%' },
          '100%': { 'background-position': '0% 50%' },
        },
      },
    },
  },
  plugins: [],
};
