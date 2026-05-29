<?php
require_once 'templates/config/db_connection.php';

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
}

$query = "SELECT t_artikel.*, t_admin.nama FROM t_artikel JOIN t_admin ON t_artikel.id_admin = t_admin.id_admin ORDER BY id_artikel DESC";
$stmt = $connection->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- layout -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
            <th scope="col" style="width: 10%">#</th>
            <th scope="col" style="width: 30%">Title</th>
            <th scope="col" style="width: 10%">Author</th>
            <th scope="col" style="width: 10%">Kolom Komentar</th>
            <th scope="col" style="width: 20%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
          <?php foreach ($result as $row): ?>
          <tr>
            <th scope="row">
              <img
                src="<?php echo $row['gambar']; ?>"
                width="75"
                height="75"
                class="img-thumbnail"
                onerror="this.onerror=null; this.src='./templates/img/picture.png';"
              />
            </th>
            <td>
              <a href="/project_jwp/artikel/detail.php?id_artikel=<?php echo $row['id_artikel']; ?>" class="text-decoration-none text-dark">
                <?php echo $row['judul_artikel']; ?>
              </a>
            </td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php $status = ($row['status_komentar']) ? 'Buka' : 'Tutup'; echo $status; ?></td>
            <td>
              <a href="./artikel/delete.php?id_artikel=<?php echo $row['id_artikel']; ?>"
              onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                <button name="hapus_post" class="btn btn-danger poppins">
                  HAPUS
                </button>
              </a>
              <br>
              <a href="./artikel/update.php?id_artikel=<?php echo $row['id_artikel']; ?>"
              onclick="return confirm('Apakah Anda yakin ingin mengubah data ini?')">
                <button name="buka_tutup" class="btn btn-primary btn-sm m-1 poppins">
                  Buka/Tutup Komentar
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
