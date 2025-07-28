<?php
$page_title = "Yeni Hatim Teklif Et";
require_once 'templates/header.php';

if (!isLoggedIn()) {
    echo "<div class='alert alert-danger'>Hatim teklif etmek için lütfen <a href='login.php'>giriş yapın</a>.</div>";
    require_once 'templates/footer.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $baslik = trim($_POST['baslik']);
    $aciklama = trim($_POST['aciklama']);
    $olusturan_id = $_SESSION['user_id'];

    if (empty($baslik)) {
        $error = "Hatim başlığı boş bırakılamaz.";
    } else {
        $conn->beginTransaction();
        try {
            $stmt = $conn->prepare("INSERT INTO hatimler (baslik, aciklama, olusturan_id, status) VALUES (:baslik, :aciklama, :olusturan_id, 'pending')");
            $stmt->execute(['baslik' => $baslik, 'aciklama' => $aciklama, 'olusturan_id' => $olusturan_id]);
            $hatim_id = $conn->lastInsertId();

            $cuz_stmt = $conn->prepare("INSERT INTO cuzler (hatim_id, cuz_no) VALUES (:hatim_id, :cuz_no)");
            for ($i = 1; $i <= 30; $i++) {
                $cuz_stmt->execute(['hatim_id' => $hatim_id, 'cuz_no' => $i]);
            }
            $conn->commit();
            $message = "Hatim teklifiniz başarıyla alınmıştır. Yönetici onayı sonrası yayınlanacaktır.";
        } catch (Exception $e) {
            $conn->rollBack();
            $error = "Bir hata oluştu: " . $e->getMessage();
        }
    }
}
?>

<div class="card form-container">
    <h1 style="text-align: center;">Yeni Hatim Teklif Et</h1>
    <p style="text-align: center;">Başlatmak istediğiniz hatmin başlığını ve niyetini/açıklamasını girin. Teklifiniz yöneticiler tarafından incelendikten sonra onaylanacaktır.</p>
    
    <?php if (isset($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if (isset($message)): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>

    <form action="yeni_hatim.php" method="POST">
        <div class="form-group">
            <label for="baslik">Hatim Başlığı</label>
            <input type="text" name="baslik" id="baslik" required>
        </div>
        <div class="form-group">
            <label for="aciklama">Açıklama / Niyet</label>
            <textarea name="aciklama" id="aciklama" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">Teklifi Gönder</button>
    </form>
</div>

<?php require_once 'templates/footer.php'; ?>
