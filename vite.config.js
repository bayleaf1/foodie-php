import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  build: {
    rollupOptions: {
      output: {
        dir: 'public/build/assets/',
        entryFileNames: 'app.js',
        assetFileNames: 'app.css',
        chunkFileNames: 'chunk.js',
        manualChunks: undefined,
      },
    },
  },
  resolve: {
    alias: {
      vue: 'vue/dist/vue.esm-bundler.js',
    },
  },
})
