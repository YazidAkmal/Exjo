<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $main_conn->prepare("UPDATE bookings SET status = 'Dibatalkan' WHERE id = ? AND user_id = ? AND status = 'Menunggu Konfirmasi WA'");
    $stmt->bind_param("ii", $booking_id, $user_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $_SESSION['message'] = "Pesanan berhasil dibatalkan.";
    } else {
        $_SESSION['message'] = "Gagal membatalkan pesanan. Pesanan mungkin sudah diproses atau tidak dapat dibatalkan.";
    }
    $stmt->close();
} else {
    $_SESSION['message'] = "ID Pesanan tidak valid.";
}

$main_conn->close();

header("Location: my_reservations.php");
exit();
?>