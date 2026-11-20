import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig(({ command }) => ({
  plugins: [vue()],
  // The production build is served by Yii from backend/web/dist.
  base: command === 'build' ? '/dist/' : '/',
  build: {
    outDir: '../backend/web/dist',
    emptyOutDir: true,
  },
  server: {
    proxy: {
      // Local backend: YII_DEBUG=1 php -S localhost:8080 -t backend/web
      '/api': 'http://localhost:8080',
    },
  },
}))
