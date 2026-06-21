<?php

require_once("tutor_auth.php");

$jadwal_valid = ['08.30 AM - 10.00 AM', '11.00 AM - 12.30 PM', '14.00 PM - 15.30 PM'];

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';


if ($aksi === 'tambah') {
    $nama     = trim($_POST['nama']     ?? '');
    $tanggal  = trim($_POST['tanggal']  ?? '');
    $jadwal   = trim($_POST['jadwal']   ?? '');
    $materi   = trim($_POST['materi']   ?? '');
    $gambar   = trim($_POST['gambar']   ?? '');
    $status   = trim($_POST['status']   ?? '');
    $kategori = trim($_POST['kategori'] ?? '');

    if (empty($nama) || empty($tanggal) || empty($jadwal) || empty($materi) || empty($status) || empty($kategori) || !in_array($jadwal, $jadwal_valid)) {
        header("Location: kelola_materi.php?error=Semua+field+wajib+diisi+dengan+benar");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO materi (nama, tanggal, jadwal, materi, gambar, status, kategori) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $nama, $tanggal, $jadwal, $materi, $gambar, $status, $kategori);

    if ($stmt->execute()) {
        header("Location: kelola_materi.php?success=Materi+berhasil+ditambahkan");
    } else {
        header("Location: kelola_materi.php?error=Gagal+menambahkan+materi");
    }
    exit();
}


if ($aksi === 'edit') {
    $id       = (int)($_POST['id']       ?? 0);
    $nama     = trim($_POST['nama']     ?? '');
    $tanggal  = trim($_POST['tanggal']  ?? '');
    $jadwal   = trim($_POST['jadwal']   ?? '');
    $materi   = trim($_POST['materi']   ?? '');
    $gambar   = trim($_POST['gambar']   ?? '');
    $status   = trim($_POST['status']   ?? '');
    $kategori = trim($_POST['kategori'] ?? '');

    if (empty($nama) || empty($tanggal) || empty($jadwal) || empty($materi) || empty($status) || empty($kategori) || !in_array($jadwal, $jadwal_valid)) {
        header("Location: kelola_materi.php?edit=$id&error=Semua+field+wajib+diisi+dengan+benar");
        exit();
    }

    $stmt = $conn->prepare("UPDATE materi SET nama=?, tanggal=?, jadwal=?, materi=?, gambar=?, status=?, kategori=? WHERE id=?");
    $stmt->bind_param("sssssssi", $nama, $tanggal, $jadwal, $materi, $gambar, $status, $kategori, $id);

    if ($stmt->execute()) {
        header("Location: kelola_materi.php?success=Materi+berhasil+diperbarui");
    } else {
        header("Location: kelola_materi.php?error=Gagal+memperbarui+materi");
    }
    exit();
}


if ($aksi === 'hapus') {
    $id = (int)($_GET['id'] ?? 0);

    if ($id <= 0) {
        header("Location: kelola_materi.php?error=ID+tidak+valid");
        exit();
    }

    $del = $conn->prepare("DELETE FROM materi WHERE id=?");
    $del->bind_param("i", $id);

    if ($del->execute()) {
        header("Location: kelola_materi.php?success=Materi+berhasil+dihapus");
    } else {
        header("Location: kelola_materi.php?error=Gagal+menghapus+materi");
    }
    exit();
}


header("Location: kelola_materi.php");
exit();