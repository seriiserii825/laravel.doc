<?php
//npm install webpack-livereload-plugin@1 --save-dev

// run prod version change in packge.json
//"prod": "mix --production",

// for cache
//<script src="{{ mix('js/app.js', 'build') }}" defer></script>
//<link href="{{ mix('css/app.css', 'build') }}" rel="stylesheet">

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
let productionSourceMaps = false;

mix.setPublicPath('public/build')
    .setResourceRoot('build')
    .js('resources/js/app.js', 'js')
    .sass('resources/sass/app.scss', 'css')
    .version()
    .options({
        processCssUrls: false
    })
    .sourceMaps(productionSourceMaps, 'source-map')
    .browserSync({
        proxy: 'http://lv-eliseev.loc/',
        files: [
            'public/build/css/app.css',  // Generated .css file
            'public/build/js/app.js',    // Generated .js file
            // =====================================================================
            // You probably need only one of the below lines, depending
            // on which platform this project is being built upon.
            // =====================================================================
            'public/**/*.+(html|php)',          // Generic .html and/or .php files [no specific platform]
            'app/**/*.+(html|php)',          // Generic .html and/or .php files [no specific platform]
            'resources/views/**/*.php', // Laravel-specific view files
        ],
        notify: {
            styles: {
                top: 'auto',
                bottom: '0'
            }
        },
        open: false
    });
