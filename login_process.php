<?php
session_start();
include 'database.php';

$previous_page = 'index.php';
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer_url = $_SERVER['HTTP_REFERER'];
    if (!strpos($referer_url, 'login.php') && !strpos($referer_url, 'register.php')) {
        $previous_page = $referer_url;
    }
}

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
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Login sebagai admin berhasil!'
            ];
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
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Login berhasil! Selamat datang, ' . htmlspecialchars($user['first_name']) . '.'
            ];
            header("Location: " . $previous_page);
            exit();
        }
    }
    $stmt_user->close();

    $_SESSION['alert'] = [
        'type' => 'error',
        'message' => 'Username/Email atau Password salah.'
    ];
    header("Location: login.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>