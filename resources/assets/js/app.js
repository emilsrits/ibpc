(function($) {

    $(document).ready(function() {
        // Hide flash message
        $('.message-close').css('display', 'inline-block').click(function () {
            $('.flash-message').fadeOut(500);
        });

        // Check all checkboxes in catalog for mass action
        $('#mass-select').click(function() {
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

        // Toggle specifications sections when creating product
        $('.content-section-toggle').click(function() {
            $('i', this).toggleClass('fa-angle-up fa-angle-down');
            $(this).parent().find('.content-container').slideToggle();
        });

        // Toggle parent_id selection for category creation
        $('#category-parent').change(function() {
           if ($(this).val() === '1') {
               $('#category-parent-id').hide();
           } else {
               $('#category-parent-id').show();
           }
        });

        // Confirm entity delete
        $('#entity-delete').click(function() {
            return confirm('Delete this?');
        });

        // Confirm product deletion in catalog
        $('#catalog-form').submit(function() {
            var massAction = $('#mass-action').val();
            if (massAction === '3') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' products?');
                }
            }
        });
        // Confirm category deletion in categories view
        $('#categories-form').submit(function() {
            var massAction = $('#mass-action').val();
            if (massAction === '3') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' categories?');
                }
            }
        });
        // Confirm specification deletion in specifications view
        $('#specifications-form').submit(function() {
            var massAction = $('#mass-action').val();
            if (massAction === '1') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' attribute groups?');
                }
            }
        });
        // Confirm attribute deletion
        $('#attributes-form').submit(function() {
            var massAction = $('#mass-action').val();
            if (massAction === '1') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' attributes?');
                }
            }
        });
        // Confirm user disable
        $('#users-form').submit(function() {
            var massAction = $('#mass-action').val();
            if (massAction === '2') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Disable ' + numberOfChecked + ' users?');
                }
            }
        });

        // Uncheck other checkboxes when one of delivery options is selected
        $('.checkout-delivery-storage, .checkout-delivery-address').click(function() {
            var checkbox = $(this).find('input[type="checkbox"]');
            checkbox.prop('checked', true);
            $('input[type="checkbox"]').not(checkbox).prop('checked', false);
        });

        // Disable order submit button after one click
        $('#checkout-confirm-form').one('submit', function() {
            $(this).find('#order-submit').addClass('disabled').attr('onclick','return false;');
        });

        // Clear all filters when clicked
        $('#filters-clear').click(function() {
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

        // Toggle dropdown for category navigation
        $('.dropdown-trigger').click(function() {
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

        /* ------AJAX------ */
        // Set AJAX defaults
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Load category specifications when creating product
        $('#category-select').change(function() {
            $.ajax({
                type: 'GET',
                url: '/admin/product/categories',
                data: {
                    selectFieldValue: $(this).val()
                },
                success: function(data) {
                    window.location.href = data.redirectUrl + data.category;
                },
                error: function(err) {
                    console.log("error: " + err);
                }
            });
        });

        // Add a product to cart
        $('.product-quick-add').click(function() {
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
        $('.cart-item-remove').click(function() {
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
    })

}(jQuery));