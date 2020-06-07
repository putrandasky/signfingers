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

// mix.js('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');


mix.webpackConfig({
  devServer: {
    proxy: {
      '*': 'http://localhost:8000'
    }
  },
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      '@': path.resolve(__dirname, 'resources/js/')
    },
  },
});
mix
  .js('resources/js/signerapp/app.js', 'public/js/signerapp.js')
  .js('resources/js/website/app.js', 'public/js/website.js')
  .sass('resources/js/signerapp/custom.scss', 'public/css/style.css')
  .sass('resources/sass/website.scss', 'public/css/website/style.css');



if (mix.inProduction()) {
  mix.version();
  mix.options({
    terser: {
      terserOptions: {
        compress: {
          drop_console: true
        }
      }
    }
  });
}
