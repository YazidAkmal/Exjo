<?php
include 'init.php';
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';
$admin_db_host = 'localhost';
$admin_db_user = 'root';
$admin_db_pass = '';
$admin_db_name = 'exjo_admin_db';
$admin_conn = new mysqli($admin_db_host, $admin_db_user, $admin_db_pass, $admin_db_name);
if ($admin_conn->connect_error) {
    $admin_db_error = "Gagal terhubung ke database admin: " . $admin_conn->connect_error;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['update_destination'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $location = $_POST['location'];
        $price = $_POST['price'];
        $package_type = $_POST['package_type'];
        $description = $_POST['description'];
        $link = $_POST['link'];

        $sql = "UPDATE destinations SET name = ?, location = ?, price = ?, description = ?, link = ?, package_type = ?";
        $params = [$name, $location, $price, $description, $link, $package_type];
        $types = "ssdsss";

        if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] == 0) {
            $stmt_old_img = $main_conn->prepare("SELECT image_path FROM destinations WHERE id = ?");
            $stmt_old_img->bind_param("i", $id);
            $stmt_old_img->execute();
            $result_old_img = $stmt_old_img->get_result();
            if ($row_old_img = $result_old_img->fetch_assoc()) {
                if (!empty($row_old_img['image_path']) && file_exists($row_old_img['image_path'])) {
                    unlink($row_old_img['image_path']);
                }
            }
            $stmt_old_img->close();

            $target_dir = "img/assets/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $image_name = time() . '_' . basename($_FILES["new_image"]["name"]);
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
                $sql .= ", image_path = ?";
                $params[] = $target_file;
                $types .= "s";
            }
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;
        $types .= "i";

        $stmt = $main_conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            header("Location: admin.php?status=update_sukses&context=Destinasi#destinasi");
        } else {
            header("Location: admin.php?status=update_gagal&context=Destinasi&error=" . urlencode($stmt->error) . "#destinasi");
        }
        $stmt->close();
        exit();
    }
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    if ($action == 'update_booking_status' && $id > 0 && isset($_GET['status'])) {
        $new_status = $_GET['status'];
        if (in_array($new_status, ['Terima', 'Tolak', 'Dibatalkan'])) {
            $stmt = $main_conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $new_status, $id);
            if ($stmt->execute()) {
                header("Location: admin.php?status=update_sukses&context=Status Pesanan#pesanan");
            } else {
                header("Location: admin.php?status=update_gagal&context=Status Pesanan#pesanan");
            }
            $stmt->close();
            exit();
        }
    }

    if ($action == 'delete_destination' && $id > 0) {
        $stmt = $main_conn->prepare("DELETE FROM destinations WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: admin.php?status=hapus_sukses&context=Destinasi#destinasi");
        } else {
            header("Location: admin.php?status=hapus_gagal&context=Destinasi#destinasi");
        }
        $stmt->close();
        exit();
    }

    if ($action == 'delete_review' && $id > 0) {
        $stmt = $main_conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: admin.php?status=hapus_sukses&context=Ulasan#ulasan");
        } else {
            header("Location: admin.php?status=hapus_gagal&context=Ulasan#ulasan");
        }
        $stmt->close();
        exit();
    }

    if ($action == 'delete_user' && $id > 0) {
        $stmt = $main_conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: admin.php?status=hapus_sukses&context=Pengguna#pengguna");
        } else {
            header("Location: admin.php?status=hapus_gagal&context=Pengguna#pengguna");
        }
        $stmt->close();
        exit();
    }

    if ($action == 'delete_gallery_image' && $id > 0) {
        $stmt_select = $main_conn->prepare("SELECT path FROM detail_image WHERE id = ?");
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (file_exists($row['path'])) {
                unlink($row['path']);
            }

            $stmt_delete = $main_conn->prepare("DELETE FROM detail_image WHERE id = ?");
            $stmt_delete->bind_param("i", $id);
            if ($stmt_delete->execute()) {
                header("Location: admin.php?status=hapus_sukses&context=Gambar Galeri#unggah-galeri");
            } else {
                header("Location: admin.php?status=hapus_gagal&context=Gambar Galeri#unggah-galeri");
            }
            $stmt_delete->close();
        }
        $stmt_select->close();
        exit();
    }
}

$new_bookings_count = $main_conn->query("SELECT COUNT(*) as count FROM bookings WHERE status IN ('Menunggu Konfirmasi', 'Menunggu Konfirmasi WA', 'Pending')")->fetch_assoc()['count'];
$destinations_count = $main_conn->query("SELECT COUNT(*) as count FROM destinations")->fetch_assoc()['count'];
$reviews_count = $main_conn->query("SELECT COUNT(*) as count FROM reviews")->fetch_assoc()['count'];
$users_count = $main_conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

$search_user_keyword = '';
$sql_users = "SELECT id, first_name, last_name, email, role, phone FROM users";
if (isset($_GET['search_user']) && !empty($_GET['search_user'])) {
    $search_user_keyword = $_GET['search_user'];
    $search_term = "%" . $main_conn->real_escape_string($search_user_keyword) . "%";
    $sql_users .= " WHERE CONCAT(first_name, ' ', last_name) LIKE ?";
}
$sql_users .= " ORDER BY id ASC";
$stmt_users = $main_conn->prepare($sql_users);
if (!empty($search_user_keyword)) {
    $stmt_users->bind_param("s", $search_term);
}
$stmt_users->execute();
$all_users_result = $stmt_users->get_result();

$filter_location = '';
$sql_gallery = "SELECT di.id, di.path, d.name as destination_name FROM detail_image di JOIN destinations d ON di.destinations_id = d.id";
if (isset($_GET['filter_location']) && !empty($_GET['filter_location'])) {
    $filter_location = $_GET['filter_location'];
    $sql_gallery .= " WHERE d.location = ?";
}
$sql_gallery .= " ORDER BY di.id DESC";
$stmt_gallery = $main_conn->prepare($sql_gallery);
if (!empty($filter_location)) {
    $stmt_gallery->bind_param("s", $filter_location);
}
$stmt_gallery->execute();
$gallery_images_result = $stmt_gallery->get_result();

$all_bookings_result = $main_conn->query("SELECT b.id, b.booking_date, b.status, u.first_name, u.last_name, d.name as destination_name FROM bookings AS b JOIN users AS u ON b.user_id = u.id JOIN booking_items AS bi ON bi.booking_id = b.id JOIN destinations AS d ON bi.destination_id = d.id GROUP BY b.id, b.booking_date, b.status, u.first_name, u.last_name, d.name ORDER BY b.id DESC");
$destinations_result = $main_conn->query("SELECT * FROM destinations ORDER BY id ASC");
$destinations_for_upload = $main_conn->query("SELECT id, name FROM destinations ORDER BY name ASC");
$reviews_result = $main_conn->query("SELECT r.*, u.first_name, u.last_name, d.name as destination_name FROM reviews r JOIN users u ON r.user_id = u.id JOIN destinations d ON r.destination_id = d.id ORDER BY r.created_at DESC");
$all_admins_result = null;
if (!isset($admin_db_error)) {
    $all_admins_result = $admin_conn->query("SELECT id, username FROM admins ORDER BY id ASC");
}
$location_query = $main_conn->query("SELECT DISTINCT location FROM destinations WHERE location IS NOT NULL AND location != '' ORDER BY location ASC");
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EXJO Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="img/assets/carousel/exjo.ico">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .wrapper {
            display: flex;
            align-items: stretch;
        }

        .admin-sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #040E27;
            color: white;
            transition: all 0.3s;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            overflow-y: auto;
        }

        .admin-sidebar .logo {
            padding: 20px 15px;
            text-align: center;
        }

        .admin-sidebar .nav-link {
            color: #adb5bd;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
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

        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
            margin-left: 250px;
        }

        .section-title {
            padding-top: 60px;
            margin-top: -60px;
            margin-bottom: 20px;
            font-weight: 700;
            color: #040E27;
        }

        #sidebarCollapse {
            display: none;
            background: #040E27;
            border: none;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .dashboard-card {
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1)
        }

        .dashboard-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px
        }

        .dashboard-card p {
            color: #f1f1f1;
            font-weight: 400;
            margin-bottom: 0
        }

        .card-bookings {
            background: linear-gradient(45deg, #ff4a52, #ff9068)
        }

        .card-destinations {
            background: linear-gradient(45deg, #4776E6, #8E54E9)
        }

        .card-reviews {
            background: linear-gradient(45deg, #00c6ff, #0072ff)
        }

        .card-users {
            background: linear-gradient(45deg, #11998e, #38ef7d)
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .05)
        }

        .card-header {
            font-weight: 700;
            background-color: #fff
        }

        .table-responsive {
            background: #fff;
            border-radius: 8px;
            padding: 15px
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .05);
        }

        .badge-Dibatalkan,
        .badge-Tolak {
            background-color: #dc3545;
            color: white;
        }

        .badge-Terima {
            background-color: #28a745;
            color: white;
        }

        .badge-Pending,
        .badge-Menunggu-Konfirmasi,
        .badge-Menunggu-Konfirmasi-WA {
            background-color: #ffc107;
            color: #212529;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                margin-left: -250px;
            }

            .admin-sidebar.toggled {
                margin-left: 0;
            }

            #content {
                margin-left: 0;
            }

            #sidebarCollapse {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1001;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="admin-sidebar" class="admin-sidebar">
            <div class="sidebar-sticky">
                <div class="logo"><a href="admin.php"><img src="img/assets/carousel/exjoputih.png" class="img-fluid"
                            alt="EXJO Admin Logo"></a></div>
                <div class="nav flex-column">
                    <a class="nav-link" href="#dashboard"><i class="fa fa-tachometer"></i> Dashboard</a>
                    <a class="nav-link" href="#pesanan"><i class="fa fa-calendar-check-o"></i> Pesanan</a>
                    <a class="nav-link" href="#destinasi"><i class="fa fa-map-marker"></i> Destinasi</a>
                    <a class="nav-link" href="#ulasan"><i class="fa fa-comments"></i> Ulasan</a>
                    <a class="nav-link" href="#pengguna"><i class="fa fa-users"></i> Pengguna</a>
                    <a class="nav-link" href="#administrator"><i class="fa fa-user-secret"></i> Administrator</a>
                    <a class="nav-link" href="#tambah-destinasi"><i class="fa fa-plus-circle"></i> Tambah Destinasi</a>
                    <a class="nav-link" href="#unggah-galeri"><i class="fa fa-photo"></i> Unggah Galeri</a>
                    <hr style="background-color: #495057;">
                    <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </div>
        </nav>

        <main id="content" role="main" class="admin-content">
            <button type="button" id="sidebarCollapse" class="btn"><i class="fa fa-bars"></i></button>
            <?php if (isset($admin_db_error))
                echo '<div class="alert alert-danger">' . $admin_db_error . '</div>'; ?>

            <section id="dashboard">
                <h2 class="section-title">Ringkasan Dashboard</h2>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="dashboard-card card-bookings">
                            <h3><?php echo $new_bookings_count; ?></h3>
                            <p>Pesanan Baru</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="dashboard-card card-destinations">
                            <h3><?php echo $destinations_count; ?></h3>
                            <p>Total Destinasi</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="dashboard-card card-reviews">
                            <h3><?php echo $reviews_count; ?></h3>
                            <p>Total Ulasan</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="dashboard-card card-users">
                            <h3><?php echo $users_count; ?></h3>
                            <p>Total Pengguna</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="pesanan" class="mt-4">
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
                                        <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['destination_name']); ?></td>
                                        <td><?php echo date('d M Y', strtotime($row['booking_date'])); ?></td>
                                        <td><span
                                                class="badge badge-<?php echo str_replace(' ', '-', $row['status']); ?>"><?php echo htmlspecialchars($row['status']); ?></span>
                                        </td>
                                        <td>
                                            <?php if (in_array($row['status'], ['Pending', 'Menunggu Konfirmasi', 'Menunggu Konfirmasi WA'])): ?>
                                                <a href="admin.php?action=update_booking_status&id=<?php echo $row['id']; ?>&status=Terima"
                                                    class="btn btn-sm btn-success btn-terima">Terima</a>
                                                <a href="admin.php?action=update_booking_status&id=<?php echo $row['id']; ?>&status=Tolak"
                                                    class="btn btn-sm btn-danger btn-tolak">Tolak</a>
                                            <?php else:
                                                echo '<span>-</span>';
                                            endif; ?>
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

            <section id="destinasi" class="mt-4">
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
                            <?php mysqli_data_seek($destinations_result, 0);
                            if ($destinations_result->num_rows > 0):
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
                                            <button class="btn btn-sm btn-primary edit-dest-btn"
                                                data-id="<?php echo $row['id']; ?>">Edit</button>
                                            <a href="admin.php?action=delete_destination&id=<?php echo $row['id']; ?>#destinasi"
                                                class="btn btn-sm btn-danger btn-hapus-destinasi">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="ulasan" class="mt-4">
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
                                        <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['destination_name']); ?></td>
                                        <td><?php for ($i = 0; $i < $row['rating']; $i++) {
                                            echo '<i class="fa fa-star text-warning"></i>';
                                        }
                                        for ($i = $row['rating']; $i < 5; $i++) {
                                            echo '<i class="fa fa-star-o text-secondary"></i>';
                                        } ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['comment']); ?></td>
                                        <td><a href="admin.php?action=delete_review&id=<?php echo $row['id']; ?>#ulasan"
                                                class="btn btn-sm btn-danger btn-hapus-ulasan">Hapus</a></td>
                                    </tr>
                                <?php endwhile; else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada ulasan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="pengguna" class="mt-4">
                <h2 class="section-title">Manajemen Pengguna</h2>
                <form method="GET" action="admin.php#pengguna" class="form-inline mb-3">
                    <input type="text" name="search_user" class="form-control mr-2" placeholder="Cari nama pengguna..."
                        value="<?php echo htmlspecialchars($search_user_keyword); ?>">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="admin.php#pengguna" class="btn btn-secondary ml-2">Reset</a>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($all_users_result->num_rows > 0):
                                while ($row = $all_users_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['phone'] ?? '-'); ?></td>
                                        <td><span
                                                class="badge badge-<?php echo ($row['role'] == 'admin') ? 'info' : 'secondary'; ?>"><?php echo htmlspecialchars(ucfirst($row['role'])); ?></span>
                                        </td>
                                        <td>
                                            <a href="admin.php?action=delete_user&id=<?php echo $row['id']; ?>"
                                                class="btn btn-sm btn-danger btn-hapus-user">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada pengguna yang cocok dengan pencarian.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="administrator" class="mt-4">
                <h2 class="section-title">Data Administrator</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($all_admins_result && $all_admins_result->num_rows > 0):
                                while ($row = $all_admins_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    </tr>
                                <?php endwhile; else: ?>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <?php echo isset($admin_db_error) ? 'Gagal memuat data admin.' : 'Belum ada data admin.'; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="tambah-destinasi" class="mt-4">
                <h2 class="section-title">Tambah Destinasi Baru</h2>
                <div class="form-container">
                    <form action="tambah_destinasi.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Destinasi</label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Lokasi</label>
                                    <select class="form-control" name="location" id="location" required>
                                        <option value="">Pilih Lokasi</option>
                                        <?php mysqli_data_seek($location_query, 0);
                                        while ($loc_row = $location_query->fetch_assoc()): ?>
                                            <option value="<?php echo htmlspecialchars($loc_row['location']); ?>">
                                                <?php echo htmlspecialchars($loc_row['location']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="link">Link Google Maps</label>
                            <input type="url" class="form-control" name="link" id="link" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Harga Tiket (Rp)</label>
                                    <input type="number" class="form-control" name="price" id="price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="package_type">Tipe Paket</label>
                                    <select class="form-control" name="package_type" id="package_type">
                                        <option value="Regular">Regular</option>
                                        <option value="VIP">VIP</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" name="description" id="description" rows="4"
                                required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Unggah Gambar Utama</label>
                                    <input type="file" class="form-control-file" name="image" id="image" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gallery_images">Unggah Gambar Galeri (Opsional)</label>
                                    <input type="file" class="form-control-file" name="gallery_images[]"
                                        id="gallery_images" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 text-right">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary">Tambah Destinasi</button>
                        </div>
                    </form>
                </div>
            </section>

            <section id="unggah-galeri" class="mt-5">
                <h2 class="section-title">Unggah & Kelola Galeri</h2>
                <div class="form-container mb-4">
                    <h4 class="mb-3">Unggah Gambar Baru</h4>
                    <form action="proses_upload_gallery.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="destination_id_gallery">Pilih Destinasi</label>
                            <select name="destination_id" id="destination_id_gallery" class="form-control" required>
                                <option value="">Pilih Destinasi</option>
                                <?php mysqli_data_seek($destinations_for_upload, 0);
                                if ($destinations_for_upload->num_rows > 0):
                                    while ($row = $destinations_for_upload->fetch_assoc()): ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?>
                                        </option>
                                    <?php endwhile; endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gallery_images_upload">Pilih Gambar (bisa lebih dari satu)</label>
                            <input type="file" class="form-control-file" name="gallery_images[]"
                                id="gallery_images_upload" multiple required>
                        </div>
                        <button type="submit" class="btn btn-success">Unggah ke Galeri</button>
                    </form>
                </div>

                <h4 class="mt-5">Daftar Semua Gambar di Galeri</h4>
                <form method="GET" action="admin.php#unggah-galeri" class="form-inline mb-3">
                    <label for="filter_location" class="mr-2">Filter berdasarkan Lokasi:</label>
                    <select name="filter_location" id="filter_location" class="form-control mr-2"
                        onchange="this.form.submit()">
                        <option value="">Semua Lokasi</option>
                        <?php mysqli_data_seek($location_query, 0);
                        while ($location_row = $location_query->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($location_row['location']); ?>" <?php if ($filter_location == $location_row['location'])
                                   echo 'selected'; ?>>
                                <?php echo htmlspecialchars($location_row['location']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <a href="admin.php#unggah-galeri" class="btn btn-secondary ml-2">Reset Filter</a>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Preview</th>
                                <th>Path File</th>
                                <th>Untuk Destinasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($gallery_images_result && $gallery_images_result->num_rows > 0):
                                while ($row = $gallery_images_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><img src="<?php echo htmlspecialchars($row['path']); ?>" width="100"
                                                class="img-thumbnail"></td>
                                        <td><?php echo htmlspecialchars($row['path']); ?></td>
                                        <td><?php echo htmlspecialchars($row['destination_name']); ?></td>
                                        <td><a href="admin.php?action=delete_gallery_image&id=<?php echo $row['id']; ?>#unggah-galeri"
                                                class="btn btn-sm btn-danger btn-hapus-galeri">Hapus</a></td>
                                    </tr>
                                <?php endwhile; else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada gambar di galeri atau tidak ada yang cocok
                                        dengan filter.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div class="modal fade" id="editDestinationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Destinasi</h5><button type="button" class="close"
                        data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="admin.php#destinasi" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-dest-id">
                        <div class="form-group"><label for="edit-dest-name">Nama Destinasi</label><input type="text"
                                class="form-control" name="name" id="edit-dest-name" required></div>
                        <div class="form-group"><label for="edit-dest-location">Lokasi</label><input type="text"
                                class="form-control" name="location" id="edit-dest-location" required></div>
                        <div class="form-group"><label for="edit-dest-link">Link Google Maps</label><input type="url"
                                class="form-control" name="link" id="edit-dest-link" required></div>
                        <div class="form-group"><label for="edit-dest-price">Harga Tiket (Rp)</label><input
                                type="number" class="form-control" name="price" id="edit-dest-price" required></div>
                        <div class="form-group">
                            <label for="edit-dest-package">Tipe Paket</label>
                            <select class="form-control" name="package_type" id="edit-dest-package">
                                <option value="Regular">Regular</option>
                                <option value="VIP">VIP</option>
                            </select>
                        </div>
                        <div class="form-group"><label for="edit-dest-description">Deskripsi</label><textarea
                                class="form-control" name="description" id="edit-dest-description" rows="3"
                                required></textarea></div>
                        <div class="form-group">
                            <label>Ganti Foto Cover (Opsional)</label>
                            <input type="file" name="new_image" class="form-control-file" accept="image/*">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Batal</button><button type="submit" name="update_destination"
                            class="btn btn-primary">Simpan Perubahan</button></div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () { $('#admin-sidebar').toggleClass('toggled'); });

            function setActiveSidebarLink() {
                var scrollPos = $(document).scrollTop();
                var found = false;
                $('.admin-sidebar .nav-link').each(function () {
                    var currLink = $(this);
                    var href = currLink.attr("href");
                    if (href && href.startsWith('#')) {
                        var refElement = $(href);
                        if (refElement.length && refElement.position().top <= scrollPos + 100 && refElement.position().top + refElement.height() > scrollPos + 100) {
                            $('.admin-sidebar .nav-link').removeClass("active");
                            currLink.addClass("active");
                            found = true;
                        }
                    }
                });
                if (!found) {
                    var hash = window.location.hash || '#dashboard';
                    $('.admin-sidebar .nav-link').removeClass('active');
                    $('.admin-sidebar .nav-link[href="' + hash + '"]').addClass('active');
                }
            }

            $(window).on('scroll', setActiveSidebarLink);
            setActiveSidebarLink();

            $(document).on('click', '.admin-sidebar .nav-link', function (event) {
                var href = $(this).attr('href');
                if (href && href.startsWith('#')) {
                    event.preventDefault();
                    var target = $(href);
                    if (target.length) {
                        $('html, body').animate({ scrollTop: target.offset().top }, 500, function () {
                            if (history.pushState) {
                                history.pushState(null, null, href);
                            } else {
                                window.location.hash = href;
                            }
                            setActiveSidebarLink();
                        });
                    }
                }
            });

            $('.edit-dest-btn').on('click', function () {
                var destId = $(this).data('id');
                $.ajax({
                    url: 'get_destinations.php',
                    type: 'POST',
                    data: { id: destId },
                    dataType: 'json',
                    success: function (data) {
                        if (data) {
                            $('#edit-dest-id').val(data.id);
                            $('#edit-dest-name').val(data.name);
                            $('#edit-dest-location').val(data.location);
                            $('#edit-dest-link').val(data.link);
                            $('#edit-dest-price').val(data.price);
                            $('#edit-dest-package').val(data.package_type);
                            $('#edit-dest-description').val(data.description);
                            $('#editDestinationModal').modal('show');
                        } else {
                            Swal.fire('Error', 'Gagal mengambil data destinasi.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Tidak dapat terhubung ke server. Pastikan file get_destinations.php ada.', 'error');
                    }
                });
            });

            function addConfirmationListener(selector, title, text, confirmButtonText, color) {
                $(document).on('click', selector, function (e) {
                    e.preventDefault();
                    const href = $(this).attr('href');
                    Swal.fire({
                        title: title, text: text, icon: 'warning', showCancelButton: true,
                        confirmButtonColor: color || '#d33', cancelButtonColor: '#6c757d',
                        confirmButtonText: confirmButtonText, cancelButtonText: 'Batal'
                    }).then((result) => { if (result.isConfirmed) { window.location.href = href; } });
                });
            }
            addConfirmationListener('.btn-hapus-destinasi', 'Hapus Destinasi?', 'Data ini akan dihapus permanen!', 'Ya, hapus!');
            addConfirmationListener('.btn-hapus-ulasan', 'Hapus Ulasan?', 'Ulasan ini akan dihapus permanen!', 'Ya, hapus!');
            addConfirmationListener('.btn-hapus-galeri', 'Hapus Gambar?', 'Gambar ini akan dihapus dari server!', 'Ya, hapus!');
            addConfirmationListener('.btn-hapus-user', 'Hapus Pengguna?', 'Akun ini akan dihapus permanen! Tindakan ini tidak bisa dibatalkan.', 'Ya, hapus!');
            addConfirmationListener('.btn-tolak', 'Tolak Pesanan?', 'Anda yakin akan menolak pesanan ini?', 'Ya, tolak!');
            addConfirmationListener('.btn-terima', 'Terima Pesanan?', "Anda yakin akan menerima pesanan ini?", 'Ya, terima!', '#28a745');

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('status')) {
                const status = urlParams.get('status');
                const context = urlParams.get('context') || 'Data';
                let title, text, icon;

                if (status.includes('sukses')) {
                    title = 'Berhasil!';
                    icon = 'success';
                    switch (status) {
                        case 'update_sukses': text = context + ' berhasil diperbarui.'; break;
                        case 'hapus_sukses': text = context + ' berhasil dihapus.'; break;
                        case 'upload_sukses': text = urlParams.get('count') + ' gambar berhasil diunggah.'; break;
                        case 'tambah_sukses': text = context + ' berhasil ditambahkan.'; break;
                    }
                } else if (status.includes('gagal')) {
                    title = 'Gagal!';
                    icon = 'error';
                    const errorMsg = urlParams.get('error');
                    text = context + ' gagal diproses.';
                    if (errorMsg) {
                        text += ' Pesan error: ' + decodeURIComponent(errorMsg);
                    }
                }

                if (title) {
                    Swal.fire({
                        icon: icon, title: title, text: text,
                        timer: 3500, showConfirmButton: false
                    });
                    const newUrl = window.location.pathname + window.location.hash;
                    window.history.replaceState({}, document.title, newUrl);
                }
            }
        });
    </script>
</body>

</html>