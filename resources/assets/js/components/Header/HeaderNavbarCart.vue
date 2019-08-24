<template>
    <a class="item-link" :href="route">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <span id="navbar-cart-items" v-if="cartData">
            ({{ cartData.itemCount }})
            {{ cartData.price }}
        </span>
        <span id="navbar-cart-items" v-else>
            (0)
        </span>
    </a>
</template>

<script>
export default {
    name: 'HeaderNavbarCart',

    props: {
        cart: Object,
        route: {
            type: String,
            required: true
        }
    },

    data ()  {
        return {
            cartData: this.$props.cart
        }
    },

    mounted () {
        this.$store.subscribe((mutation, state) => {
            if (mutation.type === 'UPDATE_CART') {
                this.cartData = state.cart;
            }
        });
    }
}
</script>