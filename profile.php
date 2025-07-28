<?php
$page_title = "Profilim";
require_once 'templates/header.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, created_at, role FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();
?>

<div class="card">
    <h1>Profil Bilgilerim</h1>
    <div class="profile-info">
        <p><strong>Kullanıcı Adı:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>E-posta:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Rol:</strong> <?php echo ucfirst($user['role']); ?></p>
        <p><strong>Kayıt Tarihi:</strong> <?php echo date('d M Y', strtotime($user['created_at'])); ?></p>
    </div>
    <hr style="margin: 20px 0;">
    <a href="raporlar.php" class="btn btn-primary">Raporlarımı ve Başarılarımı Gör</a>
</div>

<?php require_once 'templates/footer.php'; ?>
