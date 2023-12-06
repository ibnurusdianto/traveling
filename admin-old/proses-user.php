<?php
include 'connection.php';

#create user
if (isset($_POST['add'])) {
    $username = $_POST['user'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_duplicate = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($check_duplicate) > 0) {
        echo "<script>window.onload = function() { showAlert(7); }</script>";
    } else {
        $addtotable = mysqli_query($conn, "INSERT INTO user (username, password, role) VALUES ('$username', '$hashed_password', '$role')");
        if ($addtotable) {
            echo "<script>window.onload = function() { showAlert(1); }</script>";
        } else {
            echo "<script>window.onload = function() { showAlert(4); }</script>";
        }
    }
}

#update user
if (isset($_POST['update'])) {
    $aksi = $_POST['aksi'];
    $username = $_POST['user'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $update = mysqli_query($conn, "UPDATE user SET username = '$username', password = '$hashed_password', role = '$role' WHERE id = '$aksi'");
    if ($update) {
        echo "<script>window.onload = function() { showAlert(2); }</script>";
    } else {
        echo "<script>window.onload = function() { showAlert(4); }</script>";
    }
}

# delete user
if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    $hapus = mysqli_query($conn, "DELETE FROM user WHERE id = '$aksi'");
    if ($hapus) {
        header('location:user.php?delete_success=true');
    } else {
        header('location:user.php?delete_success=false');
    }
}
