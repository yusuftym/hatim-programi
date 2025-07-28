<?php
$page_title = "İbadet Yönetimi";
require_once 'admin_template_header.php';

// Form işlemleri... (PHP kodlarının üst kısmı aynı kalıyor)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ibadet_ekle'])) {
        $ad = trim($_POST['ad']);
        $aciklama = trim($_POST['aciklama']);
        $hedef_sayi = (int)$_POST['hedef_sayi'];
        $olusturan_id = $_SESSION['user_id'];
        if (!empty($ad) && $hedef_sayi > 0) {
            $stmt = $conn->prepare("INSERT INTO ibadetler (ad, aciklama, hedef_sayi, olusturan_id) VALUES (:ad, :aciklama, :hedef_sayi, :olusturan_id)");
            $stmt->execute(['ad' => $ad, 'aciklama' => $aciklama, 'hedef_sayi' => $hedef_sayi, 'olusturan_id' => $olusturan_id]);
            $message = "Yeni ibadet hedefi eklendi.";
        } else {
            $error = "İbadet adı ve hedef sayısı (0'dan büyük) zorunludur.";
        }
    }
    elseif (isset($_POST['toggle_status'])) {
        $ibadet_id = $_POST['ibadet_id'];
        $current_status = $_POST['current_status'];
        $new_status = $current_status == 1 ? 0 : 1;
        $stmt = $conn->prepare("UPDATE ibadetler SET aktif_mi = :new_status WHERE id = :id");
        $stmt->execute(['new_status' => $new_status, 'id' => $ibadet_id]);
        $message = "İbadet durumu güncellendi.";
    }
}

$ibadetler = $conn->query("SELECT * FROM ibadetler ORDER BY olusturma_tarihi DESC")->fetchAll();
?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger" style="background-color: #f8d7da; color: #842029; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;"><?php echo $error; ?></div>
<?php endif; ?>
<?php if (isset($message)): ?>
    <div class="alert alert-success" style="background-color: #d1e7dd; color: #0f5132; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;"><?php echo $message; ?></div>
<?php endif; ?>

<div class="card" style="margin-bottom: 2rem;">
    <h2><i class="fas fa-plus-circle" style="margin-right: 10px; color: var(--primary-color);"></i>Yeni İbadet Hedefi Ekle</h2>
    <form action="ibadetler.php" method="POST">
        <div style="margin-bottom: 1rem;">
            <label for="ad" style="display: block; margin-bottom: 5px; font-weight: 600;">İbadetin Adı</label>
            <input type="text" name="ad" id="ad" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="aciklama" style="display: block; margin-bottom: 5px; font-weight: 600;">Açıklama</label>
            <textarea name="aciklama" id="aciklama" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;"></textarea>
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label for="hedef_sayi" style="display: block; margin-bottom: 5px; font-weight: 600;">Hedeflenen Sayı</label>
            <input type="number" name="hedef_sayi" id="hedef_sayi" required min="1" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
        </div>
        <button type="submit" name="ibadet_ekle" style="background-color: var(--primary-color); color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem;">İbadeti Ekle</button>
    </form>
</div>

<div class="card">
    <h2><i class="fas fa-list-ul" style="margin-right: 10px; color: var(--primary-color);"></i>Mevcut İbadet Hedefleri</h2>
    <table class="content-table">
        <thead>
            <tr>
                <th>Ad</th>
                <th>Hedef</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ibadetler as $ibadet): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ibadet['ad']); ?></td>
                    <td><?php echo number_format($ibadet['hedef_sayi']); ?></td>
                    <td>
                        <?php if ($ibadet['aktif_mi']): ?>
                            <span style="color: #198754; font-weight:bold;">Aktif</span>
                        <?php else: ?>
                            <span style="color: #dc3545; font-weight:bold;">Pasif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form action="ibadetler.php" method="POST" style="margin: 0;">
                            <input type="hidden" name="ibadet_id" value="<?php echo $ibadet['id']; ?>">
                            <input type="hidden" name="current_status" value="<?php echo $ibadet['aktif_mi']; ?>">
                            <button type="submit" name="toggle_status" class="btn-sm" style="border:none; cursor:pointer; color:white; background-color: <?php echo $ibadet['aktif_mi'] ? '#dc3545' : '#198754'; ?>">
                                <?php echo $ibadet['aktif_mi'] ? 'Pasif Yap' : 'Aktif Yap'; ?>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'admin_template_footer.php'; ?>
