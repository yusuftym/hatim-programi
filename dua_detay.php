<?php
$page_title = "Dua Detayı";
require_once 'templates/header.php';

$dua_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Dua katılım işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dua_et'])) {
    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        // Kullanıcının daha önce katılıp katılmadığını kontrol et
        $stmt_check = $conn->prepare("SELECT id FROM dua_katilimlari WHERE dua_id = :dua_id AND user_id = :user_id");
        $stmt_check->execute(['dua_id' => $dua_id, 'user_id' => $user_id]);
        if (!$stmt_check->fetch()) {
            $stmt_insert = $conn->prepare("INSERT INTO dua_katilimlari (dua_id, user_id) VALUES (:dua_id, :user_id)");
            $stmt_insert->execute(['dua_id' => $dua_id, 'user_id' => $user_id]);
        }
    }
    header("Location: dua_detay.php?id=" . $dua_id); // Sayfayı yenile
    exit();
}

// Dua ve katılımcı bilgilerini çek
$stmt_dua = $conn->prepare("SELECT d.niyet, d.isim_gizli, u.username FROM dualar d JOIN users u ON d.user_id = u.id WHERE d.id = :id AND d.status = 'approved'");
$stmt_dua->execute(['id' => $dua_id]);
$dua = $stmt_dua->fetch();

if (!$dua) {
    echo "<div class='alert alert-danger'>Dua bulunamadı.</div>";
    require_once 'templates/footer.php';
    exit();
}

$stmt_katilimcilar = $conn->prepare("SELECT u.username FROM dua_katilimlari dk JOIN users u ON dk.user_id = u.id WHERE dk.dua_id = :dua_id ORDER BY dk.katilim_tarihi ASC");
$stmt_katilimcilar->execute(['dua_id' => $dua_id]);
$katilimcilar = $stmt_katilimcilar->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="card">
    <h1>Dua Detayı</h1>
    <p style="font-size: 1.2rem; font-style: italic; border-left: 4px solid var(--secondary-color); padding-left: 15px;">
        <?php echo nl2br(htmlspecialchars($dua['niyet'])); ?>
    </p>
    <p><strong>Dua Eden:</strong> <?php echo $dua['isim_gizli'] ? 'Gizli Kullanıcı' : htmlspecialchars($dua['username']); ?></p>
    
    <?php if (isLoggedIn()): ?>
    <form action="dua_detay.php?id=<?php echo $dua_id; ?>" method="POST" style="margin: 2rem 0;">
        <button type="submit" name="dua_et" class="btn btn-success">
            <i class="fas fa-check" style="margin-right: 10px;"></i> Ben de Dua Ettim
        </button>
    </form>
    <?php endif; ?>

    <hr style="margin: 2rem 0;">

    <h2>Bu Duaya Katılanlar (<?php echo count($katilimcilar); ?> kişi)</h2>
    <?php if (count($katilimcilar) > 0): ?>
        <ul style="list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 10px;">
            <?php foreach ($katilimcilar as $katilimci): ?>
                <li style="background-color: var(--bg-color); padding: 5px 15px; border-radius: 20px;">
                    <i class="fas fa-user-check" style="color: var(--success-color); margin-right: 5px;"></i>
                    <?php echo htmlspecialchars($katilimci); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Bu duaya henüz kimse katılmadı. İlk katılan siz olun!</p>
    <?php endif; ?>
</div>

<?php require_once 'templates/footer.php'; ?>
