<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$paket = $_POST['paket'];
$bulan = $_POST['bulan'];
$catatan = $_POST['catatan'];

if (empty($paket) || empty($bulan)) {
    header("Location: reservasi.php?status=gagal");
    exit();
}

$stmt = $main_conn->prepare("INSERT INTO bookings (user_id, package_name, booking_month, notes) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $paket, $bulan, $catatan);

if ($stmt->execute()) {
    header("Location: reservasi.php?status=sukses");
} else {
    header("Location: reservasi.php?status=gagal");
}

$stmt->close();
$main_conn->close();
?>