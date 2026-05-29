<?php
require_once '../templates/config/db_connection.php';

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
}

$id_komentar = (int)$_GET['id_komentar'];

// check if id_artikel is exist
$query = "SELECT * FROM t_komentar WHERE id_komentar=?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id_komentar);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // delete data
    echo "<script>alert('KOMENTAR BERHASIL DIHAPUS')</script>";
    $query = "DELETE FROM t_komentar WHERE id_komentar=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id_komentar);
    $stmt->execute();
    header("Location: ../dashboard.php?menu=menu_komentar");
} else {
    echo "<script>alert('GAGAL MENGHAPUS KOMENTAR')</script>";
}

?>