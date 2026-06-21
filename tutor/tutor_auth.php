<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "websiteku");
if (!$conn) die("Koneksi database gagal.");

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user || $user['role'] !== 'tutor') {
    header("Location: ../web.php");
    exit();
}

$tutor_username = htmlspecialchars($user['username']);
$tutor_email    = htmlspecialchars($user['email']);
