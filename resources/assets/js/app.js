require('./bootstrap.js');

import './utils/scripts.js';
import './utils/index.js';

window.Vue = require('vue');

Vue.config.productionTip = false;
//Vue.config.devtools = false;
//Vue.config.debug = false;
//Vue.config.silent = true;

import store from './vuex/store.js'

import EntityManage from './components/Admin/Entity/EntityManage.vue';
import EntityProductCategories from './components/Admin/Entity/EntityProductCategories.vue';
import EntityProductMedia from './components/Admin/Entity/EntityProductMedia.vue';
import TableForm from './components/Admin/Table/TableForm.vue';
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
        EntityManage,
        EntityProductCategories,
        EntityProductMedia,
        TableForm,
        HeaderNavbar,
        HeaderNavbarCart,
        CatalogProduct,
        ProductDetails,
        ProductForm,
        CartForm
    }
});