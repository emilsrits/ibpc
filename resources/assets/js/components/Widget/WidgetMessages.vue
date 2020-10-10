<template>
    <div class="flash-message-container" ref="container">
        <slot></slot>
    </div>
</template>

<script>
import WidgetMessagesItemVue from './WidgetMessagesItem.vue';

export default {
    name: 'WidgetMessages',

    mounted() {
        this.$store.subscribe((mutation, state) => {
            if (mutation.type === 'FLASH_MESSAGE') {
                const message = state.message;

                const ComponentClass = Vue.extend(WidgetMessagesItemVue);
                const instance = new ComponentClass({
                    propsData: {
                        messageType: message.type,
                        messageContent: message.content,
                    },
                });
                instance.$mount();

                this.$refs.container.appendChild(instance.$el);
            }
        });
    },
};
</script>

<style lang="scss">
@import '@styleModules/variables.scss';

.flash-message-container {
    position: absolute;
    top: 1rem;
    right: 1rem;
    z-index: 25;

    .flash-message {
        margin: 10px 0;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
    }

    .message {
        display: block;
        position: relative;
        padding: 20px 45px;
        width: 100%;
        color: $color-gray-darkest;
    }

    .message-success {
        background-color: lighten($color-green-darker, 30%);
        border: 1px solid $color-green-darker;
    }
    .message-info {
        background-color: lighten($color-blue, 30%);
        border: 1px solid $color-blue;
    }
    .message-warning {
        background-color: lighten($color-orange, 30%);
        border: 1px solid $color-orange;
    }
    .message-danger {
        background-color: lighten($color-red, 30%);
        border: 1px solid $color-red;
    }

    .message-content {
        word-wrap: break-word;
    }

    .message-close {
        position: absolute;
        top: 4px;
        right: 3px;

        a {
            padding: 5px 8px;
            opacity: 0.5;
        }

        a,
        a:hover {
            color: $color-black;
        }

        a:hover {
            opacity: 0.8;
        }
    }
}
</style>