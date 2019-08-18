import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
    cart: {
        itemCount: null,
        price: null
    }
};

const mutations = {
    UPDATE_CART(state, payload) {
        state.cart = payload;
    }
};

const actions = {
    updateCart(context, cart) {
        context.commit('UPDATE_CART', cart);
    }
};

const getters = {
    getCart() {
        return state.cart;
    }
};

export default new Vuex.Store({
    state,
    mutations,
    actions,
    getters
});