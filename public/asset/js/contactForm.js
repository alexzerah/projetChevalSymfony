(function($) {

    $('#contactForm').submit(function (e) {

        e.preventDefault();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: new FormData(this),
            dataType: 'json',
			processData: false,
			contentType: false,
            beforeSend: function(){

            },
            success: function (data) {
                if (data.result === 0) {
                    console.log('prout')
                }
            }
        });
    });


})(jQuery);