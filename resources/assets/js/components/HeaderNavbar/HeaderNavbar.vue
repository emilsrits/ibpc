<template>
    <nav class="navbar   is-spaced" role="navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" :href="routes.home">
                    <img :src="media.logo" alt="IBPC">
                </a>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="main-nav" @click="toggleNavbar">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="main-nav" class="navbar-menu">
                <div class="navbar-start">
                    <div class="navbar-item">
                        <header-navbar-search 
                            :route="routes.search"
                        />
                    </div>
                </div>

                <div class="navbar-end">
                    <div class="navbar-item">
                        <header-navbar-cart 
                            :cart="cart" 
                            :route="routes.cart"
                        />
                    </div>

                    <div class="navbar-item" v-if="!user">
                        <div>
                            <a class="item-link" :href="routes.login">
                                <i class="fa fa-sign-in" aria-hidden="true">&nbsp;</i>
                                Sign In
                            </a>
                        </div>
                    </div>
                    <div class="navbar-item has-dropdown is-hoverable" v-else>
                        <a class="navbar-link item-link" :href="routes.account">
                            <i class="fa fa-user" aria-hidden="true">&nbsp;</i>
                            Account
                        </a>

                        <div class="navbar-dropdown">
                            <div class="navbar-item">
                                <a @click="submitLogoutForm">
                                    <i class="fa fa-sign-out" aria-hidden="true">&nbsp;</i>
                                    Sign Out
                                </a>
                                <form id="logout-form" :action="routes.logout" method="POST" style="display: none;">
                                    <input type="hidden" name="_token" :value="csrf">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    import HeaderNavbarCart from './HeaderNavbarCart.vue';
    import HeaderNavbarSearch from './HeaderNavbarSearch';

    export default {
        components: {
            HeaderNavbarCart,
            HeaderNavbarSearch
        },

        props: {
            user: {
                type: Object,
                default() {
                    return null
                }
            },
            cart: Object,
            routes: Object,
            media: Object
        },
        
        data: function () {
            return {
                csrf: window.Laravel.csrfToken
            }
        },
        methods: {
            toggleNavbar: function (event) {
                let el = event.currentTarget
                let target = document.getElementById(el.dataset.target)
                el.classList.toggle('is-active')
                target.classList.toggle('is-active')
            },
            submitLogoutForm: function (event) {
                event.preventDefault()
                document.getElementById('logout-form').submit()
            }
        }
    }
</script>

<style lang="scss" scoped>
@import "../../../sass/modules/variables.scss";

@include until($desktop) {
    .navbar {
        padding: 0 5px;
    }
    .navbar-item.has-dropdown {
        padding: 0.5rem 0.75rem;
    }
}
</style>