<?php
include 'init.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
<<<<<<< HEAD
    exit;
    }*/
    if (!isset($_SESSION['user_id'])){
    header("Location: login.php");
    echo "<script>window.location.href='login.php';</script>";
    exit;
    }
    include 'header.php';
=======
    exit();
}
include 'database.php';

$user_id = $_SESSION['user_id'];
$stmt_user = $main_conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_data = $stmt_user->get_result()->fetch_assoc();
$stmt_user->close();

// Ambil semua lokasi
$locations = [];
$loc_result = $main_conn->query("SELECT DISTINCT location FROM destinations ORDER BY location");
while ($row = $loc_result->fetch_assoc()) {
    $locations[] = $row['location'];
}

include 'header.php';
>>>>>>> a575031 (No changes to commit.)
?>

<!-- Nice Select & Flatpickr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="bradcam_area bradcam_bg_5">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text text-center">
                    <h3>Reservasi</h3>
                    <p>Silakan pilih destinasi Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="contact-section">
    <div class="container">
        <div class="row" style="justify-content: center;">
            <div class="col-lg-8">
                <h2 class="booking-title text-center mb-5 mt-4">Silahkan Melengkapi Data Reservasi</h2>
                <form action="booking_process.php" method="POST" class="form-contact contact_form">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <input class="form-control" type="text" value="Nama: <?= htmlspecialchars($user_data['first_name'] . ' ' . $user_data['last_name'] ?? '') ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <input class="form-control" type="email" value="Email: <?= htmlspecialchars($user_data['email'] ?? '') ?>" readonly>
                            </div>
                        </div>

<<<<<<< HEAD
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
=======
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <select name="lokasi" id="lokasi" class="form-control wide" required>
                                    <option value="">Pilih Lokasi</option>
                                    <?php foreach ($locations as $loc): ?>
                                        <option value="<?= htmlspecialchars($loc) ?>"><?= htmlspecialchars($loc) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
>>>>>>> a575031 (No changes to commit.)

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <select name="destination_id" id="destinasi" class="form-control wide" required>
                                    <option value="">Pilih Lokasi Dahulu</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <input type="text" name="tanggal_pemesanan" id="tanggal-flatpickr" class="form-control" placeholder="Pilih Tanggal Pemesanan" required>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <textarea name="catatan" class="form-control" rows="4" placeholder="Catatan Tambahan (opsional)"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3 text-center">
                        <button type="submit" class="button button-contactForm boxed-btn">Kirim Reservasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
$(document).ready(function () {

    $('select').niceSelect();

    flatpickr("#tanggal-flatpickr", {
        dateFormat: "Y-m-d",
        minDate: "today"
    });

    $('#lokasi').on('change', function () {
        let lokasiVal = $(this).val();
        let destinasi = $('#destinasi');

        if (lokasiVal) {
            destinasi.html('<option value="">Memuat...</option>');
            $.post('get_destinations.php', { location: lokasiVal }, function (data) {
                destinasi.html(data);
                destinasi.niceSelect('destroy');
                destinasi.niceSelect();
            });
        } else {
            destinasi.html('<option value="">Pilih Lokasi Dahulu</option>');
            destinasi.niceSelect('destroy');
            destinasi.niceSelect();
        }
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status')) {
        const status = urlParams.get('status');
        const error = urlParams.get('error');
        const brandColor = '#1EC6B6';

        let title, text, icon;

        if (status === 'sukses') {
            title = 'Berhasil!';
            text = 'Terima kasih, reservasi Anda telah kami terima.';
            icon = 'success';
        } else {
            title = 'Gagal';
            text = error || 'Terjadi kesalahan saat mengirim data.';
            icon = 'error';
        }

        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            confirmButtonColor: brandColor
        });

        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
</script>
