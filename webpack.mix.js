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

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');

//纯 CSS
mix.styles([
    'resources/assets/css/common.css',
    'resources/assets/css/style.css'
], 'public/css/app.css');

//js
mix.js('resources/assets/js/app.js', 'public/js');


// 在开发中通常是不需要版本化，
// 你可能希望仅在运行
// npm run production 的时候进行版本化：
if (mix.config.inProduction) {
    //字体
    //mix.copy('resources/assets/fonts/', 'public/fonts/');
    //版本
    mix.version();
}
