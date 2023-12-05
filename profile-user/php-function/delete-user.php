<?php
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "travel";

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $db_name);

    // Cek apakah ada data yang diterima melalui form
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Periksa apakah user dengan id tersebut ada di database
        $sql = "SELECT * FROM user WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Ambil data user
            $user = $result->fetch_assoc();

            // Hapus user dari database
            $sql = "DELETE FROM user WHERE id = $id";
            $conn->query($sql);

            // pesan sukses dan redirect ke halaman index.php
            echo "<script>alert('Delete Successfully'); window.location.href = '../../index.php';</script>";
        } else {
            echo "User tidak ditemukan.";
        }
    }

    $conn->close();
?>