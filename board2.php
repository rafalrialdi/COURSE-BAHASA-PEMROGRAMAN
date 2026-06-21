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
    <link rel="stylesheet" href="board2.css">
</head>

<body>

  
    <nav>
        <div class="wrapper">

           
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

    <div class="wrapper">
        <section id="home">
            <img src="jaja.png "
                alt="gambar jaja" width="500">

            <div class="kolom">
                
                <h2>C++</h2>
                <p class="tit">
                    C++ adalah bahasa yang melatih kamu berpikir seperti programmer sejati, dari logika dasar sampai struktur data dan algoritma. Banyak dipakai di dunia game development, software engineering, hingga sistem embedded. Kalau kamu pengen punya pondasi coding yang kuat dan dilirik perusahaan teknologi besar, C++ adalah titik awal yang tepat untuk kamu kuasai sekarang.
                </p>

                <div class="sejajar">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSdoa2Ktjp-CCzhWDRSD9envJ7GUoKUsIWfYCpIuhLzL55Z_6g/viewform?usp=dialog" class="tbl"  target="_blank">
                        DAFTAR
                    </a> 

                    <a href="materi/c++.pdf" class="tbl1" download="" >
                        DOWLOAD MATERI
                    </a> 

                </div>
                    
                    
                    

                    

            </div>
        </section>
       <section id="python">
            <div class="kolom">
                <h2>Python</h2>
                <p class="tit">
                    Python dikenal sebagai bahasa paling ramah untuk pemula, sintaksnya simpel tapi kemampuannya luar biasa luas, mulai dari web development, data science, automation, sampai Artificial Intelligence. Kalau kamu mau belajar coding tanpa pusing dengan aturan rumit, tapi tetap relevan buat karier masa depan, Python adalah pilihan paling worth it untuk kamu pelajari sekarang.
                </p>
                
                    <div class="sejajar">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLScLxtk5AgtGb0R5qKE858g3NuA5wfYzXbv7tXgjXLk2UJowRg/viewform?usp=publish-editor" class="tbl"  target="_blank">
                        DAFTAR
                    </a> 

                    <a href="materi/python.pdf" class="tbl1" download="" class="tbl1">
                        DOWLOAD MATERI
                    </a> 

                </div>
                    
                
            </div>

            <img src="jaja3.png"
                alt="courses">
        </section>
        <section id="tutors">
            <img src="jaja.png "
                alt="gambar jaja" width="500">

            <div class="kolom">
                
                <h2>Java</h2>
                <p class="tit">
                    Java adalah bahasa yang jadi andalan banyak perusahaan besar untuk membangun aplikasi enterprise, sistem perbankan, hingga aplikasi Android. Konsep Object-Oriented Programming yang kamu pelajari di Java juga jadi fondasi penting buat ngerti bahasa lain ke depannya. Kalau target kamu kerja di perusahaan teknologi skala besar, Java adalah skill yang wajib ada di CV kamu.
                </p>
                    <div class="sejajar">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSfZm0ROgmZLx6KJZlZkNIghuoCorfX4GKtLoAxQ2PnQSpk8sg/viewform?usp=publish-editor" class="tbl"  target="_blank">
                        DAFTAR
                    </a> 

                    <a href="materi/java.pdf" class="tbl1" download="" class="tbl1">
                        DOWLOAD MATERI
                    </a> 

                </div>
                    
                    
                    

                    

            </div>
        </section>
        <!-- PARTNERS -->
        <section id="Js">
            <div class="kolom">
                <h2>Java Script</h2>
                <p class="tit">
                    JavaScript adalah bahasa yang menghidupkan website, dari animasi interaktif sampai aplikasi web modern seperti yang kamu pakai sehari-hari. Dengan satu bahasa ini, kamu bisa develop frontend, backend, bahkan aplikasi mobile. Kalau kamu mau jadi web developer yang serba bisa dan permintaan kerjanya selalu tinggi, JavaScript wajib masuk daftar belajar kamu.
                </p>
                
                    <div class="sejajar">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSffLqbDDHbeZnHZnE5tySAx_ZO8nfENQEa7w0N7OvIeMtk9pQ/viewform?usp=publish-editor" class="tbl"  target="_blank">
                        DAFTAR
                    </a> 

                    <a href="materi/js.pdf" class="tbl1" download="" class="tbl1">
                        DOWLOAD MATERI
                    </a> 

                </div>
                    
                
            </div>

            <img src="jaja3.png"
                alt="courses">
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

            <p><b>REHAN</b><br>
                Alamat: Jl. Kenanga No. 89, Bali <br>
                Email: kenanga@email.com <br>
                Telepon: 0844-5555-6666 <br>
                Instagram: @kenanga
            </p>

        </div>
    </div>
    <div class="copyright">
        
            &copy; 2026. <strong>Pemograman.</strong> All Right Reserved.
        
    </div>
</body>

</html>