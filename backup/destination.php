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
    <title>Travel - Destination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/header-footer.css">
    <link rel="stylesheet" href="style/destination.css" />
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
                    <a class="nav-link active me-4" href="destination.php">Destination</a>
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
                    echo '<a class="btn" href="login.php">Login</a>';
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

    <!-- carousel -->
    <div id="carouselExampleControls" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/1.jpg" class="d-block w-100" alt="Slide 1" />
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="header-caption">Travelling <br> Information for <br> The best Experience</h1>
                    <p class="paragaf-caption">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla condimentum tortor ac tellus tincidunt.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/2.jpg" class="d-block w-100" alt="Slide 2" />
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="header-caption">Travelling <br> Information for <br> The best Experience</h1>
                    <p class="paragaf-caption">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla condimentum tortor ac tellus tincidunt.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/3.jpg" class="d-block w-100" alt="Slide 3" />
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="header-caption">Travelling <br> Information for <br> The best Experience</h1>
                    <p class="paragaf-caption">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla condimentum tortor ac tellus tincidunt.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- end carousel -->

    <!-- destination section -->
    <div class="container">
        <h1 class="header-destination1">Travelling Information for The</h1>
        <h1 class="header-destination1">best Experience</h1>
        <p class="mt-3 paragaf-destination">Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati quidem, pariatur minus a enim mollitia? Iusto autem assumenda cupiditate illum voluptatem vero atque molestias dolorum?</p>
    </div>
    <section class="destination_section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="img/6.jpg" alt="Destination Image" class="img-fluid" />
                        </div>
                        <div class="detail-box text-start ps-3 pe-3">
                            <a href="details-destination.php">
                                <h2>Nama Destination</h2>
                            </a>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam ea facere est? Fuga inventore consectetur labore corrupti dolorum cupiditate modi!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="img/6.jpg" alt="Destination Image" class="img-fluid" />
                        </div>
                        <div class="detail-box text-start ps-3 pe-3">
                            <a href="details-destination.php">
                                <h2>Nama Destination</h2>
                            </a>
                            <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam ea facere est? Fuga inventore consectetur labore corrupti dolorum cupiditate modi!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="img/6.jpg" alt="Destination Image" class="img-fluid" />
                        </div>
                        <div class="detail-box text-start ps-3 pe-3">
                            <a href="details-destination.php">
                                <h2>Nama Destination</h2>
                            </a>
                            <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam ea facere est? Fuga inventore consectetur labore corrupti dolorum cupiditate modi!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="img/6.jpg" alt="Destination Image" class="img-fluid" />
                        </div>
                        <div class="detail-box text-start ps-3 pe-3">
                            <h2 class="">Nama Destination</h2>
                            <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam ea facere est? Fuga inventore consectetur labore corrupti dolorum cupiditate modi!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="img/6.jpg" alt="Destination Image" class="img-fluid" />
                        </div>
                        <div class="detail-box text-start ps-3 pe-3">
                            <h2 class="">Nama Destination</h2>
                            <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam ea facere est? Fuga inventore consectetur labore corrupti dolorum cupiditate modi!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="img/6.jpg" alt="Destination Image" class="img-fluid" />
                        </div>
                        <div class="detail-box text-start ps-3 pe-3">
                            <h2 class="">Nama Destination</h2>
                            <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam ea facere est? Fuga inventore consectetur labore corrupti dolorum cupiditate modi!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end destination section -->

    <!--  -->
    <section class="tempat-wisata mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img class="gambar-tempat-wisata" src="img/1.jpg" alt="" width="100%">
                </div>
                <div class="col-md-6" style="padding: 50px;">
                    <h2 class="nama-tempat-wisata">Nama Tempat Wisata</h2>
                    <p class="paragaf-tempat-wisata">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic omnis reprehenderit nesciunt iusto saepe, eius nihil tempore cumque, optio architecto voluptas, provident est ab porro beatae quod suscipit placeat quas.</p>
                    <div class="card d-inline p-2 mt-4" id="rating-card" style="background-color: #9BBEC8; border: none">
                        <i id="star1" class="bi bi-star-fill" style="color: yellow;"></i>
                        <i id="star2" class="bi bi-star-fill" style="color: yellow;"></i>
                        <i id="star3" class="bi bi-star" style="color: yellow;"></i>
                        <i id="star4" class="bi bi-star" style="color: yellow;"></i>
                        <i id="star5" class="bi bi-star" style="color: yellow;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  -->

    <!--  -->
    <section class="travelling-information mt-5 mb-5">
        <div class="container">
            <div class="row mt-5 d-flex align-items-center">
                <div class="col-5">
                    <h1 style="width: 50%;">Travelling Information</h1>
                </div>
                <div class="col-7">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum ipsum culpa libero ea fuga, sint esse? Quidem id labore minima impedit itaque deserunt, placeat, quisquam dolores dolorem ullam debitis mollitia? Excepturi ad vero nemo dicta? Totam quibusdam aperiam optio, ut rerum inventore dolorem laboriosam, velit, numquam placeat impedit doloribus sapiente!</p>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eum labore quidem consequatur est laudantium et.</p>
                </div>
            </div>
        </div>
    </section>
    <!--  -->

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>