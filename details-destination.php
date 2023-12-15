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

include 'admin/connection.php';

$query = "SELECT r.id, r.komentar, r.rating, u.username, t.nama_tempat, r.waktu
          FROM review r
          JOIN user u ON r.user_id = u.id
          JOIN tempat_wisata t ON r.tempat_wisata_id = t.id";
$datareview = mysqli_query($conn, $query);

$wisataRating = [];

while ($ambildata = mysqli_fetch_array($datareview)) {
    $nama_tempat = $ambildata['nama_tempat'];
    $rating = $ambildata['rating'];

    if (!isset($wisataRating[$nama_tempat])) {
        $wisataRating[$nama_tempat] = [
            'totalRating' => 0,
            'jumlahReview' => 0
        ];
    }
    $wisataRating[$nama_tempat]['totalRating'] += $rating;
    $wisataRating[$nama_tempat]['jumlahReview']++;
}


if (isset($_GET['nama_tempat'])) {
    $nama_tempat = $_GET['nama_tempat'];

    $sqlUpdateViews = "UPDATE tempat_wisata SET seen = seen + 1 WHERE nama_tempat = ?";
    $stmtUpdateViews = mysqli_prepare($conn, $sqlUpdateViews);
    mysqli_stmt_bind_param($stmtUpdateViews, 's', $nama_tempat);
    mysqli_stmt_execute($stmtUpdateViews);
}


$nama_kategori = $_GET['nama_kategori'] ?? '';

$sql = "SELECT * FROM kategori WHERE nama_kategori = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $nama_kategori);
mysqli_stmt_execute($stmt);
$result_kategori = mysqli_stmt_get_result($stmt);
$kategori_data = mysqli_fetch_assoc($result_kategori);

$sql_destinations = "SELECT * FROM tempat_wisata WHERE kategori_id = ?";
$stmt_destinations = mysqli_prepare($conn, $sql_destinations);
mysqli_stmt_bind_param($stmt_destinations, 'i', $kategori_data['id']);
mysqli_stmt_execute($stmt_destinations);
$result_destinations = mysqli_stmt_get_result($stmt_destinations);

mysqli_close($conn);
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Travel - Details Destination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/header-footer.css">
    <link rel="stylesheet" href="style/details-destination.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

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
                    <a class="nav-link me-4" href="others/index.html">Life History</a>
                </div>
            </div>
            <!-- Pindahkan form pencarian dan tombol login ke luar dari .navbar-nav -->
            <form class="d-flex me-2 ms-auto" action="search.php" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" value="<?= htmlentities($_GET['search'] ?? '') ?>">
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


    <!--Details Destination-->
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xxl-12 col-xl-12 col-sm-12">
                <h1 class="header-details mt-5 mb-5">
                    <?php echo $kategori_data['nama_kategori']; ?>
                </h1>
                <div class="card mb-4">
                    <img src="admin/assets/img/<?php echo $kategori_data['image']; ?>" class="card-img-top" alt="gambar">
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xxl-12 col-xl-12 col-sm-12">
                <p class="details-paragraf-destination">
                    <?php echo $kategori_data['deskripsi']; ?>
                </p>
            </div>
        </div>
    </div>
    <!--End Details Destination-->


    <!-- destination section -->
    <section class="tempat-wisata_section">
        <div class="container">
            <div class="row">
                <?php while ($destination_data = mysqli_fetch_assoc($result_destinations)) : ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="box">
                            <div class="img-box" style="height: 200px; overflow: hidden;">
                                <img src="admin/assets/img/<?php echo $destination_data['image']; ?>" alt="Destination Image" class="img-fluid" />
                            </div>
                            <div class="detail-box text-start ps-3 pe-3">
                                <a href="tempat-wisata.php?nama_kategori=<?php echo urlencode($nama_kategori); ?>&nama_tempat=<?php echo urlencode($destination_data['nama_tempat']); ?>">
                                    <h2>
                                        <?php echo $destination_data['nama_tempat']; ?>
                                    </h2>
                                </a>
                                <p class="">
                                    <?php
                                    $deskripsi = $destination_data['deskripsi'];
                                    // Membatasi deskripsi menjadi tidak lebih dari 4 baris
                                    $wrapped_desc = wordwrap($deskripsi, 40, "<br>", true);
                                    $desc_lines = explode("<br>", $wrapped_desc);
                                    if (count($desc_lines) > 4) {
                                        $wrapped_desc = implode("<br>", array_slice($desc_lines, 0, 4)) . '...';
                                    }
                                    echo $wrapped_desc;
                                    ?>
                                </p>
                                <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="rating-box d-flex align-items-center">
                                            <p class="average-rating" style="margin-top: 16px;">
                                                <?php
                                                if (isset($wisataRating[$destination_data['nama_tempat']]['totalRating']) && isset($wisataRating[$destination_data['nama_tempat']]['jumlahReview'])) {
                                                    $averageRating = $wisataRating[$destination_data['nama_tempat']]['totalRating'] / $wisataRating[$destination_data['nama_tempat']]['jumlahReview'];
                                                    echo number_format($averageRating, 1);
                                                } else {
                                                    echo "Belum ada rating";
                                                }
                                                ?>
                                            </p>
                                            <div id="rateYo_<?= str_replace(' ', '_', $destination_data['nama_tempat']); ?>"></div>
                                            <p class="mb-0">
                                                <?php
                                                if (isset($wisataRating[$destination_data['nama_tempat']]['jumlahReview'])) {
                                                    $jumlahReview = $wisataRating[$destination_data['nama_tempat']]['jumlahReview'];
                                                    echo "(" . $jumlahReview . ")";
                                                } else {
                                                    echo "(0)";
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 text-end d-flex align-items-center justify-content-end">
                                        <p class="mb-0 ms-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye me-1">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                            </svg>
                                            <?php echo $destination_data['seen']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <!-- end destination section -->


    <!--  -->
    <!-- <section class="detail_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ps-0 pe-md-5">
                    <img src="img/5.jpg" class="img-fluid img-responsiv" alt="Gambar" />
                </div>
                <div class="col-md-6 layout_padding ps-md-5">
                    <h2>Nama Tempat Wisata</h2>
                    <p class="pt-3">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, quaerat et. Cum, exercitationem consectetur? Expedita, odio at itaque in voluptas ex doloremque libero nisi sit temporibus. Officia dolor quaerat amet omnis
                        voluptates reiciendis, mollitia eaque rem blanditiis sequi accusantium? Ratione?
                    </p>
                    <a href="#" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
    </section> -->
    <!--  -->


    <!-- info section -->
    <section class="info_section mt-5">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

    <script>
        window.onload = function() {
            window.scrollTo(0, 880);
        };
    </script>

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
    <script>
        $(document).ready(function() {
            <?php foreach ($wisataRating as $nama_tempat => $ratings) : ?>
                <?php
                $averageRating = $ratings['totalRating'] / $ratings['jumlahReview'];
                $rateYoID = str_replace(' ', '_', $nama_tempat);
                ?>
                $("#rateYo_<?= $rateYoID; ?>").rateYo({
                    rating: <?= $averageRating; ?>,
                    readOnly: true,
                    starWidth: "20px"
                });
            <?php endforeach; ?>
        });
    </script>

</body>

</html>