import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";

import "leaflet/dist/leaflet.css";

createInertiaApp({
    resolve: (name) => require(`./Pages/${name}`).default,
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});
