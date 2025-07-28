import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Instrument Sans', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                'dark-green': {
                    50: '#f0f9f5',
                    100: '#daf0e6',
                    200: '#b8e1d0',
                    300: '#88cbb3',
                    400: '#51ad8e',
                    500: '#2e8b57', // Base color
                    600: '#1f7a4d',
                    700: '#013220', // Dark green (Rolls Royce style)
                    800: '#0a5233',
                    900: '#0a422a',
                    950: '#052316',
                },
                'gold': {
                    50: '#fff9eb',
                    100: '#ffedc6',
                    200: '#ffda88',
                    300: '#ffc145',
                    400: '#ffa920',
                    500: '#f98e07',
                    600: '#dd6702',
                    700: '#b74606',
                    800: '#94350c',
                    900: '#7a2c0d',
                    950: '#461402',
                },
                'cream': '#F5F5DC',
            },
            boxShadow: {
                elegant: '0 4px 30px rgba(0, 0, 0, 0.1)',
                'elegant-md': '0 8px 40px rgba(0, 0, 0, 0.15)',
            },
            borderWidth: {
                '3': '3px',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
            },
        },
    },

    plugins: [
        forms,
        require('@tailwindcss/typography'),
    ],
};