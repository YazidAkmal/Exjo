<?php

$old_first_name = isset($_GET['first_name']) ? htmlspecialchars($_GET['first_name']) : '';
$old_last_name = isset($_GET['last_name']) ? htmlspecialchars($_GET['last_name']) : '';
$old_email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
$old_phone = isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daftar Akun - EXJO</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/assets/carousel/exjo.ico">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f4f5f7;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 15px;
        }

        .login-form {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
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

        .form-group {
            margin-bottom: 15px;
        }

        .boxed-btn3 {
            width: 100%;
            text-transform: uppercase;
            background: #1EC6B6;
            border: none;
        }

        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .password-wrapper .form-control {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            display: none;
        }

        input::-ms-reveal,
        input::-webkit-password-reveal {
            display: none;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <div class="logo">
                <a href="index.php"><img src="img/logo.png" class="img-fluid" alt="EXJO Logo"></a>
            </div>
            <h3>Buat Akun Baru</h3>
            <form action="register_process.php" method="POST">
                <div class="form-group"><input type="text" name="first_name" class="form-control"
                        placeholder="Nama Depan" value="<?php echo $old_first_name; ?>" required></div>
                <div class="form-group"><input type="text" name="last_name" class="form-control"
                        placeholder="Nama Belakang" value="<?php echo $old_last_name; ?>"></div>
                <div class="form-group"><input type="email" name="email" class="form-control" placeholder="Email"
                        value="<?php echo $old_email; ?>" required></div>
                <div class="form-group"><input type="text" name="phone" class="form-control"
                        placeholder="Nomor Telepon (081234567890)" value="<?php echo $old_phone; ?>" required
                        maxlength="14"></div>

                <div class="form-group password-wrapper"><input type="password" name="password" class="form-control"
                        placeholder="Password (min. 6 karakter)" required><i
                        class="fa fa-eye-slash toggle-password"></i></div>
                <div class="form-grup password-wrapper"><input type="password" name="confirm_password"
                        class="form-control" placeholder="Konfirmasi Password" required><i
                        class="fa fa-eye-slash toggle-password"></i></div>

                <button type="submit" class="boxed-btn3">Daftar</button>
            </form>
            <div class="text-center mt-4">
                <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
            </div>
        </div>
    </div>

    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $(document).ready(function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('status')) {
                const status = urlParams.get('status');
                const error = urlParams.get('error');
                const brandColor = '#1EC6B6';

                if (status === 'gagal') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Registrasi Gagal',
                        text: decodeURIComponent(error.replace(/\+/g, ' ')),
                        confirmButtonColor: brandColor
                    });
                }

                const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.pushState({ path: newUrl }, '', newUrl);
            }

            $('.toggle-password').css('display', 'block');

            $('.toggle-password').on('click', function () {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $(this).siblings("input");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        });
    </script>
</body>

</html>