import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  build: {
    outDir: '../',
    emptyOutDir: false,
    rollupOptions: {
   
      output: {
        entryFileNames: 'campaign-form.js',
        chunkFileNames: '[name].js',
        assetFileNames: 'campaign-form.[ext]',
      },
    },
  }
})
