import { defineConfig } from "vite";
import preact from "@preact/preset-vite";
import tailwindcss from "@tailwindcss/vite";

// https://vite.dev/config/
export default defineConfig({
  plugins: [preact(), tailwindcss()],
  build: {
    outDir: "../",
    rollupOptions: {
      input: "./src/main.jsx",
      output: {
        entryFileNames: "campaign-form.js",
        assetFileNames: (assetInfo) => {
          return "campaign-form.css";
        },
      },
    },
  },
  server: {
    cors: true,
    strictPort: true,
    port: 5173,
    watch: {
      usePolling: true,
    },
  },
});
