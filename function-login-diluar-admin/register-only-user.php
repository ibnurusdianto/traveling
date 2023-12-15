<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
function isUsernameExists($username, $conn) {
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
}
function register($username, $password) {
    if (empty($username) || empty($password)) {
        return "Isi semua field!";
    }
    $conn = mysqli_connect('localhost', 'root', '', 'travel');
    $username = mysqli_real_escape_string($conn, $username);
    if (isUsernameExists($username, $conn)) {
        return "Maaf username yang anda inputkan sudah ada, mohon gunakan username lainnya";
    }
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        return "Password harus terdiri dari setidaknya satu huruf kecil, satu huruf besar, satu angka, satu karakter khusus, dan panjang minimal 8 karakter.";
    }
    $recaptcha_response = $_POST['g-recaptcha-response'];
    $recaptcha_secret = '6LdblzApAAAAABdrHJchyNV-pJPKci0c15eBtfys';
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = array(
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    );
    $recaptcha_options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptcha_data)
        )
    );
    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
    $recaptcha_json = json_decode($recaptcha_result);
    if (!$recaptcha_json->success) {
        return "anda belum ceklis captcha!";
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (username, password, role) VALUES (?, ?, 'user')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $hashed_password);
    $result = mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    return $result;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $registerResult = register($username, $password);

        if ($registerResult === true) {
            echo '<script>alert("Registration successful"); window.location.href="../login.php";</script>';
        } else {
            echo '<script>alert("'.$registerResult.'"); window.location.href="../register.php";</script>'; 
        }
    } else {
        echo '<script>alert("Isi semua field"); window.location.href="../register.php";</script>';
    }
}
?>