<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$session_expire_time = 600;
session_set_cookie_params($session_expire_time);
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_expire_time)) {
    session_unset();
    session_destroy();
    header("Location: login.php");
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
        header("Location: login.php");
        exit;
    }
  }
?>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Travel - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/header-footer.css">
    <link rel="stylesheet" href="style/login.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link me-4" aria-current="page" href="index.php">Home</a>
                    <a class="nav-link me-4" href="destination.php">Destination</a>
                    <a class="nav-link me-4" href="about.php">About</a>
                    <a class="nav-link me-4" href="ContactUS.php">Contact Us</a>
                    <a class="nav-link me-4" href="our-team.php">Our Team</a>
                </div>
            </div>
            <!-- Pindahkan form pencarian dan tombol login ke luar dari .navbar-nav -->
            <form class="d-flex me-2 ms-auto" action="#">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" value="<?= htmlentities($_GET['search'] ?? '') ?>">
                <button class="btn" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<div class="btn-group">';
                    echo '<a class="btn btn-username dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" href="#">' . $_SESSION['username'] . '</a>';
                    echo '<ul class="dropdown-menu">';
                    echo '<li><a class="dropdown-item" href="profile-user/profile.php">Profile</a></li>';
                    echo '<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>';
                    echo '</ul>';
                    echo '</div>';
                } else {
//                    echo '<a class="btn" href="login.php">Login</a>';
                }
                ?>
        </div>
    </nav>
    <!-- end navbar -->

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
                    <button type="button" class="btn btn-primary" id="confirmLogout">Logout</button>
                </div>
            </div>
        </div>
    </div>
    <!--End Modal Logout user session-->

    
    <!--Login Form-->
    <div class="container col-11 col-md-9" id="form-container">
        <div class="row align-items-center gx-5">
            <div class="col-md-6 order-md-2">
                <h2>Login to continue</h2>
                <form action="./function-login-diluar-admin/login.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="username" class="form-control" id="username" name="username" placeholder="Enter your username">
                        <label for="username" class="form-label">Enter your Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                        <label for="password" class="form-label">Enter your password</label>
                    </div>
                    <input type="submit" class="btn btn-primary mt-4" value="Login">
                </form>
            </div>
            <div class="col-md-6 order-md-1">
                <div class="col-12">
                    <img src="img/2.jpg" alt="Login" class="img-fluid">
                </div>
                <div class="col-12" id="link-container">
                    <a href="register.php">I don't have an account</a>
                </div>
            </div>
        </div>
    </div>
    <!--End Form-->


    <!-- info section -->
    <section class="info_section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>If you have any questions,</h2>
                    <h2>Let us help you!</h2>
                    <p class="pt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel quod, eaque deleniti ea alias odio!</p>
                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div>
    </section>
    <!-- end info section -->

    <!-- footer section -->
    <footer class="footer_section">
        <div class="container-fluid">
            <p>
                &copy; Tanah Air Studio
            </p>
        </div>
    </footer>
    <!-- end footer section -->

    <script>
        document.getElementById('confirmLogout').addEventListener('click', function() {
            var xhr = new XMLHttpRequest();
            // Membuka untuk melakukan post semua function logout dari user-logout.php
            xhr.open('POST', './function-login-diluar-admin/user-logout-sesi.php', true);
            xhr.onload = function() {
                if (this.status == 200) {
                    window.location.href = 'index.php';
                }
            };
            xhr.send();
        });
    </script>
    <script src="javascript/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>