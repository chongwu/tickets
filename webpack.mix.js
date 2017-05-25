const { mix } = require('laravel-mix');

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
const jsPath = 'resources/assets/js/';
const sassPath = 'resources/assets/sass/';

mix.js(jsPath + 'app.js', 'public/js')
    .sass(sassPath + 'app.scss', 'public/css');