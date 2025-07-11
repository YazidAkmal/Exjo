<?php
include 'init.php';

if (!isset($_SESSION['whatsapp_url'])) {
    header("Location: index.php");
    exit();
}

$whatsapp_url = $_SESSION['whatsapp_url'];
unset($_SESSION['whatsapp_url']);

include 'header.php';
?>

<div class="bradcam_area bradcam_bg_5">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text text-center">
                    <h3>Reservasi Berhasil Disimpan!</h3>
                    <p>Satu langkah lagi untuk konfirmasi via WhatsApp.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="contact-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div
                    style="background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    <i class="fa fa-check-circle" style="font-size: 80px; color: #28a745;"></i>
                    <h2 class="booking-title mt-4">Terima Kasih!</h2>
                    <p class="mb-4">Reservasi Anda dengan ID Pesanan
                        <strong>#BK<?php echo isset($_GET['booking_id']) ? htmlspecialchars($_GET['booking_id']) : ''; ?></strong>
                        telah berhasil kami simpan.</p>
                    <p>Klik tombol di bawah ini untuk pembayaran pesanan Anda ke admin kami melalui WhatsApp.</p>
                    <a id="whatsapp-redirect-button" href="<?php echo htmlspecialchars($whatsapp_url); ?>"
                        class="button button-contactForm boxed-btn mt-3" target="_blank">Lanjut ke WhatsApp</a>
                    <p class="mt-3"><a href="my_reservations.php">Lihat Semua Reservasi Saya</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>

<script>
    $(document).ready(function () {
        setTimeout(function () {
            var waButton = document.getElementById('whatsapp-redirect-button');
            if (waButton) {
            }
        }, 3000);
    });
</script>