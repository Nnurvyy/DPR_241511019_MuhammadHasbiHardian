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
        },
    },

    plugins: [forms],

    safelist: [
        '!border-red-500',
        'focus:!border-red-500',
        'focus:!ring-red-500',
        'bg-green-600',
        'bg-red-600',
        'bg-yellow-500',
        'fixed',
        'top-5',
        'right-5',
        'z-50',
        'px-4',
        'py-2',
        'rounded',
        'shadow',
        'text-white'
    ],
};
