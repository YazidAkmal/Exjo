<?php
session_start();

if (!isset($_SESSION['email_for_reset'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Atur Password Baru - EXJO</title>
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

        .login-form h3 {
            text-align: center;
            margin-bottom: 30px;
            color: #040E27;
            font-size: 22px;
            line-height: 1.4;
        }

        .form-control {
            height: 50px;
            border-radius: 5px;
        }

        .boxed-btn3 {
            width: 100%;
            text-transform: uppercase;
            background: #1EC6B6;
            border: none;
        }

        .form-group {
            margin-bottom: 15px;
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
            <h3>Atur Password Baru untuk<br><?php echo htmlspecialchars($_SESSION['email_for_reset']); ?></h3>

            <form action="update_password_process.php" method="POST">
                <div class="form-group password-wrapper">
                    <input type="password" name="new_password" class="form-control"
                        placeholder="Password Baru (min. 8 karakter)" required>
                    <i class="fa fa-eye-slash toggle-password"></i>
                </div>
                <div class="form-group password-wrapper">
                    <input type="password" name="confirm_new_password" class="form-control"
                        placeholder="Konfirmasi Password Baru" required>
                    <i class="fa fa-eye-slash toggle-password"></i>
                </div>
                <button type="submit" class="boxed-btn3">Simpan Password Baru</button>
            </form>
        </div>
    </div>

    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'gagal') {
                const errorMessage = urlParams.get('error') || 'Terjadi kesalahan.';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: decodeURIComponent(errorMessage.replace(/\+/g, ' ')),
                    confirmButtonColor: '#1EC6B6'
                });
                window.history.replaceState({}, document.title, window.location.pathname);
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