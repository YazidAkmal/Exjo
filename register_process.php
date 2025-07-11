<?php
session_start();
include 'database.php';

function redirect_with_error($message, $submitted_data = [])
{
    $error_message = urlencode($message);
    $query_params = '';

    if (!empty($submitted_data)) {

        unset($submitted_data['password']);
        unset($submitted_data['confirm_password']);

        $query_params = '&' . http_build_query($submitted_data);
    }

    header("Location: register.php?status=gagal&error=" . $error_message . $query_params);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($first_name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        redirect_with_error("Semua kolom wajib diisi.", $_POST);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect_with_error("Format email tidak valid.", $_POST);
    }

    if (strlen($phone) > 14) {
        redirect_with_error("Nomor telepon tidak boleh lebih dari 14 karakter.", $_POST);
    }

    if (!preg_match('/^(\+62|62|0)8[1-9][0-9]{7,11}$/', $phone)) {
        redirect_with_error("Format nomor telepon tidak valid. Gunakan format yang benar, contoh: 081234567890.", $_POST);
    }

    if (strlen($password) < 6) {
        redirect_with_error("Password harus memiliki minimal 6 karakter.", $_POST);
    }

    if ($password !== $confirm_password) {
        redirect_with_error("Password dan Konfirmasi Password tidak cocok.", $_POST);
    }

    $stmt_check = $main_conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    if ($result_check->num_rows > 0) {
        redirect_with_error("Email ini sudah terdaftar. Silakan gunakan email lain.", $_POST);
    }
    $stmt_check->close();

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt_insert = $main_conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password_hash) VALUES (?, ?, ?, ?, ?)");
    $stmt_insert->bind_param("sssss", $first_name, $last_name, $email, $phone, $password_hash);

    if ($stmt_insert->execute()) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Akun Anda berhasil dibuat. Silakan login.'
        ];
        header("Location: login.php");
        exit();
    } else {
        redirect_with_error("Terjadi kesalahan pada server. Silakan coba lagi nanti.", $_POST);
    }

    $stmt_insert->close();
    $main_conn->close();

} else {
    header("Location: register.php");
    exit();
}
?>