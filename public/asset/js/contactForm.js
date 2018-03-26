(function($) {

    $('#contactForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: new FormData(this),
			processData: false,
			contentType: false,
            beforeSend: function(){
                $.toast({
                    heading: 'Envoi...',
                    text: 'Nous traitons votre demande',
                    icon: 'info',
                    hideAfter: false,
                    stack: false
                });

                $('#contactSubmit').prop("disabled", true);
            },
            success: function (data) {
                $.toast({
                    heading: 'Super !',
                    text: 'Notre équipe vous répondra sous 48 heures',
                    icon: 'success',
                    hideAfter: 5000,
                    stack: false
                });

                $('#contactSubmit').prop("disabled", false);
            },
            error: function (data) {
                $.toast({
                    heading: 'Oups !',
                    text: 'Vérifiez que tous les champs sont corrects...',
                    icon: 'error',
                    hideAfter: 5000,
                    stack: false
                });

                $('#contactSubmit').prop("disabled", false);
            }
        });
    });


})(jQuery);