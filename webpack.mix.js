const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.setPublicPath('public_html/');

mix.copy('resources/js/shop/productController.js', 'public_html/js').sourceMaps();


mix.copy('resources/js/Inc/jquery.mask.min.js', 'public_html/js').sourceMaps();
mix.copy('resources/js/Inc/jquery-3.6.0.min.js', 'public_html/js').sourceMaps();
mix.js('resources/js/Inc/mdb.min.js', 'public_html/js').sourceMaps();


mix.copy('resources/js/BaseClass.js', 'public_html/js').sourceMaps();

mix.js('resources/js/app.js', 'public_html/js')
    .sass('resources/sass/app.scss', 'public_html/css')
    .sourceMaps();


mix.copy('resources/js/MApi.js', 'public_html/js');

