

  /**
   *
   * Import from vendors
   *
   */

  // Vue
  import Vue from 'vue'

  // Service Worker
  import './registerServiceWorker'

  // Jquery
  import 'jquery';

  // Bootstrap
  import 'bootstrap/dist/css/bootstrap.css';
  import 'bootstrap/dist/js/bootstrap.js';

  // Font awesome
  import 'font-awesome/css/font-awesome.css';


  /**
   *
   * Import from files
   *
   */

  // Script
  import app from '@/app.vue'
  import router from '@/router'
  import api from '@/vendors/axios/loader.js';
  import store from '@/store';

  // CSS
  import '@/assets/css/style.css';


  /**
   *
   * System global
   *
   */
  window.$api = api;


  /**
   *
   * Vue global & config & plugin
   *
   */
  Vue.config.productionTip = false;
  Vue.prototype.$api = api;


  /**
   *
   * Vue instance
   *
   */
  new Vue ({
    router,
    store,
    render: h => h (app),
    created: function () {
    }
  }).$mount('#app')
