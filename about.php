<!DOCTYPE html>
<html lang="en">
<?php
$session_expire_time = 600;
session_set_cookie_params($session_expire_time);
session_start();

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
    } else {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['role'] = $row['role'];
    }
}

include_once 'admin/connection.php';

$sqlTopRated = "SELECT tempat_wisata.*, MAX(review.rating) AS max_rating
FROM tempat_wisata
JOIN review ON tempat_wisata.id = review.tempat_wisata_id
GROUP BY tempat_wisata.id
ORDER BY max_rating DESC
LIMIT 1;";
$resultTopRated = mysqli_query($conn, $sqlTopRated);

mysqli_close($conn);
?>
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Travel - About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/header-footer.css">
    <link rel="stylesheet" href="style/about.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link me-4" aria-current="page" href="index.php">Home</a>
                    <a class="nav-link me-4" href="destination.php">Destination</a>
                    <a class="nav-link active me-4" href="about.php">About</a>
                    <a class="nav-link me-4" href="ContactUS.php">Contact Us</a>
                    <a class="nav-link me-4" href="our-team.php">Our Team</a>
                    <a class="nav-link me-4" href="others/index.html">Life History</a>
                </div>
            </div>
            <!-- Pindahkan form pencarian dan tombol login ke luar dari .navbar-nav -->
            <form class="d-flex me-2 ms-auto" action="search.php" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search"
                    value="<?= htmlentities($_GET['search'] ?? '') ?>">
                <input type="hidden" name="search_type" value="all">
                <button class="btn" type="submit">Search</button>
            </form>
            <?php
            if (isset($_SESSION['username'])) {
                echo '<div class="btn-group">';
                echo '<a class="btn btn-username dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" href="#">' . $_SESSION['username'] . '</a>';
                echo '<ul class="dropdown-menu">';
                echo '<li><a class="dropdown-item" href="profile-user/profile.php">Profile</a></li>';
                echo '<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>';
                if ($_SESSION['role'] == 'admin') {
                    echo '<li><a class="dropdown-item" href="admin/index.php">Admin Panel</a></li>';
                }
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
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/1.jpg" class="d-block w-100" alt="Slide 1" />
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="header-caption">Travelling <br> Information for <br> The best Experience</h1>
                    <p class="paragaf-caption">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
                        condimentum tortor ac tellus tincidunt.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/2.jpg" class="d-block w-100" alt="Slide 2" />
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="header-caption">Travelling <br> Information for <br> The best Experience</h1>
                    <p class="paragaf-caption">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
                        condimentum tortor ac tellus tincidunt.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/3.jpg" class="d-block w-100" alt="Slide 3" />
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="header-caption">Travelling <br> Information for <br> The best Experience</h1>
                    <p class="paragaf-caption">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
                        condimentum tortor ac tellus tincidunt.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- end carousel -->

    <!-- about section -->
    <section class="about_section layout_padding">
        <div class="container">
            <div class="row" style="align-items: center;">
                <div class="col-md-6 ps-md-5">
                    <h2>About</h2>
                    <p class="me-5">
                        Selamat datang di Tanah Air Travels – platform perjalanan yang didedikasikan untuk memberikan
                        pengalaman wisata tak terlupakan. Kami hadir dengan visi untuk menginspirasi dan memudahkan Anda
                        dalam menjelajahi keindahan dunia. Tanah Air Travels bukan sekadar situs perjalanan biasa; kami
                        adalah komunitas yang percaya bahwa setiap perjalanan adalah kisah unik yang patut dibagikan.
                        Di sini, kami menyajikan informasi terkini tentang destinasi wisata, tips perjalanan, ulasan
                        pengguna, dan panduan lengkap untuk membantu Anda merencanakan petualangan sempurna. Tim kami
                        yang berdedikasi bekerja keras untuk menyajikan konten bermanfaat dan inspiratif, memastikan
                        bahwa setiap langkah perjalanan Anda diwarnai dengan keceriaan dan kepuasan.
                    </p>
                </div>
                <div class="col-md-6 pe-md-5">
                    <img src="img/5.jpg" class="img-fluid img-responsiv" alt="Gambar" />
                </div>
            </div>
        </div>
    </section>
    <!-- end about section -->

    <!--  -->
    <section class="tempat-wisata mb-3">
        <div class="container">
            <?php
            if ($resultTopRated && mysqli_num_rows($resultTopRated) > 0) {
                $topRatedWisata = mysqli_fetch_assoc($resultTopRated);
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <img class="gambar-tempat-wisata" src="admin/assets/img/<?php echo $topRatedWisata['image']; ?>"
                            alt="" width="100%">
                    </div>
                    <div class="col-md-6" style="padding: 50px;">
                        <h2 class="nama-tempat-wisata">
                            <?php echo $topRatedWisata['nama_tempat']; ?>
                        </h2>
                        <p class="">
                            <?php
                            $deskripsiReview = $topRatedWisata['deskripsi'];
                            $deskripsiReview = implode(' ', array_slice(explode(' ', $deskripsiReview), 0, 30));
                            echo $deskripsiReview . '...';
                            ?>
                        </p>
                        <div class="card d-inline p-2 mt-4" id="rating-card"
                            style="background-color: #9BBEC8; border: none">
                            <?php
                            $rating = $topRatedWisata['max_rating'];
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<i class="bi bi-star-fill" style="color: yellow;"></i>';
                                } else {
                                    echo '<i class="bi bi-star" style="color: yellow;"></i>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo '<p>No top-rated destinations found.</p>';
            }
            ?>
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
                    <p class="pt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel quod, eaque deleniti ea
                        alias odio!</p>
                </div>
                <div class="col-md-6">
                    <section class="section-social-media social-media-icons">
                        <i class="bi bi-custom bi-facebook"></i>
                        <i class="bi bi-custom bi-twitter"></i>
                        <i class="bi bi-custom bi-instagram"></i>
                        <i class="bi bi-custom bi-linkedin"></i>
                        <i class="bi bi-custom bi-youtube"></i>
                    </section>
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
        window.onload = function () {
            window.scrollTo(0, 880);
        };
    </script>
    
    <script>
        document.getElementById('confirmLogout').addEventListener('click', function () {
            var xhr = new XMLHttpRequest();
            // Membuka untuk melakukan post semua function logout dari user-logout.php
            xhr.open('POST', './function-login-diluar-admin/user-logout-sesi.php', true);
            xhr.onload = function () {
                if (this.status == 200) {
                    window.location.href = 'index.php';
                }
            };
            xhr.send();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>