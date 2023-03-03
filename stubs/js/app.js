import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers"

createInertiaApp({
  progress: {
    includeCSS: false,
  },
  resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    const app = createApp({
      render: () => h(App, props),
      mounted() {
        let loader = document.getElementById('loader-container')
        loader.classList.add("loaded");
      },
    })
    app.use(plugin)
      .mount(el)
  },
})
