<?php $current = basename($_SERVER['PHP_SELF']); ?>
<nav class="admin-navbar">
    <div class="admin-navbar-wrap">
        <div class="admin-brand">
            <img src="https://upload.wikimedia.org/wikipedia/id/6/62/UNPAM_logo1.png" alt="Logo">
            <div class="admin-brand-text">
                <span>PEMROGRAMAN</span>
                <small>Admin Panel</small>
            </div>
        </div>

        <div class="admin-links">
            <ul>
                <li><a href="dashboard.php" class="<?= $current === 'dashboard.php' ? 'active' : '' ?>">Dashboard</a></li>
                <li><a href="kelola_user.php" class="<?= $current === 'kelola_user.php' ? 'active' : '' ?>">Kelola User</a></li>
                <li><a href="kelola_materi.php" class="<?= $current === 'kelola_materi.php' ? 'active' : '' ?>">Kelola Materi</a></li>
            </ul>
        </div>

        <div class="admin-right">
            <div class="admin-info">
                <div class="admin-avatar"><?= strtoupper(substr($admin_username, 0, 1)) ?></div>
                <div>
                    <div class="admin-name"><?= $admin_username ?></div>
                    <div class="admin-role">Administrator</div>
                </div>
            </div>
            <a href="../web.php" class="btn btn-sm" style="background:#2a2a2a;color:#F7DF1E">Ke Website</a>
            <a href="../logout.php" class="btn btn-red btn-sm">Logout</a>
        </div>
    </div>
</nav>
