<?php
$page_title = "Kullanıcı Yönetimi";
require_once 'admin_template_header.php';

// Sadece adminler bu sayfayı görebilir
if (!hasRole('admin')) {
    echo "<div class='alert alert-danger'>Bu sayfayı sadece Admin yetkisine sahip kullanıcılar görebilir.</div>";
    require_once 'admin_template_footer.php';
    exit();
}

// Rol değiştirme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_role'])) {
    $user_id_to_change = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    // Kendisinin rolünü değiştirmesini engelle
    if ($user_id_to_change == $_SESSION['user_id']) {
        $error = "Kendi rolünüzü değiştiremezsiniz.";
    } elseif (in_array($new_role, ['user', 'moderator', 'admin'])) {
        $stmt = $conn->prepare("UPDATE users SET role = :role WHERE id = :id");
        $stmt->execute(['role' => $new_role, 'id' => $user_id_to_change]);
        $message = "Kullanıcı rolü güncellendi.";
    } else {
        $error = "Geçersiz rol seçimi.";
    }
}

// Kullanıcıları çek
$users = $conn->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC")->fetchAll();
?>

<?php if (isset($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
<?php if (isset($message)): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>

<div class="card">
    <h2>Kayıtlı Kullanıcılar</h2>
    <table class="content-table">
        <thead>
            <tr>
                <th>Kullanıcı Adı</th>
                <th>E-posta</th>
                <th>Rol</th>
                <th>Kayıt Tarihi</th>
                <th>Rol Değiştir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><strong><?php echo ucfirst($user['role']); ?></strong></td>
                    <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                    <td>
                        <?php if ($user['id'] != $_SESSION['user_id']): // Adminin kendi rolünü değiştirmemesi için ?>
                        <form action="kullanicilar.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <select name="new_role" onchange="this.form.submit()">
                                <option value="user" <?php if($user['role'] == 'user') echo 'selected'; ?>>Kullanıcı</option>
                                <option value="moderator" <?php if($user['role'] == 'moderator') echo 'selected'; ?>>Moderatör</option>
                                <option value="admin" <?php if($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                            </select>
                            <input type="hidden" name="change_role" value="1">
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'admin_template_footer.php'; ?>
