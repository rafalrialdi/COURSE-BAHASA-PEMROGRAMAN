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

if (!$user || $user['role'] !== 'admin') {
    header("Location: ../web.php");
    exit();
}

$admin_username = htmlspecialchars($user['username']);
$admin_email    = htmlspecialchars($user['email']);
$role           = $user['role'];
$role_label     = 'Administrator';
