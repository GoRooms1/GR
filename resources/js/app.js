import "js-datepicker/dist/datepicker.min.css";
import "swiper/swiper-bundle.min.css";
import "../css/custom.css";
import "../css/style.css";

import { createApp, h } from "vue";
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import FilterPagesService from "@/Services/FilterPagesService";
import Layout from "@/Layouts/Layout.vue";
import mitt from 'mitt';

window.eventBus = mitt()

createInertiaApp({
  progress: {
    color: '#29d',
  },
  resolve: (name) => {
    const page = resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue")
    );
    page.then((module) => {
      module.default.layout = module.default.layout || Layout;
    });

    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mixin({ methods: { route: window.route } })
      .mount(el);
  },
});

FilterPagesService();
