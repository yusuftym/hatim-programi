<?php
// Bu dosya, aktivite loglama ve rozet kontrolü yapacak.
// Diğer dosyalardan (hatim.php, gunluk_ibadetler.php) çağrılacak.

function log_activity_and_check_badges($conn, $user_id, $activity_type, $related_id = null, $value = null) {
    // 1. Aktiviteyi logla
    $stmt = $conn->prepare("INSERT INTO user_activity_log (user_id, activity_type, related_id, value) VALUES (:user_id, :activity_type, :related_id, :value)");
    $stmt->execute([
        'user_id' => $user_id,
        'activity_type' => $activity_type,
        'related_id' => $related_id,
        'value' => $value
    ]);

    // 2. Rozetleri kontrol et
    check_all_badges($conn, $user_id);
}

function check_all_badges($conn, $user_id) {
    // Tüm rozet tanımlarını al
    $badges_to_check = $conn->query("SELECT * FROM badges")->fetchAll(PDO::FETCH_ASSOC);
    
    // Kullanıcının mevcut rozetlerini al
    $stmt = $conn->prepare("SELECT badge_id FROM user_badges WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user_existing_badges = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($badges_to_check as $badge) {
        // Eğer kullanıcı bu rozete zaten sahipse, kontrol etme
        if (in_array($badge['id'], $user_existing_badges)) {
            continue;
        }

        $earned = false;
        switch ($badge['type']) {
            case 'cuz':
                $stmt = $conn->prepare("SELECT COUNT(*) FROM user_activity_log WHERE user_id = :user_id AND activity_type = 'cuz_okundu'");
                $stmt->execute(['user_id' => $user_id]);
                $count = $stmt->fetchColumn();
                if ($count >= $badge['requirement']) $earned = true;
                break;
            
            case 'zikir':
                $stmt = $conn->prepare("SELECT SUM(value) FROM user_activity_log WHERE user_id = :user_id AND activity_type = 'zikir_eklendi'");
                $stmt->execute(['user_id' => $user_id]);
                $sum = $stmt->fetchColumn();
                if ($sum >= $badge['requirement']) $earned = true;
                break;
            
            case 'login':
                 $stmt = $conn->prepare("SELECT COUNT(DISTINCT DATE(activity_date)) FROM user_activity_log WHERE user_id = :user_id AND activity_type = 'login'");
                 $stmt->execute(['user_id' => $user_id]);
                 $days = $stmt->fetchColumn();
                 if ($days >= $badge['requirement']) $earned = true;
                 break;
        }

        if ($earned) {
            // Kullanıcıya rozeti ver
            $insert_stmt = $conn->prepare("INSERT INTO user_badges (user_id, badge_id) VALUES (:user_id, :badge_id)");
            $insert_stmt->execute(['user_id' => $user_id, 'badge_id' => $badge['id']]);
        }
    }
}
?>
