<?php
include 'connection.php';

#create fasilitas
if (isset($_POST['add'])) {
    $nama_fasilitas = $_POST['nama_fasilitas'];
    $tempat_wisata_id = $_POST['wisata'];

    $check_duplicate = mysqli_query($conn, "SELECT * FROM fasilitas WHERE nama_fasilitas = '$nama_fasilitas'");

    if (mysqli_num_rows($check_duplicate) > 0) {
        $row = mysqli_fetch_assoc($check_duplicate);
        if ($row['tempat_wisata_id'] == $tempat_wisata_id) {
            echo "<script>window.onload = function() { showAlert(5); }</script>";
        } else {
            $addtotable = mysqli_query($conn, "INSERT INTO fasilitas (nama_fasilitas, tempat_wisata_id) VALUES ('$nama_fasilitas', '$tempat_wisata_id')");
            if ($addtotable) {
                echo "<script>window.onload = function() { showAlert(1); }</script>";
            } else {
                echo "<script>window.onload = function() { showAlert(3); }</script>";
            }
        }
    } else {
        $addtotable = mysqli_query($conn, "INSERT INTO fasilitas (nama_fasilitas, tempat_wisata_id) VALUES ('$nama_fasilitas', '$tempat_wisata_id')");
        if ($addtotable) {
            echo "<script>window.onload = function() { showAlert(2); }</script>";
        } else {
            echo "<script>window.onload = function() { showAlert(4); }</script>";
        }
    }
}

#update wisata
if (isset($_POST['update'])) {
    $aksi = $_POST['aksi'];
    $nama_fasilitas = $_POST['nama_fasilitas'];
    $tempat_wisata_id = $_POST['wisata'];

    $update = mysqli_query($conn, "UPDATE fasilitas SET nama_fasilitas = '$nama_fasilitas', tempat_wisata_id = '$tempat_wisata_id' WHERE id = '$aksi'");
    if ($update) {
        echo "<script>window.onload = function() { showAlert(2); }</script>";
    } else {
        echo "<script>window.onload = function() { showAlert(4); }</script>";
    }
}

# delete fasilitas
if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    $hapus = mysqli_query($conn, "DELETE FROM fasilitas WHERE id = '$aksi'");
    if ($hapus) {
        header('location:fasilitas.php?delete_success=true');
    } else {
        header('location:fasilitas.php?delete_success=false');
    }
}
