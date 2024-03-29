const path = require("path");
const mix = require("laravel-mix");
const webpackNodeExternals = require("webpack-node-externals");

// Build files
mix.options({ manifest: false })
    .js("resources/js/ssr.ts", "public/build")
    .vue({ version: 3, options: { optimizeSSR: true } })
    .alias({ "@": path.resolve("resources/js") })
    .webpackConfig({
        target: "node",
        externals: [webpackNodeExternals()],
    })
    .version();