<template>
    <div class="product-section">
        <div id="product-media-gallery">
            <div class="product-media-item">
                <img class="image" :src="media" :alt="product.code">
            </div>

            <slot name="product-gallery"></slot>
        </div>
        
        <slot name="product-properties"></slot>
    </div>
</template>

<script>
export default {
    name: 'ProductDetails',

    props: {
        product: {
            type: Object,
            required: true
        },
        media: String
    }
}
</script>

<style lang="scss" scoped>
@import "../../../../sass/modules/variables.scss";

#product-media-gallery {
    .product-media-item:first-child img {
        max-height: 300px;
        margin: auto;
    }

    .product-media-thumbs {
        display: flex;
        flex-direction: row;
        justify-content: center;
        margin: auto;
        padding: 10px;
        max-width: 450px;
        max-height: 100px;

        .product-media-item {
            flex-grow: 1;
            flex-basis: 0;
            padding: 5px;
            max-width: 75px;
            > img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border: 1px solid #0d0d0d54;
            }
        }
    }
}

.product-properties {
    margin: 30px 0 10px 0;
    width: 100%;

    tr {
        line-height: 20px;
        &.category {
            > td {
                font-weight: bold;
            }
        }
        &.specification {
            background-color: $color-accent-darkest-gray;
        }
    }

    td {
        padding: 4px 5px;
        color: $font-color-darker;
        &.property, &.value {
            border-bottom: 1px solid $color-accent-darker-gray;
        }
        &.property {
            padding-left: 5px;
            width: 170px;
            border-right: 2px solid $color-accent-darker-gray;
        }
        &.value {
            padding-left: 10px;
        }
    }
}
</style>