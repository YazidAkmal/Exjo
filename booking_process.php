<?php
include 'init.php';
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

function redirect_with_error($message)
{
    header("Location: reservasi.php?status=gagal&error=" . urlencode($message));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['destination_ids']) || !is_array($_POST['destination_ids'])) {
        redirect_with_error('Anda harus memilih setidaknya satu destinasi.');
    }
    if (empty($_POST['booking_date']) || empty($_POST['num_people'])) {
        redirect_with_error('Tanggal dan jumlah orang wajib diisi.');
    }

    $user_id = $_SESSION['user_id'];
    $destination_ids = $_POST['destination_ids'];
    $booking_date = $_POST['booking_date'];
    $num_people = (int) $_POST['num_people'];

    $main_conn->begin_transaction();
    try {
        $placeholders = implode(',', array_fill(0, count($destination_ids), '?'));
        $types = str_repeat('i', count($destination_ids));
        $stmt_price = $main_conn->prepare("SELECT id, name, price FROM destinations WHERE id IN ($placeholders)");
        $stmt_price->bind_param($types, ...$destination_ids);
        $stmt_price->execute();
        $dest_results = $stmt_price->get_result();

        $total_price_destinations = 0;
        $destination_names = [];
        while ($row = $dest_results->fetch_assoc()) {
            $total_price_destinations += (float) $row['price'];
            $destination_names[] = $row['name'];
        }
        $final_total_price = $total_price_destinations * $num_people;
        $stmt_price->close();

        $stmt_booking = $main_conn->prepare("INSERT INTO bookings (user_id, booking_date, num_people, total_price, status) VALUES (?, ?, ?, ?, 'Menunggu Konfirmasi WA')");
        $stmt_booking->bind_param("isid", $user_id, $booking_date, $num_people, $final_total_price);
        $stmt_booking->execute();
        $booking_id = $main_conn->insert_id;
        $stmt_booking->close();

        $stmt_items = $main_conn->prepare("INSERT INTO booking_items (booking_id, destination_id) VALUES (?, ?)");
        foreach ($destination_ids as $dest_id) {
            $stmt_items->bind_param("ii", $booking_id, $dest_id);
            $stmt_items->execute();
        }
        $stmt_items->close();
        $main_conn->commit();

        $stmt_user = $main_conn->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();
        $user_result = $stmt_user->get_result()->fetch_assoc();
        $nama_pelanggan = $user_result['first_name'] . ' ' . $user_result['last_name'];
        $stmt_user->close();

        $_SESSION['whatsapp_url'] = "https://api.whatsapp.com/send?phone=6281252700168&text=" . urlencode(
            "Halo Admin EXJO,\n\nKonfirmasi pesanan:\n\n" .
            "ID Pesanan: #BK" . $booking_id . "\n" .
            "Nama: " . $nama_pelanggan . "\n" .
            "Tanggal: " . $booking_date . "\n" .
            "Jumlah Orang: " . $num_people . " orang\n\n" .
            "Destinasi:\n- " . implode("\n- ", $destination_names) . "\n\n" .
            "Total Harga: Rp " . number_format($final_total_price, 0, ',', '.') . "\n\n" .
            "Mohon info langkah selanjutnya. Terima kasih."
        );

        header("Location: konfirmasi-wa.php?booking_id=" . $booking_id);
        exit();
    } catch (Exception $e) {
        $main_conn->rollback();
        redirect_with_error("Gagal membuat pesanan: " . $e->getMessage());
    }
}
?>