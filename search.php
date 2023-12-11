<?php
include_once 'admin/connection.php';

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $queryCategory = "SELECT * FROM kategori WHERE nama_kategori LIKE '%$search%'";
    $resultCategory = mysqli_query($conn, $queryCategory);

    if (mysqli_num_rows($resultCategory) > 0) {
        $row = mysqli_fetch_assoc($resultCategory);
        header("Location: details-destination.php?nama_kategori=" . urlencode($row['nama_kategori']));
        exit;
    } else {
        $queryDestination = "SELECT * FROM tempat_wisata WHERE nama_tempat LIKE '%$search%'";
        $resultDestination = mysqli_query($conn, $queryDestination);

        if (mysqli_num_rows($resultDestination) > 0) {
            $row = mysqli_fetch_assoc($resultDestination);
            header("Location: tempat-wisata.php?nama_tempat=" . urlencode($row['nama_tempat']));
            exit;
        } else {
            header("Location: index.php?search_error=true");
            exit;
        }
    }
} else {
    header("Location: index.php");
    exit;
}
?>
