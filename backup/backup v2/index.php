<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Travel - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  </head>

  <body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #9eb4c7">
      <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link active me-4" aria-current="page" href="index.html">Home</a>
            <a class="nav-link me-4" href="#">Destination</a>
            <a class="nav-link me-4" href="#">About</a>
            <a class="nav-link me-4" href="#">Contact Us</a>
          </div>
        </div>
        <!-- Pindahkan form pencarian dan tombol login ke luar dari .navbar-nav -->
        <form class="d-flex me-2 ms-auto" action="#">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search"></i>
          </button>
        </form>
        <a class="btn btn-success" href="login.php">Login</a>
      </div>
    </nav>
    <!-- end navbar -->

    <!-- carousel -->
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
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

    <!--  -->
    <section class="detail_section layout_padding">
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
    </section>
    <!--  -->

    <!-- destination section -->
    <h1 class="header-destination">Destination</h1>
    <section class="destination_section">
      <div class="container">
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

    <!-- review section -->
    <section class="review_section layout_padding">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12">
                <h2>Nama Tempat Wisata</h2>
                <p class="pt-4 pb-4">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, quaerat et. Cum, exercitationem consectetur? Expedita, odio at itaque in voluptas ex doloremque libero nisi sit temporibus. Officia dolor quaerat amet omnis voluptates
                  reiciendis, mollitia eaque rem blanditiis sequi accusantium? Ratione?
                </p>
                <a href="#" class="btn btn-primary">Detail</a><br><br>
              </div>
            </div>
          </div>
          <div class="col-md-6 text-center">
            <img src="img/5.jpg" class="img-fluid img-responsive" alt="Gambar" />
          </div>
        </div>
      </div>
    </section>
    <!-- end review section -->

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
