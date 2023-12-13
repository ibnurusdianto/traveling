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
function isUsernameValid($username) {
    $conn = connectDB();

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        $conn->close();
        return true; 
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $username = $_POST['username'];
        $conn = connectDB();
        if (isUsernameValid($username)) {
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                $username = $conn->real_escape_string($username);
                $conn->close();
                header("Location: ../form_new_password.php?username=" . $username);
                exit();
            } else {
                $conn->close();
                echo '<script>alert("Maaf, Anda memasukkan username yang salah. Harap masukkan username yang valid!");';
                echo 'window.location.href="../forgot_password.php";</script>';
            }
        } else {
            $conn->close();
            echo '<script>alert("Maaf, Anda memasukkan username yang salah. Harap masukkan username yang valid!");';
            echo 'window.location.href="../forgot_password.php";</script>';
        }
    } else {
        echo '<script>alert("Harap masukkan username Anda!");</script>';
    }
}
?>