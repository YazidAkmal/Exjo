<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$booking_id = $_POST['booking_id'];
$destination_id = $_POST['destination_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

if (empty($destination_id) || empty($rating) || empty($comment)) {
    header("Location: my_reservations.php?review_status=error");
    exit();
}

$check_sql = "SELECT id FROM reviews WHERE booking_id = ?";
$check_stmt = $main_conn->prepare($check_sql);
$check_stmt->bind_param("i", $booking_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    header("Location: my_reservations.php?review_status=exists");
    exit();
}
$check_stmt->close();

$sql = "INSERT INTO reviews (user_id, destination_id, booking_id, rating, comment, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = $main_conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("iiiis", $user_id, $destination_id, $booking_id, $rating, $comment);
    
    if ($stmt->execute()) {
        header("Location: my_reservations.php?review_status=success");
    } else {
        header("Location: my_reservations.php?review_status=error");
    }
    $stmt->close();
} else {
    header("Location: my_reservations.php?review_status=error");
}

$main_conn->close();
exit();
?>
