<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Travel - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/header-footer.css">
    <link rel="stylesheet" href="style/register.css" />
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
            <!--        <button class="btn btn-success" type="button">Login</button>-->
            <a class="btn" href="login.php">Login</a>
        </div>
    </nav>
    <!-- end navbar -->



    <!--Register Form-->
    <div class="container col-11 col-md-9" id="form-container">
        <div class="row gx-5">
            <div class="col-md-6">
                <h2>Complete your registration</h2>
                <form action="./function-login-diluar-admin/register-only-user.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="username" class="form-control" id="username" name="username" placeholder="Enter your Username">
                        <label for="username" class="form-label">Enter your Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                        <label for="password" class="form-label">Enter your password</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="show-password">
                        <label class="form-check-label" for="show-password">Show password</label>
                    </div>
                    <div class="mb-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="" id="agree-term">
                            <label class="form-check-label" for="agree-term">
                                Do you accept <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">the terms of service</a>?
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="newsletter">
                            <label class="form-check-label" for="newsletter">
                                Do you want to receive our newsletters?
                            </label>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Register">
                </form>
            </div>
            <div class="col-md-6">
                <div class="row align-items-center">
                    <div class="col-12">
                        <img src="img/5.jpg" alt="Sign up" class="img-fluid">
                    </div>
                    <div class="col-12" id="link-container">
                        <a href="login.php">I already have an account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Form-->


    <!--Modal term of services-->
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title w-100 text-center" id="termsModalLabel">The Terms of Service</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-between">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam tincidunt, mauris et imperdiet ultricies, sapien turpis elementum ipsum, in sagittis velit justo et lorem.</p>
                    <img src="img/4.jpg" alt="Thumbnail" class="img-thumbnail">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--End Modals-->

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

    <script src="javascript/register.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>