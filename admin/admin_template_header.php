<?php
// Bu header, config/db.php'yi ana dizinden çağırır.
require_once __DIR__ . '/../config/db.php';

// Yetki kontrolü
if (!hasRole(['admin', 'moderator'])) {
    // Eğer yetkisi yoksa, ana sayfaya yönlendir.
    header("Location: ../index.php");
    exit();
}

// Aktif sayfayı belirlemek için dosya adını al
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Yönetim Paneli'; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<aside class="sidebar">
    <div class="logo">Hatim.in</div>
    <ul>
        <li>
            <a href="index.php" class="<?php echo ($current_page == 'index.php' ) ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt icon"></i> Gösterge Paneli
            </a>
        </li>
        <li>
            <a href="hatimler.php" class="<?php echo ($current_page == 'hatimler.php') ? 'active' : ''; ?>">
                <i class="fas fa-hand-point-up icon"></i> Hatim Yönetimi
            </a>
        </li>
        <!-- YENİ EKLENEN LİNK -->
        <li>
            <a href="dualar.php" class="<?php echo ($current_page == 'dualar.php') ? 'active' : ''; ?>">
                <i class="fas fa-hand-holding-heart icon"></i> Dua Yönetimi
            </a>
        </li>
        <li>
            <a href="ibadetler.php" class="<?php echo ($current_page == 'ibadetler.php') ? 'active' : ''; ?>">
                <i class="fas fa-praying-hands icon"></i> İbadet Yönetimi
            </a>
        </li>
        <li>
            <a href="kullanicilar.php" class="<?php echo ($current_page == 'kullanicilar.php') ? 'active' : ''; ?>">
                <i class="fas fa-users icon"></i> Kullanıcı Yönetimi
            </a>
        </li>
        <hr style="border-color: #444;">
        <li>
            <a href="../index.php">
                <i class="fas fa-globe icon"></i> Siteyi Görüntüle
            </a>
        </li>
        <li>
            <a href="../logout.php">
                <i class="fas fa-sign-out-alt icon"></i> Çıkış Yap
            </a>
        </li>
    </ul>
</aside>

<div class="main-content">
    <header class="header">
        <h1><?php echo $page_title ?? 'Yönetim Paneli'; ?></h1>
        <span>Hoş geldiniz, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
    </header>
