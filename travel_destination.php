<?php
include 'database.php';
include 'header.php'; 
$daerah = isset($_GET['daerah']) ? $_GET['daerah'] : '';
$paket = isset($_GET['paket']) ? $_GET['paket'] : '';
$harga_min = isset($_GET['harga_min']) ? (int)$_GET['harga_min'] : 0;
$harga_max = isset($_GET['harga_max']) ? (int)$_GET['harga_max'] : 1000000;

$sql = "SELECT * FROM destinations WHERE price BETWEEN ? AND ?";
$params = [$harga_min, $harga_max];
$types = "ii";

if (!empty($daerah)) {
    $sql .= " AND location = ?";
    $params[] = $daerah;
    $types .= "s"; 
}

if (!empty($paket)) {
    $sql .= " AND package_type = ?";
    $params[] = $paket;
    $types .= "s";
}

$stmt = $main_conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result_destinations = $stmt->get_result();
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EXJO - Destinasi</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="bradcam_area bradcam_bg_2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Destinasi</h3>
                        <p>Berbagai macam destinasi tersedia disini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popular_places_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb_70">
                        <h3>Daftar Destinasi</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="filter_result_wrap">
                        <h3>Filter</h3>
                        <div class="filter_bordered">
                            <form action="travel_destination.php" method="GET">
                                <div class="filter_inner">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="single_select">
                                                <select name="daerah">
                                                    <option value="">Pilih Daerah</option>
                                                    <option value="Yogyakarta" <?php if ($daerah == 'Yogyakarta') echo 'selected'; ?>>Yogyakarta</option>
                                                    <option value="Sleman" <?php if ($daerah == 'Sleman') echo 'selected'; ?>>Sleman</option>
                                                    <option value="Bantul" <?php if ($daerah == 'Bantul') echo 'selected'; ?>>Bantul</option>
                                                    <option value="Gunung Kidul" <?php if ($daerah == 'Gunung Kidul') echo 'selected'; ?>>Gunung Kidul</option>
                                                    <option value="Kulon Progo" <?php if ($daerah == 'Kulon Progo') echo 'selected'; ?>>Kulon Progo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="single_select">
                                                <select name="paket">
                                                    <option value="">Pilih Paket</option>
                                                    <option value="VIP" <?php if ($paket == 'VIP') echo 'selected'; ?>>VIP</option>
                                                    <option value="Regular" <?php if ($paket == 'Regular') echo 'selected'; ?>>Regular</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="range_slider_wrap">
                                                <span class="range">Rentang Harga</span>
                                                <div id="slider-range"></div>
                                                <p>
                                                    <input type="text" id="amount" readonly style="border:0; color:#7A838B; font-weight:300; width: 100%;">
                                                    <input type="hidden" name="harga_min" id="harga_min" value="<?php echo $harga_min; ?>">
                                                    <input type="hidden" name="harga_max" id="harga_max" value="<?php echo $harga_max; ?>">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="reset_btn">
                                    <button class="boxed-btn4" type="submit">Terapkan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="row">
                        <?php
                        if ($result_destinations && $result_destinations->num_rows > 0) {
                            while($row = $result_destinations->fetch_assoc()) {
                        ?>
                                <div class="col-lg-6 col-md-6">
                                    <div class="single_place">
                                        <div class="thumb">
                                            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                                            <a href="#" class="prise">Rp<?php echo number_format($row['price'], 0, ',', '.'); ?></a>
                                            <?php if ($row['package_type'] == 'VIP'): ?>
                                                <a href="#" class="kelas">VIP</a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="place_info">
                                            <a href="#"><h3><?php echo htmlspecialchars($row['name']); ?></h3></a>
                                            <p><?php echo htmlspecialchars($row['location']); ?></p>
                                            <div class="rating_days d-flex justify-content-between">
                                                <span class="d-flex justify-content-center align-items-center">
                                                     <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                                     <a href="#">(Review)</a>
                                                </span>
                                            </div>
                                            <a class="lihat-lebih-btn text-primary">Lihat lebih</a>
                                            <div class="extra-detail d-none">
                                                <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } 
                        } else {
                            echo '<div class="col-lg-12"><div class="alert alert-info text-center">Tidak ada destinasi yang ditemukan sesuai kriteria filter Anda.</div></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <div class="socail_links">
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
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/nice-select.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

    <script>
    $(function() {
        $('select').niceSelect();
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 1000000,
            values: [ <?php echo $harga_min; ?>, <?php echo $harga_max; ?> ],
            slide: function(event, ui) {
                $("#amount").val("Rp" + ui.values[0].toLocaleString('id-ID') + " - Rp" + ui.values[1].toLocaleString('id-ID'));
                $("#harga_min").val(ui.values[0]);
                $("#harga_max").val(ui.values[1]);
            }
        });
        $("#amount").val("Rp" + $("#slider-range").slider("values", 0).toLocaleString('id-ID') +
            " - Rp" + $("#slider-range").slider("values", 1).toLocaleString('id-ID'));
    });
    </script>
</body>

</html>