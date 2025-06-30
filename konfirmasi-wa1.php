<?php
include 'init.php';
include 'database.php';

// Pastikan ada booking_id di URL
if (!isset($_GET['booking_id'])) {
    header("Location: reservasi.php");
    exit();
}

$booking_id = (int) $_GET['booking_id'];

// Ambil semua data yang relevan dari database untuk pesan WhatsApp
$stmt = $main_conn->prepare(
    "SELECT b.id, d.name as destination_name, u.first_name, u.last_name, b.booking_date, b.total_price, b.notes 
     FROM bookings b 
     JOIN users u ON b.user_id = u.id 
     JOIN destinations d ON b.destination_id = d.id 
     WHERE b.id = ?"
);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
// Gunakan metode yang kompatibel untuk mengambil data
$stmt->bind_result($id, $destination_name, $first_name, $last_name, $booking_date, $total_price, $notes);
$stmt->fetch();
$stmt->close();

if (!$id) { // Cek apakah data ditemukan
    // Jika booking tidak ditemukan, kembalikan ke halaman utama
    header("Location: index.php");
    exit();
}

// Siapkan pesan untuk WhatsApp
$nomor_wa_admin = "6281252700168"; // <-- GANTI DENGAN NOMOR WA ANDA
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

// Buat URL WhatsApp
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
                <p class="lead" style="color: #555;">Anda akan diarahkan ke WhatsApp untuk konfirmasi dalam <span
                        id="countdown">5</span> detik...</p>
                <p>Jika Anda tidak diarahkan secara otomatis, silakan klik tombol di bawah ini.</p>
                <hr>
                <a href="<?php echo htmlspecialchars($wa_url); ?>" id="whatsapp-btn"
                    class="button button-contactForm boxed-btn">
                    Lanjutkan ke WhatsApp & Lihat Pesanan Saya
                </a>

                <script>
                    document.getElementById('whatsapp-btn').addEventListener('click', function (e) {
                        // 1. Mencegah link langsung berjalan agar kita bisa mengontrolnya
                        e.preventDefault();

                        // 2. Simpan URL WhatsApp dan URL halaman "Pesanan Saya"
                        const whatsappUrl = this.href;
                        const myReservationsUrl = 'my_reservations.php';

                        // 3. Buka WhatsApp di tab baru
                        window.open(whatsappUrl, '_blank');

                        // 4. Setelah jeda singkat, arahkan tab saat ini ke "Pesanan Saya"
                        setTimeout(function () {
                            window.location.href = myReservationsUrl;
                        }, 500); // Jeda 0.5 detik
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<script>
    // Skrip untuk countdown dan redirect otomatis
    (function () {
        let timeLeft = 5;
        const countdownElement = document.getElementById('countdown');
        const waUrl = "<?php echo $wa_url; ?>";

        const interval = setInterval(() => {
            timeLeft--;
            if (countdownElement) {
                countdownElement.textContent = timeLeft;
            }

            if (timeLeft <= 0) {
                clearInterval(interval);
                window.location.href = waUrl;
            }
        }, 1000);
    })();
</script>

<?php
// Sertakan footer halaman
include 'footer.php';
?>