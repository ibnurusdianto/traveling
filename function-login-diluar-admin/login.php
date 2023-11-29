<?php
session_start();
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
        $hashed_password = "*".strtoupper(sha1(sha1($password, true)));
        if ($hashed_password == $user['password']) {
            $_SESSION['username'] = $username;
            if ($user['role'] == 'admin') {
                return 'admin';
            } elseif ($user['role'] == 'user'){
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

        $loginResult = login($username, $password);

        if ($loginResult == "admin") {
            header('Location: ../admin/index.php');
        } elseif ($loginResult == "user"){
            header('Location: ../index.php');
        } else {
            echo 'Login gagal';
        }
    }
}


//function login($username, $password)
//{
//    $conn = mysqli_connect('localhost', 'root', '', 'travel');
//
//    // Mencegah SQL Injection sederhana
//    $username = mysqli_real_escape_string($conn, $username);
//    $password = mysqli_real_escape_string($conn, $password);
//
//    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
//
//    $result = mysqli_query($conn, $sql);
//
//
//    if (mysqli_num_rows($result) > 0) {
//        $user = mysqli_fetch_assoc($result);
//
//
//        if ($user['role'] == 'admin') {
//            return 'admin';
//        } elseif ($user['role'] == 'user') {
//            return 'user';
//        }
//    }
//    return false;
//}
//
//
//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    $username = $_POST['username'];
//    $password = $_POST['password'];
//
//    $loginResult = login($username, $password);
//
//    if ($loginResult == "admin") {
//        header('Location: ../admin/index.php');
//    } elseif ($loginResult == "user") {
//        header('Location: ../index.php');
//    } else {
//        echo 'Login gagal';
//    }
//}


?>