const mix = require('laravel-mix');
const path = require('path');

const srcPath = 'resources/assets';

mix.disableNotifications();

mix.webpackConfig({
    resolve: {
        alias: {
            '@components': path.resolve(__dirname, srcPath + '/js/components'),
            '@styleModules': path.resolve(__dirname, srcPath + '/sass/modules')
        }
    }
});

mix.js('resources/assets/js/app.js', 'js/app.js').
    sass('resources/assets/sass/app.scss', 'css/app.css');
