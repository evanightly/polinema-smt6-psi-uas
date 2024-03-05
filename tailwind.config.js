/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.svelte"],
    theme: {
        extend: {
            colors: {
                primary: "#004181",
                secondary: "#D04848",
                tertiary: "#E8630A",
                quaternary: "#FCD900",
            },
            fontFamily: {
                sans: ["Lato"],
            },
        },
    },
    darkMode: "class",
    plugins: [require("rippleui")],
};
