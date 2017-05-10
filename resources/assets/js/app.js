(function($) {

    $(document).ready(function () {
        // Hide flash message
        $('.message-close').css('display', 'inline-block').click(function () {
            $('.flash-message').fadeOut(500);
        });

        // Check all checkboxes in catalog for mass action
        $('#mass-select').click(function () {
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

        // Confirm product deletion in catalog
        $('#catalog-form').submit(function (e) {
            var massAction = $('#mass-action').val();
            if (massAction === '3') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' products?');
                }
            }
            if (massAction === '0') {
                e.preventDefault();
            }
        });

        // Confirm entity delete
        $('#entity-delete').click(function () {
            return confirm('Delete this?');
        });

        // Toggle specifications sections when creating product
        $('.content-section-toggle').click(function () {
            $('i', this).toggleClass('fa-angle-up fa-angle-down');
            $(this).parent().find('.content-container').slideToggle();
        });

        // Toggle parent_id selection for category creation
        $('#category-parent').change(function () {
           if ($(this).val() === '1') {
               $('#category-parent-id').hide();
           } else {
               $('#category-parent-id').show();
           }
        });

        // Confirm category deletion in categories view
        $('#categories-form').submit(function (e) {
            var massAction = $('#mass-action').val();
            if (massAction === '3') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' categories?');
                }
            }
            if (massAction === '0') {
                e.preventDefault();
            }
        });

        // Confirm specification deletion in specifications view
        $('#specifications-form').submit(function (e) {
            var massAction = $('#mass-action').val();
            if (massAction === '1') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' attribute groups?');
                }
            }
            if (massAction === '0') {
                e.preventDefault();
            }
        });

        // Confirm attribute deletion
        $('#attributes-form').submit(function (e) {
            var massAction = $('#mass-action').val();
            if (massAction === '1') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' attributes?');
                }
            }
            if (massAction === '0') {
                e.preventDefault();
            }
        });

        // Confirm user deletion
        $('#users-form').submit(function (e) {
            var massAction = $('#mass-action').val();
            if (massAction === '1') {
                var numberOfChecked = $('.entity-select:checked').length;

                if (numberOfChecked > 0) {
                    return confirm('Delete ' + numberOfChecked + ' users?');
                }
            }
            if (massAction === '0') {
                e.preventDefault();
            }
        });


        /* ------AJAX------ */
        // Load category specifications when creating product
        $('#category-select').change(function () {
            $.ajax({
                type: 'GET',
                url: '/admin/product/categories',
                data: {
                    selectFieldValue: $(this).val()
                },
                success: function (data) {
                    window.location.href = data.redirectUrl + data.category;
                },
                error: function(err) {
                    console.log("error: " + err);
                }
            });
        });
    })

}(jQuery));