<?php
$conn = mysqli_connect("localhost", "root", "", "travel");
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM user WHERE id='$id'");
$user = mysqli_fetch_assoc($query);

if (isset($_POST['simpan'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $img = $_FILES['img']['name'];
    $new_image = $_FILES['img'];
    $file_size = $new_image['size'];
    $file_type = $new_image['type'];
    $file_extension = strtolower(pathinfo($new_image['name'], PATHINFO_EXTENSION));
    $allowed_types = array('image/png', 'image/jpeg', 'image/jpg');
    $allowed_extensions = array('png', 'jpeg', 'jpg');
    $target_dir = "../../img/uploads/";
    $target_file = $target_dir . basename($new_image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($new_password != "" && $confirm_password != "" && $new_image["name"] == "") {
        if ($new_password != $confirm_password) {
            echo "<script>alert('Password tidak sama');</script>";
        } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $new_password)) {
            echo "<script>alert('Password harus terdiri dari setidaknya satu huruf kecil, satu huruf besar, satu angka, satu karakter khusus, dan panjang minimal 8 karakter.');</script>";
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $query = mysqli_query($conn, "UPDATE user SET password='$hashed_password' WHERE id='$id'");
            if ($query) {
                echo "<script>alert('Data berhasil diupdate, tanpa update image');</script>";
                echo "<script>window.location='../profile.php';</script>";
            } else {
                echo "<script>alert('Data gagal diupdate');</script>";
            }
        }
    }
    if ($new_password != "" && $confirm_password != "" && $new_image["name"] != "") {
        if ($new_password != $confirm_password) {
            echo "<script>alert('Password tidak sama');</script>";
        } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $new_password)) {
            echo "<script>alert('Password harus terdiri dari setidaknya satu huruf kecil, satu huruf besar, satu angka, satu karakter khusus, dan panjang minimal 8 karakter.');</script>";
        } else {
            if ($file_size > 400000000000) {
                echo "<script>alert('Gambar terlalu besar!');</script>";
                echo "<script>window.location='../profile.php';</script>";
            } elseif (!in_array($file_type, $allowed_types)) {
                echo "<script>alert('Tidak bisa upload selain tipe PNG, JPEG, and JPG!');</script>";
                echo "<script>window.location='../profile.php';</script>";
            } elseif (!in_array($file_extension, $allowed_extensions)) {
                echo "<script>alert('Image extensi hanya bisa PNG, JPEG, and JPG yang diizinkan!');</script>";
                echo "<script>window.location='../profile.php';</script>";
            } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "<script>alert('Maaf, dibilang hanya bisa upload JPG, JPEG, PNG');</script>";
                echo "<script>window.location='../profile.php';</script>";
            } elseif ($file_size > 400000000000) {
                echo "<script>alert('Maaf, Dibilang Gambar terlalu besar!');</script>";
                echo "<script>window.location='../profile.php';</script>";
            } elseif (!move_uploaded_file($new_image["tmp_name"], $target_file)) {
                echo "<script>alert('Maaf, ada kesalahan dalam upload file, mohon dicek kembali');</script>";
                echo "<script>window.location='../profile.php';</script>";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $query = mysqli_query($conn, "UPDATE user SET password='$hashed_password', img='$img' WHERE id='$id'");
                if ($query) {
                    move_uploaded_file($_FILES['img']['tmp_name'], "../../img/uploads/".$_FILES['img']['name']);
                    echo "<script>alert('Data berhasil diupdate semuanya');</script>";
                    echo "<script>window.location='../profile.php';</script>";
                } else {
                    echo "<script>alert('Data gagal diupdate');</script>";
                }
            }
        }
    }
    elseif ($new_password == "" && $confirm_password == "" && $new_image["name"] != "") {
        if ($file_size > 400000000000) {
            echo "<script>alert('Gambar terlalu besar!');</script>";
            echo "<script>window.location='../profile.php';</script>";
        } elseif (!in_array($file_type, $allowed_types)) {
            echo "<script>alert('Tidak bisa upload selain tipe PNG, JPEG, and JPG!');</script>";
            echo "<script>window.location='../profile.php';</script>";
        } elseif (!in_array($file_extension, $allowed_extensions)) {
            echo "<script>alert('Image extensi hanya bisa PNG, JPEG, and JPG yang diizinkan!');</script>";
            echo "<script>window.location='../profile.php';</script>";
        } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "<script>alert('Maaf, dibilang hanya bisa upload JPG, JPEG, PNG');</script>";
            echo "<script>window.location='../profile.php';</script>";
        } elseif ($file_size > 400000000000) {
            echo "<script>alert('Maaf, Dibilang Gambar terlalu besar!');</script>";
            echo "<script>window.location='../profile.php';</script>";
        } elseif (!move_uploaded_file($new_image["tmp_name"], $target_file)) {
            echo "<script>alert('Maaf, ada kesalahan dalam upload file, mohon dicek kembali');</script>";
            echo "<script>window.location='../profile.php';</script>";
        } else {
            $query = mysqli_query($conn, "UPDATE user SET img='$img' WHERE id='$id'");
            if ($query) {
                move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
                echo "<script>alert('Data berhasil diupdate, tanpa update password');</script>";
                echo "<script>window.location='../profile.php';</script>";
            } else {
                echo "<script>alert('Data gagal diupdate');</script>";
            }
        }
    } else {
        echo "<script>alert('Tidak ada data yang diupdate');</script>";
        echo "<script>window.location='../profile.php';</script>";
    }
}
?>