<?php
session_start();
include 'database.php';

function redirect_with_error($message)
{
    $error_message = urlencode($message);
    header("Location: reset-form.php?status=gagal&error=" . $error_message);
    exit();
}

if (!isset($_SESSION['email_for_reset'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_SESSION['email_for_reset'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if (empty($new_password) || empty($confirm_new_password)) {
        redirect_with_error("Password baru dan konfirmasi tidak boleh kosong.");
    }

    if (strlen($new_password) < 6) {
        redirect_with_error("Password baru harus memiliki minimal 6 karakter.");
    }

    if ($new_password !== $confirm_new_password) {
        redirect_with_error("Password baru dan konfirmasi tidak cocok.");
    }

    $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

    $stmt = $main_conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
    $stmt->bind_param("ss", $password_hash, $email);

    if ($stmt->execute()) {
        unset($_SESSION['email_for_reset']);

        $success_message = urlencode("Password Anda telah berhasil diperbarui! Silakan login.");
        header("Location: login.php?status=sukses&message=" . $success_message);
        exit();
    } else {
        redirect_with_error("Gagal memperbarui password. Terjadi kesalahan pada server.");
    }

    $stmt->close();
    $main_conn->close();

} else {
    header("Location: login.php");
    exit();
}
?>