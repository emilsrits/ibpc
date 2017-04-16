(function($) {

    $(document).ready(function () {
        $('.message-close').css('display', 'inline-block').click(function () {
            $('.flash-message').fadeOut(500);
        });
    })

}(jQuery));