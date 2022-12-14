import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import createServer from '@inertiajs/server'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
// import { InertiaProgress } from '@inertiajs/progress'

// InertiaProgress.init()
createServer((page) => createInertiaApp({
    page,
    render: renderToString,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`,
        import.meta.glob('./Pages/**/*.vue')),
    setup: ({ app, props, plugin: inertia }) => {
        return createSSRApp({ render: () => h(app, props) })
            .use(inertia)
    }
}))
