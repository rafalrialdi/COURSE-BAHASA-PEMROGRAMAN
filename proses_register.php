<?php
session_start();

mysqli_report(MYSQLI_REPORT_OFF);

$conn = mysqli_connect("localhost", "root", "", "websiteku");

if (!$conn) {
    die("Koneksi gagal");
}

$error = "";

$username = trim($_POST['username']);
$password = trim($_POST['password']);
$nomor    = trim($_POST['nomor']);
$email    = trim($_POST['email']);


if (empty($username) || empty($password) || empty($nomor) || empty($email)) {
    $error = "DATA KOSONGG!!!!";
}


if ($error == "") {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users(username, password, nomor, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $nomor, $email);
    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Gagal membuat akun!";
    }
}


if (!empty($error)) {
    $_SESSION['error'] = $error;
    header("Location: register.php");
    exit();
}
?>