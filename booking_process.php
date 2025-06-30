<?php
require_once 'init.php';
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $destination_id = $_POST['destination_id'];
    $booking_date = $_POST['tanggal_pemesanan'];
    $notes = $_POST['catatan'];
    $status = 'Menunggu Konfirmasi WA'; 

    $stmt_user = $main_conn->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $stmt_user->bind_result($first_name, $last_name);
    $stmt_user->fetch();
    $nama_pelanggan = $first_name . ' ' . $last_name;
    $stmt_user->close();

    $stmt_dest = $main_conn->prepare("SELECT name, price FROM destinations WHERE id = ?");
    $stmt_dest->bind_param("i", $destination_id);
    $stmt_dest->execute();
    $stmt_dest->bind_result($dest_name, $dest_price);
    $stmt_dest->fetch();
    $nama_destinasi = $dest_name;
    $harga = $dest_price;
    $stmt_dest->close();

    $stmt = $main_conn->prepare("INSERT INTO bookings (user_id, destination_id, booking_date, notes, status, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssd", $user_id, $destination_id, $booking_date, $notes, $status, $harga);
    $stmt->execute();
    $booking_id = $main_conn->insert_id; 
    $stmt->close();

    $nomor_wa_admin = "6281252700168"; 

    $pesan_wa = "Halo Admin EXJO,\n\n";
    $pesan_wa .= "Saya ingin melakukan konfirmasi untuk reservasi wisata berikut:\n\n";
    $pesan_wa .= "ID Pesanan: #BK" . $booking_id . "\n";
    $pesan_wa .= "Nama: " . $nama_pelanggan . "\n";
    $pesan_wa .= "Destinasi: " . $nama_destinasi . "\n";
    $pesan_wa .= "Tanggal: " . $booking_date . "\n";
    $pesan_wa .= "Total Harga: Rp " . number_format($harga, 0, ',', '.') . "\n";
    if (!empty($notes)) {
        $pesan_wa .= "Catatan: " . $notes . "\n";
    }
    $pesan_wa .= "\nMohon informasikan langkah selanjutnya untuk pembayaran. Terima kasih.";

    $wa_url = "https://api.whatsapp.com/send?phone=" . $nomor_wa_admin . "&text=" . urlencode($pesan_wa);

    header("Location: konfirmasi-wa.php?booking_id=" . $booking_id);
    exit();

} else {

    header("Location: reservasi.php");
    exit();
}
?>