require('./bootstrap.js');

import './utils/scripts.js';
import './utils/index.js';

window.Vue = require('vue');

Vue.config.productionTip = false;
//Vue.config.devtools = false;
//Vue.config.debug = false;
//Vue.config.silent = true;

import store from './vuex/store.js'

import HeaderNavbar from './components/Store/Header/HeaderNavbar.vue';
import CatalogProduct from './components/Store/Catalog/CatalogProduct.vue';
import ProductDetails from './components/Store/Product/ProductDetails.vue';
import ProductForm from './components/Store/Product/ProductForm.vue';
import CheckoutCart from './components/Store/Checkout/CheckoutCart.vue';

const app = new Vue({
    el: '#app',
    store,
    components: {
        HeaderNavbar,
        CatalogProduct,
        ProductDetails,
        ProductForm,
        CheckoutCart
    }
});