<?php
$page_title = "Raporlar ve Başarılarım";
require_once 'templates/header.php';

if (!isLoggedIn()) {
    echo "<div class='alert alert-danger'>Bu sayfayı görmek için lütfen <a href='login.php'>giriş yapın</a>.</div>";
    require_once 'templates/footer.php';
    exit();
}

$user_id = $_SESSION['user_id'];

// Genel İstatistikler
$stmt_cuz = $conn->prepare("SELECT COUNT(*) FROM user_activity_log WHERE user_id = :user_id AND activity_type = 'cuz_okundu'");
$stmt_cuz->execute(['user_id' => $user_id]);
$total_cuz = $stmt_cuz->fetchColumn();

$stmt_zikir = $conn->prepare("SELECT SUM(value) FROM user_activity_log WHERE user_id = :user_id AND activity_type = 'zikir_eklendi'");
$stmt_zikir->execute(['user_id' => $user_id]);
$total_zikir = $stmt_zikir->fetchColumn() ?? 0;

// Kazanılan Rozetler
$stmt_badges = $conn->prepare("
    SELECT b.name, b.description, b.icon 
    FROM user_badges ub 
    JOIN badges b ON ub.badge_id = b.id 
    WHERE ub.user_id = :user_id
    ORDER BY ub.earned_at DESC
");
$stmt_badges->execute(['user_id' => $user_id]);
$user_badges = $stmt_badges->fetchAll();

// Grafik Verileri (Son 6 Ay)
$chart_data = ['labels' => [], 'cuz_data' => [], 'zikir_data' => []];
for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i months"));
    $month_name = date('M Y', strtotime("-$i months"));
    array_push($chart_data['labels'], $month_name);

    // Aylık Cüz
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user_activity_log WHERE user_id = :uid AND activity_type = 'cuz_okundu' AND DATE_FORMAT(activity_date, '%Y-%m') = :month");
    $stmt->execute(['uid' => $user_id, 'month' => $month]);
    array_push($chart_data['cuz_data'], $stmt->fetchColumn());

    // Aylık Zikir
    $stmt = $conn->prepare("SELECT SUM(value) FROM user_activity_log WHERE user_id = :uid AND activity_type = 'zikir_eklendi' AND DATE_FORMAT(activity_date, '%Y-%m') = :month");
    $stmt->execute(['uid' => $user_id, 'month' => $month]);
    array_push($chart_data['zikir_data'], $stmt->fetchColumn() ?? 0);
}
?>
<!-- Chart.js kütüphanesini ekleyelim -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h1>Raporlar ve Başarılarım</h1>

<!-- Genel İstatistikler -->
<div class="grid-container" style="grid-template-columns: repeat(auto-fill, minmax(250px, 1fr )); margin-bottom: 2rem;">
    <div class="card stat-card" style="text-align: center;">
        <div class="icon" style="font-size: 3rem; color: var(--primary-color);"><i class="fas fa-book-reader"></i></div>
        <h3><?php echo $total_cuz; ?></h3>
        <p>Toplam Okunan Cüz</p>
    </div>
    <div class="card stat-card" style="text-align: center;">
        <div class="icon" style="font-size: 3rem; color: var(--success-color);"><i class="fas fa-praying-hands"></i></div>
        <h3><?php echo number_format($total_zikir); ?></h3>
        <p>Toplam Çekilen Zikir</p>
    </div>
</div>

<!-- Grafikler -->
<div class="card" style="margin-bottom: 2rem;">
    <h2>Aylık İlerleme Grafiği</h2>
    <canvas id="progressChart"></canvas>
</div>

<!-- Rozetler -->
<div class="card">
    <h2>Kazandığım Rozetler</h2>
    <?php if (count($user_badges) > 0): ?>
        <div class="badges-grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
            <?php foreach ($user_badges as $badge): ?>
                <div class="badge-card" title="<?php echo htmlspecialchars($badge['description']); ?>" style="text-align: center; padding: 1rem; border: 1px solid var(--border-color); border-radius: var(--border-radius);">
                    <div class="icon" style="font-size: 3rem; color: var(--warning-color);"><i class="fas <?php echo htmlspecialchars($badge['icon']); ?>"></i></div>
                    <h4><?php echo htmlspecialchars($badge['name']); ?></h4>
                    <p style="font-size: 0.9rem; color: var(--secondary-color);"><?php echo htmlspecialchars($badge['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Henüz hiç rozet kazanmadın. İbadetlerine devam et!</div>
    <?php endif; ?>
</div>

<script>
const ctx = document.getElementById('progressChart').getContext('2d');
const progressChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($chart_data['labels']); ?>,
        datasets: [{
            label: 'Okunan Cüz Sayısı',
            data: <?php echo json_encode($chart_data['cuz_data']); ?>,
            backgroundColor: 'rgba(42, 111, 219, 0.5)',
            borderColor: 'rgba(42, 111, 219, 1)',
            borderWidth: 1,
            yAxisID: 'y-axis-cuz'
        }, {
            label: 'Çekilen Zikir Sayısı',
            data: <?php echo json_encode($chart_data['zikir_data']); ?>,
            backgroundColor: 'rgba(25, 135, 84, 0.5)',
            borderColor: 'rgba(25, 135, 84, 1)',
            borderWidth: 1,
            yAxisID: 'y-axis-zikir'
        }]
    },
    options: {
        scales: {
            'y-axis-cuz': {
                type: 'linear',
                position: 'left',
                beginAtZero: true,
                title: { display: true, text: 'Cüz Sayısı' }
            },
            'y-axis-zikir': {
                type: 'linear',
                position: 'right',
                beginAtZero: true,
                title: { display: true, text: 'Zikir Sayısı' },
                grid: { drawOnChartArea: false }
            }
        }
    }
});
</script>

<?php require_once 'templates/footer.php'; ?>
