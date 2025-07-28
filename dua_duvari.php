<?php
$page_title = "Dua Duvarı";
require_once 'templates/header.php';

// Dua gönderme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dua_gonder'])) {
    if (isLoggedIn()) {
        $niyet = trim($_POST['niyet']);
        $isim_gizli = isset($_POST['isim_gizli']) ? 1 : 0;
        $user_id = $_SESSION['user_id'];
        if (!empty($niyet)) {
            $stmt = $conn->prepare("INSERT INTO dualar (user_id, niyet, isim_gizli) VALUES (:user_id, :niyet, :isim_gizli)");
            $stmt->execute(['user_id' => $user_id, 'niyet' => $niyet, 'isim_gizli' => $isim_gizli]);
            $message = "Dua talebiniz yönetici onayına gönderilmiştir. Allah kabul etsin.";
        }
    } else {
        $error = "Dua göndermek için giriş yapmalısınız.";
    }
}

// Onaylanmış duaları çek
$stmt = $conn->query("
    SELECT d.id, d.niyet, d.isim_gizli, u.username,
    (SELECT COUNT(*) FROM dua_katilimlari WHERE dua_id = d.id) as katilimci_sayisi
    FROM dualar d
    JOIN users u ON d.user_id = u.id
    WHERE d.status = 'approved'
    ORDER BY d.created_at DESC
");
$dualar = $stmt->fetchAll();
?>

<h1 style="text-align: center; margin-bottom: 1rem;">Dua Duvarı</h1>
<p style="text-align: center; max-width: 700px; margin: 0 auto 3rem auto;">Birbirimize dua ederek manevi bağlarımızı güçlendirelim. Aşağıdaki dualara katılarak veya yeni bir dua talebinde bulunarak bu hayra ortak olabilirsiniz.</p>

<?php if (isLoggedIn()): ?>
<div class="card" style="margin-bottom: 3rem;">
    <h2>Yeni Dua Talebi Gönder</h2>
    <?php if (isset($message)): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
    <form action="dua_duvari.php" method="POST">
        <div class="form-group">
            <label for="niyet">Duanız / Niyetiniz</label>
            <textarea name="niyet" id="niyet" rows="4" required class="form-control"></textarea>
        </div>
        <div class="form-group">
            <input type="checkbox" name="isim_gizli" id="isim_gizli" value="1">
            <label for="isim_gizli">İsmim gizli kalsın.</label>
        </div>
        <button type="submit" name="dua_gonder" class="btn btn-primary">Dua İste</button>
    </form>
</div>
<?php endif; ?>

<div class="grid-container">
    <?php foreach ($dualar as $dua): ?>
        <a href="dua_detay.php?id=<?php echo $dua['id']; ?>" style="text-decoration:none;">
            <div class="card dua-card">
                <p class="dua-niyet"><?php echo nl2br(htmlspecialchars($dua['niyet'])); ?></p>
                <div class="dua-meta">
                    <span>
                        <i class="fas fa-user" style="margin-right: 5px;"></i>
                        <?php echo $dua['isim_gizli'] ? 'Gizli Kullanıcı' : htmlspecialchars($dua['username']); ?>
                    </span>
                    <span class="katilimci-sayisi">
                        <i class="fas fa-hands-praying" style="margin-right: 5px;"></i>
                        <?php echo $dua['katilimci_sayisi']; ?> kişi dua etti
                    </span>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<?php require_once 'templates/footer.php'; ?>
