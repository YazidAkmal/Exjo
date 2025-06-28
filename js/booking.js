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
                first_name: {
                    required: true,
                    minlength: 5
                },
                last_name: {
                    minlength: 5
                },
                phone: {
                    required: true,
                    minlength: 11
                },
                alamat: {
                    required: true,
                    minlength: 10
                },
                email: {
                    required: true,
                    email: true
                },
                catatan: {
                    required: false,
                    minlength: 5
                },
                bulan: {
                    required: true
                },
                paket: {
                    required: true
                }
            },
            messages: {
                first_name: {
                    required: "ayolah, kamu punya nama kan kawan?",
                    minlength: "namamu singkat juga ya"
                },
                phone: {
                    required: "ayolah, kamu punya nomer hp kan?",
                    minlength: "nomermu minimal harus mengandung 11 karakter."
                },
                email: {
                    required: "masukin emailnya dong."
                },
                catatan: {
                    required: "emm, saya rasa anda belum menuliskan apapun nich.",
                    minlength: "ayolah, segini doang? buat mata kami lelah membaca dong."
                },
                bulan: {
                    required: "hayo kamu mau liburan di bulan apa."
                },
                paket:{
                    required: "pilih dong paketnya, masa engga."
                },
                alamat: {
                    required: "di cek lagi, alamatnya wajib diisi yaa.",
                    minlength: "ayolah, segini doang? buat mata kami lelah membaca dong."
                },
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