<?php require_once __DIR__ . '/../config/db.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Hatim & İbadet Platformu'; ?></title>
    <link rel="stylesheet" href="public/css/style.css">
    <!-- FontAwesome (Rozet ikonları için) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts (Arapça metinler için ) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <a href="index.php" class="logo">Hatim</a>
    <div class="nav-links">
        <a href="index.php">Ana Sayfa</a>
        <a href="hatim.php">Hatim</a>        
        <a href="gunluk_ibadetler.php">İbadetler</a>
        <a href="kuran.php">Kur'an Oku</a>
        <a href="dua_duvari.php">Dua</a>
        <?php if (isLoggedIn( )): ?>
            <a href="profile.php">Profilim</a>
            <?php if (hasRole(['admin', 'moderator'])): ?>
                <a href="admin/index.php" style="color: var(--warning-color); font-weight: bold;">Yönetim</a>
            <?php endif; ?>
            <a href="logout.php">Çıkış Yap</a>
        <?php else: ?>
            <a href="login.php">Giriş Yap</a>
            <a href="register.php" class="btn btn-primary" style="color:white; margin-left:15px; padding: 8px 20px;">Kayıt Ol</a>
        <?php endif; ?>
    </div>
</nav>

<main class="container">
