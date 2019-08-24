(function($) {

    $(document).ready(function() {
        var 
            mediaRemove = $('#product-media-preview').find('.product-media-remove'),
            mediaUpload = $('#product-media-upload'),
            specifications = $('#specifications'),
            massAction = $('#mass-action');

        // Magnific Popup initialize on product images
        $('.product-media-item > img').magnificPopup({
            type: 'image',
            gallery: {
                enabled:true
            },
            callbacks: {
                elementParse: function(item) {
                    item.src = item.el.attr('src');
                }
            }
        });

        // Hide flash message
        $('.message-close').css('display', 'inline-block').click(function () {
            $('.flash-message').fadeOut(500);
        });

        // Toggle parent_id selection for category creation
        $('#category-parent').on('change', function() {
           if ($(this).val() === '1') {
               $('#category-parent-id').hide();
           } else {
               $('#category-parent-id').show();
           }
        });

        // Preview uploaded product media
        mediaUpload.on('change', function () {
            var mediaPreview = $('#product-media-preview');
            var media = $(this)[0].files;

            for (let i = 0; i < media.length; i++) {
                var mediaPath = media[i].name;
                var extn = mediaPath.substring(mediaPath.lastIndexOf('.') + 1).toLowerCase();

                if (extn == 'jpg' || extn == 'jpeg' || extn == 'png' || extn == 'gif') {
                    if (typeof (FileReader) != 'undefined') {
                        mediaPreview.find('.media-item.new').remove();
    
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('<div />', {
                                'class': 'media-item new'
                            }).append(
                                $('<img />', {
                                    'src': e.target.result,
                                    'class': 'img-responsive'
                                })
                            ).appendTo(mediaPreview);
                        }
                        reader.readAsDataURL(media[i]);
                    } else {
                        console.log('This browser does not support FileReader');
                    }
                } else {
                    console.log('Invalid media type');
                }
            }
        });

        /* ------AJAX------ */
        // Set AJAX defaults
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Load category specifications when creating product
        $('#category-select').on('change', function() {
            $.ajax({
                type: 'GET',
                url: '/admin/product/categories',
                data: {
                    selectFieldValue: $(this).val()
                },
                success: function(data) {
                    specifications.html(data);
                },
                error: function() {
                    specifications.empty();
                }
            });
        });

        // Remove product media
        mediaRemove.on('click', function(e) {
            var el = $(this);
            e.preventDefault();
            el.addClass('disabled');
            $.ajax({
                type: 'PUT',
                url: '/admin/product/update',
                data: {
                    mediaId: el.data('id'),
                    productId: el.data('product_id')
                },
                dataType: 'json',
                success: function() {
                    el.parent().remove();
                },
                error: function(err) {
                    el.removeClass('disabled');
                    console.log("error: " + err);
                }
            });
        });

        // Confirm single entity delete
        $('#entity-delete').on('click', function(e) {
            var el = $(this);
            e.preventDefault();
            let confirmed = confirm('Delete this?');
            if (confirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: el.data('url'),
                    dataType: 'json',
                    success: function(data) {
                        window.location.href = data.redirectUrl;
                    },
                    error: function(err) {
                        console.log("error: " + err);
                    }
                });
            }
        });
    })

}(jQuery));