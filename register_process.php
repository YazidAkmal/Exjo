<?php
include 'database.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    header("Location: register.php?error=Password konfirmasi tidak cocok!");
    exit();
}

$stmt_check = $main_conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    header("Location: register.php?error=Email sudah terdaftar!");
    exit();
}
$stmt_check->close();

$password_hash = password_hash($password, PASSWORD_BCRYPT);

$stmt_insert = $main_conn->prepare("INSERT INTO users (first_name, last_name, email, password_hash) VALUES (?, ?, ?, ?)");
$stmt_insert->bind_param("ssss", $first_name, $last_name, $email, $password_hash);

if ($stmt_insert->execute()) {
    header("Location: login.php?success=Registrasi berhasil! Silakan login.");
} else {
    header("Location: register.php?error=Terjadi kesalahan, silakan coba lagi.");
}

$stmt_insert->close();
$main_conn->close();
include 'database.php';
?>