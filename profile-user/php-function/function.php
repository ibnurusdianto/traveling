<?php
session_start();
// fetch admin profile
function fetchAdmins() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "travel";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, username, img FROM user WHERE role = 'admin'";
    $result = $conn->query($sql);

    $admins = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $admins[] = $row;
        }
    }

    $conn->close();

    return $admins;
}
$admins = fetchAdmins();



// function user-profile fetch information data
$hostname = "localhost";
$username = "root";
$password = "";
$db_name = "travel";

$conn = new mysqli($hostname, $username, $password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit();
}
$username = filter_var($_SESSION['username'], FILTER_SANITIZE_STRING);
$ip = '182.253.194.7';
$access_key = '2043220da77560';
$ch = curl_init('http://ipinfo.io/' . $ip . '?token=' . $access_key);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$ip_details = json_decode($response, true);

$city = $ip_details['city'] ?? 'Unknown';
$region = $ip_details['region'] ?? 'Unknown';
$country = $ip_details['country'] ?? 'Unknown';

$location = $city . ', ' . $region . ', ' . $country;

$query = "UPDATE user SET location = ? WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $location, $username);
$stmt->execute();

$query = "SELECT * FROM user WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


// function edit data user



?>