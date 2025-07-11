<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';
include 'header.php';

$user_id = $_SESSION['user_id'];
$sql_bookings = "SELECT id, booking_date, num_people, total_price, status FROM bookings WHERE user_id = ? ORDER BY id DESC";
$stmt_bookings = $main_conn->prepare($sql_bookings);
$stmt_bookings->bind_param("i", $user_id);
$stmt_bookings->execute();
$bookings_result = $stmt_bookings->get_result();
?>

<div class="bradcam_area bradcam_bg_4">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text text-center">
                    <h3>Reservasi Saya</h3>
                    <p>Lihat riwayat perjalanan dan berikan ulasan Anda</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="whole-wrap">
    <div class="container box_1170">
        <div class="section-top-border">
            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-info text-center">' . htmlspecialchars($_SESSION['message']) . '</div>';
                unset($_SESSION['message']);
            }
            ?>
            <?php if (isset($_GET['review_status'])): ?>
                <div class="alert alert-<?php echo $_GET['review_status'] == 'success' ? 'success' : 'danger'; ?>"
                    role="alert">
                    <?php
                    if ($_GET['review_status'] == 'success')
                        echo 'Terima kasih! Ulasan Anda berhasil dikirim.';
                    elseif ($_GET['review_status'] == 'exists')
                        echo 'Anda sudah pernah memberikan ulasan untuk destinasi ini.';
                    else
                        echo 'Gagal mengirim ulasan. Silakan coba lagi.';
                    ?>
                </div>
            <?php endif; ?>

            <h3 class="mb-30">Riwayat Reservasi</h3>
            <div class="riwayat-tabel-wrapper">
                <div class="tabel-header">
                    <div class="kolom-destinasi">Destinasi & Detail Pesanan</div>
                    <div class="kolom-lain">Tanggal</div>
                    <div class="kolom-lain">Status</div>
                    <div class="kolom-lain">Aksi</div>
                </div>
                <div class="tabel-body">
                    <?php if ($bookings_result->num_rows > 0): ?>
                        <?php while ($booking = $bookings_result->fetch_assoc()): ?>
                            <div class="tabel-baris">
                                <div class="kolom-destinasi">
                                    <ul class="list-unstyled m-0 p-0">
                                        <?php
                                        $sql_items = "SELECT d.name FROM booking_items bi JOIN destinations d ON bi.destination_id = d.id WHERE bi.booking_id = ?";
                                        $stmt_items = $main_conn->prepare($sql_items);
                                        $stmt_items->bind_param("i", $booking['id']);
                                        $stmt_items->execute();
                                        $items_result = $stmt_items->get_result();
                                        while ($item = $items_result->fetch_assoc()) {
                                            echo '<li><i class="fa fa-map-marker" style="color:#1EC6B6; margin-right: 5px;"></i>' . htmlspecialchars($item['name']) . '</li>';
                                        }
                                        $stmt_items->close();
                                        ?>
                                    </ul>
                                    <small class="text-muted d-block mt-2">
                                        Jumlah: <?php echo htmlspecialchars($booking['num_people']); ?> orang | Total: Rp
                                        <?php echo number_format($booking['total_price'], 0, ',', '.'); ?>
                                    </small>
                                    <?php
                                    $sql_reviews = "SELECT r.rating, r.comment, d.name as destination_name FROM reviews r JOIN destinations d ON r.destination_id = d.id WHERE r.booking_id = ?";
                                    $stmt_reviews = $main_conn->prepare($sql_reviews);
                                    $stmt_reviews->bind_param("i", $booking['id']);
                                    $stmt_reviews->execute();
                                    $reviews_result = $stmt_reviews->get_result();
                                    if ($reviews_result->num_rows > 0) {
                                        echo '<div class="ulasan-pengguna mt-3" style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; border-left: 3px solid #1EC6B6;">';
                                        echo '<strong style="font-size: 14px;">Ulasan Anda:</strong>';
                                        echo '<ul class="list-unstyled ml-2 mt-2 mb-0">';
                                        while ($review = $reviews_result->fetch_assoc()) {
                                            echo '<li class="mb-2">';
                                            echo '<em>' . htmlspecialchars($review['destination_name']) . '</em><br>';
                                            for ($i = 0; $i < 5; $i++) {
                                                echo '<i class="fa fa-star" style="color:' . ($i < $review['rating'] ? '#FFD60A' : '#e0e0e0') . '; font-size: 12px;"></i>';
                                            }
                                            echo '<p class="m-0" style="font-style: italic; font-size: 14px;">"' . htmlspecialchars($review['comment']) . '"</p>';
                                            echo '</li>';
                                        }
                                        echo '</ul></div>';
                                    }
                                    $stmt_reviews->close();
                                    ?>
                                </div>
                                <div class="kolom-lain"><?php echo date('d M Y', strtotime($booking['booking_date'])); ?></div>
                                <div class="kolom-lain">
                                    <?php
                                    $status_db = htmlspecialchars($booking['status']);
                                    $badge_class = 'secondary';
                                    if ($status_db == 'Terima') {
                                        $badge_class = 'success';
                                    } elseif ($status_db == 'Tolak' || $status_db == 'Dibatalkan') {
                                        $badge_class = 'danger';
                                    } elseif ($status_db == 'Menunggu Konfirmasi WA') {
                                        $badge_class = 'warning';
                                    }
                                    ?>
                                    <span class="badge badge-<?php echo $badge_class; ?> p-2"><?php echo $status_db; ?></span>
                                </div>
                                <div class="kolom-lain">
                                    <?php if ($booking['status'] == 'Terima'): ?>
                                        <?php
                                        $items_for_js = [];
                                        $sql_items_js = "SELECT d.id, d.name FROM booking_items bi JOIN destinations d ON bi.destination_id = d.id WHERE bi.booking_id = ?";
                                        $stmt_items_js = $main_conn->prepare($sql_items_js);
                                        $stmt_items_js->bind_param("i", $booking['id']);
                                        $stmt_items_js->execute();
                                        $items_result_js = $stmt_items_js->get_result();
                                        while ($item_js = $items_result_js->fetch_assoc()) {
                                            $items_for_js[] = $item_js;
                                        }
                                        $stmt_items_js->close();
                                        ?>
                                        <button class="genric-btn primary-border circle small review-btn" data-toggle="modal"
                                            data-target="#reviewModal" data-booking-id="<?php echo $booking['id']; ?>"
                                            data-destinations='<?php echo htmlspecialchars(json_encode($items_for_js), ENT_QUOTES, 'UTF-8'); ?>'>
                                            Beri Ulasan
                                        </button>
                                    <?php elseif ($booking['status'] == 'Menunggu Konfirmasi WA'): ?>
                                        <a href="#" data-url="batal_reservasi.php?id=<?php echo $booking['id']; ?>"
                                            class="genric-btn danger-border circle small cancel-btn">
                                            Batalkan
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center p-5">
                            <p>Anda belum memiliki riwayat reservasi.</p>
                            <a href="reservasi.php" class="genric-btn primary">Pesan Perjalanan Sekarang</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="submit_review.php" method="POST" id="reviewForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Beri Ulasan untuk Pesanan #<span
                            id="modalBookingIdSpan"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="modal_booking_id">
                    <div class="form-group">
                        <label for="destination_id">Pilih Destinasi yang Akan Diulas</label>
                        <select name="destination_id" id="destination_id" class="form-control wide" required></select>
                    </div>
                    <div class="form-group">
                        <label>Rating</label>
                        <div class="rating">
                            <input type="radio" id="star5" name="rating" value="5" required /><label for="star5"
                                title="Luar Biasa"></label>
                            <input type="radio" id="star4" name="rating" value="4" /><label for="star4"
                                title="Bagus"></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3"
                                title="Cukup"></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2"
                                title="Kurang"></label>
                            <input type="radio" id="star1" name="rating" value="1" /><label for="star1"
                                title="Buruk"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment">Komentar Anda</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4"
                            placeholder="Bagaimana pengalaman perjalanan Anda?" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .riwayat-tabel-wrapper {
        border: 1px solid #f0f0f0;
        border-radius: 5px;
        overflow: hidden;
    }

    .tabel-header,
    .tabel-baris {
        display: grid;
        grid-template-columns: 3fr 1.5fr 1.5fr 1.5fr;
        width: 100%;
        align-items: center;
    }

    .tabel-header {
        background-color: #f9f9ff;
        color: #000D2D;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 14px;
    }

    .tabel-baris {
        border-top: 1px solid #f0f0f0;
    }

    .tabel-header>div,
    .tabel-baris>div {
        padding: 20px 15px;
        text-align: center;
    }

    .tabel-header .kolom-destinasi,
    .tabel-baris .kolom-destinasi {
        text-align: left;
    }

    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-start;
    }

    .rating>input {
        display: none;
    }

    .rating>label {
        position: relative;
        width: 1.5em;
        font-size: 2rem;
        cursor: pointer;
    }

    .rating>label::before {
        content: '\f005';
        font-family: 'FontAwesome';
        font-style: normal;
        font-weight: normal;
        position: absolute;
        color: #e0e0e0;
        transition: color 0.2s;
    }

    .rating>label:hover::before,
    .rating>label:hover~label::before,
    .rating>input:checked~label::before {
        color: #FFD60A;
    }

    @media (max-width: 767px) {
        .riwayat-tabel-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .tabel-header,
        .tabel-baris {
            min-width: 600px;
            grid-template-columns: 200px 120px 140px 120px;
        }

        .tabel-header .kolom-destinasi,
        .tabel-baris .kolom-destinasi {
            width: 200px;
        }
    }
</style>

<?php
$stmt_bookings->close();
$main_conn->close();
include 'footer.php';
?>

<script>
    jQuery(document).ready(function ($) {
        if ($('#destination_id').data('niceSelect')) {
            $('#destination_id').niceSelect('destroy');
        }
        $('#destination_id').niceSelect();

        $('.review-btn').on('click', function () {
            var bookingId = $(this).data('booking-id');
            var destinations = $(this).data('destinations');
            $('#modal_booking_id').val(bookingId);
            $('#modalBookingIdSpan').text(bookingId);
            var destinationSelect = $('#destination_id');
            destinationSelect.empty();
            if (destinations && destinations.length > 0) {
                destinations.forEach(function (dest) {
                    destinationSelect.append(new Option(dest.name, dest.id));
                });
            } else {
                destinationSelect.append(new Option('Tidak ada destinasi', ''));
            }
            destinationSelect.niceSelect('update');
        });

        $('.cancel-btn').on('click', function (event) {
            event.preventDefault();
            var cancelUrl = $(this).data('url');
            Swal.fire({
                title: 'Anda Yakin?',
                text: "Pesanan yang sudah dibatalkan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = cancelUrl;
                }
            });
        });

        $('#reviewForm').on('submit', function (event) {
            event.preventDefault();
            var form = this;
            if (!form.checkValidity()) {
                Swal.fire({
                    title: 'Form Tidak Lengkap',
                    text: 'Harap isi semua kolom (Pilih Destinasi, beri Rating, dan tulis Komentar).',
                    icon: 'error',
                    confirmButtonColor: '#1EC6B6'
                });
                return;
            }
            Swal.fire({
                title: 'Kirim Ulasan Anda?',
                text: "Ulasan yang sudah dikirim tidak dapat diubah.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1EC6B6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    HTMLFormElement.prototype.submit.call(form);
                }
            });
        });

        if (window.location.search.includes('review_status')) {
            var clean_uri = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.replaceState({}, document.title, clean_uri);
        }
    });
</script>