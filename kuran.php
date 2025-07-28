<?php
$page_title = "Kur'an-ı Kerim Oku ve Dinle";
require_once 'templates/header.php';
?>

<h1>Kur'an-ı Kerim Oku, Dinle ve Anla</h1>

<div class="kuran-container card">
    <aside class="sure-listesi" id="sure-listesi-container">
        <div id="loading-sures">Sureler Yükleniyor...</div>
    </aside>

    <main class="sure-detay" id="sure-detay-container">
        <div class="options-bar">
            <div>
                <label for="reciter-select">Kâri:</label>
                <select id="reciter-select" class="form-group">
                    <option value="7" selected>Mishary Rashid Alafasy</option>
                    <option value="1">Abd al-Basit Abd al-Samad</option>
                    <option value="4">Mahmoud Khalil Al-Husary</option>
                </select>
            </div>
            <div>
                <label for="translation-select">Meal:</label>
                <select id="translation-select" class="form-group">
                    <!-- JavaScript ile doldurulacak -->
                </select>
            </div>
            <div>
                <label for="tafsir-select">Tefsir:</label>
                <select id="tafsir-select" class="form-group">
                    <!-- JavaScript ile doldurulacak -->
                </select>
            </div>
        </div>
        <h2 id="sure-baslik"></h2>
        <div id="ayet-listesi">
            <p class="alert alert-info">Lütfen soldaki menüden bir sure seçin.</p>
        </div>
        <div id="loading" style="display: none;">Yükleniyor...</div>
    </main>
</div>

<audio id="audio-player" class="audio-player" controls style="position: sticky; bottom: 0; background: #f1f1f1; width: 100%; padding: 5px; box-shadow: 0 -2px 10px rgba(0,0,0,0.1);"></audio>

<script src="public/js/kuran.js"></script>

<?php
require_once 'templates/footer.php';
?>
