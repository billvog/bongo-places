/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                acme: ["Acme", "sans-serif"],
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
