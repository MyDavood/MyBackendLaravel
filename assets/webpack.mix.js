const mix = require('laravel-mix')
const webpackConfig = require('./webpack.config')

require('laravel-mix-clean');

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
mix.browserSync({
  proxy: '127.0.0.1:8000',
  startPath: `/backend`,
  ui: false,
  open: false,
  files: [
    'resources/views/**/*.php',
    'public/**/*.(js|css)',
  ],
});

mix
  .js('resources/js/app.js', 'public/js')
  .sass("resources/scss/vendor.scss", 'public/css', null, [
    require('rtlcss')(),
  ])
  .sass("resources/scss/backend.scss", 'public/css')
  .sass('resources/scss/fontawesome.scss', 'public/css')
  .vue({ runtimeOnly: mix.inProduction() })
  .webpackConfig(webpackConfig)
  .clean({
    cleanOnceBeforeBuildPatterns: [
      './js/*',
      './css/*',
    ],
  })
  //.options({ autoprefixer: false })
  .extract()
  .version()

if (mix.inProduction()) {
  mix.sourceMaps();
}
