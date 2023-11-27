<!DOCTYPE html>
<html lang="en">

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
<<<<<<< HEAD
<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #9eb4c7">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active me-4" aria-current="page" href="index.php">Home</a>
                <a class="nav-link me-4" href="destination.php">Destination</a>
                <a class="nav-link me-4" href="#">About</a>
                <a class="nav-link me-4" href="ContactUS.php">Contact Us</a>
                <a class="nav-link me-4" href="our-team.php">Our Team</a>
            </div>
        </div>
        <!-- Pindahkan form pencarian dan tombol login ke luar dari .navbar-nav -->
        <form class="d-flex me-2 ms-auto" action="#">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">
                <i class="bi bi-search"></i>
=======
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
>>>>>>> vita
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link me-4" aria-current="page" href="index.php">Home</a>
                    <a class="nav-link me-4" href="destination.php">Destination</a>
                    <a class="nav-link me-4" href="about.php">About</a>
                    <a class="nav-link me-4" href="#">Contact Us</a>
                    <a class="nav-link me-4" href="our-team.php">Our Team</a>
                </div>
            </div>
            <!-- Pindahkan form pencarian dan tombol login ke luar dari .navbar-nav -->
            <form class="d-flex me-2 ms-auto" action="#">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <!-- <button class="btn btn-success" type="button">Login</button>-->
        </div>
    </nav>
    <!-- end navbar -->


    
    <!--Login Form-->
    <div class="container col-11 col-md-9" id="form-container">
        <div class="row align-items-center gx-5">
            <div class="col-md-6 order-md-2">
                <h2>Login to continue</h2>
                <form>
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

    <script src="javascript/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>