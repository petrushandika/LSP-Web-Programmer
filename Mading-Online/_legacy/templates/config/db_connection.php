<?php
// Informasi koneksi database
$db_server = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'db_jewepe';

// Membuat koneksi ke database
$connection = new mysqli($db_server, $db_user, $db_password, $db_name);

// Memeriksa koneksi
if ($connection->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>
