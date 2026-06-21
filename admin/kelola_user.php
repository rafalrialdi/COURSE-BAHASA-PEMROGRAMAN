<?php require_once("admin_auth.php");

$success = "";
$error   = "";


if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $cek = $conn->prepare("SELECT username FROM users WHERE id=?");
    $cek->bind_param("i",$id);
    $cek->execute();
    $cek_result = $cek->get_result()->fetch_assoc();
    if ($cek_result && $cek_result['username'] !== $admin_username) {
        $del = $conn->prepare("DELETE FROM users WHERE id=?");
        $del->bind_param("i",$id);
        $del->execute();
        $success = "User berhasil dihapus.";
    } else {
        $error = "Tidak bisa menghapus akun sendiri!";
    }
}


if (isset($_POST['ubah_role'])) {
    $id         = (int)$_POST['user_id'];
    $role_input = $_POST['role'] ?? 'user';
    $role_baru  = in_array($role_input, ['admin','tutor','user']) ? $role_input : 'user';
    $upd  = $conn->prepare("UPDATE users SET role=? WHERE id=?");
    $upd->bind_param("si",$role_baru,$id);
    $upd->execute();
    $success = "Role user berhasil diubah.";
}


$search = isset($_GET['q']) ? trim($_GET['q']) : "";
if ($search !== "") {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE ? OR email LIKE ? ORDER BY id DESC");
    $like = "%$search%";
    $stmt->bind_param("ss",$like,$like);
} else {
    $stmt = $conn->prepare("SELECT * FROM users ORDER BY id DESC");
}
$stmt->execute();
$users = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User — Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php include "admin_navbar.php"; ?>

<div class="main">
    <div class="content-area">
        <?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
        <?php if($error):   ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h2>Daftar Semua User</h2>
                <form method="GET" class="search-bar">
                    <input type="text" name="q" placeholder="Cari username / email..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-yellow btn-sm">Cari</button>
                    <?php if($search): ?><a href="kelola_user.php" class="btn btn-sm" style="background:#f0f0f0;color:#333">Reset</a><?php endif; ?>
                </form>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nomor</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($users->num_rows > 0): $no=1;
                        while($u = $users->fetch_assoc()):
                        $badge_class = match($u['role']) {
                            'admin' => 'badge-admin',
                            'tutor' => 'badge-tutor',
                            default => 'badge-user'
                        };
                    ?>
                        <tr>
                            <td style="color:#aaa"><?= $no++ ?></td>
                            <td><strong><?= htmlspecialchars($u['username']) ?></strong></td>
                            <td style="color:#666;font-size:0.82rem"><?= htmlspecialchars($u['email']) ?></td>
                            <td style="color:#666;font-size:0.82rem"><?= htmlspecialchars($u['nomor'] ?? '-') ?></td>
                            <td><span class="badge <?= $badge_class ?>"><?= ucfirst($u['role']) ?></span></td>
                            <td>
                                <form method="POST" style="display:inline">
                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                    <input type="hidden" name="ubah_role" value="1">
                                    <select name="role" onchange="this.form.submit()"
                                        style="padding:4px 8px;border:1px solid #ddd;border-radius:6px;font-size:0.78rem;cursor:pointer"
                                        <?= $u['username']===$admin_username?'disabled':'' ?>>
                                        <option value="user"  <?= $u['role']==='user' ?'selected':'' ?>>User</option>
                                        <option value="tutor" <?= $u['role']==='tutor'?'selected':'' ?>>Tutor</option>
                                        <option value="admin" <?= $u['role']==='admin'?'selected':'' ?>>Admin</option>
                                    </select>
                                </form>
                                <?php if($u['username'] !== $admin_username): ?>
                                <a href="kelola_user.php?hapus=<?= $u['id'] ?>" class="btn btn-red btn-sm"
                                   onclick="return confirm('Hapus user <?= htmlspecialchars($u['username']) ?>?')">Hapus</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="6"><div class="empty-state"><p>Tidak ada user ditemukan.</p></div></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
