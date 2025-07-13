import preset from "../../../../vendor/filament/filament/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                blue: {
                    50: "#e6f5ff",
                    100: "#cceafc",
                    200: "#99d5f8",
                    300: "#66bff0",
                    400: "#33aae6",
                    500: "#0790d9",
                    600: "#0678b5",
                    700: "#056091",
                    800: "#04486d",
                    900: "#033049",
                    950: "#022437",
                },
            },
        },
    },
};
