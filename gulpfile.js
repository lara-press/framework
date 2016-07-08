var elixir = require('laravel-elixir');
var larapressAssets = 'public/content/themes/larapress/assets';

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(
    function (mix)
    {
        mix.sass('app.scss', 'public/content/themes/larapress/assets/css');
        mix.copy('node_modules/font-awesome/fonts', larapressAssets + '/fonts');
    }
);
