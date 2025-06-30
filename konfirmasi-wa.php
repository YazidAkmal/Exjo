<?php
include 'init.php';
include 'database.php';

if (!isset($_GET['booking_id'])) {
    header("Location: reservasi.php");
    exit();
}

$booking_id = (int)$_GET['booking_id'];

$stmt = $main_conn->prepare(
    "SELECT b.id, d.name as destination_name, u.first_name, u.last_name, b.booking_date, b.total_price, b.notes 
     FROM bookings b 
     JOIN users u ON b.user_id = u.id 
     JOIN destinations d ON b.destination_id = d.id 
     WHERE b.id = ?"
);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$stmt->bind_result($id, $destination_name, $first_name, $last_name, $booking_date, $total_price, $notes);
$stmt->fetch();
$stmt->close();

if (!$id) {
    header("Location: index.php");
    exit();
}

$nomor_wa_admin = "6281252700168"; 
$nama_pelanggan = $first_name . ' ' . $last_name;

$pesan_wa = "Halo Admin EXJO,\n\n";
$pesan_wa .= "Saya ingin melakukan konfirmasi untuk reservasi wisata berikut:\n\n";
$pesan_wa .= "ID Pesanan: #BK" . $id . "\n";
$pesan_wa .= "Nama: " . $nama_pelanggan . "\n";
$pesan_wa .= "Destinasi: " . $destination_name . "\n";
$pesan_wa .= "Tanggal: " . $booking_date . "\n";
$pesan_wa .= "Total Harga: Rp " . number_format($total_price, 0, ',', '.') . "\n";
if (!empty($notes)) {
    $pesan_wa .= "Catatan: " . $notes . "\n";
}
$pesan_wa .= "\nMohon informasikan langkah selanjutnya untuk pembayaran. Terima kasih.";

$wa_url = "https://api.whatsapp.com/send?phone=" . $nomor_wa_admin . "&text=" . urlencode($pesan_wa);

include 'header.php';
?>

<div class="container" style="padding: 100px 0;">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div style="border: 1px solid #ddd; padding: 40px; border-radius: 10px; background: #fff;">
                <i class="fa fa-check-circle" style="font-size: 80px; color: #28a745;"></i>
                <h2 class="mt-4" style="font-weight: 700;">Reservasi Berhasil Dicatat!</h2>
                <p class="lead" style="color: #555;">
                    Pesanan Anda dengan ID <strong>#BK<?php echo $id; ?></strong> telah kami simpan.
                </p>
                <p>
                    Silakan tekan tombol di bawah ini untuk mengirim detail pesanan ke admin via WhatsApp dan melihat status pesanan Anda.
                </p>
                <hr>
                <a href="<?php echo htmlspecialchars($wa_url); ?>" id="konfirmasi-btn" class="button button-contactForm boxed-btn">
                    Konfirmasi ke WhatsApp & Lihat Pesanan
                </a>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const konfirmasiBtn = document.getElementById('konfirmasi-btn');

    if (konfirmasiBtn) {
        konfirmasiBtn.addEventListener('click', function(e) {
            e.preventDefault();

            const whatsappUrl = this.href;
            const myReservationsUrl = 'my_reservations.php';

            window.open(whatsappUrl, '_blank');

            setTimeout(function() {
                window.location.href = myReservationsUrl;
            }, 300);
        });
    }
});
</script>