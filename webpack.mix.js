let mix = require('laravel-mix');
let fs = require('fs');

mix.webpackConfig({
    resolve: {
        alias: {
            //'./dependencyLibs/inputmask.dependencyLib' : path.join(__dirname, 'node_modules/inputmask/dist/inputmask/dependencyLibs/inputmask.dependencyLib.jquery'),
            'jquery.inputmask.bundle' : path.join(__dirname, 'node_modules/inputmask/dist/jquery.inputmask.bundle'),
            'jquery-validation-pt-br' : path.join(__dirname, 'node_modules/jquery-validation/dist/localization/messages_pt_BR'),
        }
    }
});

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

mix.copyDirectory('resources/otimaideia/img', 'public/img');
mix.less('resources/otimaideia/css/style.less', 'public/css', { relativeUrls: true, rootpath: '/'});
mix.less('resources/otimaideia/css/email.less', 'public/css', { relativeUrls: true, rootpath: '/'});

mix.copy('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 'public/css');
mix.copyDirectory('node_modules/bootstrap-datepicker/dist/js', 'public/js');
mix.copyDirectory('node_modules/bootstrap-datepicker/dist/locales', 'public/locales');

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/admin.js', 'public/js')
    .js('resources/otimaideia/js/main.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .less('resources/assets/less/admin.less', 'public/css');

mix.sass('resources/otimaideia/css/_custom_bootstrap.scss', 'public/css/bootstrap.custom.css');
//     .combine(
//         [
//             'public/css/bootstrap.custom.css',
//             'public/css/style.css',
//         ], 'public/css/style.css')
//     .then(function () {
//         fs.unlinkSync(process.cwd() + '/public/css/bootstrap.custom.css');
//     });

if (mix.inProduction()) {
    mix.version();
}