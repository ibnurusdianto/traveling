<?php
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "travel");

//mendapatkan id user yang akan diedit
$id = $_GET['id'];

//query untuk mengambil data user berdasarkan id
$query = mysqli_query($conn, "SELECT * FROM user WHERE id='$id'");
$user = mysqli_fetch_assoc($query);

//jika tombol simpan ditekan
if(isset($_POST['simpan'])){
    //mengambil data dari form
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $img = $_FILES['img']['name'];

    //validasi password
    if($new_password != $confirm_password){
        echo "<script>alert('Password tidak sama');</script>";
    } else {
        //hash password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        //update data user dengan password yang di-hash
        $query = mysqli_query($conn, "UPDATE user SET password='$hashed_password', img='$img' WHERE id='$id'");
        if($query){
            //upload gambar
            move_uploaded_file($_FILES['img']['tmp_name'], "../../img/uploads/".$_FILES['img']['name']);
            echo "<script>alert('Data berhasil diupdate');</script>";
            echo "<script>window.location='../profile.php';</script>";
        } else {
            echo "<script>alert('Data gagal diupdate');</script>";
        }
    }
}
?>