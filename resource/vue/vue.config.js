const path = require ('path')
const webpack = require ('webpack')
const _ = require ('lodash');
const GoogleFontsPlugin = require ("google-fonts-webpack-plugin");

const basicConfig = {
  publicPath: process.env.BASE_URL,
  configureWebpack: {
    plugins: [
      new webpack.ProvidePlugin ({
        $: 'jquery',
        jquery: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery'
      })
    ]
  },
  chainWebpack: config => {
    plugins: [
      new GoogleFontsPlugin({
        fonts: [
          { family: "Playfair" }
        ]
      })
    ]
   }
};

const developmentConfig = {
  devServer: {
    //clientLogLevel: 'info',
    port: 8011,
    watchOptions: {
      poll: true
    },
    proxy: process.env.VUE_APP_API_HOSTNAME
  }
};

const productionConfig = {
};

module.exports = _.assign (basicConfig
  , process.env.NODE_ENV == 'development' ? developmentConfig : {}
  , process.env.NODE_ENV == 'production' ? productionConfig : {});
