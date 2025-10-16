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
                sans: ['Inter', 'Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ocean: {
                    50: '#CAF0F8',
                    100: '#ADE8F4',
                    200: '#90E0EF',
                    300: '#48CAE4',
                    400: '#00B4D8',
                    500: '#0096C7',
                    600: '#0077B6',
                    700: '#023E8A',
                    800: '#03045E',
                },
            },
            backgroundImage: {
                'gradient-ocean': 'linear-gradient(135deg, #0077B6 0%, #00B4D8 50%, #90E0EF 100%)',
                'gradient-ocean-dark': 'linear-gradient(135deg, #023E8A 0%, #0077B6 100%)',
            },
        },
    },

    plugins: [forms],
};