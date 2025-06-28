<?php
session_start();
include 'database.php';

$previous_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
$previous_page = strtok($previous_page, '?');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_email = $_POST['username_email'];
    $password = $_POST['password'];

    $stmt_admin = $admin_conn->prepare("SELECT username, password_hash FROM admins WHERE username = ?");
    $stmt_admin->bind_param("s", $username_email);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();
    if ($result_admin->num_rows === 1) {
        $admin = $result_admin->fetch_assoc();
        if (password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: admin.php");
            exit();
        }
    }
    $stmt_admin->close();

    $stmt_user = $main_conn->prepare("SELECT id, first_name, password_hash FROM users WHERE email = ?");
    $stmt_user->bind_param("s", $username_email);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    if ($result_user->num_rows === 1) {
        $user = $result_user->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            header("Location: index.php"); 
            exit();
        }
    }
    $stmt_user->close();
    header("Location: login.php?error=Username atau Password yang Anda masukkan salah.");
    exit();
}
?>