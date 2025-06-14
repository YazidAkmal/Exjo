<?php
if (!isset($_SESSION['email_for_reset'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Atur Password Baru - EXJO</title>
    <style>
        body {
            background-color: #f4f5f7;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-form {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
        .login-form .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-form .logo img {
            max-width: 150px;
        }
        .login-form h3 {
            text-align: center;
            margin-bottom: 30px;
            color: #040E27;
        }
        .form-control {
            height: 50px;
            border-radius: 5px;
        }
        .boxed-btn3 {
            width: 100%;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h3>Atur Password Baru untuk <?php echo htmlspecialchars($_SESSION['email_for_reset']); ?></h3>

            <?php if (isset($_GET['error'])) { echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>'; } ?>

            <form action="update-password_process.php" method="POST">
                <div class="form-group mb-3">
                    <input type="password" name="new_password" class="form-control" placeholder="Password Baru" required>
                </div>
                <div class="form-group mb-4">
                    <input type="password" name="confirm_new_password" class="form-control" placeholder="Konfirmasi Password Baru" required>
                </div>
                <button type="submit" class="boxed-btn3">Simpan Password Baru</button>
            </form>
        </div>
    </div>
</body>
</html>