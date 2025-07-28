<?php
$page_title = "Kayıt Ol";
require_once 'templates/header.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Tüm alanlar zorunludur.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Geçersiz e-posta formatı.";
    } elseif (strlen($password) < 6) {
        $error = "Şifre en az 6 karakter olmalıdır.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $error = "Bu e-posta adresi zaten kayıtlı.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            if ($stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password])) {
                header("Location: login.php?success=1");
                exit();
            } else {
                $error = "Kayıt sırasında bir hata oluştu.";
            }
        }
    }
}
?>

<div class="card form-container">
    <h1 style="text-align: center;">Kayıt Ol</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="username">Kullanıcı Adı</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="email">E-posta</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Şifre</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">Kayıt Ol</button>
    </form>
    <p style="margin-top: 15px; text-align: center;">Zaten bir hesabınız var mı? <a href="login.php">Giriş Yapın</a></p>
</div>

<?php require_once 'templates/footer.php'; ?>
