<template>
    <a class="item-link" :href="route">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <span v-if="cart" id="navbar-cart-items">
            ({{ Object.keys(cart.items).length }})
            {{ cart.price }}
        </span>
        <span v-else id="navbar-cart-items">
            (0)
        </span>
    </a>
</template>

<script>
    export default {
        props: {
            cart: Object,
            route: {
                type: String,
                required: true
            }
        }
    }
</script>