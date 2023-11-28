<?php
function register($username, $password) {
    $conn = mysqli_connect('localhost', 'root', '', 'travel');
    $username = mysqli_real_escape_string($conn, $username);
    $password = "*".strtoupper(sha1(sha1($password, true)));

    $sql = "INSERT INTO user (username, password, role) VALUES (?, ?, 'user')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    $result = mysqli_stmt_execute($stmt);

    return $result;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $registerResult = register($username, $password);

    if ($registerResult) {
        echo '<script>alert("Registration successful"); window.location.href="../login.php";</script>';
    } else {
        echo 'Registration failed';
    }
}
?>