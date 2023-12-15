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
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Travel - Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/header-footer.css">
    <link rel="stylesheet" href="style/contact-us.css" />
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
                    <a class="nav-link active me-4" href="ContactUS.php">Contact Us</a>
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
    <div id="carouselExampleControls" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/1.jpg" class="d-block w-100" alt="Slide 1" />
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="header-caption">Travelling <br> Information for <br> The best Experience</h1>
                    <p class="paragaf-caption">Explore our comprehensive travel website dedicated to providing essential information for the best travel experience.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/2.jpg" class="d-block w-100" alt="Slide 2" />
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="header-caption">Travelling <br> Information for <br> The best Experience</h1>
                    <p class="paragaf-caption">Explore our comprehensive travel website dedicated to providing essential information for the best travel experience.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/3.jpg" class="d-block w-100" alt="Slide 3" />
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="header-caption">Travelling <br> Information for <br> The best Experience</h1>
                    <p class="paragaf-caption">Explore our comprehensive travel website dedicated to providing essential information for the best travel experience.</p>
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


    <!--Title-->
    <div class="container title-about-us mb-5">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xl-12 col-xxl-12 col-sm-12">
                <h1 class="title-about-us">Contact</h1>
            </div>
        </div>
    </div>
    <!--End Title-->

    <!--Contant US-->
    <section class="contactus-section mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xl-12 col-xxl-12 col-sm-12 gambar-kesiji">
                    <section class="section-gambar d-flex justify-content-between align-items-center">
                        <img src="img/5.jpg" alt="Image 1" class="img-fluid">
                        <div class="text-content">
                            <!-- <h1 class="title-section-gambar">Traveling</h1> -->
                            <p class="paragaf-section-gambar">Welcome to our Contact page! At Tanah Air Travels, we are delighted to receive inquiries, feedback, and suggestions from you. Our dedicated team is ready to assist with any questions you may have about destinations, travel, or our services.</p>
                            <p class="paragaf-section-gambar">Thank you for choosing Tanah Air Travels as your travel partner. We are committed to providing the best service and assisting you in making each journey an unforgettable experience. We look forward to hearing from you soon!</p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <!--End Contant US-->

    <!--Form social media-->
    <!-- <div class="container social-media mt-5 mb-5">
        <div class="row" style="text-align: center;">
            <div class="col-md-6 col-sm-6 col-xl-6 col-xxl-6 col-sm-6 pertama">
                <section class="section-social-media social-media-icons">
                    <i class="bi bi-custom bi-facebook"></i>
                    <i class="bi bi-custom bi-twitter"></i>
                    <i class="bi bi-custom bi-instagram"></i>
                    <i class="bi bi-custom bi-linkedin"></i>
                    <i class="bi bi-custom bi-youtube"></i>
                </section>
            </div>
            <div class="col-md-6 col-sm-6 col-xl-6 col-xxl-6 col-sm-6 keloro">
                <img class="gambar-contact" src="img/7.jpg" alt="gambar-2">
            </div>
        </div>
    </div> -->
    <!--End Form social media-->

    <div class="container mb-5 mt-5">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xxl-12 col-xl-12 col-sm-12">
                <p class="details-about">Tanah Air Travels is a comprehensive platform designed to streamline and enhance the travel experience. This system 
                    integrates various features and functionalities to provide users with valuable information, planning tools, and resources for a seamless 
                    journey. Whether you're a seasoned traveler or embarking on your first adventure, Tanah Air Travels is tailored to meet the diverse needs 
                    of all users. <br><br>
                    Key features of Tanah Air Travels include real-time updates on travel destinations, reviews from users, as well as a list of related tourist 
                    attractions. Users can access in-depth information on tourist spot descriptions, admission prices, reviews, and facilities. The system also 
                    facilitates convenient booking processes, allowing users to reserve flights, hotels, and other travel services directly through the platform. 
                    Furthermore, Tanah Air Travels incorporates user-generated content, such as reviews and recommendations, fostering a community where travelers 
                    can share their experiences and insights. This collaborative aspect enhances the overall travel planning and decision-making process. <br><br>
                    In summary, the Tanah Air Travels is a dynamic and user-friendly platform that aims to empower travelers with the knowledge and tools needed 
                    to create memorable and enjoyable travel experiences.
                </p>
            </div>
        </div>
    </div>

    <!-- info section -->
    <section class="info_section">
        <div class="container">
            <div class="row" style="align-items: center;">
                <div class="col-md-6">
                    <h2>If you have any questions,</h2>
                    <h2>Let us help you!</h2>
                    <p class="pt-3">Your journey is our priority. If you have any questions or need assistance, our dedicated team is here to help.</p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>