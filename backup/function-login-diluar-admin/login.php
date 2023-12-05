<?php
session_start();

$max_attempts = 3;
$delay = 30;

if (isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

function login($username, $password) {
    $conn = mysqli_connect('localhost', 'root', '', 'travel');
    $username = mysqli_real_escape_string($conn, $username);

    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $hashed_password = $user['password'];
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            if ($user['role'] == 'admin') {
                return 'admin';
            } elseif ($user['role'] == 'user') {
                return 'user';
            }
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= $max_attempts) {
            if (time() - $_SESSION['last_attempt_time'] < $delay) {
                echo "<script>alert('Anda sudah mencoba login sebanyak 3x dan tunggu 30 detik untuk melakukan login kembali!'); window.location.href = '../login.php';</script>";
                exit;
            } else {
                $_SESSION['login_attempts'] = 0;
            }
        }

        $loginResult = login($username, $password);

        if ($loginResult == "admin") {
            header('Location: ../admin/index.php');
        } elseif ($loginResult == "user"){
            header('Location: ../index.php');
        } else {
            if (!isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = 1;
            } else {
                $_SESSION['login_attempts']++;
            }
            $_SESSION['last_attempt_time'] = time();
            echo 'Login gagal';
        }
    }
}

?>