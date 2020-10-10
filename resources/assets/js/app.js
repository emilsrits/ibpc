require('./bootstrap.js');

import './utils';

window.Vue = require('vue');

Vue.config.productionTip = false;

import store from './store'

import EntityCategoryParent from './components/Admin/Entity/EntityCategoryParent';
import EntityManage from './components/Admin/Entity/EntityManage';
import EntityProductCategories from './components/Admin/Entity/EntityProductCategories';
import EntityProductMedia from './components/Admin/Entity/EntityProductMedia';
import TableForm from './components/Admin/Table/TableForm';
import HeaderNavbar from './components/Header/HeaderNavbar';
import HeaderNavbarCart from './components/Header//HeaderNavbarCart';
import CatalogProduct from './components/Store/Catalog/CatalogProduct';
import ProductDetails from './components/Store/Product/ProductDetails';
import ProductForm from './components/Store/Product/ProductForm';
import CartForm from './components/Store/Cart/CartForm';
import WidgetMessages from './components/Widget/WidgetMessages';
import WidgetMessagesItem from './components/Widget/WidgetMessagesItem';
import WidgetPaginationSize from './components/Widget/WidgetPaginationSize';

const app = new Vue({
    el: '#app',
    store,
    components: {
        EntityCategoryParent,
        EntityManage,
        EntityProductCategories,
        EntityProductMedia,
        TableForm,
        HeaderNavbar,
        HeaderNavbarCart,
        CatalogProduct,
        ProductDetails,
        ProductForm,
        CartForm,
        WidgetMessages,
        WidgetMessagesItem,
        WidgetPaginationSize
    }
});