(function($) {

    $('#contactForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: new FormData(this),
			processData: false,
			contentType: false,
            success: function (data) {

                console.log("message sent");

                $.toast({
                    heading: 'Youpi !',
                    text: 'Nous avons bien reçu votre message.',
                    position: 'bottom-center',
                    stack: false,
                    showHideTransition: 'plain',
                    icon: 'success',
                    hideAfter: 5000
                });
            },
            error: function (data) {
                $.toast({
                    heading: 'Oops!',
                    text: 'Vérifiez que vos infos sont correctes...',
                    hideAfter: 7000,
                    stack: false,
                    showHideTransition: 'plain',
                    icon: 'error'
                })
            }
        });
    });


})(jQuery);