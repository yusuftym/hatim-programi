<?php
$page_title = "Toplu İbadetler ve Zikirler";
require_once 'templates/header.php';
// ... (Sayfanın başındaki PHP kodları aynı kalabilir) ...
$stmt = $conn->query("SELECT i.id, i.ad, i.aciklama, i.hedef_sayi, (SELECT SUM(okunan_sayi) FROM ibadet_kayitlari WHERE ibadet_id = i.id) as toplam_okunan FROM ibadetler i WHERE i.aktif_mi = 1");
$ibadetler = $stmt->fetchAll();
?>

<h1 style="text-align: center; margin-bottom: 1rem;">Toplu İbadetler</h1>
<p style="text-align: center; max-width: 700px; margin: 0 auto 3rem auto;">Topluluk olarak hedeflere ulaşmak için zikirlere katılın. Okuduğunuz miktarı ekleyerek ortak hedefe katkıda bulunabilirsiniz.</p>

<div class="grid-container">
    <?php if (count($ibadetler) > 0): ?>
        <?php foreach ($ibadetler as $ibadet): ?>
            <?php
                $toplam_okunan = $ibadet['toplam_okunan'] ?? 0;
                $hedef = $ibadet['hedef_sayi'];
                $percent = ($hedef > 0) ? ($toplam_okunan / $hedef) * 100 : 0;
            ?>
            <div class="card">
                <div class="card-body">
                    <div class="card-icon"><i class="fas fa-star"></i></div>
                    <h3><?php echo htmlspecialchars($ibadet['ad']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($ibadet['aciklama'])); ?></p>
                    
                    <div class="progress-bar">
                        <div class="progress" style="width: <?php echo min(100, $percent); ?>%;"></div>
                    </div>
                    <p>
                        <strong>Hedef:</strong> <?php echo number_format($hedef); ?>  

                        <strong>Okunan:</strong> <?php echo number_format($toplam_okunan); ?>
                    </p>
                </div>

                <?php if (isLoggedIn()): ?>
                <form action="gunluk_ibadetler.php" method="POST" style="margin-top:15px;">
                    <input type="hidden" name="ibadet_id" value="<?php echo $ibadet['id']; ?>">
                    <input type="number" name="okunan_sayi" placeholder="Okuduğunuz sayı" required class="form-group" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px; margin-bottom:10px;">
                    <button type="submit" name="update_zikir" class="btn btn-success" style="width:100%;">Katkıda Bulun</button>
                </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card" style="grid-column: 1 / -1; text-align:center;">
            <p>Henüz eklenmiş bir ibadet hedefi bulunmuyor.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'templates/footer.php'; ?>
