<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Our Team - SIT</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet" />
    <!-- Stylesheet -->
    <link rel="stylesheet" href="style/our-team.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal-content {
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .modal-title {
            color: #333;
            font-family: 'Arial', sans-serif;
            text-transform: uppercase;
        }

        .modal-body .btn {
            margin: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .modal-body .btn:hover {
            background-color: #007bff;
            color: #fff;
            transform: scale(1.1);
        }
    </style>
</head>
<body>



<section>
    <div class="row">
        <h1>Our Team Sistem Informasi Traveling</h1>
    </div>
        <div class="text-center">
            <a type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#portfolioModal">View Portfolio</a>
            <a type="button" class="btn btn-primary" href="index.php">Back to Index</a>
            <a type="button" class="btn btn-dark" href="login.php">Login</a>
            <a type="button" class="btn btn-dark" href="register.php">Register</a>
        </div>
    <div class="row">
        <div class="column">
            <div class="card">
                <div class="img-container">
                    <img src="img/freya_jayawardana%20(1).jpg" />
                </div>
                <h3>Freya Jayawardana</h3>
                <p>Penyemengatku &#128536;</p>
                <div class="icons">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="card">
                <div class="img-container">
                    <img src="img/feni_fitriyanti.jpg" />
                </div>
                <h3>Feni Fitriyanti</h3>
                <p>Penyemengatku &#128536;</p>
                <div class="icons">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="card">
                <div class="img-container">
                    <img src="img/gabriela_abigail.jpg" />
                </div>
                <h3>Gabriela abigail</h3>
                <p>Penyemengatku &#128536;</p>
                <div class="icons">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div class="card">
                <div class="img-container">
                    <img src="img/developer/vita-figzam.png" />
                </div>
                <h3>Vita Rahmada</h3>
                <p>Expert Front-end Developer 👩‍💻</p>
                <div class="icons">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="card">
                <div class="img-container">
                    <img src="img/developer/mahisa-figzam.png" />
                </div>
                <h3>Mahisa Aghisni Fadhli</h3>
                <p>Back-end Developer + Specialist UI UX 👨🏻‍💻</p>
                <div class="icons">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="card">
                <div class="img-container">
                    <img src="img/developer/fadly-figzam.png" />
                </div>
                <h3>Muhammad Fadly Gimnastiar</h3>
                <p>Back-end Developer + Specialist UI UX 👨🏻‍💻</p>
                <div class="icons">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Modal Portfolio-->
<div class="modal fade" id="portfolioModal" tabindex="-1" aria-labelledby="portfolioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="portfolioModalLabel">Portfolio Our Team</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <a href="portfolio/ibnu/index.html" class="btn btn-primary">Ibnu</a>
                    <a href="portfolio/mahisa/index.html" class="btn btn-primary">Mahisa</a>
                    <a href="portfolio/vita-rahmada/index.html" class="btn btn-primary">Vita</a>
                    <a href="portfolio/fadly/index.html" class="btn btn-primary">Fadly</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Modal-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>