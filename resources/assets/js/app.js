(function($) {

    $(document).ready(function () {
        $('.message-close').css('display', 'inline-block').click(function () {
            $('.flash-message').fadeOut(500);
        });

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

        $('#category-select').change(function () {
            $.ajax({
                type: 'GET',
                url: '/admin/catalog/specifications',

                data: {
                    selectFieldValue: $(this).val()
                },

                success: function (response) {
                    console.log(response.redirectUrl + response.data);
                    window.location.href = response.redirectUrl + response.data;
                }
            });
        });
    })

}(jQuery));