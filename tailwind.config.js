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
        accent: {
          50:  '#eef2ff',
          100: '#e0e7ff',
          200: '#c7d2fe',
          300: '#a5b4fc',
          400: '#818cf8',
          500: '#8b5cf6',
          600: '#4f46e5',
          700: '#4338ca',
          800: '#3730a3',
          900: '#312e81',
        },
        surface: {
          DEFAULT: '#0a0a0f',
          50:      '#0f0f1a',
          100:     '#13131f',
          200:     '#1a1a2e',
          card:    '#111118',
          border:  '#1e1e2e',
        },
        content: {
          strong:  '#f8fafc',
          DEFAULT: '#cbd5e1',
          muted:   '#64748b',
          light:   '#334155',
        },
      },
      fontSize: {
        'display-2xl': ['4.5rem', { lineHeight: '1.1', letterSpacing: '-0.03em', fontWeight: '800' }],
        'display-xl':  ['3.75rem', { lineHeight: '1.1', letterSpacing: '-0.03em', fontWeight: '700' }],
        'display-lg':  ['3rem',    { lineHeight: '1.15', letterSpacing: '-0.02em', fontWeight: '700' }],
        'display-md':  ['2.25rem', { lineHeight: '1.2',  letterSpacing: '-0.02em', fontWeight: '600' }],
        'display-sm':  ['1.875rem',{ lineHeight: '1.25', letterSpacing: '-0.01em', fontWeight: '600' }],
      },
      fontFamily: {
        display: ['"Poppins"', 'sans-serif'],
        body:    ['"Poppins"', 'sans-serif'],
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
