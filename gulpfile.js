const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

// /*
//  |--------------------------------------------------------------------------
//  | Elixir Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Elixir provides a clean, fluent API for defining some basic Gulp tasks
//  | for your Laravel application. By default, we are compiling the Sass
//  | file for our application, as well as publishing vendor resources.
//  |
//  */
// var bowerPath = '/bower_components';
//
// // Get Bower Package Paths
// var paths = {
//     'jquery': bowerPath + '/jquery/dist/',
//     'bootstrap': bowerPath + '/bootstrap-sass/assets/',
//     'fontawesome': bowerPath + '/font-awesome/'
// }
//
// elixir (function (mix) {
//     // Add Styles to project
//     mix.copy(paths.bootstrap + 'stylesheets', 'resources/assets/bootstrap-sass')
//         .copy(paths.fontawesome + 'css/font-awesome.css', 'resources/css/font-awesome.css');
//
//     // Add Fonts to project
//     mix.copy(paths.fontawesome + 'fonts', 'public/fonts');
//
//     // Merge Styles
//     mix.styles([
//         'font-awesome.css'
//     ],'public/css/components.css', 'resources/css');
//
//     mix.sass('app.scss');
//     // Compile SASS
//
//     mix.webpack('app.js');
//
//     // mix.webpack([
//     //     "js/jquery.js",
//     //     "js/app.js"
//     // ]);
// });
elixir(function(mix) {
    mix.sass([
        'app.scss',
    ]);

    mix.styles([
        '../../../node_modules/zoomple/styles/zoomple.css'

    ]);

    mix.scripts([
      '../../../node_modules/jquery/dist/jquery.min.js',
      // '../../../node_modules/jquery/dist/jquery.js',
      // '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
      // '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
      // '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/*',
      '../../../node_modules/zoomple/zoomple.js',
      'Chart.min.js',
      'zoomple_prep.js',
      'answer_ajax.js',
      'emma_carousel.js',
      'exam_users_ajax.js',
      'list_filter.js',
      'app.js'
    ]);

    /*mix.copy(
      'node_modules/chart.js/dist/Chart.min.js', 'public/js/Chart.min.js'
    );*/


});