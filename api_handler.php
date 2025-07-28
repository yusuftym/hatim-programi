<?php
require_once __DIR__ . '/config/db.php'; 

header('Content-Type: application/json');
define('API_BASE_URL', 'https://api.quran.com/api/v4/' );

function call_quran_api($endpoint, $params = []) {
    $url = API_BASE_URL . $endpoint;
    if (!empty($params)) {
        $url .= '?' . http_build_query($params );
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $output = curl_exec($ch);
    if (curl_errno($ch)) {
        return ['error' => 'API isteği başarısız: ' . curl_error($ch)];
    }
    curl_close($ch);
    return json_decode($output, true);
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'get_surahs':
        $response = call_quran_api('chapters', ['language' => 'tr']);
        echo json_encode($response['chapters'] ?? []);
        break;

    case 'get_options':
        $stmt = $conn->query("SELECT api_id, ad FROM tefsirler WHERE aktif_mi = 1 AND dil = 'tr' ORDER BY ad ASC");
        $tefsirler = $stmt->fetchAll();
        
        $mealler = [
            ['api_id' => 131, 'ad' => 'Diyanet İşleri Başkanlığı'],
            ['api_id' => 85, 'ad' => 'Elmalılı Hamdi Yazır'],
            ['api_id' => 20, 'ad' => 'İngilizce - Sahih International']
        ];

        echo json_encode(['tefsirler' => $tefsirler, 'mealler' => $mealler]);
        break;

    case 'get_surah_details':
        $surah_id = (int)($_GET['surah_id'] ?? 1);
        $translation_id = (int)($_GET['translation_id'] ?? 131);
        $tafsir_id = (int)($_GET['tafsir_id'] ?? 171);
        $recitation_id = (int)($_GET['recitation_id'] ?? 7);

        $params = [
            'language' => 'tr',
            'words' => false,
            'translations' => $translation_id,
            'tafsirs' => $tafsir_id,
            'recitation' => $recitation_id,
            'fields' => 'text_uthmani,chapter_id'
        ];
        $response = call_quran_api("verses/by_chapter/{$surah_id}", $params);
        
        $verses_data = [];
        if (isset($response['verses'])) {
            foreach ($response['verses'] as $verse) {
                $verse_key = $verse['verse_key'];
                $tafsir_text = 'Bu ayet için seçili tefsir kaynağında veri bulunamadı.';
                if (isset($verse['tafsirs'][0]['text'])) {
                    $tafsir_text = $verse['tafsirs'][0]['text'];
                }

                $verses_data[$verse_key] = [
                    'verse_number' => $verse['verse_number'],
                    'text_uthmani' => $verse['text_uthmani'],
                    'translation' => $verse['translations'][0]['text'] ?? 'Meal bulunamadı.',
                    'tafsir' => $tafsir_text,
                    'audio_url' => $verse['audio']['url'] ?? ''
                ];
            }
        }
        echo json_encode($verses_data);
        break;
    
    default:
        echo json_encode(['error' => 'Geçersiz işlem.']);
        break;
}
?>
