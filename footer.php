<footer class="footer">
    <div class="footer_top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-md-6 col-lg-5">
                    <div class="footer_widget">
                        <div class="footer_logo">
                            <a href="#">
                                <img src="img/assets/carousel/exjoputih.png" class="img-fluid" alt="Logo EXJO Putih">
                            </a>
                        </div>
                        <p>Jl. Ring Road Utara, Ngringin,<br> Condongcatur, Kec. Depok, Kab. Sleman <br> Daerah Istimewa
                            Yogyakarta 55281 <br>
                            <a href="four.html">+62 0000 1111 123</a> <br>
                            <a href="mailto:exjoyk@gmail.com">exjoyk@gmail.com</a>
                        </p>
                        <div class="socail_links">
                            <ul>
                                <li><a href="#"><i class="ti-facebook"></i></a></li>
                                <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">Popular Destination</h3>
                        <ul class="links double_links">
                            <li><a href="travel_destination.php?daerah=Yogyakarta">Yogyakarta</a></li>
                            <li><a href="travel_destination.php?daerah=Sleman">Sleman</a></li>
                            <li><a href="travel_destination.php?daerah=Kulon Progo">Kulon Progo</a></li>
                            <li><a href="travel_destination.php?daerah=Bantul">Bantul</a></li>
                            <li><a href="travel_destination.php?daerah=Gunung Kidul">Gunung Kidul</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">Footage</h3>
                        <div class="instagram_feed">
                            <div class="single_insta"><a href="#"><img src="img/assets/yk/ykCover.jpg" class="img-fluid"
                                        alt=""></a></div>
                            <div class="single_insta"><a href="#"><img src="img/assets/sl/slCover.jpg" class="img-fluid"
                                        alt=""></a></div>
                            <div class="single_insta"><a href="#"><img src="img/assets/ba/baCover.jpg" class="img-fluid"
                                        alt=""></a></div>
                            <div class="single_insta"><a href="#"><img src="img/assets/gk/gkCover.jpg" class="img-fluid"
                                        alt=""></a></div>
                            <div class="single_insta"><a href="#"><img src="img/assets/kp/kpCover.jpg" class="img-fluid"
                                        alt=""></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copy-right_text">
        <div class="container">
            <div class="footer_border"></div>
            <div class="row">
                <div class="col-xl-12">
                    <p class="copy_right text-center">
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script> <a>Universitas Amikom Yogyakarta</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="js/vendor/jquery-1.12.4.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<script src="js/vendor/modernizr-3.5.0.min.js"></script>
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
<script src="js/slick.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    document.addEventListener("DOMContentLoaded", function () {
        const profileTrigger = document.getElementById('profileTrigger');
        const dropdownContent = document.getElementById('profileDropdownContent');

        if (profileTrigger) {
            profileTrigger.addEventListener('click', function (event) {
                dropdownContent.classList.toggle('show');
                event.stopPropagation();
            });
        }

        window.addEventListener('click', function (event) {
            if (dropdownContent && dropdownContent.classList.contains('show')) {
                if (!profileTrigger.contains(event.target)) {
                    dropdownContent.classList.remove('show');

                }
            }
        });
    });
</script>

</body>

</html>