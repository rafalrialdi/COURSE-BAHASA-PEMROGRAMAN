<?php
session_start();

$username = $_SESSION['username'] ?? null;
if ($username){
    $username = htmlspecialchars($username);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COURSE BAHASA PEMROGRAMAN</title>
    <link rel="stylesheet" href="web.css">
</head>

<body>

    
    <nav>
        <div class="wrapper">

           
            <div class="logo">
                <img src="https://upload.wikimedia.org/wikipedia/id/6/62/UNPAM_logo1.png" alt="Logo" />
                <a href="">PEMROGRAMAN</a>
            </div>

            <!-- MENU -->
            <div class="menu">
                <ul>
                    <li><a href="#home" class="tbl-biru">Home</a></li>
                    <li><a href="#courses" class="tbl-biru">Courses</a></li>
                    <li><a href="#tutors" class="tbl-biru">Tutors</a></li>
                    <li><a href="#partners" class="tbl-biru">Partners</a></li>
                    <li><a href="#contact" class="tbl-biru">Contact</a></li>
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

    <div class="wrapper">
        <section id="home">
            <img src="jaja.png " alt="gambar jaja" width="500">

            <div class="kolom">
                
                <h2>Yukk Ngoding bareng dengan kakak tingkat</h2>
                <p class="tit">
                    Di sini kamu bisa belajar bareng tiap hari dengan mahasiswa UNPAM lainnya, dibimbing langsung oleh
                    kakak tingkat. Jadi bukan cuma kamu yang makin paham coding, tapi mereka juga dapet sekaligus
                    pengalaman mengajar. Win-Win!
                </p>
                <a href="<?php
                    if($username){
                        echo 'board.php';
                    } else {
                        echo 'login.php';
                    }
                ?>" class="tbl-pink">
                    PELAJARI LEBIH LANJUT
                </a>



            </div>
        </section>
        <section id="courses">
            <div class="kolom">
                <h2>COURSES ONLINE</h2>
                <p class="tit">
                    Pelatihan coding online yang membantu kamu belajar HTML, CSS,
                    JavaScript, dan pemrograman modern dengan mudah, menyenangkan,
                    interaktif, serta meningkatkan keterampilan membuat website,
                    aplikasi, dan karier digital masa depan.
                </p>
                <p>
                    <a href="<?php
                    if($username){
                        echo 'board.php';
                    } else {
                        echo 'login.php';
                    }
                ?>" class="tbl-pink">
                        PELAJARI LEBIH LANJUT
                    </a>
                </p>
            </div>

            <img src="jaja3.png" alt="courses">
        </section>
        <section id="tutors">
            <div class="tengah">
                <div class="kolom">
                    <h2>PENGEMBANG</h2>
                </div>

                <div class="tutor-list">

                    <div class="kartu-tutor">
                        <img src="jaja8.jpeg    "
                            alt="">
                        <p>Rafal Rialdi</p>
                    </div>

                    <div class="kartu-tutor">
                        <img src="jaja10.jpeg" alt="">
                        <p>REZKI FAJAR PRATAMA</p>
                    </div>

                    <div class="kartu-tutor">
                        <img src="jaja9.jpeg"
                            alt="">
                        <p>FARUQH FATIHUL IKWAN</p>
                    </div>

                    <div class="kartu-tutor">
                        <img src="https://square-vn.com/app/dscms/assets/images/person-1.jpg?v=1653932875" alt="">
                        <p>REHAN AL AMIN</p>
                    </div>

                </div>
            </div>
        </section>
        
        <section id="partners">
            <div class="partners">

                <!-- Gambar Partner -->
                <div class="partner">
                    <a href="https://unpam.ac.id/" target="_blank">
                        <img src="jaja4.png" alt="Universitas Pamulang">
                    </a>
                    <p class="deskripsi">UNIVERSITAS PAMULANG</p>
                </div>

                
                <div class="kolom">
                    <h2>PARTNERS</h2>
                    <p class="tit">
                        Partner bersama Universitas Pamulang menghadirkan kolaborasi
                        pendidikan yang inovatif, mendukung pengembangan keterampilan,
                        penelitian, dan teknologi. Melalui kerja sama ini, mahasiswa
                        mendapatkan peluang belajar, praktik, serta pengalaman yang
                        bermanfaat untuk mempersiapkan diri menghadapi tantangan dunia kerja
                        dan masa depan lebih baik.
                    </p>
                </div>

            </div>
        </section>

    </div>

    <!-- CONTACT -->
    <div id="contact">
        <div class="footer">
            <div class="footer-section">
                <h3>CONTACT US</h3>
            </div>
        </div>
        <div class="mat">
            <p><b>RAFAL RIALDI</b><br>
                Alamat: Jl. Bhakti No. 123, Tangerang <br>
                Email: Rafalrialdi1@email.com <br>
                Telepon: 0812-3456-7890 <br>
                Instagram: @rafalsxc
            </p>

            <p><b>REZKI FAJAR PRATAMA</b><br>
                Alamat: Jln Grogol jaya 4, Depok <br>
                Email: rezkifp22@gmail.com <br>
                Telepon: 0895-3240-8442 <br>
                Instagram: @rezkifjr_
            </p>

            <p><b>FARUQH FATIHUL IKWAN</b><br>
                Alamat:  Jl. Mesjid Jami Nurul Amin, Depok <br>
                Email: faruqfatihul2105@gmail.com <br>
                Telepon: 0858-9394-8842 <br>
                Instagram: @furay_qo
            </p>

            <p><b>REHAN AL AMIN</b><br>
                Alamat: Jl. Kenanga No. 89, Bogor <br>
                Email: kenanga@email.com <br>
                Telepon: 0844-5555-6666 <br>
                Instagram: @REHAN
            </p>

        </div>
    </div>
    <div class="copyright">
        <div class="wrapper">
            &copy; 2026. <b>Pemograman.</b> All Right Reserved.
        </div>
    </div>
</body>

</html>