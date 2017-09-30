let mix = require('laravel-mix');

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

mix.autoload({
    jquery: ['$', 'window.jQuery',"jQuery","window.$","jquery","window.jquery"],
    tether: ['Tether', 'window.Tether'],
});

mix.js([
    'resources/assets/js/app.js',
    'resources/assets/js/tooltips.js',
], 'public/js').version();
mix.js('resources/assets/js/edit-qa.js', 'public/js').version();
mix.js('resources/assets/js/clipboard.js', 'public/js').version();
mix.sass('resources/assets/sass/app.scss', 'public/css').version();
mix.js([
    './node_modules/jquery/dist/jquery.js',
    './node_modules/tether/dist/js/tether.js',
    // './node_modules/jquery/dist/jquery.min.js',
    './node_modules/bootstrap/dist/js/bootstrap.js',
    // './node_modules/bootstrap/dist/js/bootstrap.min.js',
],'public/js/basic.js').version()

mix.browserSync({
    proxy: 'localhost'
});
