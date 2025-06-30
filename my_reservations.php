<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';
include 'header.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            b.id, 
            b.booking_date, 
            b.status, 
            b.destination_id,
            d.name AS destination_name 
        FROM bookings AS b
        JOIN destinations AS d ON b.destination_id = d.id
        WHERE b.user_id = ? 
        ORDER BY b.id DESC";

$stmt = $main_conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $main_conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
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

            <?php if (isset($_GET['review_status']) && $_GET['review_status'] == 'success'): ?>
                <div class="alert alert-success">Terima kasih! Ulasan Anda berhasil dikirim.</div>
            <?php elseif (isset($_GET['review_status']) && $_GET['review_status'] == 'error'): ?>
                <div class="alert alert-danger">Gagal mengirim ulasan. Silakan coba lagi.</div>
            <?php elseif (isset($_GET['review_status']) && $_GET['review_status'] == 'exists'): ?>
                <div class="alert alert-warning">Anda sudah pernah memberikan ulasan untuk pesanan ini.</div>
            <?php endif; ?>

            <h3 class="mb-30">Riwayat Reservasi</h3>

            <div class="riwayat-tabel-wrapper">
                <div class="tabel-header">
                    <div class="kolom-destinasi">Destinasi Perjalanan</div>
                    <div class="kolom-lain">Tanggal Pesan</div>
                    <div class="kolom-lain">Status</div>
                    <div class="kolom-lain">Aksi</div>
                </div>

                <div class="tabel-body">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="tabel-baris">
                                <div class="kolom-destinasi"><?php echo htmlspecialchars($row['destination_name']); ?></div>
                                <div class="kolom-lain"><?php echo date('d M Y', strtotime($row['booking_date'])); ?></div>
                                <div class="kolom-lain">
                                    <?php
                                    $status_db = htmlspecialchars($row['status']);
                                    $badge_class = 'secondary';

                                    $status_display = $status_db;
                                    if ($status_db == 'Terima') {
                                        $status_display = 'Diterima';
                                        $badge_class = 'success';
                                    } elseif ($status_db == 'Tolak') {
                                        $status_display = 'Ditolak';
                                        $badge_class = 'danger';
                                    } elseif ($status_db == 'Menunggu Konfirmasi WA') {
                                        $status_display = 'Menunggu Konfirmasi WA';
                                        $badge_class = 'warning';
                                    }
                                    ?>
                                    <span
                                        class="badge badge-<?php echo $badge_class; ?> p-2"><?php echo $status_display; ?></span>
                                </div>
                                <div class="kolom-lain">
                                    <?php if ($row['status'] == 'Terima'): ?>
                                        <button class="genric-btn primary-border circle small review-btn" data-toggle="modal"
                                            data-target="#reviewModal" data-booking-id="<?php echo $row['id']; ?>"
                                            data-destination-id="<?php echo $row['destination_id']; ?>">
                                            Beri Ulasan
                                        </button>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center p-5">
                            <p>Anda belum memiliki riwayat reservasi.</p>
                            <a href="travel_destination.php" class="genric-btn primary">Pesan Perjalanan Sekarang</a>
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
            <form action="submit_review.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Beri Ulasan Anda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="modal_booking_id">
                    <input type="hidden" name="destination_id" id="modal_destination_id">

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
    /* [PERBAIKAN 3: ATURAN CSS BARU UNTUK LAYOUT YANG RAPI] */
    .riwayat-tabel-wrapper {
        border: 1px solid #f0f0f0;
        border-radius: 5px;
        overflow: hidden;
    }

    .tabel-header,
    .tabel-baris {
        display: grid;
        grid-template-columns: 2.5fr 1.5fr 1.5fr 1.5fr;
        /* 4 kolom: Destinasi, Tanggal, Status, Aksi */
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


    /* Kode CSS untuk rating bintang tidak diubah */
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-start;
        margin-left: -5px;
    }

    .rating>input {
        display: none;
    }

    .rating>label {
        position: relative;
        width: 2em;
        font-size: 2rem;
        color: #FFD60A;
        cursor: pointer;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .rating>label::before {
        content: '\f005';
        font-family: 'FontAwesome';
        font-style: normal;
        font-weight: normal;
        position: absolute;
        opacity: 0.4;
    }

    .rating>label:hover:before,
    .rating>label:hover~label:before,
    .rating>input:checked~label:before {
        opacity: 1 !important;
    }
</style>

<?php
$stmt->close();
$main_conn->close();
include 'footer.php';
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var reviewButtons = document.querySelectorAll('.review-btn');
        reviewButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var bookingId = this.getAttribute('data-booking-id');
                var destinationId = this.getAttribute('data-destination-id');

                document.getElementById('modal_booking_id').value = bookingId;
                document.getElementById('modal_destination_id').value = destinationId;
            });
        });
    });
</script>