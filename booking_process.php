<?php
include 'init.php'; 
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$destination_id = $_POST['destination_id'];
$tanggal_pemesanan = $_POST['tanggal_pemesanan']; 
$catatan = $_POST['catatan'];

if (empty($destination_id) || empty($tanggal_pemesanan)) {
    header("Location: reservasi.php?status=gagal");
    exit();
}

$stmt = $main_conn->prepare("INSERT INTO bookings (user_id, destination_id, booking_date, notes) VALUES (?, ?, ?, ?)");

$stmt->bind_param("iiss", $user_id, $destination_id, $tanggal_pemesanan, $catatan);

if ($stmt->execute()) {
    header("Location: reservasi.php?status=sukses");
} else {
    header("Location: reservasi.php?status=gagal");
}

$stmt->close();
$main_conn->close();
?>