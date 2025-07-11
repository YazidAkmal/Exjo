<?php
include 'init.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'header.php';
include 'database.php';

$destinations = [];
$dest_result = $main_conn->query("SELECT id, name, price, image_path, location FROM destinations ORDER BY location, name ASC");
if ($dest_result) {
    while ($row = $dest_result->fetch_assoc()) {
        $destinations[] = $row;
    }
}
$locations = array_unique(array_column($destinations, 'location'));
sort($locations);
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" />

<div class="bradcam_area bradcam_bg_5">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text text-center">
                    <h3>Reservasi Paket Wisata</h3>
                    <p>Pilih tanggal dan destinasi yang Anda inginkan.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="contact-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form action="booking_process.php" method="POST" class="form-contact contact_form"
                    style="background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    <h2 class="booking-title text-center mb-5">Formulir Reservasi</h2>

                    <fieldset class="mb-5">
                        <legend class="mb-3 h4">Langkah 1: Tentukan Jadwal & Jumlah Orang</legend>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group"><label for="booking_date">Tanggal Kunjungan</label><input
                                        type="text" name="booking_date" id="booking_date" class="form-control"
                                        placeholder="Pilih Tanggal..." required></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group"><label for="num_people">Jumlah Orang</label><input type="number"
                                        name="num_people" id="num_people" class="form-control"
                                        placeholder="max 50 orang" min="1" max="50" value="1" required></div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="mb-3 h4">Langkah 2: Pilih Destinasi</legend>
                        <div class="form-group mb-4">
                            <label for="location-filter">Filter berdasarkan Lokasi</label>
                            <select id="location-filter" class="form-control wide">
                                <option value="">Tampilkan Semua Lokasi</option>
                                <?php foreach ($locations as $loc): ?>
                                    <option value="<?php echo htmlspecialchars($loc); ?>">
                                        <?php echo htmlspecialchars($loc); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="destination-list"
                            style="max-height: 400px; overflow-y: auto; border: 1px solid #eee; padding: 15px; border-radius: 5px;">
                            <?php if (!empty($destinations)): ?>
                                <?php foreach ($destinations as $dest): ?>
                                    <div class="form-check destination-item mb-2"
                                        data-location="<?php echo htmlspecialchars($dest['location']); ?>">
                                        <input class="form-check-input destination-checkbox" type="checkbox"
                                            name="destination_ids[]" value="<?php echo $dest['id']; ?>"
                                            data-price="<?php echo $dest['price']; ?>" id="dest-<?php echo $dest['id']; ?>">
                                        <label class="form-check-label" for="dest-<?php echo $dest['id']; ?>">
                                            <?php echo htmlspecialchars($dest['name']); ?> - <span
                                                class="text-success font-weight-bold">Rp
                                                <?php echo number_format($dest['price'], 0, ',', '.'); ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center">Tidak ada destinasi yang tersedia saat ini.</p>
                            <?php endif; ?>
                        </div>
                    </fieldset>

                    <hr class="my-4">
                    <div class="text-right">
                        <h3>Total Biaya: <span id="total-price" style="color: #1EC6B6;">Rp 0</span></h3>
                    </div>
                    <div class="form-group mt-4 text-center">
                        <button type="submit" class="button button-contactForm boxed-btn">Kirim Reservasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
<script>
    $(document).ready(function () {
        flatpickr("#booking_date", { dateFormat: "Y-m-d", minDate: "today" });
        $('#location-filter').niceSelect();

        function calculateTotal() {
            let pricePerPerson = 0;
            $('.destination-checkbox:checked').each(function () { pricePerPerson += parseFloat($(this).data('price')); });
            let numPeople = parseInt($('#num_people').val()) || 1;
            let finalTotal = pricePerPerson * numPeople;
            $('#total-price').text('Rp ' + finalTotal.toLocaleString('id-ID'));
        }

        $(document).on('change keyup', '.destination-checkbox, #num_people', function () { calculateTotal(); });

        $('#location-filter').on('change', function () {
            let selectedLocation = $(this).val();
            if (selectedLocation) {
                $('.destination-item').hide();
                $('.destination-item[data-location="' + selectedLocation + '"]').show();
            } else {
                $('.destination-item').show();
            }
        });

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('status')) {
            if (urlParams.get('status') === 'sukses') {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Reservasi Anda telah kami terima.', confirmButtonColor: '#1EC6B6' });
            } else {
                const error = urlParams.get('error') || 'Terjadi kesalahan.';
                Swal.fire({ icon: 'error', title: 'Gagal', text: decodeURIComponent(error.replace(/\+/g, ' ')), confirmButtonColor: '#1EC6B6' });
            }
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>