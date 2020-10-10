<template>
    <div id="product-media">
        <label class="is-hidden" for="media">Media</label>

        <div id="product-media-preview">
            <slot name="media-preview" :deleteMedia="deleteMedia"></slot>
        </div>

        <input
            id="product-media-upload"
            type="file"
            name="media[]"
            accept="image/gif, image/jpeg, image/png"
            multiple="multiple"
            @change="previewMedia"
        />
    </div>
</template>

<script>
export default {
    name: 'EntityProductMedia',

    methods: {
        previewMedia(event) {
            const el = event.currentTarget;
            const media = el.files;
            let preview = document.getElementById('product-media-preview');

            for (let i = 0; i < media.length; i++) {
                let mediaPath = media[i].name;
                let extn = mediaPath
                    .substring(mediaPath.lastIndexOf('.') + 1)
                    .toLowerCase();

                if (
                    extn == 'jpg' ||
                    extn == 'jpeg' ||
                    extn == 'png' ||
                    extn == 'gif'
                ) {
                    if (typeof FileReader != 'undefined') {
                        preview
                            .querySelectorAll('.media-item.new')
                            .forEach((node) =>
                                node.parentNode.removeChild(node)
                            );

                        let reader = new FileReader();
                        reader.onload = (e) => {
                            let mediaItem = document.createElement('div');
                            mediaItem.className = 'media-item new';

                            let image = document.createElement('img');
                            image.src = e.target.result;
                            image.className = 'image';

                            mediaItem.appendChild(image);
                            preview.appendChild(mediaItem);
                        };
                        reader.readAsDataURL(media[i]);
                    } else {
                        this.$store.dispatch('flashMessage', {
                            type: 'message-warning',
                            content: 'This browser does not support FileReader',
                        });
                    }
                } else {
                    this.$store.dispatch('flashMessage', {
                        type: 'message-danger',
                        content: 'Invalid media type.',
                    });
                }
            }
        },

        deleteMedia(event) {
            event.preventDefault();

            const el = event.currentTarget;

            el.classList.add('disabled');

            axios
                .put('/admin/product/update', {
                    mediaId: el.dataset.id,
                    productId: el.dataset.product_id,
                })
                .then((response) => {
                    el.parentNode.remove();
                })
                .catch((error) => {
                    el.classList.remove('disabled');
                    console.error('error: ' + error);
                });
        },
    },
};
</script>

<style lang="scss">
@import '@styleModules/variables.scss';

#product-media-preview {
    display: grid;
    grid-gap: 5px;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    align-items: end;
    justify-items: center;
    margin: 5px 0 15px;

    .media-item {
        position: relative;
        display: inline-block;
        &.new {
            border: 1px solid $color-green;
        }
    }

    .media-remove {
        position: absolute;
        right: 0;
        bottom: 0;
    }
}

#product-media-upload {
    padding: 10px;
    transition: border 0.3s ease;
    border: 3px dashed $color-gray-lighter;
    &:hover,
    &:focus {
        border-color: $color-green-darker;
    }
}

@include mobile() {
    #product-media {
        input[type='file'] {
            width: 100%;
        }
    }
}
</style>