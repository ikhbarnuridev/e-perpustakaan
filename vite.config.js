import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";
import fg from "fast-glob"; // import fast-glob

const pageCssFiles = fg.sync("resources/css/filament/app/**/*.css");

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/filament/app/theme.css",
                ...pageCssFiles,
            ],
            refresh: [...refreshPaths, "app/Livewire/**"],
        }),
    ],
});
