require('./bootstrap.js');
import './utils/scripts.js';
import './utils/index.js';

window.Vue = require('vue');

Vue.config.productionTip = false;
//Vue.config.devtools = false;
//Vue.config.debug = false;
//Vue.config.silent = true;

Vue.component('header-navbar', require('./components/HeaderNavbar/HeaderNavbar.vue').default);

const app = new Vue({
    el: '#app',
});