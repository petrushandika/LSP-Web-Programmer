<?php
require_once '../templates/config/db_connection.php';

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
}

$id_artikel = (int)$_GET['id_artikel'];

// check if id_artikel is exist
$query = "SELECT * FROM t_artikel WHERE id_artikel=?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id_artikel);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // delete data
    echo "<script>alert('DATA BERHASIL DIHAPUS')</script>";
    $query = "DELETE FROM t_artikel WHERE id_artikel=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id_artikel);
    $stmt->execute();
    header("Location: ../dashboard.php");
} else {
    echo "<script>alert('GAGAL MENGHAPUS DATA')</script>";
}

?>