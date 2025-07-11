<?php
include 'database.php';

$email = $_POST['email'];

$stmt = $main_conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['email_for_reset'] = $email;
    header("Location: reset-form.php");
    exit();
} else {
    header("Location: forgot-password.php?error=Email tidak terdaftar di sistem kami.");
    exit();
}
?>