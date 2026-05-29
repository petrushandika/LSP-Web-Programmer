<?php
require_once 'templates/config/db_connection.php';

session_start();

if (isset($_SESSION['name'])) {
    header("Location: dashboard.php");
}

if (isset($_POST['login'])) {
    $email_admin = $_POST['email'];
    $password_admin = md5($_POST['password']);

    $query = "SELECT * FROM t_admin WHERE email=? AND password=?";
    $stmt = $connection->prepare($query);

    $stmt->bind_param("ss", $email_admin, $password_admin);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['name'] = $row['nama'];
        $_SESSION['id_adm'] = $row['id_admin'];
        header("Location: dashboard.php");
    } else {
        echo "<script>alert('LOGIN GAGAL. Silakan coba lagi')</script>";
    }
}

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

    <title>LOGIN - Mading Online JeWePe</title>
  </head>
  <body style="margin: 0; background-color: #fffee6">
    <!-- header -->
    <?php
    include('templates/header.php');
    ?>

    <!-- content -->
    <!-- main container -->
    <div
      class="container d-flex justify-content-center align-items-center min-vh-100"
    >
      <!-- login container -->
      <div class="row border rounded-5 p-3 bg-white shadow box-area">
        <!-- left -->
        <div class="col-md-6 left-box">
          <div class="row align-items center">
            <div class="mt-3 mb-3 text-center">
              <img src="https://img.icons8.com/stickers/50/module.png" alt="" />
              <p class="logo-text">Sekolah Tinggi JeWePe</p>
              <h2 class="header-text mt-5 mb-3 poppins">Selamat Datang!</h2>
            </div>
            <form action="" method="POST">
            <p class="poppins">Email</p>
            <div class="input-group mb-4">
              <input
                type="text"
                class="form-control form-control-lg bg-light fs-6"
                name="email"
                placeholder="name@example.com"
                required
              />
            </div>
            <p class="poppins">Password</p>
            <div class="input-group mb-1">
              <input
                type="password"
                class="form-control form-control-lg bg-light fs-6"
                name="password"
                placeholder="********"
                required
              />
            </div>
            <!-- <div class="input-group mb-5 d-flex justify-content-between">
              <div class="form-check">
                <input
                  type="checkbox"
                  id="formCheck"
                  class="form-check-input"
                />
                <label for="formCheck" class="form-check-label text-secondary"
                  ><small>Remember Me</small></label
                >
              </div>
            </div> -->
            <div class="input-group mb-5 mt-5">
              <button name="login" class="btn btn-lg btn-warning w-100 fs-6">LOGIN</button>
            </div>
            </form>
          </div>
        </div>

        <!-- right -->
        <div
          class="col-md-6 right-box rounded-4 d-flex justify-content-center align-items-center flex-column"
          style="background: #ffdb00"
        >
          <div class="featured-image mb-5 mt-5">
            <img
              src="https://img.icons8.com/clouds/250/comics-magazine.png"
              class="img-fluid"
              alt="comics-magazine"
            />
          </div>
        </div>
      </div>
    </div>

    <!-- footer -->
    <?php
    include('templates/footer.php');
    ?>
  </body>
</html>
