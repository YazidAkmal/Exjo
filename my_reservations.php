<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';
include 'header.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT id, package_name, booking_date, status, destination_id 
        FROM bookings 
        WHERE user_id = ? 
        ORDER BY booking_date DESC";

$stmt = $main_conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $main_conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Bradcam (Judul Halaman) -->
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

<!-- Konten Utama -->
<div class="whole-wrap">
    <div class="container box_1170">
        <div class="section-top-border">

            <!-- Notifikasi setelah submit ulasan -->
            <?php if(isset($_GET['review_status']) && $_GET['review_status'] == 'success'): ?>
                <div class="alert alert-success">Terima kasih! Ulasan Anda berhasil dikirim.</div>
            <?php elseif(isset($_GET['review_status']) && $_GET['review_status'] == 'error'): ?>
                <div class="alert alert-danger">Gagal mengirim ulasan. Silakan coba lagi.</div>
            <?php elseif(isset($_GET['review_status']) && $_GET['review_status'] == 'exists'): ?>
                 <div class="alert alert-warning">Anda sudah pernah memberikan ulasan untuk pesanan ini.</div>
            <?php endif; ?>

            <h3 class="mb-30">Riwayat Reservasi</h3>
            <div class="progress-table-wrap">
                <div class="progress-table">
                    <div class="table-head">
                        <div class="serial">Paket Perjalanan</div>
                        <div class="visit">Tanggal Pesan</div>
                        <div class="percentage">Bulan</div>
                        <div class="visit">Status</div>
                        <div class="visit">Aksi</div>
                    </div>

                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="table-row">
                                <div class="serial"><?php echo htmlspecialchars($row['package_name']); ?></div>
                                <div class="visit"><?php echo date('d M Y', strtotime($row['booking_date'])); ?></div>
                                <div class="percentage"><?php echo htmlspecialchars($row['booking_month']); ?></div>
                                <div class="visit">
                                    <?php
                                        $status = htmlspecialchars($row['status']);
                                        $badge_class = 'secondary';
                                        if ($status == 'Accepted') $badge_class = 'success';
                                        elseif ($status == 'Pending') $badge_class = 'warning';
                                        elseif ($status == 'Rejected') $badge_class = 'danger';
                                    ?>
                                    <span class="badge badge-<?php echo $badge_class; ?> p-2"><?php echo $status; ?></span>
                                </div>
                                <div class="visit">
                                    <?php if ($status == 'Accepted'): ?>
                                        <button class="genric-btn primary-border circle small review-btn" 
                                                data-toggle="modal" 
                                                data-target="#reviewModal" 
                                                data-booking-id="<?php echo $row['id']; ?>"
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

<!-- Modal untuk Memberi Ulasan -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
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
                    <input type="radio" id="star5" name="rating" value="5" required/><label for="star5" title="Luar Biasa"></label>
                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Bagus"></label>
                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Cukup"></label>
                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Kurang"></label>
                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Buruk"></label>
                </div>
            </div>
            <div class="form-group">
                <label for="comment">Komentar Anda</label>
                <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Bagaimana pengalaman perjalanan Anda?" required></textarea>
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
.rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-start;
    margin-left: -5px;
}

.rating > input {
    display: none;
}

.rating > label {
    position: relative;
    width: 2em;
    font-size: 2rem; 
    color: #FFD60A;
    cursor: pointer;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

.rating > label::before {
    content: '\f005'; 
    font-family: 'FontAwesome';
    font-style: normal;
    font-weight: normal;
    position: absolute;
    opacity: 0.4;
}

.rating > label:hover:before,
.rating > label:hover ~ label:before,
.rating > input:checked ~ label:before {
    opacity: 1 !important; 
}
</style>

<?php
$stmt->close();
$main_conn->close();
include 'footer.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var reviewButtons = document.querySelectorAll('.review-btn');
    reviewButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var bookingId = this.getAttribute('data-booking-id');
            var destinationId = this.getAttribute('data-destination-id');
            
            document.getElementById('modal_booking_id').value = bookingId;
            document.getElementById('modal_destination_id').value = destinationId;
        });
    });
});
</script>
