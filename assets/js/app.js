import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'


createInertiaApp({
    progress: {
        includeCSS: false,
    },
    resolve: name => import(`./pages/${name}`),
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
