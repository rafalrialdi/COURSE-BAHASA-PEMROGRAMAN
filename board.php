<?php
session_start();


if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PELATIHAN PEMROGRAMAN</title>
    <link rel="stylesheet" href="board.css">
    <link rel="stylesheet" href="board-hero.css">
</head>

<body>

    
    <nav>
        <div class="wrapper">

            <!-- LOGO -->
            <div class="logo">
                <img src="https://upload.wikimedia.org/wikipedia/id/6/62/UNPAM_logo1.png"
                    alt="gambar jaja" />
                <a href="web.php">PEMROGRAMAN</a>
            </div>

           
            <div class="menu">
                <ul>
                    <li><a href="board.php" class="tbl-biru">Tutors</a></li>
                    <li class="dropdown">
                        <a href="board2.php" class="tbl-biru">
                            Class
                        </a>

                        <div class="dropdown-content">
                            <a href="board2.php#home">C++</a>
                            <a href="board2.php#python">Python</a>
                            <a href="board2.php#tutors">Java</a>
                            <a href="board2.php#Js" class="tut">Js</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="board3.php" class="tbl-biru">
                            Jadwal
                        </a>

                        <div class="dropdown-content">
                            <a href="board3.php#c++">C++</a>
                            <a href="board3.php#pyton">Python</a>
                            <a href="board3.php#java">Java</a>
                            <a href="board3.php#js" class="tut">Js</a>
                        </div>
                    </li>
                    <li><a href="board4.php" class="tbl-biru">Diskusi </a></li>
                    <li class="dropdown">
                        <?php if($username){ ?>

                        <a href="#" class="dropbtn">
                            👤 <?php echo $username; ?>
                        </a>

                        <div class="dropdown-content"><?php 
                        $conn_nav = mysqli_connect("localhost", "root", "", "websiteku");
                        $stmt_nav = $conn_nav->prepare("SELECT role FROM users WHERE username = ?");
                        $stmt_nav->bind_param("s", $username);
                        $stmt_nav->execute();
                        $role_data = $stmt_nav->get_result()->fetch_assoc();
                        if($role_data && $role_data['role'] === 'admin'): ?>
                          <a href="admin/dashboard.php" class="tut">Admin</a>
                        <?php elseif($role_data && $role_data['role'] === 'tutor'): ?>
                          <a href="tutor/kelola_materi.php" class="tut">Tutor</a>
                        <?php endif; ?>
                        <a href="logout.php">Logout</a>
                        </div>

                        <?php } else    { ?>

                        <a href="login.php" class="tbl-biru">Sign In</a>

                        <?php } ?>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="wrappe">
        <section class="board">

            <h1>Punya skill? Yuk jadi tutor!</h1>

            <div class="content">

                <div class="kiri">
                    <img src="https://img.magnific.com/free-vector/hand-drawn-online-tutor-illustration_52683-146749.jpg"
                        alt="Logo Tutor">
                </div>

                <div class="kanan">
                    <p>
                        Bergabunglah sebagai tutor dan bagikan ilmu yang kamu miliki kepada sesama mahasiswa. Selain
                        membantu orang lain belajar, kamu juga akan mengasah kemampuan komunikasi, memperdalam pemahaman
                        materi, serta membangun pengalaman yang berharga untuk masa depan kariermu.
                    </p>
                    <div class="deskripsi">
                        <p class="si">Benefit yang akan kamu dapatkan :</p>

                        <ul>
                            <li>🔥 Skill makin tajam karena sering ngajarin</li>
                            <li>🗣️ Jadi lebih pede ngomong di depan orang</li>
                            <li>💼 Pengalaman keren buat portofolio & CV</li>
                            <li>👥 Nambah teman & networking</li>

                        </ul>
                        <div class="li-tombol-row">
                            <div class="li-terakhir">🎓 Ikut berkontribusi bantu mahasiswa lain</div>
                            <a href="https://docs.google.com/forms/d/e/1FAIpQLSef8qtdhgks4s26K-J8dg8RLulsel2o6oRBTlfe5P8B6RyEPA/viewform?usp=publish-editor
                                " class="tombol"  target="_blank">DAFTAR SEGERA</a>
                        </div>

                    </div>
                </div>
            </div>
