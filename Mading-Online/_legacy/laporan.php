<?php
require_once 'templates/config/db_connection.php';

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
}

// get data from db
$query = "SELECT t_artikel.judul_artikel, COUNT(t_komentar.id_komentar) AS jumlah_komentar FROM t_artikel LEFT JOIN t_komentar ON t_artikel.id_artikel = t_komentar.id_artikel GROUP BY t_artikel.judul_artikel ORDER BY jumlah_komentar DESC";
$stmt = $connection->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// tanggal hari ini
$tanggal = date('d/m/Y');

?>

<!-- layout -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="templates/css/style.css" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <!-- Bootstrap Icons CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <title>Document</title>
</head>
<body>
    <div class="content">
        <div class="row">
            <div class="text-center mt-5">
                <h2 class="poppins">LAPORAN</h2>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-5">
        <div class="p-3" style="width: 75%;">
            <table class="table table-warning table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="width: 80%" class="ps-5 pt-3 pb-3">Judul Artikel</th>
                        <th scope="col" style="width: 20%" class="pe-5 pt-3 pb-3">Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                    <?php foreach ($result as $row): ?>
                    <tr>
                        <td class="ps-5 pe-3"><?php echo $row['judul_artikel']; ?></td>
                        <td class="pe-5"><?php echo $row['jumlah_komentar']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: include('templates/no_entry.php'); ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="text-end">
                Dicetak pada <?php echo $tanggal; ?> oleh <?php echo $_SESSION['name']; ?>
            </div>
        </div>
        </div>
    </div>

    <div class="d-flex justify-content-end w-75 pe-3 mt-5">
        <button id="btn-print" type="button" class="btn btn-success align-items-center"><i class="bi bi-printer-fill me-2" style="font-size: 1.5rem;"></i> <span class="h5">Cetak Laporan</span></button>
    </div>

    <!-- print content -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="templates/js/printThis.js"></script>
    <script>
        $(document).ready(function() {
            $('#btn-print').click(function() {
                $('.content').printThis();
            });
        });
    </script>
</body>
</html>