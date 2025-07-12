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

    plugins: [
        forms,
        function({ addBase, theme }) {
            addBase({
                // Estilos globais para inputs, textareas e selects
                'input, textarea, select': {
                    color: theme('colors.slate.900'),
                    backgroundColor: theme('colors.slate.50'),
                    borderColor: theme('colors.slate.300'),
                    borderRadius: theme('borderRadius.xl'),
                    padding: theme('spacing.4'),
                    paddingTop: theme('spacing.3'),
                    paddingBottom: theme('spacing.3'),
                    fontSize: theme('fontSize.base'),
                    lineHeight: theme('lineHeight.normal'),
                    transition: 'all 0.2s ease',
                    outline: 'none',
                    '&:focus': {
                        borderColor: theme('colors.blue.500'),
                        boxShadow: `0 0 0 2px ${theme('colors.blue.500')}`,
                        backgroundColor: theme('colors.white'),
                    },
                    '&::placeholder': {
                        color: theme('colors.slate.500'),
                        opacity: '1',
                    },
                },
                
                // Estilos específicos para dark mode
                '.dark input, .dark textarea, .dark select': {
                    color: theme('colors.white'),
                    backgroundColor: theme('colors.slate.700'),
                    borderColor: theme('colors.slate.600'),
                    '&:focus': {
                        borderColor: theme('colors.blue.400'),
                        boxShadow: `0 0 0 2px ${theme('colors.blue.400')}`,
                        backgroundColor: theme('colors.slate.700'),
                    },
                    '&::placeholder': {
                        color: theme('colors.slate.400'),
                        opacity: '1',
                    },
                },
                
                // Estilos para file inputs
                'input[type="file"]': {
                    backgroundColor: 'transparent',
                    border: 'none',
                    padding: '0',
                    '&::file-selector-button': {
                        backgroundColor: theme('colors.blue.50'),
                        color: theme('colors.blue.700'),
                        border: 'none',
                        borderRadius: theme('borderRadius.full'),
                        padding: `${theme('spacing.2')} ${theme('spacing.4')}`,
                        fontSize: theme('fontSize.sm'),
                        fontWeight: theme('fontWeight.semibold'),
                        marginRight: theme('spacing.4'),
                        cursor: 'pointer',
                        transition: 'all 0.2s ease',
                        '&:hover': {
                            backgroundColor: theme('colors.blue.100'),
                        },
                    },
                },
                
                '.dark input[type="file"]::file-selector-button': {
                    backgroundColor: theme('colors.blue.900'),
                    color: theme('colors.blue.400'),
                    '&:hover': {
                        backgroundColor: theme('colors.blue.800'),
                    },
                },
                
                // Estilos para checkboxes e radios
                'input[type="checkbox"], input[type="radio"]': {
                    backgroundColor: theme('colors.white'),
                    borderColor: theme('colors.slate.300'),
                    borderRadius: theme('borderRadius.md'),
                    '&:focus': {
                        borderColor: theme('colors.blue.500'),
                        boxShadow: `0 0 0 2px ${theme('colors.blue.500')}`,
                    },
                },
                
                '.dark input[type="checkbox"], .dark input[type="radio"]': {
                    backgroundColor: theme('colors.slate.700'),
                    borderColor: theme('colors.slate.600'),
                    '&:focus': {
                        borderColor: theme('colors.blue.400'),
                        boxShadow: `0 0 0 2px ${theme('colors.blue.400')}`,
                    },
                },
                
                // Estilos para labels
                'label': {
                    color: theme('colors.slate.700'),
                    fontSize: theme('fontSize.sm'),
                    fontWeight: theme('fontWeight.medium'),
                    marginBottom: theme('spacing.2'),
                },
                
                '.dark label': {
                    color: theme('colors.slate.300'),
                },
                
                // Transições suaves para dark mode
                '*': {
                    transition: 'background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease',
                },
            })
        }
    ],
};
