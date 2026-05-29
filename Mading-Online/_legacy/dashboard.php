<?php
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
}

$activeMenu = isset($_GET['menu']) ? $_GET['menu'] : 'menu_daftar_artikel';
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

    <!-- Bootstrap Icons CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <!-- text editor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

    <!-- favicon -->
    <link
      rel="shortcut icon"
      href="https://img.icons8.com/stickers/100/module.png"
      type="image/x-icon"
    />

    <title>Dashboard - Mading Online JeWePe</title>
  </head>
  <body>
    <!-- header -->
    <?php
    include('templates/header.php');
    ?>

    <!-- dashboard -->
    <div class="container-fluid">
      <div class="row flex-nowrap">
        <!-- sidebar -->
        <div
          class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark"
          style="width: 280px"
        >
          <div
            class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100"
          >
            <div
              class="d-flex align-items-center pb-3 mb-3 link-light text-decoration-none mt-3"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="40"
                height="32"
                fill="currentColor"
                class="bi bi-person-circle me-2"
                viewBox="0 0 16 16"
              >
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path
                  fill-rule="evenodd"
                  d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"
                />
              </svg>
              <span class="fs-3" style="font-weight: bold"
                ><?php echo $_SESSION['name'] ?></span
              >
            </div>
            <div class="mb-3">
              <!-- new post -->
              <a href="?menu=menu_add_post">
                <button
                  type="button"
                  class="btn btn-light pt-3 pb-3 ps-5 pe-5 rounded-pill"
                  style="color: orange"
                >
                  <span class="bi-plus-square-fill fa-lg"></span>
                  <strong> &nbsp;Buat Artikel </strong>
                </button>
              </a>
            </div>
            <div class="border-bottom w-100"></div>
            <ul
              class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
              id="menu"
            >
              <li class="nav-item">
                <a
                  href="?menu=menu_daftar_artikel"
                  class="nav-link align-middle px-0 <?php echo ($activeMenu === 'menu_daftar_artikel') ? 'link-warning' : 'link-light'; ?>"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="30"
                    height="30"
                    fill="currentColor"
                    class="bi bi-file-earmark-richtext-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM7 6.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0zm-.861 1.542 1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047l1.888.974V9.5a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V9s1.54-1.274 1.639-1.208zM5 11h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z"
                    />
                  </svg>
                  <span
                    class="ms-1 d-none d-sm-inline fs-4"
                    style="font-weight: bold"
                    >Artikel</span
                  >
                </a>
              </li>
              <li>
                <a
                  href="?menu=menu_laporan"
                  class="nav-link px-0 align-middle <?php echo ($activeMenu === 'menu_laporan') ? 'link-warning' : 'link-light'; ?>"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="30"
                    height="30"
                    fill="currentColor"
                    class="bi bi-file-earmark-bar-graph"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"
                    />
                    <path
                      d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"
                    />
                  </svg>
                  <span
                    class="ms-1 d-none d-sm-inline fs-4"
                    style="font-weight: bold"
                    >Laporan</span
                  ></a
                >
              </li>
              <li>
                <a
                  href="?menu=menu_komentar"
                  class="nav-link px-0 align-middle <?php echo ($activeMenu === 'menu_komentar') ? 'link-warning' : 'link-light'; ?>"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="30"
                    height="30"
                    fill="currentColor"
                    class="bi bi-chat-left-text-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z"
                    />
                  </svg>
                  <span
                    class="ms-1 d-none d-sm-inline fs-4"
                    style="font-weight: bold"
                    >Komentar</span
                  >
                </a>
              </li>
            </ul>
            <div class="border-top w-100 mb-3"></div>
            <div class="pb-4">
              <a
                href="index.php"
                target="_blank"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-light text-decoration-none"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-box-arrow-up-right me-2"
                  viewBox="0 0 16 16"
                >
                  <path
                    fill-rule="evenodd"
                    d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"
                  />
                  <path
                    fill-rule="evenodd"
                    d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"
                  />
                </svg>
                <strong>Lihat Web</strong>
              </a>
            </div>
          </div>
        </div>
        <!-- content -->
        <div class="col py-3">
          <?php switch ($activeMenu) {
            case "menu_add_post":
              include('artikel/insert.php');
              break;
            case "menu_daftar_artikel":
              include('artikel/list_artikel.php');
              break;
            case "menu_laporan":
              include('laporan.php');
              break;
            case "menu_komentar":
              include('komentar/list_komentar.php');
              break;
            default:
              include('templates/no_entry.php');
          } ?>
        </div>
      </div>
    </div>

    <!-- footer -->
    <?php
    include('templates/footer.php');
    ?>

    <!-- custom script -->
    <script src="templates/js/script.js"></script>
  </body>
</html>
