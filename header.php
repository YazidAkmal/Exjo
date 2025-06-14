<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EXJO</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid">
                    <div class="header_bottom_border">
                        <div class="row align-items-center">
                            <div class="col-xl-2 col-lg-2">
                                <div class="logo">
                                    <a href="index.php">
                                        <img src="img/logo.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="main-menu  d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="index.php">Beranda</a></li>
                                            <li><a href="about.php">Tentang Kami</a></li>
                                            <li><a href="travel_destination.php">Destinasi</a></li>
                                            <li><a href="#">Reservasi <i class="ti-angle-down"></i></a>
                                                <ul class="submenu">
                                                    <li><a href="promo.php">Pilihan Paket</a></li>
                                                    <li><a href="reservasi.php">Reservasi Sekarang</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="contact.php">Kontak</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 d-none d-lg-block">
                                <div class="social_wrap d-flex align-items-center justify-content-end">
                                    <div class="number">
                                        <p> <i class="fa fa-phone"></i> +62 0000 1111 123</p>
                                    </div>
                                    <div class="social_links d-none d-xl-block">
                                        <ul>
                                            <li><a href="four.html"> <i class="fa fa-facebook"></i> </a></li>
                                            <li><a href="four.html"> <i class="fa fa-linkedin"></i> </a></li>
                                            <li><a href="four.html"> <i class="fa fa-instagram"></i> </a></li>
                                            <li><a href="four.html"> <i class="fa fa-google-plus"></i> </a></li>
                                            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_username'])): ?>
                                                <li><a href="logout.php" title="Logout"> <i class="fa fa-sign-out" style="font-size: 18px;"></i> </a></li>
                                            <?php else: ?>
                                                <li><a href="login.php" title="Login"> <i class="fa fa-sign-in" style="font-size: 18px;"></i> </a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>