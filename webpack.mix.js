const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/search.js', 'public/js');

mix.sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
