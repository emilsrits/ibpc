import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
    message: {
        type: null,
        content: null,
    },

    cart: {
        itemCount: null,
        price: null
    }
};

const mutations = {
    FLASH_MESSAGE(state, payload) {
        state.message = payload;
    },

    UPDATE_CART(state, payload) {
        state.cart = payload;
    }
};

const actions = {
    flashMessage(context, message) {
        context.commit('FLASH_MESSAGE', message)
    },

    updateCart(context, cart) {
        context.commit('UPDATE_CART', cart);
    }
};

const getters = {
    getMessage() {
        return state.message;
    },

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