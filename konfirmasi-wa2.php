<?php
include 'init.php';
include 'database.php';

// Pastikan ada booking_id di URL
if (!isset($_GET['booking_id'])) {
    header("Location: reservasi.php");
    exit();
}

$booking_id = (int)$_GET['booking_id'];

// Ambil semua data yang relevan dari database
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

// Siapkan pesan untuk WhatsApp
$nomor_wa_admin = "6281252700168"; // GANTI DENGAN NOMOR WA ANDA
$nama_pelanggan = $first_name . ' ' . $last_name;
$pesan_wa = "Halo Admin EXJO,\n\nSaya ingin konfirmasi reservasi:\nID: #BK" . $id . "\nNama: " . $nama_pelanggan . "\nDestinasi: " . $destination_name . "\nTanggal: " . $booking_date . "\n\nMohon info pembayaran. Terima kasih.";
$wa_url = "https://api.whatsapp.com/send?phone=" . $nomor_wa_admin . "&text=" . urlencode($pesan_wa);

// Sertakan header halaman
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
                    Langkah selanjutnya adalah konfirmasi pesanan Anda ke admin via WhatsApp. Setelah itu, Anda bisa melihat status pesanan di halaman "Pesanan Saya".
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
// Sertakan footer halaman
include 'footer.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const konfirmasiBtn = document.getElementById('konfirmasi-btn');

    konfirmasiBtn.addEventListener('click', function(e) {
        // 1. Mencegah link langsung berjalan
        e.preventDefault();

        // 2. Ambil URL tujuan dari tombol
        const whatsappUrl = this.href;
        const myReservationsUrl = 'my_reservations.php';

        // 3. Buka WhatsApp di tab baru
        window.open(whatsappUrl, '_blank');

        // 4. Setelah jeda singkat, arahkan tab saat ini ke halaman "Pesanan Saya"
        // Ini memberi waktu bagi browser untuk membuka tab baru
        setTimeout(function() {
            window.location.href = myReservationsUrl;
        }, 300); // Jeda 0.3 detik
    });
});
</script>