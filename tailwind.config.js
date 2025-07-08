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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    light: '#6366f1',
                    DEFAULT: '#4f46e5',
                    dark: '#312e81',
                },
                accent: {
                    light: '#38bdf8',
                    DEFAULT: '#0ea5e9',
                    dark: '#0369a1',
                },
                success: '#22c55e',
                warning: '#f59e42',
                danger: '#ef4444',
                info: '#0ea5e9',
            },
            boxShadow: {
                'xl-strong': '0 8px 32px 0 rgba(31, 41, 55, 0.25)',
                'glow': '0 0 16px 2px #6366f1',
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
            },
            animation: {
                'fade-in': 'fadeIn 0.7s ease-in',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: 0 },
                    '100%': { opacity: 1 },
                },
            },
        },
        darkMode: 'class',
    },

    plugins: [forms],
};
