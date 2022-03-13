const mix = require('laravel-mix');
require('laravel-mix-tailwind');
if(typeof path=="undefined"){
    var path = require('path');
}
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
let basePath = 'public/';
let jsPath = 'js';
let cssPath = 'css';
mix.setPublicPath(basePath);
mix.webpackConfig({
    resolve: {
        alias: {
            "common_components": path.resolve(__dirname, 'resources/js/components'),
            "admin_components": path.resolve(__dirname, 'resources/js/pages/admin/components'),
            "open_components": path.resolve(__dirname, 'resources/js/pages/open/components'),
            "pages_components": path.resolve(__dirname, 'resources/js/pages/components'),
            "pages": path.resolve(__dirname, 'resources/js/pages'),
            "bower_components_path": path.resolve(__dirname, 'public/bower_components'),
            "public_path": path.resolve(__dirname, 'public'),
            "sass":path.resolve(__dirname, 'resources/sass'),
            "@":path.resolve(__dirname, 'node_modules'),
        },
    },
    output: {
        publicPath: '/',
        chunkFilename: jsPath+'/components/[name].js?id=[chunkhash]',
    }
});
if(process.argv.includes('--css')){
    global.Mix.manifest.name = 'mix-manifest-css.json';
    mix.less('resources/less/adminlte.less', cssPath)
        .sass('resources/sass/app.scss', cssPath);
}else if(process.argv.includes('--tailwindcss')){
    global.Mix.manifest.name = 'mix-manifest-tailwindcss.json';
    mix.sass('resources/sass/tailwindcss.scss', cssPath)
        .tailwind();
}else {
    global.Mix.manifest.name = 'mix-manifest.json';
    mix.js('resources/js/bootstrap.js', jsPath)
        .js('resources/js/app.js', jsPath);
    if(typeof mix.vue=="function"){
        mix.vue();
    }
        //mix.tailwind()
    ;
}
mix.version();
if (!mix.inProduction()) {
    mix.sourceMaps();
}
