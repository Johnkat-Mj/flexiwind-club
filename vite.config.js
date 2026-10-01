import tailwindcss from "@tailwindcss/vite";
import laravel from "laravel-vite-plugin";
// import { bunny } from "laravel-vite-plugin/fonts";
import { defineConfig, lazyPlugins } from "vite-plus";

export default defineConfig({
    plugins: lazyPlugins(() => [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/flexilla.js",
                "resources/js/club.js",
                "resources/js/docs.js",
                "resources/js/block.js",
                "resources/js/sidebar-plugin.js",
                'resources/css/site-font.css',
            ],
            refresh: true,
            // fonts: [
            //     bunny("Instrument Sans", {
            //         weights: [400, 500, 600],
            //     }),
            // ],
        }),
        tailwindcss(),
    ]),
    server: {
        cors: true,
        fs: {
            // Le docs-kit et les sources gratuites vivent dans le dépôt public,
            // un dossier frère. À remplacer par vendor/ une fois publié.
            allow: ["..", "../flexiwind"],
        },
        watch: {
            ignored: [
                "**/.agents/**",
                "**/.claude/**",
                "**/.cursor/**",
                "**/.junie/**",
                "**/storage/framework/views/**",
                "**/vendor/**",
            ],
        },
    },
});
