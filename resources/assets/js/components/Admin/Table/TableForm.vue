<template>
    <div class="scrollable-x">
        <form id="entity-table-form" class="inverted" method="POST" :action="action" @submit="formSubmit">
            <input type="hidden" name="_token" :value="csrf">

            <div class="table-action">
                <div class="select">
                    <select id="mass-action" name="mass-action">
                        <option value="0"></option>
                        <slot name="select-options"></slot>
                    </select>
                </div>

                <button class="button button-action action-do" type="submit">Apply</button>

                <span id="table-filters-clear" class="button button-action has-text-dark" type="button" @click="clearFilters">
                    <i class="fa fa-refresh"></i>
                    <span class="is-hidden-mobile">&nbsp;Clear Filters</span>
                </span>
            </div>

            <slot name="entity-table"></slot>
        </form>
    </div>
</template>

<script>
export default {
    name: 'TableForm',

    props: {
        action: String
    },

    data: function () {
        return {
            csrf: window.Laravel.csrfToken
        }
    },

    methods: {
        formSubmit(event) {
            event.preventDefault();

            let el = event.currentTarget;

            let massAction = document.getElementById('mass-action');

            if (massAction.options[massAction.selectedIndex].value != 0) {
                let confirmed = confirm('Are you sure?');

                if (confirmed) {
                    el.submit();
                }

                return false;
            }

            el.submit();
        },

        clearFilters(event) {
            let filterInputs = document.getElementsByClassName('filter-input');

            for (let element of filterInputs) {
                if (element.tagName === 'SELECT') {
                    element.selectedIndex = 0;
                } else {
                    element.value = '';
                }
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.table-action {
    margin: 10px 0 15px;
}
</style>