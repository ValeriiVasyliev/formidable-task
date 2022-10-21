let mix = require('laravel-mix');

let ImageminPlugin = require( 'imagemin-webpack-plugin' ).default;
mix.webpackConfig( {
    plugins: [
        new ImageminPlugin( {
            // disable: process.env.NODE_ENV !== 'production', // Disable during development
            // pngquant: {
            //     quality: '95-100',
            // },
            test: /\.(jpe?g|png|gif|svg)$/i,
        } ),
    ],
} ) 

mix.js('assets/src/js/main.js', 'assets/dist')
   .sass('assets/src/scss/main.scss', 'assets/dist')
   .copy( 'assets/src/img', 'assets/dist/img', false )
   .copy( 'assets/src/font', 'assets/dist/font', false )
   .options({ processCssUrls: false });