import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import DefineOptions from 'unplugin-vue-define-options/vite'

export default defineConfig({
  resolve: {
    alias: [
      {
        find: /^~.+/,
        replacement: (val) => {
          return val.replace(/^~/, "");
        },
      },
    ],
  },
  plugins: [
    laravel([
      'resources/js/app.js',
      'resources/scss/vendor.scss',
      'resources/scss/backend.scss',
      'resources/scss/fontawesome.scss',
    ]),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    DefineOptions(),
  ],
});
