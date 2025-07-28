<?php
$page_title = "Aktif Hatimler";
require_once 'templates/header.php';

$stmt = $conn->query("
    SELECT h.id, h.baslik, h.aciklama, u.username as olusturan,
    (SELECT COUNT(*) FROM cuzler WHERE hatim_id = h.id AND okundu_mu = 1) as tamamlanan_cuz
    FROM hatimler h
    JOIN users u ON h.olusturan_id = u.id
    WHERE h.tamamlandi_mi = 0 AND h.status = 'approved'
    ORDER BY h.olusturma_tarihi DESC
");
$aktif_hatimler = $stmt->fetchAll();
?>

<h1 style="text-align: center; margin-bottom: 1rem;">Devam Eden Hatimler</h1>
<p style="text-align: center; max-width: 700px; margin: 0 auto 3rem auto;">Aşağıdaki hatimlerden birine katılarak cüz alabilir veya yeni bir hatim teklifinde bulunabilirsiniz.</p>

<?php if (isLoggedIn()): ?>
<div style="text-align: center; margin-bottom: 3rem;">
    <a href="yeni_hatim.php" class="btn btn-primary">Yeni Hatim Teklif Et</a>
</div>
<?php endif; ?>

<?php if (count($aktif_hatimler) > 0): ?>
    <div class="grid-container">
        <?php foreach ($aktif_hatimler as $hatim): ?>
            <div class="card">
                <div class="card-body">
                    <div class="card-icon"><i class="fas fa-book-open"></i></div>
                    <h3><?php echo htmlspecialchars($hatim['baslik']); ?></h3>
                    <p><strong>Niyet:</strong> <?php echo mb_strimwidth(htmlspecialchars($hatim['aciklama']), 0, 120, "..."); ?></p>
                    <small><strong>Başlatan:</strong> <?php echo htmlspecialchars($hatim['olusturan']); ?></small>
                    
                    <?php $percent = ($hatim['tamamlanan_cuz'] > 0) ? ($hatim['tamamlanan_cuz'] / 30) * 100 : 0; ?>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?php echo $percent; ?>%;"></div>
                    </div>
                    <p style="font-weight: 600;"><?php echo $hatim['tamamlanan_cuz']; ?>/30 Cüz Tamamlandı</p>
                </div>
                <a href="hatim.php?id=<?php echo $hatim['id']; ?>" class="btn btn-secondary" style="margin-top: 1.5rem; width:100%;">Detayları Gör ve Katıl</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="card" style="text-align: center;">
        <p>Şu anda aktif bir hatim bulunmuyor. İlk hatmi teklif etmek ister misiniz?</p>
    </div>
<?php endif; ?>

<?php require_once 'templates/footer.php'; ?>
