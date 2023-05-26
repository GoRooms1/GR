import "swiper/swiper-bundle.min.css";
import "@vuepic/vue-datepicker/dist/main.css";
import "../css/custom.css";
import "../css/style.css";

import { createSSRApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import Layout from "@/Layouts/Layout.vue";
import mitt from "mitt";

const app = createInertiaApp({
  progress: {
    color: "#29d",
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
    const VueApp = createSSRApp({ render: () => h(App, props) });
    VueApp.config.globalProperties.$eventBus = mitt();
    VueApp.use(plugin).mixin({ methods: {} }).mount(el);
  },
});
