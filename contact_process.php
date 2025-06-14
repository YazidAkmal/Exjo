<?php
include 'database.php';

$name = $main_conn->real_escape_string($_REQUEST['name']);
$from = $main_conn->real_escape_string($_REQUEST['email']);
$subject = $main_conn->real_escape_string($_REQUEST['subject']);
$cmessage = $main_conn->real_escape_string($_REQUEST['message']);

$sql = "INSERT INTO contacts (name, email, subject, message) VALUES ('$name', '$from', '$subject', '$cmessage')";

if ($main_conn->query($sql) === TRUE) {
    $to = "exjoyk@gmail.com"; 

    $number = isset($_REQUEST['number']) ? $_REQUEST['number'] : '';
    $csubject = $subject;

    $headers = "From: $from" . "\r\n";
    $headers .= "Reply-To: ". $from . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $email_subject = "Pesan baru dari website EXJO: " . $csubject;

    $logo = 'img/assets/carousel/exjologo.png';
    $link = '#';

    $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
    $body .= "<table style='width: 100%;'>";
    $body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
    $body .= "<a href='{$link}'><img src='{$logo}' alt=''></a><br><br>";
    $body .= "</td></tr></thead><tbody><tr>";
    $body .= "<td style='border:none;'><strong>Name:</strong> {$name}</td>";
    $body .= "<td style='border:none;'><strong>Email:</strong> {$from}</td>";
    $body .= "</tr>";
    $body .= "<tr><td style='border:none;'><strong>Subject:</strong> {$csubject}</td></tr>";
    $body .= "<tr><td></td></tr>";
    $body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
    $body .= "</tbody></table>";
    $body .= "</body></html>";

    mail($to, $email_subject, $body, $headers);
    header("Location: contact.php?status=sukses");
    echo '<a href="contact.php">Kembali</a>';

} else {
    header("Location: contact.php?status=gagal");
    echo "Error: " . $sql . "<br>" . $main_conn->error;
}
$main_conn->close();
?>