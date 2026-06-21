<nav class="admin-navbar">
    <div class="admin-navbar-wrap">
        <div class="admin-brand">
            <img src="https://upload.wikimedia.org/wikipedia/id/6/62/UNPAM_logo1.png" alt="Logo">
            <div class="admin-brand-text">
                <span>PEMROGRAMAN</span>
                <small>Tutor Panel</small>
            </div>
        </div>

        <div class="admin-links">
            <ul>
                <li><a href="kelola_materi.php" class="active">Kelola Materi</a></li>
            </ul>
        </div>

        <div class="admin-right">
            <div class="admin-info">
                <div class="admin-avatar"><?= strtoupper(substr($tutor_username, 0, 1)) ?></div>
                <div>
                    <div class="admin-name"><?= $tutor_username ?></div>
                    <div class="admin-role">Tutor</div>
                </div>
            </div>
            <a href="../web.php" class="btn btn-sm" style="background:#2a2a2a;color:#F7DF1E">Ke Website</a>
            <a href="../logout.php" class="btn btn-red btn-sm">Logout</a>
        </div>
    </div>
</nav>
