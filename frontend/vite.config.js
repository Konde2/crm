// frontend/vite.config.js
import { fileURLToPath, URL } from 'node:url' // Убедитесь, что эта строка есть
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      // Это связывает символ @ с вашей папкой src
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  server: {
    host: '0.0.0.0',     // ← КЛЮЧЕВОЙ ПАРАМЕТР
    port: 5173,
    strictPort: true,
    // Для Windows + Docker (если понадобится позже):
    watch: {
      usePolling: true
    }
  }
})