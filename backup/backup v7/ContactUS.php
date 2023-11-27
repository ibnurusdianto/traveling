<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Travel - Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
<!--    <link rel="stylesheet" href="style/header-footer.css">-->
    <link rel="stylesheet" href="style/contact-us.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
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
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn" type="submit">
                <i class="bi bi-search cari"></i>
            </button>
        </form>
        <a class="btn" href="login.php">Login</a>
    </div>
</nav>
<!-- end navbar -->

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


<!--Title-->
<div class="container title-about-us">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xl-12 col-xxl-12 col-sm-12">
            <h1 class="title-about-us">Contact</h1>
        </div>
    </div>
</div>
<!--End Title-->

<!--Contant US-->
<div class="container-fluid contact-us-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xl-12 col-xxl-12 col-sm-12 gambar-kesiji">
            <section class="section-gambar d-flex justify-content-between align-items-center">
                <img src="img/5.jpg" alt="Image 1" class="img-fluid">
                <div class="text-content">
                    <h1 class="title-section-gambar">Traveling</h1>
                    <p class="paragaf-section-gambar">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium architecto at atque consequatur corporis debitis delectus deserunt doloribus esse in incidunt iste laboriosam nam numquam odio, perferendis placeat quaerat quas qui rerum sint temporibus veritatis voluptate? Ad at expedita ipsam molestias nam quibusdam quidem quis, tenetur voluptates voluptatibus. Accusamus dolores eos facilis odit officia repudiandae similique veniam voluptas? Cumque incidunt laborum libero numquam officiis! Ad alias assumenda commodi corporis delectus doloremque dolores earum eligendi enim est excepturi exercitationem fugit harum ipsa ipsum laudantium minus neque nesciunt nostrum pariatur perferendis, perspiciatis placeat quam quasi quis, repellat soluta sunt totam velit voluptate.</p>
                </div>
            </section>
        </div>
    </div>
</div>
<!--End Contant US-->

<!--Form social media-->
<div class="container">
    <div class="row">
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
            <img class="gambar-contact" src="img/6.jpg" alt="gambar-2">
        </div>
    </div>
</div>
<!--End Form social media-->

<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xxl-12 col-xl-12 col-sm-12">
            <p class="details-about">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci animi dicta dignissimos doloremque earum, et laudantium nostrum obcaecati reprehenderit rerum totam unde voluptate? Aliquid asperiores autem commodi, consectetur consequatur corporis dolores esse exercitationem expedita illum incidunt ipsa libero necessitatibus nemo nisi nostrum obcaecati officia perspiciatis quisquam quo quos reprehenderit sapiente similique ut vel veniam, voluptates! Aliquam beatae eum eveniet id illo in labore laudantium magnam, maxime nam nesciunt obcaecati, perspiciatis quas quia quis sed velit voluptas! Animi aspernatur beatae blanditiis, commodi consectetur culpa debitis delectus distinctio dolorem ducimus eaque earum et eveniet excepturi explicabo illum impedit laudantium libero magni molestiae molestias nam natus necessitatibus nesciunt non nostrum numquam, officia perspiciatis quia quibusdam quidem quod quos recusandae reprehenderit temporibus velit voluptatum. Accusantium asperiores atque dicta eligendi minima nulla, sunt ut! Beatae dolores doloribus enim sequi? Accusantium aliquam consequatur consequuntur dolore et facere fugit magni, maxime minus molestiae nam omnis praesentium quaerat quidem quod recusandae ut vitae! Ab accusamus amet animi aspernatur aut autem, consectetur culpa distinctio dolor dolores dolorum ex exercitationem expedita, explicabo illo impedit incidunt iste iure magni minima molestiae molestias natus necessitatibus neque obcaecati perferendis quaerat, quasi quos reiciendis repellendus sapiente sed sequi temporibus. Accusamus amet assumenda at aut commodi consequatur consequuntur corporis delectus deleniti dicta distinctio ducimus et excepturi facilis fuga hic incidunt labore maxime minus officia omnis optio quaerat quasi quidem ratione recusandae repellendus rerum saepe sapiente sequi suscipit, vel voluptates voluptatum. Consequuntur earum eveniet hic impedit ipsum magni modi nostrum quaerat sapiente sint sunt, voluptatem.</p>
        </div>
    </div>
</div>


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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>