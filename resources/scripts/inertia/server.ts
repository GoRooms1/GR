// resources/scripts/inertia/server.ts
import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { withVite } from './with-vite'
import createServer from '@inertiajs/server'

createServer((page) => createInertiaApp({
    page,
    render: renderToString,
    resolve: (name) => withVite(import.meta.glob('../../views/pages/**/*.vue'), name),
    setup({ app, props, plugin }) {
        return createSSRApp({
            render: () => h(app, props),
        }).use(plugin)
    },
}))