<?php
include 'database.php';

// Pastikan ada data lokasi yang dikirim
if (isset($_POST['location'])) {
    $location = $_POST['location'];

    // Ambil ID dan NAMA destinasi berdasarkan lokasi
    $stmt = $main_conn->prepare("SELECT id, name FROM destinations WHERE location = ? ORDER BY name");
    $stmt->bind_param("s", $location);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<option value="">Pilih Destinasi</option>';
        while ($row = $result->fetch_assoc()) {
            // Value dari option adalah ID, sedangkan yang tampil adalah Nama
            echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
        }
    } else {
        echo '<option value="">Tidak ada destinasi</option>';
    }
    $stmt->close();
}
?>