require('./bootstrap.js');

import './utils/scripts.js';
import './utils/index.js';

window.Vue = require('vue');

Vue.config.productionTip = false;
//Vue.config.devtools = false;
//Vue.config.debug = false;
//Vue.config.silent = true;

import store from './vuex/store.js'

import HeaderNavbar from './components/Header/HeaderNavbar.vue';
import HeaderNavbarCart from './components/Header//HeaderNavbarCart.vue';
import CatalogProduct from './components/Store/Catalog/CatalogProduct.vue';
import ProductDetails from './components/Store/Product/ProductDetails.vue';
import ProductForm from './components/Store/Product/ProductForm.vue';
import CartForm from './components/Store/Cart/CartForm.vue';

const app = new Vue({
    el: '#app',
    store,
    components: {
        HeaderNavbar,
        HeaderNavbarCart,
        CatalogProduct,
        ProductDetails,
        ProductForm,
        CartForm
    }
});