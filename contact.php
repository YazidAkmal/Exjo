<?php
include 'init.php';
include 'header.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EXJO</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- bradcam_area  -->
    <div class="bradcam_area bradcam_bg_4">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Kontak</h3>
                        <p>Hubungi kami di kontak dibawah ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ bradcam_area  -->

    <!--  contact section start  -->
    <section class="contact-section">
        <div class="container">
            <div class="d-none d-sm-block mb-5 pb-4">
                <div class="map-wrapper">
                    <div class="embed-map-fixed">
                        <div class="embed-map-container">
                            <iframe class="embed-map-frame" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3953.2778864895754!2d110.4096117!3d-7.7603254!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a599bd3bdc4ef%3A0x6f1714b0c4544586!2sUniversitas%20Amikom%20Yogyakarta!5e0!3m2!1sid!2sid!4v1746015773134!5m2!1sid!2sid"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </iframe>
                            <a href="https://sprunkiretake.net"
                                style="font-size:2px!important;color:gray!important;position:absolute;bottom:0;left:0;z-index:1;max-height:1px;overflow:hidden">
                                sprunki retake
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if (isset($_GET['status'])) {
                if ($_GET['status'] == 'sukses') {
                    echo '<div class="alert alert-success" role="alert">Pesan Anda telah berhasil terkirim! Terima kasih.</div>';
                } else if ($_GET['status'] == 'gagal') {
                    echo '<div class="alert alert-danger" role="alert">Terjadi kesalahan. Mohon periksa kembali isian Anda dan coba lagi.</div>';
                }
            }
            ?>
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Kirim kami pesan</h2>
                </div>
                <div class="col-lg-8">
                    <form action="contact_process.php" method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-pesan">
                                    <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukkan pesan'"
                                        placeholder="Masukkan Pesan"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-pesan">
                                    <input class="form-control valid" name="name" id="name" type="text"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nama anda'"
                                        placeholder="Nama anda">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-pesan">
                                    <input class="form-control valid" name="email" id="email" type="email"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email anda'"
                                        placeholder="Email anda">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-pesan">
                                    <input class="form-control" name="subject" id="subject" type="text"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Subjek'"
                                        placeholder="Subjek">
                                </div>
                            </div>
                        </div>
                        <div class="form-pesan mt-3">
                            <button type="submit" class="button button-contactForm boxed-btn">Kirim</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3>Daerah Istimewa Yogyakarta 5528.</h3>
                            <p>Jl. Ring Road Utara, Ngringin,
                                Condongcatur, Kec. Depok, Kab. Sleman
                            </p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3>+62 0000 1111 123</h3>
                            <p>Sen s.d Sab, 09:00 s.d 18:00</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3>exjoyk@gmail.com</h3>
                            <p>Hubungi kami kapan saja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  contact section end  -->

    <?php
    include 'footer.php';
    ?>

    <!-- Modal 
  <div class="modal fade custom_search_pop" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="serch_form">
            <input type="text" placeholder="Search" >
            <button type="submit">search</button>
        </div>
      </div>
    </div>
  </div> -->

    <!-- JS here -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/ajax-form.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/scrollIt.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/nice-select.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/gijgo.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--contact js-->
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>

    <script src="js/main.js"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }

        });
    </script>

    <script>
        $(document).ready(function () {
            const urlParams = new URLSearchParams(window.location.search);

            if (urlParams.has('status')) {
                const status = urlParams.get('status');
                const error = urlParams.get('error');
                const brandColor = '#1EC6B6';

                let title, text, icon;

                if (status === 'sukses') {
                    title = 'Berhasil!';
                    text = 'Aksi Anda telah berhasil diproses.';
                    icon = 'success';
                } else {
                    title = 'Oops... Terjadi Kesalahan';
                    text = error || 'Silakan periksa kembali isian Anda dan coba lagi.';
                    icon = 'error';
                }

                if (window.location.pathname.includes('reservasi.php') && status === 'sukses') {
                    text = 'Terima kasih, reservasi Anda telah kami terima dan akan segera diproses.';
                }

                Swal.fire({
                    icon: icon,
                    title: title,
                    text: text,
                    confirmButtonColor: brandColor
                });

                window.history.replaceState({}, document.title, window.location.pathname + window.location.hash);
            }
        });
    </script>
</body>

</html>