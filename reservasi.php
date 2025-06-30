<?php
include 'init.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';

$user_id = $_SESSION['user_id'];
$stmt_user = $main_conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_data = $stmt_user->get_result()->fetch_assoc();
$stmt_user->close();

$locations = [];
$loc_result = $main_conn->query("SELECT DISTINCT location FROM destinations ORDER BY location");
while ($row = $loc_result->fetch_assoc()) {
    $locations[] = $row['location'];
}

include 'header.php';
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
                                <input class="form-control" type="text"
                                    value="Nama: <?= htmlspecialchars($user_data['first_name'] . ' ' . $user_data['last_name'] ?? '') ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <input class="form-control" type="email"
                                    value="Email: <?= htmlspecialchars($user_data['email'] ?? '') ?>" readonly>
                            </div>
                        </div>

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

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <select name="destination_id" id="destinasi" class="form-control wide" required>
                                    <option value="">Pilih Lokasi Dahulu</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <input type="text" name="tanggal_pemesanan" id="tanggal-flatpickr" class="form-control"
                                    placeholder="Pilih Tanggal Pemesanan" required>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <textarea name="catatan" class="form-control" rows="4"
                                    placeholder="Catatan Tambahan (opsional)"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3 text-center">
                        <button type="submit" class="button button-contactForm boxed-btn">Kirim Reservasi</button>
                        <p class="text-center mt-2 text-muted"><small>Setelah menekan tombol, Anda akan diarahkan ke
                                WhatsApp untuk konfirmasi pesanan dengan admin.</small></p>
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