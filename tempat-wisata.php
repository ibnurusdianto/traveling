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

if (isset($_GET['nama_tempat'])) {
    $nama_tempat = mysqli_real_escape_string($conn, $_GET['nama_tempat']);
    $query = "SELECT * FROM tempat_wisata WHERE nama_tempat = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $nama_tempat);
    mysqli_stmt_execute($stmt);
    $result_tempat_wisata = mysqli_stmt_get_result($stmt);

    if ($row_tempat_wisata = mysqli_fetch_assoc($result_tempat_wisata)) {
        $nama_tempat = $row_tempat_wisata['nama_tempat'];
        $deskripsi = $row_tempat_wisata['deskripsi'];
        $image = $row_tempat_wisata['image'];

    } else {
        header("Location: destination.php");
        exit;
    }
} else {
    header("Location: destination.php");
    exit;
}

    $query_fasilitas = "SELECT nama_fasilitas FROM fasilitas WHERE tempat_wisata_id = ?";
    $stmt_fasilitas = mysqli_prepare($conn, $query_fasilitas);
    mysqli_stmt_bind_param($stmt_fasilitas, 'i', $row_tempat_wisata['id']);
    mysqli_stmt_execute($stmt_fasilitas);
    $result_fasilitas = mysqli_stmt_get_result($stmt_fasilitas);

    $query_comments = "SELECT r.komentar, r.rating, u.username, r.waktu
                       FROM review r
                       JOIN user u ON r.user_id = u.id
                       WHERE r.tempat_wisata_id = ?";
    
    $stmt_comments = mysqli_prepare($conn, $query_comments);
    
    if ($stmt_comments === false) {
        die("Error in preparing statement: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt_comments, 'i', $row_tempat_wisata['id']);
    mysqli_stmt_execute($stmt_comments);

    $result_comments = mysqli_stmt_get_result($stmt_comments);
    
    if ($result_comments === false) {
        die("Error in getting result: " . mysqli_error($conn));
    }

    $kategori_id = mysqli_real_escape_string($conn, $row_tempat_wisata['kategori_id']);

    $query_similar = "SELECT * FROM tempat_wisata WHERE kategori_id = ? AND nama_tempat != ? LIMIT 3";
    $stmt_similar = mysqli_prepare($conn, $query_similar);
    mysqli_stmt_bind_param($stmt_similar, 'ss', $kategori_id, $nama_tempat);
    mysqli_stmt_execute($stmt_similar);
    $result_similar = mysqli_stmt_get_result($stmt_similar);

mysqli_stmt_close($stmt_comments);
mysqli_close($conn);
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Travel - Tempat Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/header-footer.css">
    <link rel="stylesheet" href="style/tempat-wisata.css">
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

    <!--Details Tempat Wisata-->
    <div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xxl-12 col-xl-12 col-sm-12">
            <h1 class="header-details mb-5"><?php echo $nama_tempat; ?></h1>
            <div class="card mb-4">
                <img src="admin/assets/img/<?php echo $image; ?>" class="card-img-top" alt="gambar">
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xxl-12 col-xl-12 col-sm-12">
            <h5>Deskripsi : </h5>
            <p class="details-paragraf-tempat-wisata"><?php echo $deskripsi; ?></p>
            <div class="col-md-12 col-lg-12 col-xxl-12 col-xl-12 col-sm-12">
                <h5>Harga Tiket Masuk : </h5>
                <p>Rp <?php echo number_format($row_tempat_wisata['htm'], 0, ',', '.'); ?></p>
                <h5>Fasilitas : </h5>
                <?php
                    echo '<ul>';
                    while ($row_fasilitas = mysqli_fetch_assoc($result_fasilitas)) {
                        echo '<li>' . $row_fasilitas['nama_fasilitas'] . '</li>';
                    }
                    echo '</ul>';
                ?>
            </div>
        </div>
    </div>
</div>
    <!--End Details Tempat Wisata-->

    <!-- komentar -->
    <div class="komentar container p-5 mt-5">
    <h5 class="pb-2">Komentar</h5>
    <div class="form">
        <form id="commentForm" action="submit_comment.php" method="post">
        <textarea name="komentar" id="komentar" rows="7" required></textarea>
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <div class="row">
                <div class="col-6 mt-4 align-items-center">
                    <div class="card d-inline p-2" id="rating-card" style="background-color: #9BBEC8; border: none">
                        <i id="star1" class="bi bi-star-fill" style="color: yellow;" onclick="setRating(1)"></i>
                        <i id="star2" class="bi bi-star-fill" style="color: yellow;" onclick="setRating(2)"></i>
                        <i id="star3" class="bi bi-star-fill" style="color: yellow;" onclick="setRating(3)"></i>
                        <i id="star4" class="bi bi-star-fill" style="color: yellow;" onclick="setRating(4)"></i>
                        <i id="star5" class="bi bi-star-fill" style="color: yellow;" onclick="setRating(5)"></i>
                        <input type="hidden" name="nama_tempat" value="<?php echo $nama_tempat; ?>">
                        <input type="hidden" name="rating" id="rating" value="0">
                    </div>
                </div>
            </div>
            <input class="btn mt-4" type="submit" value="Submit" style="background-color: #9BBEC8; color: white;">
        </form>
    </div>
    </div>
    <!-- end komentar -->

    <!-- komentar user -->
    <?php
    while ($row_comment = mysqli_fetch_assoc($result_comments)) {
        echo '<div class="komentar-user container mt-5 mb-5 p-5">';
        echo '<div class="row align-items-center">';
        echo '<div class="col-3">';
        echo '<h5>' . $row_comment['username'] . '</h5>';
        echo '</div>';
        echo '<div class="col-9">';
        echo '<p>' . $row_comment['komentar'] . '</p>';
        echo '<div class="card d-inline p-2" id="rating-card" style="background-color: #9BBEC8; border: none">';
        for ($i = 1; $i <= 5; $i++) {
            $starClass = ($i <= $row_comment['rating']) ? 'bi-star-fill' : 'bi-star';
            echo '<i class="bi ' . $starClass . '" style="color: yellow;"></i>';
        }
        echo '</div>';
        
        $commentDate = date('Y-m-d', strtotime($row_comment['waktu']));
        echo '<p class="comment-time">Waktu komentar: ' . $commentDate . '</p>';
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
    <!-- end komentar user -->

    <!-- similar destinations -->
    <div class="container">
        <h1 class="header-similar-destinations mt-5">Similar Destinations</h1>
    </div>
    <section class="similar-destinations_section">
    <div class="container">
        <div class="row">
            <?php
            while ($row_similar = mysqli_fetch_assoc($result_similar)) {
                echo '<div class="col-md-6 col-lg-4">';
                echo '<div class="box">';
                echo '<div class="img-box">';
                echo '<img src="admin/assets/img/' . $row_similar['image'] . '" alt="Destination Image" class="img-fluid" />';
                echo '</div>';
                echo '<div class="detail-box text-start ps-3 pe-3">';
                echo '<a href="tempat-wisata.php?nama_tempat=' . urlencode($row_similar['nama_tempat']) . '">';
                echo '<h2>' . $row_similar['nama_tempat'] . '</h2>';
                echo '</a>';
                $limited_description = implode(' ', array_slice(explode(' ', $row_similar['deskripsi']), 0, 20));
                echo '<p class="">' . $limited_description . '...</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    </section>
    <!-- end similar destinations -->

    <!-- info section -->
    <section class="info_section mt-5">
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
        function setRating(rating) {
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById(`star${i}`);
                star.style.color = i <= rating ? 'yellow' : 'gray';
            }
            document.getElementById('rating').value = rating;
        }
    </script>

    <script>
        document.getElementById('confirmLogout').addEventListener('click', function() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', './function-login-diluar-admin/user-logout-sesi.php', true);
            xhr.onload = function() {
                if (this.status == 200) {
                    window.location.href = 'index.php';
                }
            };
            xhr.send();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>