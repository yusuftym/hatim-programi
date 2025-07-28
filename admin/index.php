<?php
$page_title = "Gösterge Paneli";
require_once 'admin_template_header.php';

// İstatistikleri çek
$total_users = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$pending_hatims = $conn->query("SELECT COUNT(*) FROM hatimler WHERE status = 'pending'")->fetchColumn();
$active_ibadets = $conn->query("SELECT COUNT(*) FROM ibadetler WHERE aktif_mi = 1")->fetchColumn();
$total_cuz_read = $conn->query("SELECT COUNT(*) FROM cuzler WHERE okundu_mu = 1")->fetchColumn();
?>

<div class="dashboard-grid">
    <div class="stat-card">
        <div class="icon" style="color: #3498db;"><i class="fas fa-users"></i></div>
        <div class="info">
            <h3><?php echo $total_users; ?></h3>
            <p>Toplam Kullanıcı</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon" style="color: #f1c40f;"><i class="fas fa-hourglass-half"></i></div>
        <div class="info">
            <h3><?php echo $pending_hatims; ?></h3>
            <p>Onay Bekleyen Hatim</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon" style="color: #2ecc71;"><i class="fas fa-praying-hands"></i></div>
        <div class="info">
            <h3><?php echo $active_ibadets; ?></h3>
            <p>Aktif İbadet Hedefi</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon" style="color: #9b59b6;"><i class="fas fa-book-reader"></i></div>
        <div class="info">
            <h3><?php echo $total_cuz_read; ?></h3>
            <p>Okunmuş Toplam Cüz</p>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <h2>Hızlı Erişim</h2>
    <p>Yönetim paneline hoş geldiniz. Soldaki menüyü kullanarak site içeriğini yönetebilirsiniz.</p>
    <ul>
        <li><strong>Hatim Yönetimi:</strong> Kullanıcılar tarafından gönderilen yeni hatim tekliflerini onaylayın veya reddedin.</li>
        <li><strong>İbadet Yönetimi:</strong> Topluluk için yeni zikir ve ibadet hedefleri oluşturun, mevcutları düzenleyin.</li>
        <li><strong>Kullanıcı Yönetimi:</strong> Kayıtlı kullanıcıları listeleyin ve rollerini (admin, moderatör, kullanıcı) güncelleyin.</li>
    </ul>
</div>

<?php require_once 'admin_template_footer.php'; ?>
