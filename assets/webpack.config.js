const path = require('path')
const defineOptions = require('unplugin-vue-define-options/webpack')

// https://stefanbauer.me/tips-and-tricks/autocompletion-for-webpack-path-aliases-in-phpstorm-when-using-laravel-mix
module.exports = {
  output: {
    chunkFilename: 'js/[name].js?id=[chunkhash]',
  },
  resolve: {
    alias: {
      '@': path.resolve('./resources/js'),
    },
    extensions: ['.js', '.vue', '.json'],
  },
  devServer: {
    allowedHosts: 'all',
  },
  plugins: [
    defineOptions({
      include: [/\.vue$/, /\.vue\?vue/],
    }),
  ],
}
