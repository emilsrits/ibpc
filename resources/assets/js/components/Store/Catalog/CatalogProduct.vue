<template>
    <div class="product-item">
        <div class="product-media">
            <a :href="route">
                <img class="image" :src="media" :alt="product.code">
            </a>
        </div>
        <p class="product-link has-text-centered">
            <a :href="route">{{ product.title }}</a>
        </p>

        <div v-if="product.stock > 5" class="stock-status in-stock is-uppercase has-text-right">
            <div class="stock-text">In Stock</div>
        </div>

        <div v-else class="stock-status low-stock is-uppercase has-text-right">
            <div class="stock-text">{{ product.stock }} In Stock</div>
        </div>

        <div class="product-price">
            <div v-if="productPrices.old" class="product-price-old">{{ productPrices.old }}</div>
            <div class="product-price-current">{{ productPrices.current }}</div>
        </div>

        <div class="product-add-to-cart has-text-right">
            <button class="product-quick-add" type="button" :value="product.id" @click="addProductToCart">
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
            default() {
                return null;
            }
        },
        productPrices: Object,
        media: String,
        route: String
    },

    methods: {
        addProductToCart(event) {
            let el = event.currentTarget

            axios.post('/cart/add', {
                productId: el.value
            })
            .then(response => {
                this.$store.dispatch('updateCart', response.data);
            })
            .catch(error => {
                console.log('error: ' + error);
            });
        }
    }
}
</script>

<style lang="scss" scoped>
@import "../../../../sass/modules/variables.scss";

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