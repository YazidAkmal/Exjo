<?php
include 'database.php';
include 'init.php';
include 'header.php';

$daerah = isset($_GET['daerah']) ? $_GET['daerah'] : '';
$paket = isset($_GET['paket']) ? $_GET['paket'] : '';
$harga_min = isset($_GET['harga_min']) ? (int) $_GET['harga_min'] : 0;
$harga_max = isset($_GET['harga_max']) ? (int) $_GET['harga_max'] : 1000000;

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
$stmt->bind_result($id, $name, $location, $description, $price, $image_path, $package_type, $link);

$destinations_data = [];
while ($stmt->fetch()) {
    $destinations_data[] = [
        'id' => $id,
        'name' => $name,
        'location' => $location,
        'description' => $description,
        'price' => $price,
        'image_path' => $image_path,
        'package_type' => $package_type,
        'link' => $link
    ];
}
$stmt->close();
?>
<!--<!doctype html>
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
</head> -->

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
    <style>
        .filter-sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 50px;

            .rating-bintang i {
                color: #e0e0e0;
            }

            .rating-bintang i.rated {
                color: #FFD60A !important;
            }
        }
    </style>
    <div class="popular_places_area">
        <div class="container"></div>
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
                    <div class="filter_result_wrap filter-sticky">
                        <h3>Filter</h3>
                        <div class="filter_bordered">
                            <form action="travel_destination.php" method="GET">
                                <div class="filter_inner">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <select class="form-control" name="daerah">
                                                    <option value="">Pilih Daerah</option>
                                                    <option value="Yogyakarta" <?php if ($daerah == 'Yogyakarta')
                                                        echo 'selected'; ?>>Yogyakarta</option>
                                                    <option value="Sleman" <?php if ($daerah == 'Sleman')
                                                        echo 'selected'; ?>>Sleman</option>
                                                    <option value="Bantul" <?php if ($daerah == 'Bantul')
                                                        echo 'selected'; ?>>Bantul</option>
                                                    <option value="Gunung Kidul" <?php if ($daerah == 'Gunung Kidul')
                                                        echo 'selected'; ?>>Gunung Kidul</option>
                                                    <option value="Kulon Progo" <?php if ($daerah == 'Kulon Progo')
                                                        echo 'selected'; ?>>Kulon Progo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <select class="form-control" name="paket">
                                                    <option value="">Pilih Paket</option>
                                                    <option value="VIP" <?php if ($paket == 'VIP')
                                                        echo 'selected'; ?>>VIP
                                                    </option>
                                                    <option value="Regular" <?php if ($paket == 'Regular')
                                                        echo 'selected'; ?>>Regular</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="range_slider_wrap">
                                                <label class="mb-3">Rentang Harga</label>
                                                <div id="price-slider" class="mb-4"></div>
                                                <div class="d-flex justify-content-between">
                                                    <input type="text" name="harga_min" id="harga_min_input"
                                                        class="form-control mr-2" style="width: 48%;" placeholder="Min">
                                                    <input type="text" name="harga_max" id="harga_max_input"
                                                        class="form-control" style="width: 48%;" placeholder="Max">
                                                </div>
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
                        if (!empty($destinations_data)) {
                            foreach ($destinations_data as $row) {
                                $destination_id = $row['id'];

                                $img_sql = "SELECT path FROM detail_image WHERE destinations_id = ?";
                                $img_stmt = $main_conn->prepare($img_sql);
                                $img_stmt->bind_param("i", $destination_id);
                                $img_stmt->execute();
                                $img_stmt->bind_result($gallery_image_path);

                                $images = [];
                                while ($img_stmt->fetch()) {
                                    $images[] = $gallery_image_path;
                                }
                                $img_stmt->close();
                                ?>
                                <div class="col-lg-6 col-md-6">
                                    <div class="single_place">
                                        <div class="thumb">
                                            <img src="<?php echo htmlspecialchars($row['image_path']); ?>"
                                                alt="<?php echo htmlspecialchars($row['name']); ?>">
                                            <span
                                                class="prise">Rp<?php echo number_format($row['price'], 0, ',', '.'); ?></span>
                                            <?php if ($row['package_type'] == 'VIP'): ?>
                                                <span class="kelas">VIP</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="place_info">
                                            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                                            <p><?php echo htmlspecialchars($row['location']); ?></p>
                                            <?php
                                            $sql_rating = "SELECT AVG(rating) as avg_rating, COUNT(rating) as total_reviews FROM reviews WHERE destination_id = ?";
                                            $stmt_rating = $main_conn->prepare($sql_rating);
                                            $stmt_rating->bind_param("i", $destination_id); // $destination_id sudah ada dari kode Anda sebelumnya
                                            $stmt_rating->execute();
                                            $rating_result = $stmt_rating->get_result()->fetch_assoc();

                                            $avg_rating = round($rating_result['avg_rating'] ?? 0);
                                            $total_reviews = $rating_result['total_reviews'] ?? 0;
                                            $stmt_rating->close();
                                            ?>
                                            <div class="rating_days d-flex justify-content-between">
                                                <span class="d-flex justify-content-center align-items-center rating-bintang">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i class="fa fa-star<?php if ($i <= $avg_rating)
                                                            echo ' rated'; ?>"></i>
                                                    <?php endfor; ?>
                                                    <a href="#">(<?php echo $total_reviews; ?> Ulasan)</a>
                                                </span>
                                            </div>
                                            <a class="lihat-lebih-btn text-primary" style="cursor: pointer;">Lihat lebih</a>
                                            <div class="extra-detail d-none mt-2">
                                                <p><strong>Deskripsi:</strong>
                                                    <?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                                                <p><strong>Alamat:</strong> <a
                                                        href="<?php echo htmlspecialchars($row['link']); ?>"
                                                        target="_blank"><?php echo htmlspecialchars($row['location']); ?></a>
                                                </p>
                                                <?php
                                                $img_sql = "SELECT path FROM detail_image WHERE destinations_id = ?";
                                                $img_stmt = $main_conn->prepare($img_sql);
                                                $img_stmt->bind_param("i", $destination_id);
                                                $img_stmt->execute();
                                                $img_result = $img_stmt->get_result();
                                                $images = [];
                                                while ($img_row = $img_result->fetch_assoc()) {
                                                    $images[] = $img_row['path'];
                                                }
                                                $img_stmt->close();
                                                ?>
                                                <?php if (!empty($images)): ?>
                                                    <p><strong>Galeri:</strong></p>
                                                    <div class="image-slider">
                                                        <?php foreach ($images as $i => $img): ?>
                                                            <img src="<?php echo htmlspecialchars($img); ?>"
                                                                alt="Foto <?php echo htmlspecialchars($row['name']) . ' ' . ($i + 1); ?>"
                                                                class="slider-image"
                                                                style="width:100%; height:auto; display:<?php echo $i === 0 ? 'block' : 'none'; ?>;">
                                                        <?php endforeach; ?>
                                                        <?php if (count($images) > 1): ?>
                                                            <div class="slider-controls mt-2 text-center">
                                                                <button type="button" class="prev-slide btn btn-sm btn-dark">‹</button>
                                                                <button type="button" class="next-slide btn btn-sm btn-dark">›</button>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($images)): ?>
                                                <?php endif; ?>

                                                <hr>
                                                <p><strong>Ulasan Pengguna:</strong></p>
                                                <?php
                                                $sql_all_reviews = "SELECT r.rating, r.comment, u.first_name, u.last_name 
                                                FROM reviews r 
                                                JOIN users u ON r.user_id = u.id 
                                                WHERE r.destination_id = ? 
                                                ORDER BY r.created_at DESC";
                                                $stmt_all_reviews = $main_conn->prepare($sql_all_reviews);
                                                $stmt_all_reviews->bind_param("i", $destination_id);
                                                $stmt_all_reviews->execute();
                                                $all_reviews_result = $stmt_all_reviews->get_result();

                                                if ($all_reviews_result->num_rows > 0) {
                                                    while ($review_row = $all_reviews_result->fetch_assoc()) {
                                                        echo '<div class="single-review mb-3" style="border-bottom: 1px solid #eee; padding-bottom: 10px;">';
                                                        echo '<strong>' . htmlspecialchars($review_row['first_name'] . ' ' . $review_row['last_name']) . '</strong>';
                                                        echo '<div class="rating-bintang">';
                                                        for ($j = 1; $j <= 5; $j++) {
                                                            echo '<i class="fa fa-star' . ($j <= $review_row['rating'] ? ' rated' : '') . '"></i>';
                                                        }
                                                        echo '</div>';
                                                        echo '<p class="m-0" style="font-style: italic;">"' . htmlspecialchars($review_row['comment']) . '"</p>';
                                                        echo '</div>';
                                                    }
                                                } else {
                                                    echo '<p>Belum ada ulasan untuk destinasi ini.</p>';
                                                }
                                                $stmt_all_reviews->close();
                                                ?>
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

    <?php include 'footer.php'; ?>

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
    <!-- <script src="js/main.js"></script>  -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.css">

    <script>
        $(document).ready(function () {
            function formatNumber(num) {
                return new Intl.NumberFormat('id-ID').format(num);
            }

            function unformatNumber(str) {
                if (!str) return 0;
                return parseInt(String(str).replace(/\./g, '')) || 0;
            }

            var priceSlider = document.getElementById('price-slider');
            var minPriceInput = document.getElementById('harga_min_input');
            var maxPriceInput = document.getElementById('harga_max_input');

            if (priceSlider) {
                noUiSlider.create(priceSlider, {
                    start: [<?php echo $harga_min; ?>, <?php echo $harga_max; ?>],
                    connect: true,
                    step: 5000,
                    range: { 'min': 0, 'max': 1000000 },
                    format: {
                        to: function (value) { return parseInt(value); },
                        from: function (value) { return parseInt(value); }
                    }
                });

                minPriceInput.value = formatNumber(<?php echo $harga_min; ?>);
                maxPriceInput.value = formatNumber(<?php echo $harga_max; ?>);

                priceSlider.noUiSlider.on('update', function (values, handle) {
                    if (handle === 0) {
                        minPriceInput.value = formatNumber(values[0]);
                    } else {
                        maxPriceInput.value = formatNumber(values[1]);
                    }
                });

                minPriceInput.addEventListener('change', function () {
                    var unformattedValue = unformatNumber(this.value);
                    this.value = formatNumber(unformattedValue);
                    priceSlider.noUiSlider.set([unformattedValue, null]);
                });

                maxPriceInput.addEventListener('change', function () {
                    var unformattedValue = unformatNumber(this.value);
                    this.value = formatNumber(unformattedValue);
                    priceSlider.noUiSlider.set([null, unformattedValue]);
                });

                const form = document.querySelector('.filter_bordered form');
                form.addEventListener('submit', function (e) {
                    minPriceInput.value = unformatNumber(minPriceInput.value);
                    maxPriceInput.value = unformatNumber(maxPriceInput.value);
                });
            }

            $('.col-lg-8').on('click', '.lihat-lebih-btn', function (e) {
                e.preventDefault();
                var detailDiv = $(this).closest('.place_info').find('.extra-detail');
                detailDiv.toggleClass('d-none');
                $(this).text(detailDiv.hasClass('d-none') ? 'Lihat lebih' : 'Sembunyikan');
            });

            $('.col-lg-8').on('click', '.prev-slide, .next-slide', function () {
                var slider = $(this).closest('.image-slider');
                var images = slider.find('.slider-image');
                var currentIndex = images.filter(':visible').index();
                var newIndex = $(this).hasClass('prev-slide')
                    ? (currentIndex - 1 + images.length) % images.length
                    : (currentIndex + 1) % images.length;
                images.hide().eq(newIndex).show();
            });
        });
    </script>
</body>

</html>