import Vue from 'vue'
import App from './App.vue'
import VueSweetalert2 from 'vue-sweetalert2'
import store from './store.js' 
import router from './router.js' 

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

Vue.config.productionTip = false

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'


Vue.use(VueSweetalert2)

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)


export const bus = new Vue();

new Vue({
  store,
  router, 
  render: h => h(App),
}).$mount('#app')
