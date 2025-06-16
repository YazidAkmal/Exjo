<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - EXJO</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body { background-color: #f4f5f7; }
        .login-container { display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-form { background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        .login-form .logo { text-align: center; margin-bottom: 20px; }
        .login-form .logo img { max-width: 150px; }
        .login-form h3 { text-align: center; margin-bottom: 30px; color: #040E27; }
        .login-form .form-control { width: 100%; height: 50px; border: 1px solid #e5e6e9; border-radius: 5px; background-color: #f8f9fa; padding-left: 20px; font-size: 16px; transition: border-color 0.3s ease; margin-bottom: 15px; }
        .login-form .form-control:focus { border-color: #17A295; box-shadow: none; background-color: #fff; }
        .boxed-btn3 { width: 100%; text-transform: uppercase; background: #17A295; color: #fff; display: block; padding: 12px; border: none; border-radius: 5px; font-size: 16px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <div class="logo">
                <img src="img/logo.png" alt="EXJO Logo">
            </div>
            <h3>Reset Password</h3>
            <p style="text-align: center; color: #555; margin-bottom: 20px;">Masukkan email Anda yang terdaftar.</p>

            <?php if (isset($_GET['error'])) { echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>'; } ?>
            
            <form action="forgot-password_process.php" method="POST">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email Anda" required>
                </div>
                <button type="submit" class="boxed-btn3">Kirim</button>
            </form>
            <div class="text-center mt-4">
                <p><a href="login.php">Kembali ke Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>