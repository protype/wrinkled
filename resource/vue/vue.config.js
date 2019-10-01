const path = require ('path')
const webpack = require ('webpack')
const _ = require ('lodash');

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
