const mix = require('laravel-mix');
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
let jsPath = 'js';
mix.webpackConfig({
    resolve: {
        alias: {
            "common_components": path.resolve(__dirname, 'resources/js/components'),
            "admin_components": path.resolve(__dirname, 'resources/js/pages/admin/components'),
            "open_components": path.resolve(__dirname, 'resources/js/pages/open/components'),
            "pages_components": path.resolve(__dirname, 'resources/js/pages/components'),
            "pages": path.resolve(__dirname, 'resources/js/pages'),
            "bower_components_path": path.resolve(__dirname, 'public/bower_components'),
            "public": path.resolve(__dirname, 'public'),
            "sass":path.resolve(__dirname, 'resources/sass'),
        },
    },
    output: {
        publicPath: '/',
        chunkFilename: jsPath+'/components/[name].js?id=[chunkhash]',
    }
});
mix//.less('resources/less/skins.less', 'public/css')
    //.sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/bootstrap.js', 'public/'+jsPath)
    .js('resources/js/app.js', 'public/'+jsPath)
    .version();
if (!mix.inProduction()) {
    mix.sourceMaps();
}
