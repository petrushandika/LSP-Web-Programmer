<?php
require_once '../templates/config/db_connection.php';

if (isset($_POST['post_komentar'])) {
    $nama_user = $_POST['nama_user'];
    $email_user = $_POST['email_user'];
    $isi_komentar = $_POST['komentar_user'];
    $id_artikel = (int)$_GET['id_artikel'];

    $query = "INSERT INTO t_komentar (id_artikel, nama_user, email_user, isi_komentar) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("isss", $id_artikel, $nama_user, $email_user, $isi_komentar);
    $stmt->execute();
    echo "<script>alert('Komentar berhasil dikirim.')</script>";
    header("Location: ../artikel/detail.php?id_artikel=" . $id_artikel . "#comment_section");
}