// @ts-ignore
import { createSSRApp, h } from "vue";
import { renderToString } from "@vue/server-renderer";
import { createInertiaApp } from "@inertiajs/vue3";
import createServer from "@inertiajs/vue3/server";
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Layout from "@/Layouts/Layout.vue";

createServer((page) =>
  createInertiaApp({
    page,
    render: renderToString,
    resolve: (name) => {
      const pages = resolvePageComponent(
        `./Pages/${name}.vue`,
        import.meta.glob("./Pages/*/*.vue")
      );
      pages.then((module) => {
        module.default.layout = Layout;
      });
  
      return pages;
    },    
    setup({ App, props, plugin }) {
      return createSSRApp({
        render: () => h(App, props),
      }).use(plugin);
    },
  })
);
