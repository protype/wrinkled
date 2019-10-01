

/**
 *
 * Router
 *
 */

// Import
import Vue from 'vue'
import Router from 'vue-router'

// Use router
Vue.use (Router)

// Export
export default new Router ({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [

    // Index
    {
      path: '/',
      name: 'index',
      component: () => import ('@/views/index.vue'),
    }
  ]
})
