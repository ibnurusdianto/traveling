<?php
include 'connection.php';

#create barang
if (isset($_POST['add'])) {
    $nama_kategori = $_POST['nama_kategori'];

    $check_duplicate = mysqli_query($conn, "SELECT * FROM kategori WHERE nama_kategori = '$nama_kategori'");
    if (mysqli_num_rows($check_duplicate) > 0) {
        echo "<script>window.onload = function() { showAlert(7); }</script>";
    } else {
        $addtotable = mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')");
        if ($addtotable) {
            echo "<script>window.onload = function() { showAlert(1); }</script>";
        } else {
            echo "<script>window.onload = function() { showAlert(4); }</script>";
        }
    }
}

#update barang
if (isset($_POST['update'])) {
    $aksi = $_POST['aksi'];
    $nama_kategori = $_POST['nama_kategori'];

    $update = mysqli_query($conn, "UPDATE category SET nama_kategori = '$nama_kategori' WHERE id = '$aksi'");
    if ($update) {
        header('location:kategori.php?update_success=true');
    } else {
        header('location:kategori.php?update_success=false');
    }
}

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    $hapus = mysqli_query($conn, "DELETE FROM kategori WHERE id = '$aksi'");
    if ($hapus) {
        header('location:kategori.php?delete_success=true');
    } else {
        header('location:kategori.php?delete_success=false');
    }
}
