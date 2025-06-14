<?php
include 'init.php';
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';

$new_bookings_count = $main_conn->query("SELECT COUNT(*) as count FROM bookings WHERE status = 'Pending'")->fetch_assoc()['count'];
$destinations_count = $main_conn->query("SELECT COUNT(*) as count FROM destinations")->fetch_assoc()['count'];
$reviews_count = $main_conn->query("SELECT COUNT(*) as count FROM reviews")->fetch_assoc()['count'];
$users_count = $main_conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

$latest_bookings_result = $main_conn->query("SELECT bookings.*, users.first_name, users.last_name FROM bookings JOIN users ON bookings.user_id = users.id ORDER BY bookings.booking_date DESC LIMIT 5");

$all_bookings_result = $main_conn->query("SELECT bookings.*, users.first_name, users.last_name FROM bookings JOIN users ON bookings.user_id = users.id ORDER BY bookings.booking_date DESC");

$destinations_result = $main_conn->query("SELECT * FROM destinations ORDER BY name ASC");

$reviews_result = $main_conn->query("SELECT reviews.*, users.first_name, users.last_name, destinations.name as destination_name FROM reviews JOIN users ON reviews.user_id = users.id JOIN destinations ON reviews.destination_id = destinations.id ORDER BY reviews.created_at DESC");

?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EXJO Admin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/assets/carousel/exjo.ico">
    
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
        .admin-sidebar .nav-link:hover { background: #495057; color: #fff; border-left: 3px solid #1EC6B6; }
        .admin-sidebar .nav-link.active { background: #0B8E86; color: #fff; border-left: 3px solid #1EC6B6; font-weight: bold; }
        .admin-sidebar .nav-link i { margin-right: 10px; width: 20px; text-align: center; }
        .admin-content { margin-left: 16.666667%; padding: 30px; }
        .dashboard-card { border-radius: 8px; padding: 25px; margin-bottom: 30px; color: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .dashboard-card h3 { font-size: 2.5rem; font-weight: 700; }
        .card-bookings { background: linear-gradient(45deg, #ff4a52, #ff9068); }
        .card-destinations { background: linear-gradient(45deg, #4776E6, #8E54E9); }
        .card-reviews { background: linear-gradient(45deg, #00c6ff, #0072ff); }
        .card-users { background: linear-gradient(45deg, #11998e, #38ef7d); }
        .card { border: none; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .card-header { font-weight: 700; background-color: #fff; }
        h2.section-title { margin-bottom: 30px; font-weight: 700; color: #040E27; }
        .table-responsive { background: #fff; border-radius: 8px; padding: 15px; }
        .form-container { background: #fff; padding: 30px; border-radius: 8px; }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 admin-sidebar">
                <div class="logo">
                    <a href="admin.php"><img src="img/assets/carousel/exjoputih.png" alt=""></a>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="#dashboard"><i class="fa fa-tachometer"></i> Dashboard</a>
                    <a class="nav-link" href="#pesanan"><i class="fa fa-calendar-check-o"></i> Pesanan</a>
                    <a class="nav-link" href="#destinasi"><i class="fa fa-map-marker"></i> Destinasi</a>
                    <a class="nav-link" href="#ulasan"><i class="fa fa-comments"></i> Ulasan</a>
                    <a class="nav-link" href="#tambah-destinasi"><i class="fa fa-plus-circle"></i> Tambah Destinasi</a>
                    <hr style="background-color: #495057;">
                    <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                </nav>
            </div>
            
            <div class="col-lg-10 admin-content">
                <section id="dashboard">
                    <h2 class="section-title">Ringkasan Dashboard</h2>
                    <div class="row">
                        <div class="col-md-3"><div class="dashboard-card card-bookings"><h3><?php echo $new_bookings_count; ?></h3><p>Pesanan Baru (Pending)</p></div></div>
                        <div class="col-md-3"><div class="dashboard-card card-destinations"><h3><?php echo $destinations_count; ?></h3><p>Total Destinasi</p></div></div>
                        <div class="col-md-3"><div class="dashboard-card card-reviews"><h3><?php echo $reviews_count; ?></h3><p>Total Ulasan</p></div></div>
                        <div class="col-md-3"><div class="dashboard-card card-users"><h3><?php echo $users_count; ?></h3><p>Total Pengguna</p></div></div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header"><h4>Pesanan Terbaru (5 Teratas)</h4></div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead><tr><th>ID</th><th>Pelanggan</th><th>Paket</th><th>Tanggal Pesan</th><th>Status</th><th>Aksi</th></tr></thead>
                                            <tbody>
                                                <?php if ($latest_bookings_result->num_rows > 0): while($row = $latest_bookings_result->fetch_assoc()): ?>
                                                <tr>
                                                    <td>#<?php echo $row['id']; ?></td>
                                                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['package_name']); ?></td>
                                                    <td><?php echo date('d M Y, H:i', strtotime($row['booking_date'])); ?></td>
                                                    <td><span class="badge badge-warning"><?php echo htmlspecialchars($row['status']); ?></span></td>
                                                    <td><button class="btn btn-sm btn-success">Terima</button> <button class="btn btn-sm btn-danger">Tolak</button></td>
                                                </tr>
                                                <?php endwhile; else: ?>
                                                    <tr><td colspan="6" class="text-center">Tidak ada pesanan terbaru.</td></tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section id="pesanan" class="mt-5">
                    <h2 class="section-title">Kelola Semua Pemesanan</h2>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead><tr><th>ID Pesanan</th><th>Pelanggan</th><th>Paket</th><th>Bulan</th><th>Status</th><th>Aksi</th></tr></thead>
                            <tbody>
                                <?php if ($all_bookings_result->num_rows > 0): while($row = $all_bookings_result->fetch_assoc()): ?>
                                <tr>
                                    <td>#BK<?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['package_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['booking_month']); ?></td>
                                    <td><span class="badge badge-info"><?php echo htmlspecialchars($row['status']); ?></span></td>
                                    <td><button class="btn btn-sm btn-success">Terima</button> <button class="btn btn-sm btn-danger">Tolak</button> <button class="btn btn-sm btn-info">Lihat</button></td>
                                </tr>
                                <?php endwhile; else: ?>
                                    <tr><td colspan="6" class="text-center">Belum ada data pemesanan.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
                
                <section id="destinasi" class="mt-5">
                    <h2 class="section-title">Kelola Destinasi</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead><tr><th>ID</th><th>Gambar</th><th>Destinasi</th><th>Lokasi</th><th>Harga</th><th>Aksi</th></tr></thead>
                            <tbody>
                                <?php if ($destinations_result->num_rows > 0): while($row = $destinations_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><img src="<?php echo htmlspecialchars($row['image_path']); ?>" width="60" height="60" class="rounded" style="object-fit: cover;"></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                                    <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                                    <td><button class="btn btn-sm btn-primary">Edit</button> <button class="btn btn-sm btn-danger">Delete</button></td>
                                </tr>
                                <?php endwhile; else: ?>
                                    <tr><td colspan="6" class="text-center">Belum ada data destinasi.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="ulasan" class="mt-5">
                    <h2 class="section-title">Ulasan Pelanggan</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead><tr><th>ID</th><th>Pelanggan</th><th>Destinasi</th><th>Rating</th><th>Komentar</th><th>Aksi</th></tr></thead>
                            <tbody>
                                <?php if ($reviews_result->num_rows > 0): while($row = $reviews_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['destination_name']); ?></td>
                                    <td>
                                        <?php for($i = 0; $i < $row['rating']; $i++) { echo '<i class="fa fa-star text-warning"></i>'; } ?>
                                        <?php for($i = $row['rating']; $i < 5; $i++) { echo '<i class="fa fa-star-o text-secondary"></i>'; } ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['comment']); ?></td>
                                    <td><button class="btn btn-sm btn-danger">Hapus</button></td>
                                </tr>
                                <?php endwhile; else: ?>
                                    <tr><td colspan="6" class="text-center">Belum ada ulasan dari pelanggan.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
                
                <section id="tambah-destinasi" class="mt-5">
                    <h2 class="section-title">Tambah Destinasi Baru</h2>
                    <div class="form-container">
                        <?php if(isset($_GET['status_tambah']) && $_GET['status_tambah'] == 'sukses'): ?>
                            <div class="alert alert-success">Destinasi baru berhasil ditambahkan!</div>
                        <?php elseif(isset($_GET['status_tambah']) && $_GET['status_tambah'] == 'gagal'): ?>
                            <div class="alert alert-danger">Gagal menambahkan destinasi. <?php echo isset($_GET['error']) ? htmlspecialchars($_GET['error']) : ''; ?></div>
                        <?php endif; ?>

                        <form id="destinationForm" action="tambah_destinasi.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6"><div class="form-group"><label>Nama Destinasi</label><input type="text" class="form-control" name="name" required></div></div>
                                <div class="col-md-6"><div class="form-group"><label>Lokasi</label><input type="text" class="form-control" name="location" required></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><div class="form-group"><label>Harga Tiket (Rp)</label><input type="number" class="form-control" name="price" required></div></div>
                                <div class="col-md-6"><div class="form-group"><label>Tipe Paket</label><select class="form-control" name="package_type"><option value="Regular">Regular</option><option value="VIP">VIP</option></select></div></div>
                            </div>
                            <div class="form-group"><label>Deskripsi</label><textarea class="form-control" name="description" rows="3" required></textarea></div>
                            <div class="form-group"><label>Unggah Gambar Utama</label><input type="file" class="form-control-file" name="image" required></div>
                            <button type="submit" class="btn btn-primary">Tambah Destinasi</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).on('click', 'a[href^="#"]', function (event) {
            event.preventDefault();
            var target = $($.attr(this, 'href'));
            if(target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 500);
            }
        });
    </script>
</body>
</html>