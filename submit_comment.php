<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

if (isset($_SESSION['username'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'travel');

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);

    $nama_tempat = mysqli_real_escape_string($conn, $_POST['nama_tempat']);
    $query_destination = "SELECT id FROM tempat_wisata WHERE nama_tempat = ?";
    $stmt_destination = mysqli_prepare($conn, $query_destination);
    mysqli_stmt_bind_param($stmt_destination, 's', $nama_tempat);
    mysqli_stmt_execute($stmt_destination);
    $result_destination = mysqli_stmt_get_result($stmt_destination);

    if ($row_destination = mysqli_fetch_assoc($result_destination)) {
        $tempat_wisata_id = $row_destination['id'];

        $waktu = date("Y-m-d");

        $query = "INSERT INTO review (user_id, tempat_wisata_id, komentar, rating, waktu) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'iisss', $_SESSION['user_id'], $tempat_wisata_id, $komentar, $rating, $waktu);

        if (mysqli_stmt_execute($stmt)) {
            echo "Comment and rating submitted successfully!";
            // Redirect using absolute path
            header("Location: tempat-wisata.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Destination not found.";
    }

    mysqli_close($conn);
} else {
    echo "Please log in to submit comments and ratings.";
}
?>
