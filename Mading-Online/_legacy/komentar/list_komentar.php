<?php
require_once 'templates/config/db_connection.php';

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
}

$query = "SELECT t_komentar.*, t_artikel.judul_artikel FROM t_komentar JOIN t_artikel ON t_komentar.id_artikel = t_artikel.id_artikel ORDER BY id_komentar DESC";
$stmt = $connection->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
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

    <!-- favicon -->
    <link
      rel="shortcut icon"
      href="https://img.icons8.com/stickers/100/module.png"
      type="image/x-icon"
    />

    <title>Document</title>
</head>
<body>
    <div class="p-3" style="width: 100%">
      <table class="table table-warning table-striped table-hover">
        <thead>
          <tr>
            <th scope="col" style="width: 50%">Comments</th>
            <th scope="col" style="width: 20%">User</th>
            <th scope="col" style="width: 10%">Status Tampil</th>
            <th scope="col" style="width: 20%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
          <?php foreach ($result as $row): ?>
          <tr>
            <td class="ps-3">
              <a href="/project_jwp/artikel/detail.php?id_artikel=<?php echo $row['id_artikel']; ?>#comment_section" class="text-decoration-none text-dark">
                <div>
                    <?php echo $row['isi_komentar']; ?>
                </div>
                <div class="text-muted">
                    artikel: 
                    <span class="h6"><?php echo $row['judul_artikel']; ?></span>
                </div>
              </a>
            </td>
            <td><?php echo $row['nama_user']; ?></td>
            <td><?php $status = ($row['status_tampil']) ? 'Tampil' : 'Tidak'; echo $status; ?></td>
            <td>
              <a href="./komentar/delete.php?id_komentar=<?php echo $row['id_komentar']; ?>"
              onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                <button name="hapus_komentar" class="btn btn-danger poppins">
                  HAPUS
                </button>
              </a>
              <br>
              <a href="./komentar/update.php?id_komentar=<?php echo $row['id_komentar']; ?>"
              onclick="return confirm('Apakah Anda yakin ingin mengubah data ini?')">
                <button name="ubah_komentar" class="btn btn-primary btn-sm poppins m-1">
                  Ubah Status Tampil
                </button>
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php else: include('templates/no_entry.php'); ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
</body>
</html>