<template>
    <nav class="navbar is-fixed-top is-spaced" role="navigation">
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
                    <slot name="navbar-start"></slot>
                </div>

                <div class="navbar-end">
                    <slot name="navbar-end"></slot>

                    <div v-if="!user" class="navbar-item">
                        <div>
                            <a class="item-link" :href="routes.login">
                                <i class="fa fa-sign-in">&nbsp;</i>
                                Sign In
                            </a>
                        </div>
                    </div>

                    <div v-else class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link item-link" :href="routes.account">
                            <i class="fa fa-user">&nbsp;</i>
                            Account
                        </a>

                        <div class="navbar-dropdown">
                            <div class="navbar-item">
                                <a @click.prevent="submitLogoutForm">
                                    <i class="fa fa-sign-out">&nbsp;</i>
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

export default {
    name: 'HeaderNavbar',

    props: {
        user: {
            type: Object,
            default() {
                return null;
            }
        },
        media: Object,
        routes: Object
    },
    
    data: function () {
        return {
            csrf: window.Laravel.csrfToken
        }
    },
    
    methods: {
        toggleNavbar(event) {
            let el = event.currentTarget;
            let target = document.getElementById(el.dataset.target);

            el.classList.toggle('is-active');
            target.classList.toggle('is-active');
        },

        submitLogoutForm(event) {
            document.getElementById('logout-form').submit();
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