import { defineConfig } from 'vite'
import preact from '@preact/preset-vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [preact()],
  build: {
    outDir: '../',
    rollupOptions: {
      input: './src/main.jsx',
      output: {
        entryFileNames: 'magura-map.js',
      }
    }
  },
  server: {
    cors: true,
    strictPort: true,
    port: 5173,
    watch: {
      usePolling: true, 
    },
  },
})
