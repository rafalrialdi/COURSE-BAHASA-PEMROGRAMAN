<?php require_once("admin_auth.php");

$jadwal_list = ['08.30 AM - 10.00 AM', '11.00 AM - 12.30 PM', '14.00 PM - 15.30 PM'];


$edit_data = null;
if (isset($_GET['edit'])) {
    $id_edit = (int)$_GET['edit'];
    $res = $conn->prepare("SELECT * FROM materi WHERE id=?");
    $res->bind_param("i",$id_edit);
    $res->execute();
    $edit_data = $res->get_result()->fetch_assoc();
}


$materi_list = $conn->query("SELECT * FROM materi ORDER BY kategori ASC, id DESC");


$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : "";
$error   = isset($_GET['error'])   ? htmlspecialchars($_GET['error'])   : "";

$kategori_list = ['C++','Python','Java','JavaScript'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Materi</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php include "admin_navbar.php"; ?>

<div class="main">
    <div class="content-area">
        <?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
        <?php if($error):   ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 1.8fr;gap:20px;align-items:start;">

            
            <div class="card">
                <div class="card-header">
                    <h2><?= $edit_data ? 'Edit Materi' : 'Tambah Materi' ?></h2>
                    <?php if($edit_data): ?>
                    <a href="kelola_materi.php" class="btn btn-sm" style="background:#f0f0f0;color:#333">Batal</a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form method="POST" action="proses_materi.php">
                        <input type="hidden" name="aksi" value="<?= $edit_data ? 'edit' : 'tambah' ?>">
                        <?php if($edit_data): ?>
                        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label>Kelas / Kategori</label>
                            <select name="kategori" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach($kategori_list as $kat): ?>
                                <option value="<?= $kat ?>" <?= ($edit_data['kategori']??'')===$kat?'selected':'' ?>><?= $kat ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small>Materi hanya akan tampil di tabel kelas yang dipilih</small>
                        </div>

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" placeholder="Cth: Rafal Rialdi"
                                value="<?= htmlspecialchars($edit_data['nama']??'') ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal"
                                value="<?= htmlspecialchars($edit_data['tanggal']??'') ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Jadwal</label>
                            <select name="jadwal" required>
                                <option value="">-- Pilih Jadwal --</option>
                                <?php foreach($jadwal_list as $j): ?>
                                <option value="<?= $j ?>" <?= ($edit_data['jadwal']??'')===$j?'selected':'' ?>><?= $j ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small>Jadwal dibatasi pada 3 sesi yang tersedia</small>
                        </div>

                        <div class="form-group">
                            <label>Topik Materi</label>
                            <input type="text" name="materi" placeholder="Cth: Pengenalan C++"
                                value="<?= htmlspecialchars($edit_data['materi']??'') ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Link Download</label>
                            <input type="text" name="gambar" placeholder="Cth: https://link-file.com/materi.pdf"
                                value="<?= htmlspecialchars($edit_data['gambar']??'') ?>">
                            <small>Opsional — isi jika ada file yang bisa didownload</small>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" name="status" placeholder="Cth: Aktif / Selesai / Libur"
                                value="<?= htmlspecialchars($edit_data['status']??'') ?>" required>
                            <small>Bebas diisi sesuai kebutuhan</small>
                        </div>

                        <button type="submit" class="btn btn-yellow" style="width:100%">
                            <?= $edit_data ? 'Simpan Perubahan' : 'Tambah Materi' ?>
                        </button>
                    </form>
                </div>
            </div>

            
            <div class="card">
                <div class="card-header">
                    <h2>Daftar Materi (<?= $materi_list->num_rows ?>)</h2>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kelas</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jadwal</th>
                                <th>Materi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if($materi_list->num_rows > 0): $no=1;
                            while($m = $materi_list->fetch_assoc()):
                            $badge_class = match($m['kategori']) {
                                'C++'        => 'badge-cpp',
                                'Python'     => 'badge-python',
                                'Java'       => 'badge-java',
                                'JavaScript' => 'badge-js',
                                default      => 'badge-user'
                            };
                        ?>
                            <tr>
                                <td style="color:#aaa"><?= $no++ ?></td>
                                <td><span class="badge <?= $badge_class ?>"><?= htmlspecialchars($m['kategori']) ?></span></td>
                                <td><strong><?= htmlspecialchars($m['nama']) ?></strong></td>
                                <td style="font-size:0.8rem;color:#666"><?= !empty($m['tanggal']) ? date('d M Y', strtotime($m['tanggal'])) : '-' ?></td>
                                <td style="font-size:0.8rem;color:#666"><?= htmlspecialchars($m['jadwal']) ?></td>
                                <td style="font-size:0.8rem;color:#666"><?= htmlspecialchars($m['materi']) ?></td>
                                <td style="font-size:0.8rem"><?= htmlspecialchars($m['status']) ?></td>
                                <td style="white-space:nowrap">
                                    <a href="kelola_materi.php?edit=<?= $m['id'] ?>" class="btn btn-yellow btn-sm">Edit</a>
                                    <a href="proses_materi.php?aksi=hapus&id=<?= $m['id'] ?>" class="btn btn-red btn-sm"
                                       onclick="return confirm('Hapus materi ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr><td colspan="8">
                                <div class="empty-state"><p>Belum ada materi.</p></div>
                            </td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>