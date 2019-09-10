<template>
    <div class="page-size-select" v-if="enabled">
        <select name="page_size" @change="changePageSize">
            <option value="20" :selected="defaultSize == 20">20</option>
            <option value="40" :selected="defaultSize == 40">40</option>
            <option value="60" :selected="defaultSize == 60">60</option>
        </select>
    </div>
</template>

<script>
export default {
    name: 'WidgetPaginationSize',

    props: {
        enabled: {
            type: Boolean,
            default: true
        },
        defaultSizeProp: {
            type: [Number, String],
            default: 20
        },
        route: {
            type: String,
            required: true
        }
    },

    computed: {
        defaultSize () {
            return (Number.isInteger(Number(this.$props.defaultSizeProp)) ?  this.$props.defaultSizeProp : 20);
        }
    },

    methods: {
        changePageSize(event) {
            let el = event.currentTarget;
            let selection = el.options[el.selectedIndex].value;

            axios.get(this.$props.route, {
                    params: {
                        pageSize: selection
                    }
                })
                .then(response => {
                    if (response.data.redirectUrl) {
                        window.location.href = response.data.redirectUrl;
                    }
                })
                .catch(error => {
                    console.log('error: ' + error);
                });
        }
    }
}
</script>

<style lang="scss" scoped>
@import "../../../sass/modules/variables.scss";

.page-size-select {
    margin: 8px 15px;

    select {
        padding: 3px 5px;
        border: 1px solid $color-gray-darker;
        background-color: $color-black-transparent;
    }

    option {
        background-color: $color-gray-darkest;
    }
}
</style>