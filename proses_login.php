<?php
session_start();

mysqli_report(MYSQLI_REPORT_OFF);


$conn = mysqli_connect("localhost", "root", "", "websiteku");

if (!$conn) {
    die("Koneksi gagal");
}


$username = trim($_POST['username'] ?? "");
$password = trim($_POST['password'] ?? "");


if (empty($username) || empty($password)) {
    $_SESSION['error2'] = "DATA HARUS DIISI!";
    header("Location: login.php");
    exit();
}


$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();


if ($row = $result->fetch_assoc()) {

   
    if (password_verify($password, $row['password'])) {

        
        $_SESSION['username'] = $username;

        header("Location: web.php");
        exit();

    } else {
       
        $_SESSION['error2'] = "Password salah!";
        header("Location: login.php");
        exit();
    }

} else {
    
    $_SESSION['error2'] = "Username tidak ditemukan!";
    header("Location: login.php");
    exit();
}
?>