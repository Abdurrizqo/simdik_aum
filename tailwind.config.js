/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    daisyui: {
        themes: [
            {
                mytheme: {
                    primary: "#1B4242",

                    secondary: "#5C8374",

                    accent: "#00ffff",

                    neutral: "#ffffff",

                    "base-100": "#ffffff",

                    info: "#0000ff",

                    success: "#43766C",

                    warning: "#00ff00",

                    error: "#ff0000",
                },
            },
        ],
    },
    plugins: [require("daisyui")],
};
