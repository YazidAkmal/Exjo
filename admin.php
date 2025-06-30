<?php
include 'init.php';
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';

$pesan_notifikasi = '';

if (isset($_GET['action']) && $_GET['action'] == 'update_booking_status' && isset($_GET['id']) && isset($_GET['status'])) {
    $booking_id = (int) $_GET['id'];
    $new_status = $_GET['status'];

    if ($new_status == 'Terima' || $new_status == 'Tolak') {
        $stmt = $main_conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $booking_id);
        if ($stmt->execute()) {
            $pesan_notifikasi = '<div class="alert alert-success">Status pesanan #BK' . $booking_id . ' berhasil diperbarui menjadi ' . $new_status . '.</div>';
        } else {
            $pesan_notifikasi = '<div class="alert alert-danger">Gagal memperbarui status pesanan.</div>';
        }
        $stmt->close();
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete_destination' && isset($_GET['id'])) {
    $id_to_delete = (int) $_GET['id'];
    $stmt = $main_conn->prepare("DELETE FROM destinations WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    if ($stmt->execute()) {
        $pesan_notifikasi = '<div class="alert alert-success">Destinasi berhasil dihapus.</div>';
    } else {
        $pesan_notifikasi = '<div class="alert alert-danger">Gagal menghapus destinasi.</div>';
    }
    $stmt->close();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete_review' && isset($_GET['id'])) {
    $id_to_delete = (int) $_GET['id'];
    $stmt = $main_conn->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    if ($stmt->execute()) {
        $pesan_notifikasi = '<div class="alert alert-success">Ulasan berhasil dihapus.</div>';
    } else {
        $pesan_notifikasi = '<div class="alert alert-danger">Gagal menghapus ulasan.</div>';
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_destination'])) {
    $id_to_update = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $link = $_POST['link'];

    $stmt = $main_conn->prepare("UPDATE destinations SET name = ?, location = ?, price = ?, description = ?, link = ? WHERE id = ?");
    $stmt->bind_param("ssdssi", $name, $location, $price, $description, $link, $id_to_update);

    if ($stmt->execute()) {
        $pesan_notifikasi = '<div class="alert alert-success">Destinasi berhasil diperbarui.</div>';
    } else {
        $pesan_notifikasi = '<div class="alert alert-danger">Gagal memperbarui destinasi.</div>';
    }
    $stmt->close();
}

$new_bookings_count = $main_conn->query("SELECT COUNT(*) as count FROM bookings WHERE status IN ('Menunggu Konfirmasi', 'Menunggu Konfirmasi WA', 'Pending')")->fetch_assoc()['count'];
$destinations_count = $main_conn->query("SELECT COUNT(*) as count FROM destinations")->fetch_assoc()['count'];
$reviews_count = $main_conn->query("SELECT COUNT(*) as count FROM reviews")->fetch_assoc()['count'];
$users_count = $main_conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

$all_bookings_result = $main_conn->query(
    "SELECT 
        bookings.*, 
        users.first_name, 
        users.last_name, 
        destinations.name as destination_name
    FROM bookings 
    JOIN users ON bookings.user_id = users.id 
    JOIN destinations ON bookings.destination_id = destinations.id 
    ORDER BY bookings.id DESC"
);

$destinations_result = $main_conn->query("SELECT * FROM destinations ORDER BY id ASC");
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

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .admin-sidebar {
            background: #040E27;
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
            height: 100%;
        }

        .admin-sidebar .logo {
            padding: 0 15px 30px 15px;
        }

        .admin-sidebar .logo img {
            max-width: 100%;
        }

        .admin-sidebar .nav-link {
            color: #adb5bd;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .admin-sidebar .nav-link:hover {
            background: #495057;
            color: #fff;
            border-left: 3px solid #1EC6B6;
        }

        .admin-sidebar .nav-link.active {
            background: #0B8E86;
            color: #fff;
            border-left: 3px solid #1EC6B6;
            font-weight: bold;
        }

        .admin-sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .admin-content {
            margin-left: 16.666667%;
            padding: 30px;
        }

        .dashboard-card {
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .card-bookings {
            background: linear-gradient(45deg, #ff4a52, #ff9068);
        }

        .card-bookings p {
            color: #000;
            font-weight: 500;
        }

        .card-destinations {
            background: linear-gradient(45deg, #4776E6, #8E54E9);
        }

        .card-reviews {
            background: linear-gradient(45deg, #00c6ff, #0072ff);
        }

        .card-users {
            background: linear-gradient(45deg, #11998e, #38ef7d);
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            font-weight: 700;
            background-color: #fff;
        }

        h2.section-title {
            margin-bottom: 30px;
            font-weight: 700;
            color: #040E27;
        }

        .table-responsive {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
        }

        .card-bookings p,
        .card-destinations p,
        .card-reviews p,
        .card-users p {
            color: #000;
            font-weight: 500;
        }

        .badge-Pending {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-Terima {
            background-color: #28a745;
            color: white;
        }

        .badge-Tolak {
            background-color: #dc3545;
            color: white;
        }

        .badge-Menunggu-Konfirmasi-WA {
            background-color: #17a2b8;
            color: white;
        }
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
                    <a class="nav-link" href="#dashboard"><i class="fa fa-tachometer"></i> Dashboard</a>
                    <a class="nav-link" href="#pesanan"><i class="fa fa-calendar-check-o"></i> Pesanan</a>
                    <a class="nav-link" href="#destinasi"><i class="fa fa-map-marker"></i> Destinasi</a>
                    <a class="nav-link" href="#ulasan"><i class="fa fa-comments"></i> Ulasan</a>
                    <a class="nav-link" href="#tambah-destinasi"><i class="fa fa-plus-circle"></i> Tambah Destinasi</a>
                    <a class="nav-link" href="upload_gallery.php"><i class="fa fa-photo"></i> Unggah Galeri</a>

                    <hr style="background-color: #495057;">
                    <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </nav>

            <main class="col-lg-10 admin-content">
                <?php if (!empty($pesan_notifikasi)) {
                    echo $pesan_notifikasi;
                } ?>

                <section id="dashboard">
                    <h2 class="section-title">Ringkasan Dashboard</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-card card-bookings">
                                <h3><?php echo $new_bookings_count; ?></h3>
                                <p>Pesanan Baru (Pending)</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-card card-destinations">
                                <h3><?php echo $destinations_count; ?></h3>
                                <p>Total Destinasi</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-card card-reviews">
                                <h3><?php echo $reviews_count; ?></h3>
                                <p>Total Ulasan</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-card card-users">
                                <h3><?php echo $users_count; ?></h3>
                                <p>Total Pengguna</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="pesanan" class="mt-5">
                    <h2 class="section-title">Kelola Semua Pemesanan</h2>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Destinasi</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($all_bookings_result->num_rows > 0):
                                    while ($row = $all_bookings_result->fetch_assoc()): ?>
                                        <tr>
                                            <td>#BK<?php echo $row['id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['destination_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                                            <td><span
                                                    class="badge badge-<?php echo str_replace(' ', '-', htmlspecialchars($row['status'])); ?>"><?php echo htmlspecialchars($row['status']); ?></span>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($row['status'] == 'Menunggu Konfirmasi' && !empty($row['bukti_pembayaran'])): ?>
                                                    <a href="<?php echo htmlspecialchars($row['bukti_pembayaran']); ?>"
                                                        target="_blank" class="btn btn-sm btn-info mb-1">Lihat Bukti</a>
                                                <?php endif; ?>

                                                <?php

                                                if ($row['status'] == 'Pending' || $row['status'] == 'Menunggu Konfirmasi' || $row['status'] == 'Menunggu Konfirmasi WA'):
                                                    ?>
                                                    <a href="admin.php?action=update_booking_status&id=<?php echo $row['id']; ?>&status=Terima#pesanan"
                                                        class="btn btn-sm btn-success btn-terima">Terima</a>
                                                    <a href="admin.php?action=update_booking_status&id=<?php echo $row['id']; ?>&status=Tolak#pesanan"
                                                        class="btn btn-sm btn-danger btn-tolak">Tolak</a>
                                                <?php else: ?>
                                                    <span>-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data pemesanan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="destinasi" class="mt-5">
                    <h2 class="section-title">Kelola Destinasi</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Gambar</th>
                                    <th>Destinasi</th>
                                    <th>Lokasi</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($destinations_result->num_rows > 0):
                                    while ($row = $destinations_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><img src="<?php echo htmlspecialchars($row['image_path']); ?>" width="60"
                                                    height="60" class="rounded" style="object-fit: cover;"
                                                    onerror="this.onerror=null;this.src='https://placehold.co/60x60/EEE/31343C?text=No+Img';">
                                            </td>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                                            <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                                            <td>
                                                <a href="admin.php?action=edit_destination&id=<?php echo $row['id']; ?>#form-edit-destinasi"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <a href="admin.php?action=delete_destination&id=<?php echo $row['id']; ?>#destinasi"
                                                    class="btn btn-sm btn-danger btn-hapus-destinasi">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data destinasi.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="ulasan" class="mt-5">
                    <h2 class="section-title">Ulasan Pelanggan</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Destinasi</th>
                                    <th>Rating</th>
                                    <th>Komentar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($reviews_result->num_rows > 0):
                                    while ($row = $reviews_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['destination_name']); ?></td>
                                            <td>
                                                <?php for ($i = 0; $i < $row['rating']; $i++) {
                                                    echo '<i class="fa fa-star text-warning"></i>';
                                                } ?>
                                                <?php for ($i = $row['rating']; $i < 5; $i++) {
                                                    echo '<i class="fa fa-star-o text-secondary"></i>';
                                                } ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['comment']); ?></td>
                                            <td>
                                                <a href="admin.php?action=delete_review&id=<?php echo $row['id']; ?>#ulasan"
                                                    class="btn btn-sm btn-danger btn-hapus-ulasan">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada ulasan dari pelanggan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <?php
                if (isset($_GET['action']) && $_GET['action'] == 'edit_destination' && isset($_GET['id'])):
                    $id_to_edit = $_GET['id'];
                    $edit_stmt = $main_conn->prepare("SELECT * FROM destinations WHERE id = ?");
                    $edit_stmt->bind_param("i", $id_to_edit);
                    $edit_stmt->execute();
                    $edit_result = $edit_stmt->get_result();
                    if ($edit_result->num_rows === 1):
                        $dest_to_edit = $edit_result->fetch_assoc();
                        ?>
                        <section id="form-edit-destinasi" class="mt-5">
                            <h2 class="section-title">Edit Destinasi: <?php echo htmlspecialchars($dest_to_edit['name']); ?>
                            </h2>
                            <div class="form-container">
                                <form action="admin.php#destinasi" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $dest_to_edit['id']; ?>">
                                    <div class="form-group"><label>Nama Destinasi</label><input type="text" class="form-control"
                                            name="name" value="<?php echo htmlspecialchars($dest_to_edit['name']); ?>" required>
                                    </div>
                                    <div class="form-group"><label>Lokasi</label><input type="text" class="form-control"
                                            name="location" value="<?php echo htmlspecialchars($dest_to_edit['location']); ?>"
                                            required></div>
                                    <div class="form-group"><label>Link Google Maps</label><input type="url"
                                            class="form-control" name="link"
                                            value="<?php echo htmlspecialchars($dest_to_edit['link']); ?>" required></div>
                                    <div class="form-group"><label>Harga Tiket (Rp)</label><input type="number"
                                            class="form-control" name="price" value="<?php echo $dest_to_edit['price']; ?>"
                                            required></div>
                                    <div class="form-group"><label>Deskripsi</label><textarea class="form-control"
                                            name="description" rows="4"
                                            required><?php echo htmlspecialchars($dest_to_edit['description']); ?></textarea>
                                    </div>
                                    <button type="submit" name="update_destination" class="btn btn-success">Update
                                        Destinasi</button>
                                    <a href="admin.php#destinasi" class="btn btn-secondary">Batal</a>
                                </form>
                            </div>
                        </section>
                        <?php
                    endif;
                    $edit_stmt->close();
                endif;
                ?>

                <section id="tambah-destinasi" class="mt-5">
                    <h2 class="section-title">Tambah Destinasi Baru</h2>
                    <div class="form-container">
                        <?php if (isset($_GET['status_tambah']) && $_GET['status_tambah'] == 'sukses'): ?>
                            <div class="alert alert-success">Destinasi baru berhasil ditambahkan!</div>
                        <?php elseif (isset($_GET['status_tambah']) && $_GET['status_tambah'] == 'gagal'): ?>
                            <div class="alert alert-danger">Gagal menambahkan destinasi.
                                <?php echo isset($_GET['error']) ? htmlspecialchars($_GET['error']) : ''; ?></div>
                        <?php endif; ?>

                        <form id="destinationForm" action="tambah_destinasi.php" method="POST"
                            enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"><label>Nama Destinasi</label><input type="text"
                                            class="form-control" name="name" required></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Lokasi</label><input type="text" class="form-control"
                                            name="location" required></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Link Google Maps</label>
                                <input type="url" class="form-control" name="link"
                                    placeholder="https://maps.app.goo.gl/contoh" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"><label>Harga Tiket (Rp)</label><input type="number"
                                            class="form-control" name="price" required></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Tipe Paket</label><select class="form-control"
                                            name="package_type">
                                            <option value="Regular">Regular</option>
                                            <option value="VIP">VIP</option>
                                        </select></div>
                                </div>
                            </div>
                            <div class="form-group"><label>Deskripsi</label><textarea class="form-control"
                                    name="description" rows="3" required></textarea></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Unggah Gambar Utama</label>
                                        <input type="file" class="form-control-file" name="image" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Unggah Gambar Galeri (Bisa pilih lebih dari satu)</label>
                                        <input type="file" class="form-control-file" name="gallery_images[]" multiple>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah Destinasi</button>
                        </form>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            function setActiveSidebarLink() {
                $('.admin-sidebar .nav-link').removeClass('active');
                var hash = window.location.hash;
                if (!hash) { hash = '#dashboard'; }
                $('.admin-sidebar .nav-link[href="' + hash + '"]').addClass('active');
            }
            setActiveSidebarLink();
            $(document).on('click', '.admin-sidebar .nav-link', function (event) {
                var href = $(this).attr('href');
                if (href.startsWith('#')) {
                    event.preventDefault();
                    var target = $(href);
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top - 20
                        }, 500);
                        history.pushState(null, null, href);
                        setActiveSidebarLink();
                    }
                }
            });

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('status') && !urlParams.has('action')) {
                if (urlParams.get('status') === 'sukses') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Terima kasih, data telah diterima.',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat mengirim data.',
                    });
                }
                window.history.replaceState({}, document.title, window.location.pathname + window.location.hash);
            }

            $('.btn-terima').on('click', function (e) {
                e.preventDefault();
                const href = $(this).attr('href');
                Swal.fire({
                    title: 'Konfirmasi Pesanan',
                    text: "Anda yakin ingin menerima pesanan ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, terima!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });

            $('.btn-tolak').on('click', function (e) {
                e.preventDefault();
                const href = $(this).attr('href');

                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Anda akan menolak pesanan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                })
            });

            $('.btn-hapus-destinasi').on('click', function (e) {
                e.preventDefault();
                const href = $(this).attr('href');

                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Destinasi ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                })
            });

            $('.btn-hapus-ulasan').on('click', function (e) {
                e.preventDefault();
                const href = $(this).attr('href');

                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Ulasan ini akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                })
            });

        });
    </script>
</body>

</html>