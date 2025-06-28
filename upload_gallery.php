<?php
include 'init.php';
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';

$destinations_result = $main_conn->query("SELECT id, name FROM destinations ORDER BY name ASC");
?>

<!doctype html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <title>EXJO Admin</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { background-color: #f8f9fa; color: #333; }
        .admin-sidebar { background: #040E27; min-height: 100vh; padding-top: 20px; position: fixed; height: 100%; }
        .admin-sidebar .logo { padding: 0 15px 30px 15px; }
        .admin-sidebar .logo img { max-width: 100%; }
        .admin-sidebar .nav-link { color: #adb5bd; padding: 12px 20px; border-left: 3px solid transparent; transition: all 0.3s ease; }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active { background: #495057; color: #fff; border-left: 3px solid #1EC6B6; }
        .admin-sidebar .nav-link i { margin-right: 10px; width: 20px; text-align: center; }
        .admin-content { margin-left: 16.666667%; padding: 30px; }
        .form-container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        h2.section-title { margin-bottom: 30px; font-weight: 700; color: #040E27; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-lg-2 admin-sidebar">
                <div class="logo">
                    <a href="admin.php"><img src="img/assets/carousel/exjoputih.png" alt=""></a>
                </div>
                <div class="nav flex-column">
                    <a class="nav-link" href="admin.php#dashboard"><i class="fa fa-tachometer"></i> Dashboard</a>
                    <a class="nav-link" href="admin.php#pesanan"><i class="fa fa-calendar-check-o"></i> Pesanan</a>
                    <a class="nav-link" href="admin.php#destinasi"><i class="fa fa-map-marker"></i> Destinasi</a>
                    <a class="nav-link" href="admin.php#ulasan"><i class="fa fa-comments"></i> Ulasan</a>
                    <a class="nav-link" href="admin.php#tambah-destinasi"><i class="fa fa-plus-circle"></i> Tambah Destinasi</a>
                    <a class="nav-link active" href="upload_gallery.php"><i class="fa fa-photo"></i> Unggah Galeri</a>
                    <hr style="background-color: #495057;">
                    <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </nav>

            <main class="col-lg-10 admin-content">
                <section id="unggah-galeri">
                    <h2 class="section-title">Unggah Gambar Galeri untuk Destinasi</h2>
                    <div class="form-container">
                        <?php if(isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
                            <div class="alert alert-success">Gambar galeri berhasil ditambahkan!</div>
                        <?php elseif(isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
                            <div class="alert alert-danger">Gagal menambahkan gambar. <?php echo isset($_GET['error']) ? htmlspecialchars($_GET['error']) : ''; ?></div>
                        <?php endif; ?>

                        <form action="proses_upload_gallery.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Pilih Destinasi</label>
                                <select class="form-control" name="destination_id" required>
                                    <option value="">Pilih salah satu destinasi</option>
                                    <?php while($row = $destinations_result->fetch_assoc()): ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Unggah Gambar Galeri (Bisa pilih lebih dari satu)</label>
                                <input type="file" class="form-control-file" name="gallery_images[]" multiple required>
                            </div>

                            <button type="submit" class="btn btn-primary">Unggah Gambar</button>
                        </form>
                    </div>
                </section>
            </main>
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