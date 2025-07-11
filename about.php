<?php 
include 'init.php';
include 'database.php';

$result_perjalanan = $main_conn->query("SELECT COUNT(*) as total FROM bookings");
$total_perjalanan = $result_perjalanan->fetch_assoc()['total'];

$result_destinasi = $main_conn->query("SELECT COUNT(*) as total FROM destinations");
$total_destinasi = $result_destinasi->fetch_assoc()['total'];

$result_ulasan = $main_conn->query("SELECT COUNT(*) as total FROM reviews WHERE rating >= 4");
$ulasan_positif = $result_ulasan->fetch_assoc()['total'];

include 'header.php'; 
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EXJO</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- bradcam_area  -->
    <div class="bradcam_area bradcam_bg_3">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Tentang Kami</h3>                  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ bradcam_area  -->
    
    <div class="about_story">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="story_heading">
                        <h3>Our Story</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-11 offset-lg-1">
                            <div class="story_info">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vel error blanditiis cupiditate quam adipisci perspiciatis magni, soluta reprehenderit architecto accusamus, eligendi facere iure illo ipsum, repellendus nostrum tempore. Temporibus, dolore!</p>
                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Exercitationem suscipit reprehenderit illum et illo, corporis soluta tenetur ea officia praesentium. Aperiam laudantium, earum totam illum et iusto fugit quas necessitatibus?</p>
                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempora inventore impedit delectus cum doloremque esse, mollitia illo repudiandae sit molestiae quidem exercitationem nemo ipsum dolorum aut voluptates dolorem. Iure, amet!</p>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A dicta est illum totam nihil, necessitatibus commodi cum quos error earum fugit asperiores facilis ratione adipisci inventore placeat, non ipsum consequatur.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="counter_wrap justify-content-center">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 col-md-4 justify-content-center">
                                        <div class="single_counter text-center">
                                            <h3  class="counter"> <?php echo $total_perjalanan; ?> </h3>
                                            <p>Total Perjalanan</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 justify-content-center">
                                        <div class="single_counter text-center">
                                            <h3 class="counter"> <?php echo $total_destinasi; ?> </h3>
                                            <p>Total Destinasi</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 justify-content-center">
                                        <div class="single_counter text-center">
                                            <h3 class="counter"> <?php echo $ulasan_positif; ?> </h3>
                                            <p>Ulasan Positif</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- team -->
    <div class="popular_places_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="story_heading">
                        <h3>Our Team</h3>
                    </div>
                </div>
            </div>
            <div class="story_thumb justify-content-center">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="single_place">
                            <div class="thumb1">
                                <img src="img/assets/people/fixman.png" class="img-fluid" alt="">
                            </div>
                            <div class="place_info">
                                <a href=""><h3>Yazid Akmal Adyatma</h3></a>
                                <h5>23.11.5845</h5>
                                <p>Project Leader, Frontend</p>                           
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single_place">
                            <div class="thumb1">
                                <img src="img/assets/people/fixman.png" class="img-fluid" alt="">                            
                            </div>
                            <div class="place_info">
                                <a href=""><h3>Muhammad Evan Alviansyah</h3></a>
                                <h5>23.11.5844</h5>
                                <p>Backend Developer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single_place">
                            <div class="thumb1">
                                <img src="img/assets/people/fixman.png" class="img-fluid" alt="">
                            </div>
                            <div class="place_info">
                                <a href=""><h3>Rafly Muhammad Fauzi</h3></a>
                                <h5>23.11.5821</h5>
                                <p>Support</p>                               
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single_place">
                            <div class="thumb1">
                                <img src="img/assets/people/fixwoman.png" class="img-fluid" alt="">
                            </div>
                            <div class="place_info">
                                <a href=""><h3>Wulandari</h3></a>
                                <h5>23.11.5855</h5>
                                <p>Support</p>                               
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single_place">
                            <div class="thumb1">
                                <img src="img/assets/people/fixman.png" class="img-fluid" alt="">
                            </div>
                            <div class="place_info">
                                <a href=""><h3>Galang P.A.P</h3></a>
                                <h5>23.11.5825</h5>
                                <p>Support</p>                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <!-- link that opens popup -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-de7e2ef6bfefd24b79a3f68b414b87b8db5b08439cac3f1012092b2290c719cd.js"></script>

    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"> </script> -->
    <!-- JS here -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/ajax-form.js"></script>
   
   

    
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
    </script>
</body>

</html>