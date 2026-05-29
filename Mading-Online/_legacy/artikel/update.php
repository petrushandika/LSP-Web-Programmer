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
    $row = $result->fetch_assoc();
    $new_status = !$row['status_komentar'];
    // update data
    $status = ($new_status) ? "DIBUKA" : "DITUTUP";
    echo "<script>alert('KOLOM KOMENTAR BERHASIL " . $status . ")</script>";
    $query = "UPDATE t_artikel SET status_komentar = ? WHERE id_artikel=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ii", $new_status, $id_artikel);
    $stmt->execute();
    header("Location: ../dashboard.php");
} else {
    echo "<script>alert('GAGAL MENGUBAH DATA')</script>";
}

?>