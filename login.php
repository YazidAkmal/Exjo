<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EXJO</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
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
            <div class="logo">
                <img src="img/logo.png" alt="EXJO Logo">
            </div>
            <h3>Login Akun</h3>
            
            <?php
                if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
                }
                
            ?>
            <form action="login_process.php" method="POST">
                <div class="form-group mb-3">
                    <input type="text" name="username_email" class="form-control" placeholder="Username (untuk Admin) / Email (untuk Pengguna)" required>
                </div>
                <div class="form-group mb-4">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="boxed-btn3">Login</button>
            </form>
            <div class="text-center mt-4" style="color: #555;">
                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                <p><a href="forgot-password.php">Lupa Password?</a></p>
            </div>
        </div>
    </div>
    <script src="js/vendor/jquery-1.12.4.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('status')) {
        const status = urlParams.get('status');
        const error = urlParams.get('error'); 
        const brandColor = '#1EC6B6';

        let title, text, icon;

        if (status === 'sukses') {
            title = 'Berhasil!';
            text = 'Aksi Anda telah berhasil diproses.'; 
            icon = 'success';
        } else { 
            title = 'Oops... Terjadi Kesalahan';
            text = error || 'Silakan periksa kembali isian Anda dan coba lagi.'; 
            icon = 'error';
        }

        if (window.location.pathname.includes('reservasi.php') && status === 'sukses') {
            text = 'Terima kasih, reservasi Anda telah kami terima dan akan segera diproses.';
        }

        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            confirmButtonColor: brandColor 
        });

        window.history.replaceState({}, document.title, window.location.pathname + window.location.hash);
    }
});
    </script>
    
</body>
</html>