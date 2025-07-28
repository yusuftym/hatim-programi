<?php
$page_title = "Hatim Düzenle";
require_once 'admin_template_header.php';

$hatim_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Düzenleme formunu gönderme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hatim_guncelle'])) {
    $baslik = trim($_POST['baslik']);
    $aciklama = trim($_POST['aciklama']);
    
    if (!empty($baslik)) {
        $stmt = $conn->prepare("UPDATE hatimler SET baslik = :baslik, aciklama = :aciklama WHERE id = :id");
        $stmt->execute(['baslik' => $baslik, 'aciklama' => $aciklama, 'id' => $hatim_id]);
        // Başarılı güncelleme sonrası hatimler listesine yönlendir
        header("Location: hatimler.php?message=updated");
        exit();
    } else {
        $error = "Başlık alanı boş bırakılamaz.";
    }
}

// Düzenlenecek hatim bilgilerini çek
$stmt = $conn->prepare("SELECT * FROM hatimler WHERE id = :id");
$stmt->execute(['id' => $hatim_id]);
$hatim = $stmt->fetch();

if (!$hatim) {
    echo "<div class='alert alert-danger'>Hatim bulunamadı.</div>";
    require_once 'admin_template_footer.php';
    exit();
}
?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger" style="background-color: #f8d7da; color: #842029; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;"><?php echo $error; ?></div>
<?php endif; ?>

<div class="card">
    <h2>"<?php echo htmlspecialchars($hatim['baslik']); ?>" Hatmini Düzenle</h2>
    <form action="hatim_duzenle.php?id=<?php echo $hatim_id; ?>" method="POST">
        <div style="margin-bottom: 1rem;">
            <label for="baslik" style="display: block; margin-bottom: 5px; font-weight: 600;">Hatim Başlığı</label>
            <input type="text" name="baslik" id="baslik" value="<?php echo htmlspecialchars($hatim['baslik']); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label for="aciklama" style="display: block; margin-bottom: 5px; font-weight: 600;">Açıklama / Niyet</label>
            <textarea name="aciklama" id="aciklama" rows="5" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;"><?php echo htmlspecialchars($hatim['aciklama']); ?></textarea>
        </div>
        <button type="submit" name="hatim_guncelle" style="background-color: var(--primary-color); color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem;">Değişiklikleri Kaydet</button>
        <a href="hatimler.php" style="margin-left: 10px; text-decoration: none; color: var(--dark-gray);">İptal</a>
    </form>
</div>

<?php require_once 'admin_template_footer.php'; ?>
