<?php
/*if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit;
    }*/
    if (!isset($_SESSION['user_id'])){
    header("Location: login.php");
    echo "<script>window.location.href='login.php';</script>";
    exit;
    }
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

	<div class="bradcam_area bradcam_bg_5">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Reservasi</h3>
                        <p>Silahkan isi form reservasi anda, ENJOY.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!--content-->
<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'sukses') {
        echo '<div class="alert alert-success text-center" role="alert">Reservasi Anda telah berhasil dikirim! Kami akan segera menghubungi Anda.</div>';
    } else {
        echo '<div class="alert alert-danger text-center" role="alert">Terjadi kesalahan. Mohon periksa kembali isian Anda dan coba lagi.</div>';
    }
}
?>
	<section class="contact-section">
		<div class="container">
			<div class="row" style="justify-content: center;">
				<div class="col-12" >
					<h2 class="booking-title" style="justify-content: center;">Silahkan mengisi data reservasi</h2>
				</div>
				<div class="col-lg-8">
					<form class="form-booking booking_form" action="booking_process.php" method="post" id="contactForm" novalidate="novalidate">
						<div class="row">
							<div class="col-md-6 mb-3">
                                <div class="form-group">
                                  <input class="form-control" name="first_name" id="first_name" type="text" placeholder="First Name" required>
                                </div>
                              </div>
                          
                              <!-- Last Name -->
                              <div class="col-md-6 mb-3">
                                <div class="form-group">
                                  <input class="form-control" name="last_name" id="last_name" type="text" placeholder="Last Name">
                                </div>
                              </div>
                          
                              <!-- Email -->
                              <div class="col-md-6 mb-3">
                                <div class="form-group">
                                  <input class="form-control" name="email" id="email" type="email" placeholder="Email" required>
                                </div>
                              </div>
                          
                              <!-- Nomor HP -->
                              <div class="col-md-6 mb-3">
                                <div class="form-group">
                                  <input class="form-control" name="phone" id="phone" type="text" placeholder="Nomor HP (08xxxxxxx)" required>
                                </div>
                              </div>
                          
                              <!-- Alamat -->
                              <div class="col-12 mb-3">
                                <div class="form-group">
                                  <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Alamat Lengkap (Nama Jalan, No. Rumah, Nama Dusun RT/RW, Desa, Kecamatan, Kabupaten, Provinsi)" required></textarea>
                                </div>
                              </div>
                          
                              <!-- Pilih Paket -->
                              <div class="col-md-6 mb-3">
                                <div class="form-group">
                                  <select class="form-control" name="paket" id="paket" required>
                                    <option value="" disabled selected>Pilih Paket</option>
                                    <option value="sleman">Paket Sleman</option>
                                    <option value="jogja">Paket Jogja</option>
                                    <option value="bantul">Paket Bantul</option>
                                    <option value="gk">Paket Gunungkidul</option>
                                    <option value="kp">Paket Kulon Progo</option>
                                  </select>
                                </div>
                              </div>
                          
                              <!-- Pilih Bulan -->
                              <div class="col-md-6 mb-3">
                                <div class="form-group">
                                  <select class="form-control" name="bulan" id="bulan" required>
                                    <option value="" disabled selected>Pilih Bulan Pemesanan</option>
                                    <option value="Januari">Januari</option>
                                    <option value="Februari">Februari</option>
                                    <option value="Maret">Maret</option>
                                    <option value="April">April</option>
                                    <option value="Mei">Mei</option>
                                    <option value="Juni">Juni</option>
                                    <option value="Juli">Juli</option>
                                    <option value="Agustus">Agustus</option>
                                    <option value="September">September</option>
                                    <option value="Oktober">Oktober</option>
                                    <option value="November">November</option>
                                    <option value="Desember">Desember</option>
                                  </select>
                                </div>
                              </div>
                          
                              <!-- Catatan -->
                              <div class="col-12 mb-3">
                                <div class="form-group">
                                  <textarea class="form-control" name="catatan" id="catatan" rows="3" placeholder="Catatan Tambahan (opsional)"></textarea>
                                </div>
                              </div>
                          
						</div>
						<div class="form-group mt-3">
							<button type="submit" class="button button-contactForm boxed-btn">Kirim</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

    <!-- footer start -->
    <footer class="footer">
        <div class="footer_top">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-md-6 col-lg-5">
                        <div class="footer_widget">
                            <div class="footer_logo">
                                <a href="#">
                                    <img src="img/assets/carousel/exjoputih.png" alt="">
                                </a>
                            </div>
                            <p>Jl. Ring Road Utara, Ngringin,<br>  Condongcatur, Kec. Depok, Kab. Sleman <br> Daerah Istimewa Yogyakarta 55281 <br>
                                <a href="#">+62 0000 1111 123</a> <br>
                                <a href="mailto:exjoyk@gmail.com">exjoyk@gmail.com</a>
                            </p>
                            <div class="social_links">
                                <ul>
                                    <li>
                                        <a href="four.html">
                                            <i class="ti-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="four.html">
                                            <i class="ti-twitter-alt"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="four.html">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="four.html">
                                            <i class="fa fa-pinterest"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="four.html">
                                            <i class="fa fa-youtube-play"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Popular destination
                            </h3>
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
                            <h3 class="footer_title">
                                Footage
                            </h3>
                            <div class="instagram_feed">
                                <div class="single_insta">
                                    <a href="#">
                                        <img src="img/assets/yk/ykCover.jpg" alt="">
                                    </a>
                                </div>
                                <div class="single_insta">
                                    <a href="#">
                                        <img src="img/assets/sl/slCover.jpg" alt="">
                                    </a>
                                </div>
                                <div class="single_insta">
                                    <a href="#">
                                        <img src="img/assets/ba/baCover.jpg" alt="">
                                    </a>
                                </div>
                                <div class="single_insta">
                                    <a href="#">
                                        <img src="img/assets/gk/gkCover.jpg" alt="">
                                    </a>
                                </div>
                                <div class="single_insta">
                                    <a href="#">
                                        <img src="img/assets/kp/kpCover.jpg" alt="">
                                    </a>
                                </div>
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
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> <a>Universitas Amikom Yogyakarta</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--/ footer end  -->

  <!-- Modal -->
  <div class="modal fade custom_search_pop" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="serch_form">
            <input type="text" placeholder="Search" >
            <button type="submit">search</button>
        </div>
      </div>
    </div>
  </div>

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

	<!--contact js-->
    <script src="js/booking.js"></script>
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
</body>
</html>