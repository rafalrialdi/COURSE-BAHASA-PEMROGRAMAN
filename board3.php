<?php
session_start();
 
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
 
$username = htmlspecialchars($_SESSION['username']);
 

$conn = mysqli_connect("localhost", "root", "", "websiteku");
if (!$conn) die("Koneksi database gagal.");
 

function getMateri($conn, $kategori) {
    $stmt = $conn->prepare("SELECT * FROM materi WHERE kategori=? ORDER BY id ASC");
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    return $stmt->get_result();
}
 
$cpp    = getMateri($conn, "C++");
$python = getMateri($conn, "Python");
$java   = getMateri($conn, "Java");
$js     = getMateri($conn, "JavaScript");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PELATIHAN PEMROGRAMAN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="allboard.css">
    <link rel="stylesheet" href="board3.css">
</head>
<body>
    <?php include("allboard.php"); ?>
 
    <?php
    function renderTabel($result, $judul, $section_id) { ?>
 
    <div class="wrapper">
        <section id="contact">
            <div class="footer">
                <div class="footer-section">
                    <h3><?= htmlspecialchars($judul) ?></h3>
                </div>
            </div>
        </section>
    </div>
 
    <div class="wrapper">
        <section id="<?= $section_id ?>">
            <table class="tabel-materi">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jadwal</th>
                        <th>Materi</th>
                        <th>Download</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($result && $result->num_rows > 0):
                    $no = 1;
                    while($m = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['nama']) ?></td>
                        <td><?= !empty($m['tanggal']) ? date('d M Y', strtotime($m['tanggal'])) : '-' ?></td>
                        <td><?= htmlspecialchars($m['jadwal']) ?></td>
                        <td><?= htmlspecialchars($m['materi']) ?></td>
                        <td>
                            <?php if(!empty($m['gambar'])): ?>
                                <a href="<?= htmlspecialchars($m['gambar']) ?>" class="tbl1" target="_blank">DOWNLOAD MATERI</a>
                            <?php else: ?>
                                <span style="color:#aaa;font-size:0.85rem">-</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($m['status']) ?></td>
                    </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;padding:20px;color:#aaa;">
                            Belum ada materi <?= htmlspecialchars($judul) ?> tersedia.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </section>
        <hr>
    </div>
 
    <?php } ?>
 
    <?php renderTabel($cpp,    "C++",    "c++");    ?>
    <?php renderTabel($python, "Python", "python"); ?>
    <?php renderTabel($java,   "Java",   "java");   ?>
    <?php renderTabel($js,     "Js",     "js");     ?>

</body>
</html>