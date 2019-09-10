<template>
    <div class="field is-horizontal">
        <div class="field-body">
            <slot name="top-level" :topCategoryChange="topCategoryChange"></slot>

            <slot name="parent-id" v-if="!isTopLevel"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EntityCategoryParent',

    props: {
        topLevel: {
            default: false
        }
    },

    data () {
        return {
            isTopLevel: this.$props.topLevel 
        }
    },

    methods: {
        topCategoryChange(event) {
            let el = event.currentTarget;

            if (el.options[el.selectedIndex].value == '1') {
                this.isTopLevel = true;
            } else {
                this.isTopLevel = false;
            }
        }
    }
}
</script>