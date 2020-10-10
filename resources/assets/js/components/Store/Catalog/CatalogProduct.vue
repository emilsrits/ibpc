<template>
    <div class="product-item">
        <div class="product-media">
            <a :href="route">
                <img 
                    class="image" 
                    :src="media" 
                    :alt="product.code" 
                />
            </a>
        </div>
        <p class="product-link has-text-centered">
            <a :href="route">{{ product.title }}</a>
        </p>

        <div
            class="stock-status in-stock is-uppercase has-text-right"
            v-if="product.stock > 5"
        >
            <div class="stock-text">In Stock</div>
        </div>

        <div
            class="stock-status low-stock is-uppercase has-text-right"
            v-else-if="product.stock > 0"
        >
            <div class="stock-text">{{ product.stock }} In Stock</div>
        </div>

        <div
            class="stock-status out-of-stock is-uppercase has-text-right"
            v-else
        >
            <div class="stock-text">Out Of Stock</div>
        </div>

        <div class="product-price">
            <div class="product-price-old" v-if="productPrices.old">
                {{ productPrices.old }}
            </div>
            <div class="product-price-current">{{ productPrices.current }}</div>
        </div>

        <div class="product-add-to-cart has-text-right" v-if="product.status">
            <button
                class="product-quick-add"
                type="button"
                :value="product.id"
                @click="addProductToCart"
            >
                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CatalogProduct',

    props: {
        product: {
            type: Object,
            default: null,
        },
        productPrices: Object,
        media: String,
        route: String,
    },

    methods: {
        addProductToCart(event) {
            const el = event.currentTarget;

            axios
                .post('/cart/add', {
                    productId: el.value,
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

.product-item {
    padding: 10px 10px 4px;
    height: 320px;
    background-color: $color-black-transparent;

    .product-media {
        margin: 5px auto;
        width: 80%;
        height: 120px;
        img {
            margin: auto;
            max-height: 120px;
            border: 2px solid $color-gray-darkest;
        }
    }

    .product-link {
        margin: 10px 0 0;
        height: 60px;
        font-size: 13px;
        font-weight: bold;
        word-wrap: break-word;
        overflow: hidden;
    }

    .stock-status {
        margin: 8px 5px;
        font-size: 11px;
        font-weight: bold;

        .stock-text {
            letter-spacing: 0.2px;
        }
    }

    .in-stock .stock-text {
        color: $color-green;
    }
    .low-stock .stock-text {
        color: $color-orange;
    }
    .out-of-stock .stock-text {
        color: $color-red;
    }

    .product-price {
        margin: 5px;
        height: 40px;

        .product-price-old {
            margin: 0;
            color: $color-gray-lighter;
            font-size: 13px;
            line-height: 20px;
            text-decoration: line-through;
        }

        .product-price-current {
            color: $color-gray-lightest;
            font-size: 15px;
            font-weight: bold;
            line-height: 25px;
        }
    }

    .product-add-to-cart {
        button {
            margin-right: 5px;
            padding: 0;
            width: 40px;
            height: 25px;
            color: $color-gray-darkest;
            border: none;
            border-radius: 10px;
            background-color: $color-white;
            box-shadow: inset $color-gray-darkest 0 1px 5px 0;
            outline: none;
            &:hover {
                box-shadow: inset $color-gray-darkest 0 1px 5px 1px;
            }
            &:focus {
                outline: 0;
            }
        }
    }
}
</style>