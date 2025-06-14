<?php
include 'database.php';

if (!isset($_SESSION['email_for_reset'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email_for_reset'];
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];

if ($new_password !== $confirm_new_password) {
    header("Location: reset-form.php?error=Password konfirmasi tidak cocok!");
    exit();
}

$new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

$stmt = $main_conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
$stmt->bind_param("ss", $new_password_hash, $email);

if ($stmt->execute()) {
    unset($_SESSION['email_for_reset']);
    header("Location: login.php?success=Password berhasil diubah! Silakan login dengan password baru Anda.");
} else {
    header("Location: reset-form.php?error=Terjadi kesalahan saat mengubah password.");
}

$stmt->close();
$main_conn->close();
?>