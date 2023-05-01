// resources/scripts/inertia/server.ts
// @ts-ignore
import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/vue3'
import { withVite } from './with-vite'
import createServer from '@inertiajs/vue3/server'

createServer((page) => createInertiaApp({
    page,
    render: renderToString,
    resolve: (name) => withVite(import.meta.glob('../../views/pages/**/*.vue'), name),
    setup({ App, props, plugin }) {
        return createSSRApp({
            render: () => h(App, props),
        }).use(plugin)
    },
}))