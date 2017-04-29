(function($) {

    $(document).ready(function () {
        // Hide flash message
        $('.message-close').css('display', 'inline-block').click(function () {
            $('.flash-message').fadeOut(500);
        });

        // Check all checkboxes in catalog for mass action
        $('#mass-select').click(function () {
            if ($(this).is(':checked')) {
                $('.product-select').each(function () {
                    $(this).prop('checked', true);
                });
            } else {
                $('.product-select').each(function () {
                    $(this).prop('checked', false);
                });
            }
        });

        // Confirm product deletion in catalog
        $('#catalog-form').submit(function () {
            if ($('#mass-action').val() === '4') {
                var numberOfChecked = $('.product-select:checked').length;

                return confirm('Delete ' + numberOfChecked + ' products?');
            }
        });

        // Toggle specifications sections when creating product
        $('.product-content-section-toggle').click(function () {
            $('i', this).toggleClass('fa-angle-up fa-angle-down');
            $(this).parent().find('.product-container').slideToggle();
        });

        /* ------AJAX------ */
        // Load category specifications when creating product
        $('#category-select').change(function () {
            $.ajax({
                type: 'GET',
                url: '/admin/catalog/specifications',
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