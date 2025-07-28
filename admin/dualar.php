<?php
$page_title = "Dua Yönetimi";
require_once 'admin_template_header.php';

// --- FORM İŞLEMLERİ ---

// 1. Dua Onay/Reddetme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dua_onayla'])) {
    $dua_id = $_POST['dua_id'];
    $action = $_POST['action'];
    
    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE dualar SET status = 'approved' WHERE id = :id");
        $stmt->execute(['id' => $dua_id]);
        $message = "Dua talebi onaylandı.";
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("DELETE FROM dualar WHERE id = :id");
        $stmt->execute(['id' => $dua_id]);
        $message = "Dua talebi reddedildi ve silindi.";
    }
}

// 2. Yayınlanmış Dua Durumunu Değiştirme (Aktif/Pasif)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dua_durum_degistir'])) {
    $dua_id = $_POST['dua_id'];
    $current_status = $_POST['current_status'];
    // 'approved' ise 'inactive' yap, 'inactive' ise 'approved' yap
    $new_status = ($current_status === 'approved') ? 'inactive' : 'approved';
    
    $stmt = $conn->prepare("UPDATE dualar SET status = :new_status WHERE id = :id");
    $stmt->execute(['new_status' => $new_status, 'id' => $dua_id]);
    $message = "Yayınlanmış dua durumu güncellendi.";
}


// --- VERİ ÇEKME İŞLEMLERİ ---

// 1. Onay bekleyen duaları çek
$stmt_pending = $conn->query("SELECT d.id, d.niyet, d.isim_gizli, u.username as olusturan, d.created_at FROM dualar d JOIN users u ON d.user_id = u.id WHERE d.status = 'pending' ORDER BY d.created_at ASC");
$bekleyen_dualar = $stmt_pending->fetchAll();

// 2. Onaylanmış veya Pasif duaları çek
$stmt_published = $conn->query("SELECT d.id, d.niyet, d.status, u.username as olusturan FROM dualar d JOIN users u ON d.user_id = u.id WHERE d.status IN ('approved', 'inactive') ORDER BY d.created_at DESC");
$yayinlanmis_dualar = $stmt_published->fetchAll();
?>

<?php if (isset($message)): ?>
    <div class="alert alert-success" style="background-color: #d1e7dd; color: #0f5132; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;"><?php echo $message; ?></div>
<?php endif; ?>

<!-- BÖLÜM 1: ONAY BEKLEYEN DUALAR -->
<div class="card" style="margin-bottom: 2rem;">
    <h2><i class="fas fa-envelope-open-text" style="margin-right: 10px; color: #f1c40f;"></i>Onay Bekleyen Dua Talepleri</h2>
    <?php if (count($bekleyen_dualar) > 0): ?>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Dua / Niyet</th>
                    <th>Talep Eden</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bekleyen_dualar as $dua): ?>
                    <tr>
                        <td style="max-width: 400px;"><?php echo nl2br(htmlspecialchars($dua['niyet'])); ?></td>
                        <td><?php echo $dua['isim_gizli'] ? '<em>İsim Gizli</em>' : htmlspecialchars($dua['olusturan']); ?></td>
                        <td>
                            <form action="dualar.php" method="POST" style="display: inline-block; margin-right: 5px;">
                                <input type="hidden" name="dua_id" value="<?php echo $dua['id']; ?>">
                                <button type="submit" name="action" value="approve" class="btn-sm" style="border:none; cursor:pointer; background-color: #198754; color:white;">Onayla</button>
                                <input type="hidden" name="dua_onayla" value="1">
                            </form>
                            <form action="dualar.php" method="POST" style="display: inline-block;">
                                <input type="hidden" name="dua_id" value="<?php echo $dua['id']; ?>">
                                <button type="submit" name="action" value="reject" class="btn-sm" style="border:none; cursor:pointer; background-color: #dc3545; color:white;" onclick="return confirm('Bu dua talebini reddetmek istediğinizden emin misiniz?');">Reddet</button>
                                <input type="hidden" name="dua_onayla" value="1">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Onay bekleyen dua talebi bulunmuyor.</p>
    <?php endif; ?>
</div>

<!-- BÖLÜM 2: YAYINLANMIŞ DUALAR -->
<div class="card">
    <h2><i class="fas fa-check-circle" style="margin-right: 10px; color: #2ecc71;"></i>Yayınlanmış Dualar</h2>
    <?php if (count($yayinlanmis_dualar) > 0): ?>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Dua / Niyet</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($yayinlanmis_dualar as $dua): ?>
                    <tr>
                        <td style="max-width: 400px;"><?php echo nl2br(htmlspecialchars($dua['niyet'])); ?></td>
                        <td>
                            <?php if ($dua['status'] === 'approved'): ?>
                                <span style="color: #198754; font-weight:bold;">Aktif</span>
                            <?php else: ?>
                                <span style="color: #dc3545; font-weight:bold;">Pasif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="dualar.php" method="POST" style="margin: 0;">
                                <input type="hidden" name="dua_id" value="<?php echo $dua['id']; ?>">
                                <input type="hidden" name="current_status" value="<?php echo $dua['status']; ?>">
                                <button type="submit" name="dua_durum_degistir" class="btn-sm" style="border:none; cursor:pointer; color:white; background-color: <?php echo ($dua['status'] === 'approved') ? '#dc3545' : '#198754'; ?>">
                                    <?php echo ($dua['status'] === 'approved') ? 'Pasif Yap' : 'Aktif Yap'; ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Henüz yayınlanmış bir dua bulunmuyor.</p>
    <?php endif; ?>
</div>

<?php require_once 'admin_template_footer.php'; ?>
