<template>
    <div class="product-section">
        <h2 class="product-title">{{ product.title }}</h2>
        <p class="product-code">{{ product.code }}</p>

        <p class="product-price-old" v-if="productPrices.old">
            <s>{{ productPrices.old }}</s>
        </p>

        <p class="product-price-current">
            {{ productPrices.current }}
        </p>

        <template v-if="product.stock > 0 && product.status">
            <div class="stock-status in-stock" v-if="product.stock > 5">
                <div class="stock-icon">
                    <i class="fa fa-circle" aria-hidden="true"></i>
                </div>
                <div class="stock-text">In Stock</div>
            </div>

            <div class="stock-status low-stock" v-else>
                <div class="stock-icon">
                    <i class="fa fa-circle" aria-hidden="true"></i>
                </div>
                <div class="stock-text">{{ product.stock }} In Stock</div>
            </div>
        </template>
        <template v-else>
            <div class="stock-status out-of-stock">
                <div class="stock-icon">
                    <i class="fa fa-circle" aria-hidden="true"></i>
                </div>
                <div class="stock-text">Out of Stock</div>
            </div>
        </template>

        <div class="form-container" v-if="product.status">
            <form
                id="product-add-form"
                role="form"
                method="POST"
                :action="route"
                @submit.prevent="addProductToCart"
            >
                <input 
                    type="hidden" 
                    name="_token" 
                    :value="csrf" 
                />

                <label for="qty">Qty:&nbsp;</label>
                <input
                    id="qty"
                    type="number"
                    name="qty"
                    min="1"
                    max="1000"
                    value="1"
                    title="qty"
                    pattern="[0-9]*"
                />

                <button
                    class="button button-action action-do"
                    type="submit"
                    name="submit"
                >
                    Add To Cart
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ProductForm',

    props: {
        product: {
            type: Object,
            required: true,
        },
        productPrices: Object,
        route: String,
    },

    data: function () {
        return {
            csrf: window.Laravel.csrfToken,
        };
    },

    methods: {
        addProductToCart(event) {
            const el = event.target;

            axios
                .post('/cart/add', {
                    productId: this.product.id,
                    qty: el.elements.qty.value,
                })
                .then((response) => {
                    this.$store.dispatch('updateCart', response.data.cart);
                })
                .catch((error) => {
                    console.error('error: ' + error);
                });
        },
    },
};
</script>

<style lang="scss" scoped>
@import '@styleModules/variables.scss';

.product-title {
    margin: 20px 0 10px;
    padding-bottom: 10px;
    font-size: 20px;
    font-weight: bold;
    border-bottom: 1px solid $color-gray-darkest;
}

.product-code {
    padding: 10px 0;
}

.product-price-old {
    color: $color-gray-lighter;
}

.product-price-current {
    font-size: 20px;
    font-weight: bold;
}

.stock-status {
    margin: 15px 0;

    .stock-icon {
        display: table-cell;
        padding-right: 7px;
        vertical-align: middle;
        > i {
            display: block;
            font-size: 10px;
        }
    }

    .stock-text {
        display: table-cell;
        text-transform: uppercase;
        font-size: 14px;
        font-weight: bold;
    }
}

.in-stock .stock-icon {
    > i {
        color: $color-green;
    }
}

.low-stock .stock-icon {
    > i {
        color: $color-orange;
    }
}

.out-of-stock .stock-icon {
    > i {
        color: $color-red;
    }
}

.form-container {
    margin: 20px 0;
    padding: 15px 0;
    border-top: 1px solid $color-gray-darkest;
}

#product-add-form {
    display: flex;
    justify-content: flex-start;
    align-items: center;

    label {
        display: none;
    }

    #qty {
        margin-right: 20px;
        width: 60px;
        height: 50px;
        font-size: 20px;
        text-align: center;
        background: $color-gray-darkest;
        border: 1px $color-black solid;
        border-radius: 3px;
        outline: none;
        transition: border-color ease-in-out 0.25s;
        &:focus {
            border: 1px solid $color-green-darker;
        }
    }
}
</style>