<template>
    <div id="cart-form">
        <form role="form" method="POST" :action="routes.action">
            <input type="hidden" name="_method" :value="method" v-if="method">
            <input type="hidden" name="_token" :value="csrf">

            <fieldset>
                <table id="shopping-cart-table" class="table is-fullwidth is-hoverable">
                    <thead class="table-head">
                        <tr>
                            <th></th>
                            <th class="is-hidden-mobile"></th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th class="is-hidden-mobile">Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        <tr v-if="!cartData.price">
                            <td class="is-size-5 has-text-centered" colspan="6" style="padding: 20px 0;">
                                Cart is empty
                            </td>
                        </tr>
                        <slot name="cart-items" :removeProductFromCart="removeProductFromCart"></slot>
                    </tbody>
                </table>
            </fieldset>

            <div class="cart-actions" v-if="cartData.price">
                <div class="cart-update has-text-right">
                    <button class="button button-action action-do" type="submit" name="submit">Update Cart</button>
                </div>

                <div class="cart-checkout has-text-right">
                    <div class="cart-total">
                        <span>Total excl. VAT: {{ cartData.price }}</span>
                    </div>
                    <button class="button button-action action-add" type="button" title="Checkout" @click.prevent="goToCheckout">
                        <i class="fa fa-arrow-right" aria-hidden="true">&nbsp;</i>
                        Checkout
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'CartForm',

    props: {
        method: {
            type: String,
            default() {
                return 'PATCH';
            }
        },
        cartTotalPrice: String,
        routes: Object
    },

    data: function () {
        return {
            csrf: window.Laravel.csrfToken,
            cartData: {
                price: this.$props.cartTotalPrice
            }
        }
    },

    mounted () {
        this.$store.subscribe((mutation, state) => {
            if (mutation.type === 'UPDATE_CART') {
                this.cartData.price = state.cart.price;
            }
        });
    },

    methods: {
        removeProductFromCart(event) {
            let el = event.currentTarget

            axios.post('/cart/remove', {
                productId: el.value
            })
            .then(response => {
                this.$store.dispatch('updateCart', response.data);

                el.closest('tr').remove();
            })
            .catch(error => {
                console.log('error: ' + error);
            });
        },

        goToCheckout(event) {
            window.location = this.routes.checkout;
        }
    }
}
</script>

<style lang="scss" scoped>
@import "../../../../sass/modules/variables.scss";

#cart-form {
    .cart-actions {
        margin-top: 25px;
    }

    .cart-update {
        padding: 10px;
    }

    .cart-total {
        margin: 10px 10px 20px;
        font-size: 16px;
        font-weight: bold;
    }

    .cart-checkout {
        margin-left: auto;
        padding: 10px;
    }
}

#shopping-cart-table {
    tbody {
        td {
            vertical-align: middle;
        }
    }

    .cart-item-remove {
        padding: 10px;
        color: $color-white;
        &:hover {
            color: $color-green-darker;
        }
    }

    .cart-item-media img {
        margin: auto;
        width: auto;
        max-height: 50px;
    }

    .cart-item-price {
        min-width: 100px;
    }

    #qty {
        width: 50px;
        height: 40px;
        font-size: 16px;
        text-align: center;
        background-color: $color-gray-darker;
        border: 1px $color-black solid;
        border-radius: 3px;
        outline: none;
        transition: border-color ease-in-out .25s;
        &:focus {
            border: 1px solid $color-green-darker;
        }
    }
}

/* RESPONSIVE STYLES */
@include until($desktop) {
    #cart-form {
        #shopping-cart-table {
            .table-body td {
                padding: 15px 10px;
                font-size: 13px;
            }
            #qty {
                width: 40px;
                font-size: 14px;
            }
        }

        .cart-checkout {
            margin: 15px auto;
        }
    }
}
</style>