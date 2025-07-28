document.addEventListener('DOMContentLoaded', function() {
    const sureListesiContainer = document.getElementById('sure-listesi-container');
    const ayetListesi = document.getElementById('ayet-listesi');
    const sureBaslik = document.getElementById('sure-baslik');
    const loadingDiv = document.getElementById('loading');
    const audioPlayer = document.getElementById('audio-player');

    const reciterSelect = document.getElementById('reciter-select');
    const translationSelect = document.getElementById('translation-select');
    const tafsirSelect = document.getElementById('tafsir-select');

    function initializePage() {
        fetch('api_handler.php?action=get_surahs')
            .then(response => response.json())
            .then(data => {
                const loadingSures = document.getElementById('loading-sures');
                if(loadingSures) loadingSures.style.display = 'none';
                if (!data || data.length === 0) return;
                data.forEach(sure => {
                    const link = document.createElement('a');
                    link.href = `#${sure.id}`;
                    link.dataset.sureId = sure.id;
                    link.dataset.sureName = sure.name_simple;
                    link.innerHTML = `${sure.id}. ${sure.name_simple} (${sure.name_arabic})`;
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        document.querySelectorAll('.sure-listesi a').forEach(l => l.classList.remove('active'));
                        link.classList.add('active');
                        loadSure(sure.id, sure.name_simple);
                    });
                    sureListesiContainer.appendChild(link);
                });
            });

        fetch('api_handler.php?action=get_options')
            .then(response => response.json())
            .then(data => {
                if (data.mealler) {
                    data.mealler.forEach(meal => {
                        const option = new Option(meal.ad, meal.api_id);
                        translationSelect.add(option);
                    });
                }
                if (data.tefsirler) {
                    data.tefsirler.forEach(tefsir => {
                        const option = new Option(tefsir.ad, tefsir.api_id);
                        tafsirSelect.add(option);
                    });
                }
            });
    }

    function loadSure(sureId, sureName) {
        sureBaslik.textContent = `${sureId}. ${sureName} Suresi`;
        ayetListesi.innerHTML = '';
        loadingDiv.style.display = 'block';

        const recitationId = reciterSelect.value;
        const translationId = translationSelect.value;
        const tafsirId = tafsirSelect.value;

        const apiUrl = `api_handler.php?action=get_surah_details&surah_id=${sureId}&recitation_id=${recitationId}&translation_id=${translationId}&tafsir_id=${tafsirId}`;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                loadingDiv.style.display = 'none';
                if (Object.keys(data).length === 0) {
                    ayetListesi.innerHTML = '<p class="alert alert-danger">Veri alınamadı. Lütfen tekrar deneyin.</p>';
                    return;
                }

                for (const key in data) {
                    const ayetData = data[key];
                    const ayetDiv = document.createElement('div');
                    ayetDiv.className = 'ayet';
                    ayetDiv.innerHTML = `
                        <div class="ayet-header">
                            <span class="ayet-no">Ayet ${ayetData.verse_number}</span>
                            <button class="btn btn-sm btn-primary play-btn" data-audio-src="https://verses.quran.com/${ayetData.audio_url}">Dinle</button>
                        </div>
                        <div class="ayet-
ar">${ayetData.text_uthmani}</div>
                        <div class="ayet-meal">${ayetData.translation}</div>
                        <div class="ayet-tefsir"><strong>Tefsir:</strong> ${ayetData.tafsir.replace(/<[^>]*>/g, '')}</div>
                    `;
                    ayetListesi.appendChild(ayetDiv);
                }

                document.querySelectorAll('.play-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const audioSrc = this.dataset.audioSrc;
                        if (audioSrc && audioSrc.endsWith('mp3')) {
                            audioPlayer.src = audioSrc;
                            audioPlayer.play();
                        } else {
                            alert('Bu ayet için ses dosyası bulunamadı.');
                        }
                    });
                });
            })
            .catch(error => {
                loadingDiv.style.display = 'none';
                ayetListesi.innerHTML = `<p class="alert alert-danger">Bir hata oluştu: ${error}</p>`;
            });
    }

    if (sureListesiContainer) {
        initializePage();
        reciterSelect.addEventListener('change', reloadCurrentSure);
        translationSelect.addEventListener('change', reloadCurrentSure);
        tafsirSelect.addEventListener('change', reloadCurrentSure);
    }

    function reloadCurrentSure() {
        const activeSureLink = document.querySelector('.sure-listesi a.active');
        if (activeSureLink) {
            const sureId = activeSureLink.dataset.sureId;
            const sureName = activeSureLink.dataset.sureName;
            loadSure(sureId, sureName);
        }
    }
});
