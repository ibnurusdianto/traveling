<?php
$session_expire_time = 600;
session_set_cookie_params($session_expire_time);
session_start();

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_expire_time)) {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit;
}

$_SESSION['last_activity'] = time();

if (isset($_SESSION['username'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'travel');
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        session_unset();
        session_destroy();
        header("Location: ../login.php");
        exit;
    } else {
        $row = mysqli_fetch_assoc($result);

        if ($row['role'] != 'admin') {
            header("Location: ../index.php");
            exit;
        }
    }
} else {
    header("Location: ../index.php");
    exit;
}
include('proses-user.php');
$query = mysqli_query($conn, "SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>User</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Eksternal -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">


<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <!-- Start Logo -->
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <img src="\" alt="">
                <span class="d-none d-lg-block">Travel</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

        <!-- Start Search Bar -->
        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <!-- End Search Bar -->

        <!-- Start Icons Navigation -->
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['username']; ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu">
                        <li>
                            <button class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#backModal">
                                <i class="bi bi-person"></i>
                                <span>Home</span>
                            </button>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Icons Navigation -->

    </header>
    <!-- End Header -->

    <!-- Modal back index -->
    <div class="modal fade" id="backModal" tabindex="-1" aria-labelledby="backModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="backModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to go back to the index?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="../index.php" class="btn btn-primary">Yes</a>
            </div>
            </div>
        </div>
    </div>
    <!-- End Modal back index -->

    <!--Modal Logout user session-->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  Are you sure you want to logout?
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-danger" id="confirmLogout">Logout</button>
              </div>
          </div>
      </div>
  </div>
<!--End Modal Logout user session-->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <!-- dashboard -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
                        <path d="M22 22L2 22" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M3 22.0001V11.3472C3 10.4903 3.36644 9.67432 4.00691 9.10502L10.0069 3.77169C11.1436 2.76133 12.8564 2.76133 13.9931 3.77169L19.9931 9.10502C20.6336 9.67432 21 10.4903 21 11.3472V22.0001" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M10 9H14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M9 15.5H15" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M9 18.5H15" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M18 22V16C18 14.1144 18 13.1716 17.4142 12.5858C16.8284 12 15.8856 12 14 12H10C8.11438 12 7.17157 12 6.58579 12.5858C6 13.1716 6 14.1144 6 16V22" stroke="#1C274C" stroke-width="1.5" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- end dashboard -->

            <!-- wisata -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="wisata.php">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
                        <path d="M18 8.80745C18 13.7615 13.7333 15 11.6 15C9.73333 15 6 13.7615 6 8.80745C6 6.71017 7.20839 5.35826 8.26099 4.65274C8.79638 4.29388 9.48354 4.55201 9.57296 5.17624C9.75127 6.421 10.8777 7.34944 11.5596 6.27998C12.1424 5.36614 12.3529 4.13169 12.3529 3.38896C12.3529 2.28965 13.503 1.59108 14.4009 2.2646C16.1512 3.5774 18 5.776 18 8.80745Z" stroke="#1C274C" stroke-width="1.5" />
                        <path d="M20 15L4 22" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M4 15L9 17.1875M20 22L14.5 19.5938" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M15 10C14.8 10.6667 13.92 12 12 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <span>Wisata</span>
                </a>
            </li>
            <!-- end wisata -->

            <!-- kategori -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="kategori.php">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
                        <path d="M16.755 2H7.24502C6.08614 2 5.50671 2 5.03939 2.16261C4.15322 2.47096 3.45748 3.18719 3.15795 4.09946C3 4.58055 3 5.17705 3 6.37006V20.3742C3 21.2324 3.985 21.6878 4.6081 21.1176C4.97417 20.7826 5.52583 20.7826 5.8919 21.1176L6.375 21.5597C7.01659 22.1468 7.98341 22.1468 8.625 21.5597C9.26659 20.9726 10.2334 20.9726 10.875 21.5597C11.5166 22.1468 12.4834 22.1468 13.125 21.5597C13.7666 20.9726 14.7334 20.9726 15.375 21.5597C16.0166 22.1468 16.9834 22.1468 17.625 21.5597L18.1081 21.1176C18.4742 20.7826 19.0258 20.7826 19.3919 21.1176C20.015 21.6878 21 21.2324 21 20.3742V6.37006C21 5.17705 21 4.58055 20.842 4.09946C20.5425 3.18719 19.8468 2.47096 18.9606 2.16261C18.4933 2 17.9139 2 16.755 2Z" stroke="#1C274C" stroke-width="1.5" />
                        <path d="M10.5 11L17 11" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M7 11H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M7 7.5H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M7 14.5H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M10.5 7.5H17" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M10.5 14.5H17" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <span>Kategori</span>
                </a>
            </li>
            <!-- end kategori -->

            <!-- fasilitas -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="fasilitas.php">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
                        <path d="M16 4.00195C18.175 4.01406 19.3529 4.11051 20.1213 4.87889C21 5.75757 21 7.17179 21 10.0002V16.0002C21 18.8286 21 20.2429 20.1213 21.1215C19.2426 22.0002 17.8284 22.0002 15 22.0002H9C6.17157 22.0002 4.75736 22.0002 3.87868 21.1215C3 20.2429 3 18.8286 3 16.0002V10.0002C3 7.17179 3 5.75757 3.87868 4.87889C4.64706 4.11051 5.82497 4.01406 8 4.00195" stroke="#1C274C" stroke-width="1.5" />
                        <path d="M10.5 14L17 14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M7 14H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M7 10.5H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M7 17.5H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M10.5 10.5H17" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M10.5 17.5H17" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M8 3.5C8 2.67157 8.67157 2 9.5 2H14.5C15.3284 2 16 2.67157 16 3.5V4.5C16 5.32843 15.3284 6 14.5 6H9.5C8.67157 6 8 5.32843 8 4.5V3.5Z" stroke="#1C274C" stroke-width="1.5" />
                    </svg>
                    <span>Fasilitas</span>
                </a>
            </li>
            <!-- end fasilitas -->

            <!-- user -->
            <li class="nav-item">
                <a class="nav-link" href="user.php">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
                        <circle cx="12" cy="6" r="4" stroke="#1C274C" stroke-width="1.5" />
                        <path d="M18 9C19.6569 9 21 7.88071 21 6.5C21 5.11929 19.6569 4 18 4" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M6 9C4.34315 9 3 7.88071 3 6.5C3 5.11929 4.34315 4 6 4" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <ellipse cx="12" cy="17" rx="6" ry="4" stroke="#1C274C" stroke-width="1.5" />
                        <path d="M20 19C21.7542 18.6153 23 17.6411 23 16.5C23 15.3589 21.7542 14.3847 20 14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M4 19C2.24575 18.6153 1 17.6411 1 16.5C1 15.3589 2.24575 14.3847 4 14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <span>User</span>
                </a>
            </li>
            <!-- end user -->

            <!-- Review -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="review.php">
                    <svg width="25" height="25" fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M10.3 6.74a.75.75 0 01-.04 1.06l-2.908 2.7 2.908 2.7a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 011.06.04zm3.44 1.06a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.908-2.7-2.908-2.7z"></path>
                            <path fill-rule="evenodd" d="M1.5 4.25c0-.966.784-1.75 1.75-1.75h17.5c.966 0 1.75.784 1.75 1.75v12.5a1.75 1.75 0 01-1.75 1.75h-9.69l-3.573 3.573A1.457 1.457 0 015 21.043V18.5H3.25a1.75 1.75 0 01-1.75-1.75V4.25zM3.25 4a.25.25 0 00-.25.25v12.5c0 .138.112.25.25.25h2.5a.75.75 0 01.75.75v3.19l3.72-3.72a.75.75 0 01.53-.22h10a.25.25 0 00.25-.25V4.25a.25.25 0 00-.25-.25H3.25z"></path>
                        </g>
                    </svg>
                    <span>Review</span>
                </a>
            </li>
            <!-- end Review -->

        </ul>
    </aside>
    <!-- End Sidebar-->

    <!-- Start #main -->
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>User</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="card">
                <div class="card-header">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-left: 5px;">
                        Tambah User
                    </button>

                    <!-- Create Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah User</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        <div class="mb-3">
                                            <label for="user" class="col-form-label">Username</label>
                                            <input type="text" name="user" class="form-control" placeholder="Username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="col-form-label">Password</label>
                                            <input type="text" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="role">Role</label>
                                            <select class="form-select mb-3" name="role">
                                                <option selected>Pilih Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="add">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h5 class="mb-3">Data User</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered display" id="myTable">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">No</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $datauser = mysqli_query($conn, "SELECT * FROM user");
                                $i = 1;
                                while ($ambildata = mysqli_fetch_array($datauser)) {
                                    $user = $ambildata['username'];
                                    $password = $ambildata['password'];
                                    $role = $ambildata['role'];
                                    $aksi = $ambildata['id'];
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $user; ?></td>
                                        <td><?= $password; ?></td>
                                        <td><?= $role; ?></td>
                                        <td class="flex flex-wrap gap-2">
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $aksi; ?>">Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem(<?= $aksi; ?>)">Delete</button>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="edit<?= $aksi; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post">
                                                        <div class="mb-3">
                                                            <label for="user" class="col-form-label">Username</label>
                                                            <input type="text" name="user" class="form-control" value="<?= $user; ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="password" class="col-form-label">Password</label>
                                                            <input type="text" name="password" class="form-control" value="<?= $password; ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="role">Role</label>
                                                            <select class="form-select mb-3" name="role">
                                                                <option value="admin" <?= ($role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                                                <option value="user" <?= ($role == 'user') ? 'selected' : ''; ?>>User</option>
                                                            </select>
                                                        </div>
                                                        <input type="hidden" name="aksi" value="<?= $aksi; ?>">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                };
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Kelompok 5</span></strong>.
        </div>
    </footer><!-- End Footer -->

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- Eksternal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        async function showAlert(type) {
            let redirectURL = 'user.php';

            if (type == 1) {
                await new window.Swal({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data berhasil ditambahkan!',
                    padding: '2em',
                });
                window.location.href = redirectURL;
            } else if (type == 2) {
                await new window.Swal({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data berhasil diubah!',
                    padding: '2em',
                });
                window.location.href = redirectURL;
            } else if (type == 3) {
                await new window.Swal({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Data gagal ditambahkan!',
                    padding: '2em',
                });
                window.location.href = redirectURL;
            } else if (type == 4) {
                await new window.Swal({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Data gagal diubah!',
                    padding: '2em',
                });
                window.location.href = redirectURL;
            } else if (type == 5) {
                await new window.Swal({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Data sudah ada!',
                    padding: '2em',
                });
                window.location.href = redirectURL;
            }
        }

        function deleteItem(itemId) {
            Swal.fire({
                title: 'Apakah anda yakin untuk menghapus user ini?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Saya yakin!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `proses-user.php?delete=1&aksi=${itemId}`;
                }
            });
        }
    </script>

    <script>
        document.getElementById('confirmLogout').addEventListener('click', function() {
          var xhr = new XMLHttpRequest();
          // Membuka untuk melakukan post semua function logout dari user-logout.php
          xhr.open('POST', '../function-login-diluar-admin/user-logout-sesi.php', true);
          xhr.onload = function() {
              if (this.status == 200) {
                  window.location.href = 'index.php';
              }
          };
          xhr.send();
      });
    </script>

</body>

</html>