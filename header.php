<?php
//session_start();
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

    <link rel="shortcut icon" type="image/x-icon" href="img/assets/carousel/exjo.ico">
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

   <style>
        .main-header-area {
            background: #fff !important; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        #sticky-header.sticky {
            box-shadow: 0 5px 15px rgba(0,0,0,0.05) !important;
        }

        .signin-btn { 
            margin-left: 15px !important; 
            background-color: #1EC6B6 !important; 
            color: white !important; 
            padding: 10px 25px !important; 
            border-radius: 50px !important; 
            font-weight: 500 !important; 
        }
        .signin-btn:hover { background-color: #17A295 !important; }

        .profile-dropdown { 
            position: relative; 
            display: inline-block; 
            margin-left: 20px;
        }

        .profile-trigger img { 
            width: 45px; !important;
            height: 45px; !important;
            border-radius: 50%; 
            border: 2px solid #e0e0e0;
            cursor: pointer;
            transition: transform 0.2s ease-in-out, border-color 0.2s ease-in-out; 
        }
        
        .profile-trigger:hover img {
            border-color: #1EC6B6;
            transform: translateY(-3px); 
        }
        
        .profile-dropdown-content { 
            display: none; 
            position: absolute; 
            background-color: #fff; 
            min-width: 220px; 
            box-shadow: 0 8px 16px rgba(0,0,0,0.1); 
            border-radius: 8px; 
            right: 0; 
            top: 46px;
            border: 1px solid #f0f0f0;
        }
        
        .profile-dropdown-content.show {
            display: block;
        }

        .profile-dropdown-header { 
            padding: 15px; 
            border-bottom: 1px solid #f0f0f0; 
            font-weight: bold;
            color: #333;
        }
        
        .profile-dropdown-content a { 
            color: #333; 
            padding: 12px 15px; 
            text-decoration: none; 
            display: flex;
            align-items: center;
            font-size: 14px;
        }
        .profile-dropdown-content a:hover { 
            background-color: #f5f5f5; 
        }
        .profile-dropdown-content a i { 
            margin-right: 12px; 
            color: #555;
            width: 18px;
        }
    </style>
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!--header start -->
    <header>
        <div class="header-area ">
           <div id="sticky-header" class="main-header-area">
                <div class="container-fluid">
                    <div class="header_bottom_border">
                        <div class="row align-items-center">
                            <div class="col-xl-2 col-lg-2">
                                <div class="logo">
                                    <a href="index.php"><img src="img/logo.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-7">
                                <div class="main-menu d-none d-lg-block">
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
                            <div class="col-xl-3 col-lg-3 d-none d-lg-block">
                                <div class="social_wrap d-flex align-items-center justify-content-end">
                                    <div class="number">
                                        <p><i class="fa fa-phone"></i> +62 0000 1111 123</p>
                                    </div>
                                    
                                    <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_username'])): ?>
                                        <div class="profile-dropdown">
                                            <div class="profile-trigger" id="profileTrigger">
                                                <img src="img/assets/icon/default-profile.png" alt="Profile">
                                            </div>
                                            <div id="profileDropdownContent" class="profile-dropdown-content">
                                                <div class="profile-dropdown-header">
                                                    Halo, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Admin'; ?>
                                                </div>
                                                <a href="my_reservations.php"><i class="fa fa-calendar-check-o"></i> Reservasi Saya</a>
                                                <a href="logout.php"><i class="fa fa-sign-out"></i> Log out</a>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <a href="login.php" class="signin-btn">Login</a>
                                    <?php endif; ?>
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
    <!-- header-end -->
</body>
</html>