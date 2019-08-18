<template>
    <form class="search-form" role="form" method="GET" :action="route">
        <div class="search-container">
            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            <input id="search" type="search" name="q">
        </div>
    </form>
</template>

<script>
export default {
    name: 'HeaderNavbarSearch',

    props: {
        route: {
            type: String,
            required: true
        }
    }
}
</script>

<style lang="scss" scoped>
@import "../../../../sass/modules/variables.scss";

.search-form {
    .search-container {
        position: relative;
    }

    button {
        position: absolute;
        top: 0;
        left: 0;
        padding: 0px 8px;
        height: 26px;
        color: $font-color-darker;
        background: 0 0;
        border: none;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        outline: 0;
        cursor: pointer;
        transition: .3s ease-in-out;
        &:hover {
            color: $color-accent-darker-green;
            background-color: $color-black;
        }
    }

    input[type="search"] {
        padding: 0px 8px 0px 36px;
        width: 180px;
        height: 26px;
        color: $font-color-base;
        font-size: $size-7;
        background: $color-accent-darkest-gray;
        border: none;
        border-radius: 8px;
        outline: 0;
        vertical-align: middle;
        transition: .3s ease-out;
        &:focus {
            box-shadow: 0 0 2px $color-accent-darker-green;
        }
    }
}
</style>