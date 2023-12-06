<?php
include 'connection.php';

#create wisata
if (isset($_POST['add'])) {
    $nama_tempat = $_POST['nama_tempat'];
    $deskripsi = $_POST['deskripsi'];
    $htm = $_POST['htm'];
    $kategori_id = $_POST['kategori'];
    $nama_file = $_FILES['image']['name'];
    $folder = 'assets/img/';
    $tmp_name = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp_name, $folder . $nama_file);

    $check_duplicate = mysqli_query($conn, "SELECT * FROM tempat_wisata WHERE nama_tempat = '$nama_tempat'");
    if (mysqli_num_rows($check_duplicate) > 0) {
        echo "<script>window.onload = function() { showAlert(5); }</script>";
    } else {
        $addtotable = mysqli_query($conn, "INSERT INTO tempat_wisata (nama_tempat, deskripsi, htm, kategori_id, image) VALUES ('$nama_tempat', '$deskripsi', '$htm', '$kategori_id', '$nama_file')");
        if ($addtotable) {
            echo "<script>window.onload = function() { showAlert(1); }</script>";
        } else {
            echo "<script>window.onload = function() { showAlert(4); }</script>";
        }
    }
}

#update fasilitas
if (isset($_POST['update'])) {
    $aksi = $_POST['aksi'];
    $nama_tempat = $_POST['nama_tempat'];
    $deskripsi = $_POST['deskripsi'];
    $htm = $_POST['htm'];
    $kategori_id = $_POST['kategori'];
    $oldImage = $_POST['oldImage'];

    if ($_FILES['image']['name'] == "") {
        $nama_file = $oldImage;
    } else {
        unlink('assets/img/' . $oldImage);
        $nama_file = $_FILES['image']['name'];
        $folder = 'assets/img/';
        $tmp_name = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp_name, $folder . $nama_file);
    }

    $update = mysqli_query($conn, "UPDATE tempat_wisata SET nama_tempat = '$nama_tempat', deskripsi = '$deskripsi', htm = '$htm', kategori_id = '$kategori_id', image = '$nama_file' WHERE id = '$aksi'");
    if ($update) {
        echo "<script>window.onload = function() { showAlert(2); }</script>";
    } else {
        echo "<script>window.onload = function() { showAlert(4); }</script>";
    }
}

# delete fasilitas
if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    $hapus = mysqli_query($conn, "DELETE FROM tempat_wisata WHERE id = '$aksi'");
    if ($hapus) {
        header('location:wisata.php?delete_success=true');
    } else {
        header('location:wisata.php?delete_success=false');
    }
}
