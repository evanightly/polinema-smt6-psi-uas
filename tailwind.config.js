/** @type {import('tailwindcss').Config} */
export default {
    content: ['./resources/**/*.svelte'],
    theme: {
        extend: {
            colors: {
                primary: '#FCD900',
                secondary: '#E8630A',
                tertiary: '#D04848',
                quaternary: '#004181',
                edit: '#2563EB',
                delete: '#E11D48',
            },
            fontFamily: {
                sans: ['Lato'],
            },
        },
    },
    darkMode: 'class',
    plugins: [require('rippleui')],
};
