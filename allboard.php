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