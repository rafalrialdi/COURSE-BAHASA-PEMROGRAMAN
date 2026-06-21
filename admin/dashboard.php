<?php require_once("admin_auth.php");

$total_user   = $conn->query("SELECT COUNT(*) as t FROM users WHERE role='user'")->fetch_assoc()['t'];
$total_admin  = $conn->query("SELECT COUNT(*) as t FROM users WHERE role='admin'")->fetch_assoc()['t'];
$total_tutor  = $conn->query("SELECT COUNT(*) as t FROM users WHERE role='tutor'")->fetch_assoc()['t'];
$total_materi = $conn->query("SELECT COUNT(*) as t FROM materi")->fetch_assoc()['t'];
$total_cpp    = $conn->query("SELECT COUNT(*) as t FROM materi WHERE kategori='C++'")->fetch_assoc()['t'];
$total_python = $conn->query("SELECT COUNT(*) as t FROM materi WHERE kategori='Python'")->fetch_assoc()['t'];
$total_java   = $conn->query("SELECT COUNT(*) as t FROM materi WHERE kategori='Java'")->fetch_assoc()['t'];
$total_js     = $conn->query("SELECT COUNT(*) as t FROM materi WHERE kategori='JavaScript'")->fetch_assoc()['t'];

$user_terbaru = $conn->query("SELECT username, email, role FROM users ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        
        if (typeof Chart === 'undefined') {
            document.write('<scr' + 'ipt src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></scr' + 'ipt>');
        }
    </script>
</head>
<body>
<?php include "admin_navbar.php"; ?>

<div class="main">
    <div class="content-area">

        
        <div class="card">
            <div class="card-header">
                <h2>Statistik Pengguna</h2>
            </div>
            <div class="card-body">
                <div class="chart-box">
                    <canvas id="userChart"></canvas>
                </div>
            </div>
        </div>

       
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-value"><?= $total_materi ?></div>
                <div class="stat-label">Total Materi</div>
            </div>
            <div class="stat-card red">
                <div class="stat-value"><?= $total_cpp ?></div>
                <div class="stat-label">Materi C++</div>
            </div>
            <div class="stat-card green">
                <div class="stat-value"><?= $total_python ?></div>
                <div class="stat-label">Materi Python</div>
            </div>
            <div class="stat-card purple">
                <div class="stat-value"><?= $total_java ?></div>
                <div class="stat-label">Materi Java</div>
            </div>
            <div class="stat-card blue">
                <div class="stat-value"><?= $total_js ?></div>
                <div class="stat-label">Materi JavaScript</div>
            </div>
        </div>

        
        <div class="card">
            <div class="card-header">
                <h2>User Terbaru</h2>
                <a href="kelola_user.php" class="btn btn-dark btn-sm">Lihat Semua</a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($user_terbaru->num_rows > 0): $no = 1;
                        while ($u = $user_terbaru->fetch_assoc()):
                            $badge_class = match ($u['role']) {
                                'admin' => 'badge-admin',
                                'tutor' => 'badge-tutor',
                                default => 'badge-user'
                            };
                    ?>
                        <tr>
                            <td style="color:#aaa"><?= $no++ ?></td>
                            <td><strong><?= htmlspecialchars($u['username']) ?></strong></td>
                            <td style="color:#777;font-size:0.82rem"><?= htmlspecialchars($u['email']) ?></td>
                            <td><span class="badge <?= $badge_class ?>"><?= ucfirst($u['role']) ?></span></td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="4"><div class="empty-state"><p>Belum ada user.</p></div></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
new Chart(document.getElementById('userChart'), {
    type: 'bar',
    data: {
        labels: ['User', 'Admin', 'Tutor'],
        datasets: [{
            label: 'Jumlah',
            data: [<?= $total_user ?>, <?= $total_admin ?>, <?= $total_tutor ?>],
            backgroundColor: ['#2ecc71', '#1a1a1a', '#3498db'],
            borderRadius: 6,
            maxBarThickness: 80
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
    }
});
</script>
</body>
</html>