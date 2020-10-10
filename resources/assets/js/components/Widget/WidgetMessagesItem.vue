<template>
    <div class="flash-message" ref="message">
        <transition name="fade" v-on:leave="leave">
            <div :class="['message', messageType]" v-if="show">
                <div class="message-close">
                    <a
                        aria-label="message-close"
                        data-dismiss="message"
                        @click="closeMessage"
                    >
                        <i class="fa fa-times"></i>
                    </a>
                </div>

                <div class="message-content">
                    <template v-if="messageContent">
                        {{ messageContent }}
                    </template>

                    <slot name="message-content"></slot>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import { setTimeout } from 'timers';

export default {
    name: 'WidgetMessagesItem',

    props: {
        messageType: {
            type: String,
            required: true,
        },
        messageContent: {
            type: String,
            required: false,
            default: null,
        },
    },

    data() {
        return {
            show: true,
        };
    },

    methods: {
        closeMessage(event) {
            const el = event.currentTarget;

            this.show = false;
        },

        leave(el, done) {
            setTimeout(() => {
                this.$refs.message.remove();
            }, 600);
        },
    },
};
</script>

<style lang="scss" scoped>
.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-leave-to {
    opacity: 0;
}
</style>