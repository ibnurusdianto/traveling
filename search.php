<?php
include_once 'admin/connection.php';

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    // Check if the search term matches any category
    $queryCategory = "SELECT * FROM kategori WHERE nama_kategori LIKE '%$search%'";
    $resultCategory = mysqli_query($conn, $queryCategory);

    // Check if the search term matches any destination only if no category is found
    if (mysqli_num_rows($resultCategory) > 0) {
        // If a category is found, redirect to details-destination.php
        $row = mysqli_fetch_assoc($resultCategory);
        header("Location: details-destination.php?nama_kategori=" . urlencode($row['nama_kategori']));
        exit;
    } else {
        // If no matching category result is found, check for destination
        $queryDestination = "SELECT * FROM tempat_wisata WHERE nama_tempat LIKE '%$search%'";
        $resultDestination = mysqli_query($conn, $queryDestination);

        if (mysqli_num_rows($resultDestination) > 0) {
            // If a destination is found, redirect to tempat-wisata.php
            $row = mysqli_fetch_assoc($resultDestination);
            header("Location: tempat-wisata.php?nama_tempat=" . urlencode($row['nama_tempat']));
            // Add JavaScript for automatic scrolling to the bottom
            echo '<script>window.onload = function () { window.scrollTo(0, document.body.scrollHeight); }; </script>';
            exit;
        } else {
            // If no matching result is found, redirect to index.php with an error flag
            header("Location: index.php?search_error=true");
            exit;
        }
    }
} else {
    // Handle case when no search query is provided
    header("Location: index.php");
    exit;
}
?>
