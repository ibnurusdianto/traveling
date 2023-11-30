<?php
include 'connection.php';

#create kategori
if (isset($_POST['add'])) {
    $nama_kategori = $_POST['nama_kategori'];

    $check_duplicate = mysqli_query($conn, "SELECT * FROM kategori WHERE nama_kategori = '$nama_kategori'");
    if (mysqli_num_rows($check_duplicate) > 0) {
        echo "<script>window.onload = function() { showAlert(5); }</script>";
    } else {
        $addtotable = mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')");
        if ($addtotable) {
            echo "<script>window.onload = function() { showAlert(1); }</script>";
        } else {
            echo "<script>window.onload = function() { showAlert(3); }</script>";
        }
    }
}

#update kategori
if (isset($_POST['update'])) {
    $aksi = $_POST['aksi'];
    $nama_kategori = $_POST['nama_kategori'];

    $update = mysqli_query($conn, "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id = '$aksi'");
    if ($update) {
        echo "<script>window.onload = function() { showAlert(2); }</script>";
    } else {
        echo "<script>window.onload = function() { showAlert(4); }</script>";
    }
}

# delete kategori
if (isset($_GET['delete'])) {
    $aksi = $_GET['aksi'];

    $hapus = mysqli_query($conn, "DELETE FROM kategori WHERE id = '$aksi'");
    if ($hapus) {
        header('location:kategori.php?delete_success=true');
    } else {
        header('location:kategori.php?delete_success=false');
    }
}
