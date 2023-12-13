<?php
session_start();
function connectDB() {
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "travel";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    return $conn;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_POST['username'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $username = $_POST['username'];

        if ($new_password === $confirm_password) {
            if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $new_password)) {
                $conn = connectDB();
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE user SET password = ? WHERE username = ?");
                $stmt->bind_param("ss", $hashed_password, $username);
                $stmt->execute();
                header("Location: login.php");
                exit();
            } else {
                echo '<div class="alert alert-danger" role="alert">Password tidak memenuhi kriteria keamanan!</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Password dan konfirmasi password tidak cocok!</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Semua field harus diisi!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style/form_new_password.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Reset Password
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <input type="hidden" name="username" value="<?php echo htmlspecialchars($_GET['username']); ?>">
                        <button type="submit" class="btn btn-primary">Confirm Forgot Password</button>
                        <button type="button" class="btn btn-primary" onclick="window.location.href='./login.php'">Cancel Forgot Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>