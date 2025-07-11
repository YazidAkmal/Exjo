<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - EXJO</title>
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
            padding: 20px 0;
        }

        .login-form {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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
            <h3>Login Akun</h3>
            <form action="login_process.php" method="POST">
                <div class="form-group mb-3">
                    <input type="text" name="username_email" class="form-control"
                        placeholder="Username (Admin) / Email (Pengguna)" required>
                </div>
                <div class="form-group mb-4 password-wrapper">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <i class="fa fa-eye-slash toggle-password"></i>
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
        $(document).ready(function () {
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

    <?php
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];

        if ($alert['type'] === 'error') {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{$alert['message']}'
            });
        </script>";
        }

        elseif ($alert['type'] === 'success') {
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil',
                text: '{$alert['message']}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        </script>";
        }

        unset($_SESSION['alert']);
    }
    ?>
</body>

</html>