import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/admin.css",
                "resources/js/admin.js",
            ],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
        },
    },
    // Allow access from the internet (via LocalTunnel/Ngrok/Cloudflare) and
    // make HMR connect back through your public tunnel domain.
    // Set VITE_TUNNEL_HOST env var to e.g. "myhassel.loca.lt" when tunneling.
    server: {
        // Bind locally for normal dev; use env-based HMR host when tunneling
        host: "127.0.0.1",
        port: 5173,
        // If 5173 is busy, Vite will pick the next free port (5174, 5175, ...)
        strictPort: false,
        hmr: process.env.VITE_TUNNEL_HOST
            ? {
                  host: process.env.VITE_TUNNEL_HOST,
                  protocol: "wss",
                  port: 443,
                  clientPort: 443,
              }
            : {
                  host: "127.0.0.1",
              },
    },
});
// Vite is the bridge that connects Laravel with Vue (or React) and makes your frontend development
// fast and smooth. 🚀
