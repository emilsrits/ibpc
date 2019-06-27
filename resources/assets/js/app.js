(function($) {

    $(document).ready(function() {
        var 
            itemAdd = $('.product-quick-add'),
            itemRemove = $('.cart-item-remove'),
            mediaRemove = $('#product-media-preview').find('.product-media-remove'),
            mediaUpload = $('#product-media-upload'),
            specifications = $('#specifications');

        // Hide flash message
        $('.message-close').css('display', 'inline-block').click(function () {
            $('.flash-message').fadeOut(500);
        });

        // Check all checkboxes in table for mass action
        $('#mass-select').on('click', function() {
            if ($(this).is(':checked')) {
                $('.entity-select').each(function () {
                    $(this).prop('checked', true);
                });
            } else {
                $('.entity-select').each(function () {
                    $(this).prop('checked', false);
                });
            }
        });

        // Clear all filters when clicked
        $('#filters-clear').on('click', function() {
            clearAllInputs($('#table-search'));
        });
        // Clear all filters from a admin panel table
        function clearAllInputs(selector) {
            $(selector).find(':input').each(function() {
                $(this).val('');
            });
            $(selector).find('select').each(function () {
                $(this).selectedIndex = 0;
            });
        }

        // Toggle form sections
        $('.content-section-toggle').on('click', function() {
            $('i', this).toggleClass('fa-angle-up fa-angle-down');
            $(this).parent().find('.content-container').slideToggle();
        });

        // Toggle parent_id selection for category creation
        $('#category-parent').on('change', function() {
           if ($(this).val() === '1') {
               $('#category-parent-id').hide();
           } else {
               $('#category-parent-id').show();
           }
        });

        // Confirm entity delete
        $('#entity-delete').on('click', function() {
            return confirm('Delete this?');
        });

        // Confirm product deletion in catalog
        $('#catalog-form').on('submit', function() {
            var massAction = $('#mass-action').val();
            if (massAction === '3') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' products?');
                }
            }
        });
        // Confirm category deletion in categories view
        $('#categories-form').on('submit', function() {
            var massAction = $('#mass-action').val();
            if (massAction === '3') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' categories?');
                }
            }
        });
        // Confirm specification deletion in specifications view
        $('#specifications-form').on('submit', function() {
            var massAction = $('#mass-action').val();
            if (massAction === '1') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' attribute groups?');
                }
            }
        });
        // Confirm attribute deletion
        $('#attributes-form').on('submit', function() {
            var massAction = $('#mass-action').val();
            if (massAction === '1') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' attributes?');
                }
            }
        });
        // Confirm user disable
        $('#users-form').on('submit', function() {
            var massAction = $('#mass-action').val();
            if (massAction === '2') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Disable ' + numberOfChecked + ' users?');
                }
            }
        });

        // Uncheck other checkboxes when one of delivery options is selected
        $('.checkout-delivery-storage, .checkout-delivery-address').on('click', function() {
            var checkbox = $(this).find('input[type="checkbox"]');
            checkbox.prop('checked', true);
            $('input[type="checkbox"]').not(checkbox).prop('checked', false);
        });

        // Disable order submit button after one click
        $('#checkout-confirm-form').one('submit', function() {
            $(this).find('#order-submit').addClass('disabled').attr('onclick','return false;');
        });

        // Toggle dropdown for category navigation
        $('.dropdown-trigger').on('click', function() {
            toggleDropdown($(this));
        });
        function toggleDropdown(selector) {
            $('.dropdown-content').hide();
            $(selector).find('.dropdown-content').show();
        }
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown-content').length && !$(e.target).closest('.dropdown-trigger').length) {
                $('.dropdown-content').hide();
            }
        });

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

        // Preview uploaded product media
        mediaUpload.on('change', function () {
            var mediaPreview = $('#product-media-preview');
            var media = $(this)[0].files;

            for (var i = 0; i < media.length; i++) {
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

        // Add a product to cart
        itemAdd.on('click', function() {
            $.ajax({
                type: 'POST',
                url: '/cart/add',
                data: {
                    productId: $(this).val()
                },
                dataType: 'json',
                success: function(data) {
                    $('#navbar-cart-items').html(data);
                },
                error: function(err) {
                    console.log("error: " + err);
                }
            });
        });

        // Remove a product from cart
        itemRemove.on('click', function() {
            $.ajax({
                type: 'POST',
                url: '/cart/remove',
                data: {
                    productId: $(this).val()
                },
                dataType: 'json',
                success: function(data) {
                    window.location.href = data.redirectUrl;
                },
                error: function(err) {
                    console.log("error: " + err);
                }
            });
        });

        // Remove product media
        mediaRemove.on('click', function(e) {
            var el = $(this);
            e.preventDefault();
            el.addClass('disabled');
            $.ajax({
                type: 'POST',
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
    })

}(jQuery));