import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brand-green': {
                    DEFAULT: '#12EDC1', // El color principal
                    'light': '#A0FFEE',  // Una versión más clara
                    'dark': '#0DBFA0',   // Una versión más oscura para hovers
                },
            },
        },
    },

    plugins: [forms],
};
