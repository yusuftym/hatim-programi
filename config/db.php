<?php
// Oturumu başlat
session_start();

// Veritabanı ayarları
$servername = "localhost";
$username = "root"; // Veritabanı kullanıcı adınız
$password = ""; // Veritabanı şifreniz
$dbname = "hatim"; // Oluşturduğunuz veritabanının adı

// PDO ile güvenli bağlantı
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Hata durumunda bağlantıyı sonlandır ve mesaj göster
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

// Yardımcı fonksiyon: Kullanıcının giriş yapıp yapmadığını kontrol eder
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Yardımcı fonksiyon: Kullanıcının rolünü kontrol eder
function hasRole($role) {
    if (!isLoggedIn()) {
        return false;
    }
    $user_role = $_SESSION['user_role'] ?? 'user';
    if (is_array($role)) {
        return in_array($user_role, $role);
    }
    return $user_role === $role;
}
?>
