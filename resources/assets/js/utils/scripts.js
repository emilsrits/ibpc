(function($) {

    $(document).ready(function() {
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

        // Toggle parent_id selection for category creation
        $('#category-parent').on('change', function() {
           if ($(this).val() === '1') {
               $('#category-parent-id').hide();
           } else {
               $('#category-parent-id').show();
           }
        });
    })

}(jQuery));