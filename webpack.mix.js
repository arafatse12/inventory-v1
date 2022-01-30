const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js').vue()
    .sass('resources/css/app.scss', 'public/css');


mix.js('resources/assets/scripts/index.js', 'public/js/adminator.js')
    .sass('resources/assets/styles/index.scss', 'public/css/adminator.css')
    .copyDirectory('resources/assets/static/images', 'public/assets/images')
    .copyDirectory('resources/assets/static/fonts', 'public/assets/fonts')
    .sourceMaps();


mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            'vue$': 'vue/dist/vue.esm.js',
            '@': __dirname + '/resources/js',
            '@comp': __dirname + '/resources/js/components',
        },
    },
});
