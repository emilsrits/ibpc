<template>
    <div class="entity-manage">
        <a
            class="button button-clean action-link"
            v-if="routes.back"
            :href="routes.back"
        >
            Go Back
        </a>

        <button
            id="entity-delete"
            class="button button-action action-remove"
            type="button"
            v-if="routes.delete"
            @click.prevent="deleteEntity"
        >
            Delete
        </button>

        <a
            class="button button-action action-add"
            :href="routes.add"
            v-if="routes.add"
        >
            Add New
        </a>

        <template v-else>
            <button
                id="entity-save"
                class="button button-action action-do"
                type="submit"
                name="submit"
                value="save"
                v-if="canSave"
            >
                Save
            </button>
        </template>
    </div>
</template>

<script>
export default {
    name: 'EntityManage',

    props: {
        canSave: {
            type: Boolean,
            default: true,
        },
        routes: {
            type: Object,
            default: {},
        },
    },

    methods: {
        deleteEntity(event) {
            const el = event.currentTarget;
            const confirmed = confirm('Delete this?');

            if (confirmed) {
                axios
                    .delete(this.routes.delete)
                    .then((response) => {
                        window.location.href = response.data.redirectUrl;
                    })
                    .catch((error) => {
                        this.$store.dispatch(
                            'flashMessage',
                            error.response.data
                        );
                    });
            }

            return false;
        },
    },
};
</script>

<style lang="scss" scoped>
.entity-manage {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin: 10px 0;

    .button {
        margin: 0 5px;
    }
}
</style>