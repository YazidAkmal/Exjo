$(document).ready(function(){
    
    (function($) {
        "use strict";

    
    jQuery.validator.addMethod('answercheck', function (value, element) {
        return this.optional(element) || /^\bcat\b$/.test(value)
    }, "type the correct answer -_-");

    // validate contactForm form
    $(function() {
        $('#contactForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 5
                },
                subject: {
                    required: true,
                    minlength: 5
                },
                number: {
                    required: true,
                    minlength: 11
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true,
                    minlength: 7
                }
            },
            messages: {
                name: {
                    required: "ayolah, kamu punya nama kan kawan?",
                    minlength: "nama lengkap ya, he he."
                },
                subject: {
                    required: "masa gaada subyeknya.",
                    minlength: "hanya itu saja? O.K."
                },
                number: {
                    required: "ayolah, kamu punya nomer hp kan?",
                    minlength: "nomermu minimal harus mengandung 11 karakter."
                },
                email: {
                    required: "masukin emailnya dong."
                },
                message: {
                    required: "emm, saya rasa anda belum menuliskan apapun nich.",
                    minlength: "ayolah, segini doang? buat mata kami lelah membaca dong."
                }
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    type:"POST",
                    data: $(form).serialize(),
                    url:"contact_process.php",
                    success: function() {
                        $('#contactForm :input').attr('disabled', 'disabled');
                        $('#contactForm').fadeTo( "slow", 1, function() {
                            $(this).find(':input').attr('disabled', 'disabled');
                            $(this).find('label').css('cursor','default');
                            $('#success').fadeIn()
                            $('.modal').modal('hide');
		                	$('#success').modal('show');
                        })
                    },
                    error: function() {
                        $('#contactForm').fadeTo( "slow", 1, function() {
                            $('#error').fadeIn()
                            $('.modal').modal('hide');
		                	$('#error').modal('show');
                        })
                    }
                })
            }
        })
    })
        
 })(jQuery)
})