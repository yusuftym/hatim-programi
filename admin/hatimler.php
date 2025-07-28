<?php
$page_title = "Hatim Yönetimi";
require_once 'admin_template_header.php';

// --- FORM İŞLEMLERİ ---

// 1. Hatim Onay/Reddetme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hatim_onayla'])) {
    $hatim_id = $_POST['hatim_id'];
    $action = $_POST['action'];
    
    if ($action === 'approve' || $action === 'reject') {
        $new_status = ($action === 'approve') ? 'approved' : 'rejected';
        $stmt = $conn->prepare("UPDATE hatimler SET status = :status WHERE id = :id");
        $stmt->execute(['status' => $new_status, 'id' => $hatim_id]);
        $message = "Hatim teklif durumu güncellendi.";
    }
}

// 2. Yayınlanmış Hatim Durumunu Değiştirme (Aktif/Tamamlandı)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hatim_durum_degistir'])) {
    $hatim_id = $_POST['hatim_id'];
    $current_status = $_POST['current_status'];
    $new_status = $current_status == 1 ? 0 : 1; // 1 ise 0 yap, 0 ise 1 yap
    
    $stmt = $conn->prepare("UPDATE hatimler SET tamamlandi_mi = :new_status WHERE id = :id");
    $stmt->execute(['new_status' => $new_status, 'id' => $hatim_id]);
    $message = "Yayınlanmış hatim durumu güncellendi.";
}


// --- VERİ ÇEKME İŞLEMLERİ ---

// 1. Onay bekleyen hatimleri çek
$stmt_pending = $conn->query("
    SELECT h.id, h.baslik, h.aciklama, u.username as olusturan, h.olusturma_tarihi
    FROM hatimler h
    JOIN users u ON h.olusturan_id = u.id
    WHERE h.status = 'pending'
    ORDER BY h.olusturma_tarihi ASC
");
$bekleyen_hatimler = $stmt_pending->fetchAll();

// 2. Onaylanmış (yayınlanmış) hatimleri çek
$stmt_approved = $conn->query("
    SELECT h.id, h.baslik, h.tamamlandi_mi, u.username as olusturan,
    (SELECT COUNT(*) FROM cuzler WHERE hatim_id = h.id AND okundu_mu = 1) as tamamlanan_cuz
    FROM hatimler h
    JOIN users u ON h.olusturan_id = u.id
    WHERE h.status = 'approved'
    ORDER BY h.olusturma_tarihi DESC
");
$onaylanmis_hatimler = $stmt_approved->fetchAll();
?>

<?php if (isset($message)): ?>
    <div class="alert alert-success" style="background-color: #d1e7dd; color: #0f5132; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;"><?php echo $message; ?></div>
<?php endif; ?>


<!-- BÖLÜM 1: ONAY BEKLEYEN HATİMLER -->
<div class="card" style="margin-bottom: 2rem;">
    <h2><i class="fas fa-hourglass-half" style="margin-right: 10px; color: #f1c40f;"></i>Onay Bekleyen Hatimler</h2>
    <?php if (count($bekleyen_hatimler) > 0): ?>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Teklif Eden</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bekleyen_hatimler as $hatim): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($hatim['baslik']); ?></td>
                        <td><?php echo htmlspecialchars($hatim['olusturan']); ?></td>
                        <td>
                            <!-- DÜZENLE BUTONU EKLENDİ -->
                            <a href="hatim_duzenle.php?id=<?php echo $hatim['id']; ?>" class="btn-sm" style="background-color: #f39c12; color:white; text-decoration:none; margin-right: 5px;">Düzenle</a>
                            
                            <form action="hatimler.php" method="POST" style="display: inline-block; margin-right: 5px;">
                                <input type="hidden" name="hatim_id" value="<?php echo $hatim['id']; ?>">
                                <button type="submit" name="action" value="approve" class="btn-sm" style="border:none; cursor:pointer; background-color: #198754; color:white;">Onayla</button>
                                <input type="hidden" name="hatim_onayla" value="1">
                            </form>
                            <form action="hatimler.php" method="POST" style="display: inline-block;">
                                <input type="hidden" name="hatim_id" value="<?php echo $hatim['id']; ?>">
                                <button type="submit" name="action" value="reject" class="btn-sm" style="border:none; cursor:pointer; background-color: #dc3545; color:white;">Reddet</button>
                                <input type="hidden" name="hatim_onayla" value="1">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Onay bekleyen hatim bulunmuyor.</p>
    <?php endif; ?>
</div>

<!-- BÖLÜM 2: YAYINLANMIŞ HATİMLER -->
<div class="card">
    <h2><i class="fas fa-check-circle" style="margin-right: 10px; color: #2ecc71;"></i>Yayınlanmış Hatimler</h2>
    <?php if (count($onaylanmis_hatimler) > 0): ?>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>İlerleme</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($onaylanmis_hatimler as $hatim): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($hatim['baslik']); ?></td>
                        <td><?php echo $hatim['tamamlanan_cuz']; ?> / 30</td>
                        <td>
                            <?php if ($hatim['tamamlandi_mi']): ?>
                                <span style="color: #198754; font-weight:bold;">Tamamlandı</span>
                            <?php else: ?>
                                <span style="color: #0d6efd; font-weight:bold;">Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- DÜZENLE BUTONU EKLENDİ -->
                            <a href="hatim_duzenle.php?id=<?php echo $hatim['id']; ?>" class="btn-sm" style="background-color: #f39c12; color:white; text-decoration:none; margin-right: 5px;">Düzenle</a>

                            <form action="hatimler.php" method="POST" style="display: inline-block;">
                                <input type="hidden" name="hatim_id" value="<?php echo $hatim['id']; ?>">
                                <input type="hidden" name="current_status" value="<?php echo $hatim['tamamlandi_mi']; ?>">
                                <button type="submit" name="hatim_durum_degistir" class="btn-sm" style="border:none; cursor:pointer; color:white; background-color: <?php echo $hatim['tamamlandi_mi'] ? '#0d6efd' : '#198754'; ?>">
                                    <?php echo $hatim['tamamlandi_mi'] ? 'Aktif Yap' : 'Tamamlandı Yap'; ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Henüz yayınlanmış bir hatim bulunmuyor.</p>
    <?php endif; ?>
</div>

<?php require_once 'admin_template_footer.php'; ?>
