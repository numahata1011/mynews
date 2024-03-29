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
 |※webpack.mix.js を編集sたらターミナルでnpm run watchを実行
*/

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css')//追加項目
    .sass('resources/sass/profile.scss', 'public/css')//課題追加項目
    .sass('resources/sass/front.scss', 'public/css'); // 追記(19)