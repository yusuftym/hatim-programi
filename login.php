<?php
$page_title = "Giriş Yap";
require_once 'templates/header.php';
require_once 'helpers/activity_helper.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['success'])) {
    $message = "Kayıt başarılı! Lütfen giriş yapın.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "E-posta ve şifre alanları zorunludur.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            
            log_activity_and_check_badges($conn, $user['id'], 'login');

            header("Location: index.php");
            exit();
        } else {
            $error = "E-posta veya şifre hatalı.";
        }
    }
}
?>

<div class="card form-container">
    <h1 style="text-align: center;">Giriş Yap</h1>
    <?php if (isset($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if (isset($message)): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">E-posta</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Şifre</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">Giriş Yap</button>
    </form>
    <p style="margin-top: 15px; text-align: center;">Hesabınız yok mu? <a href="register.php">Kayıt Olun</a></p>
</div>

<?php require_once 'templates/footer.php'; ?>
