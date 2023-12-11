<?php
session_start();

if (isset($_SESSION['username'])) {
    include 'admin/connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
        $rating = mysqli_real_escape_string($conn, $_POST['rating']);
        $tempat_wisata_id = mysqli_real_escape_string($conn, $_POST['tempat_wisata_id']);
        $nama_tempat = mysqli_real_escape_string($conn, $_POST['nama_tempat']);

        // Mendapatkan user_id dari sesi
        $username = $_SESSION['username'];
        $query_user_id = "SELECT id FROM user WHERE username = ?";
        $stmt_user_id = mysqli_prepare($conn, $query_user_id);
        mysqli_stmt_bind_param($stmt_user_id, 's', $username);
        mysqli_stmt_execute($stmt_user_id);
        $result_user_id = mysqli_stmt_get_result($stmt_user_id);

        if ($row_user_id = mysqli_fetch_assoc($result_user_id)) {
            $user_id = $row_user_id['id'];

            // Menyimpan komentar ke dalam tabel review dengan waktu saat ini
            $query_add_comment = "INSERT INTO review (user_id, tempat_wisata_id, komentar, rating, waktu) VALUES (?, ?, ?, ?, NOW())";
            $stmt_add_comment = mysqli_prepare($conn, $query_add_comment);
            mysqli_stmt_bind_param($stmt_add_comment, 'iisi', $user_id, $tempat_wisata_id, $komentar, $rating);
            mysqli_stmt_execute($stmt_add_comment);

            mysqli_stmt_close($stmt_add_comment);
        }

        mysqli_stmt_close($stmt_user_id);
        mysqli_close($conn);

        // Redirect kembali ke halaman tempat wisata setelah menambah komentar
        header("Location: tempat-wisata.php?nama_tempat=" . ($nama_tempat));
        exit;
    }
} else {
    // Jika sesi tidak ada, arahkan ke halaman login
    header("Location: login.php");
    exit;
}
