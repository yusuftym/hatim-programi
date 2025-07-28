# Hatimin - Kolektif Hatim & İbadet Platformu

**Birlikte okumanın ve dua etmenin huzurunu dijitalde yaşayın.**

Hatim.in, kullanıcıların bir araya gelerek kolektif olarak Kur'an-ı Kerim hatimleri düzenlemesini, toplu zikirlere katılmasını ve birbirleri için dua edebileceği manevi bir sosyal platformdur. Bu proje, modern web teknolojileri kullanılarak (PHP, MySQL, Bootstrap 5) sıfırdan geliştirilmiştir.

---
**Lütfen**

Önerilerinizi söylemekten çekinmeyin beraber bütelim bu sistemi
---

## ✨ Temel Özellikler

### Kullanıcı Arayüzü
- **Modern ve Mobil Uyumlu Tasarım:** Bootstrap 5 ile geliştirilmiş, her cihazda harika görünen estetik arayüz.
- **Kullanıcı Sistemi:** Güvenli kayıt olma, giriş yapma ve şifre güncelleme.
- **Kolektif Hatimler:**
    - Yeni hatimler başlatma veya mevcut hatimlere katılma.
    - Görsel arayüz üzerinden kolayca cüz alma, bırakma ve okundu olarak işaretleme.
    - Hatim ilerlemesini anlık olarak takip etme.
- **Dua Duvarı:**
    - Topluluktan dua isteme (isim gizli seçeneğiyle).
    - Başkalarının dualarına "Ben de Dua Ettim" butonuyla katılma.
    - Duaya katılanları görme.
- **Toplu İbadetler:**
    - Belirli hedefler için (örn: 100.000 Salavat) açılmış zikir halkalarına katılma.
    - Okunan miktarı girerek ortak hedefe katkıda bulunma.
- **Kur'an-ı Kerim Okuyucu:**
    - Tüm sureleri listeleme ve ayet ayet görüntüleme.
    - Farklı kârilerden sesli olarak dinleme.
    - Birden fazla Türkçe meal ve tefsir arasında anlık geçiş yapma.
- **Kullanıcı Paneli (Dashboard):**
    - Kişisel istatistikleri (okunan cüz, çekilen zikir vb.) görme.
    - Kazanılan rozetleri ve açıklamalarını görüntüleme.
    - Katıldığı hatimleri, duaları ve ibadet katkılarını takip etme.

### Yönetim Paneli
- **Gösterge Paneli:** Onay bekleyen içerikler ve genel site istatistikleri.
- **Hatim Yönetimi:** Kullanıcıların hatim tekliflerini onaylama, reddetme veya mevcut hatimleri düzenleme.
- **Dua Yönetimi:** Dua taleplerini onaylama, reddetme veya yayından kaldırma.
- **İbadet Yönetimi:** Yeni toplu ibadet hedefleri oluşturma, mevcutları düzenleme ve aktif/pasif yapma.
- **Kullanıcı Yönetimi:** Kullanıcıları listeleme, rollerini (`user`, `moderator`, `admin`) değiştirme ve kullanıcı silme.

---

## 🛠️ Kurulum Adımları

Bu projeyi kendi yerel sunucunuzda (XAMPP, WAMP, MAMP vb.) çalıştırmak için aşağıdaki adımları izleyin:

1.  **Veritabanı Sunucusunu Başlatın:**
    - XAMPP Kontrol Panelini açın ve **Apache** ile **MySQL** servislerini başlatın.

2.  **Veritabanını Oluşturun:**
    - Tarayıcınızdan `http://localhost/phpmyadmin` adresine gidin.
    - Yeni bir veritabanı oluşturun. Adını `hatim_platformu` olarak belirleyin. Karşılaştırma (collation ) ayarını `utf8mb4_general_ci` olarak seçmeniz önerilir.
    - Oluşturduğunuz `hatim_platformu` veritabanını seçin ve üst menüdeki **"İçe Aktar" (Import)** sekmesine tıklayın.
    - Proje dosyaları içinde bulunan `hatim_platformu.sql` dosyasını seçin ve içe aktarma işlemini başlatın. Bu işlem, gerekli tüm tabloları ve başlangıç verilerini (admin kullanıcısı, tefsirler vb.) oluşturacaktır.

3.  **Proje Dosyalarını Sunucuya Kopyalayın:**
    - Bu projenin tüm dosyalarını, web sunucunuzun ana dizinine (`C:/xampp/htdocs/`) kopyalayın. Proje klasörünün adının `hatim-platformu` olduğundan emin olun.

4.  **Veritabanı Bağlantısını Kontrol Edin (İsteğe Bağlı):**
    - Proje dosyaları içindeki `config/db.php` dosyasını bir metin düzenleyici ile açın.
    - `DB_USER` ve `DB_PASS` değişkenlerinin, kendi MySQL kurulumunuzla uyumlu olduğunu kontrol edin. (XAMPP için varsayılan kullanıcı `root`, şifre ise boştur).

5.  **Projeyi Çalıştırın:**
    - Tarayıcınızın adres çubuğuna `http://localhost/hatim-platformu/` yazarak siteye erişin.

6.  **Yönetim Paneline Giriş:**
    - Site üzerinden "Giriş Yap" butonuna tıklayın.
    - **E-posta:** `admin@hatim.com`
    - **Şifre:** `admin123`
    - bilgileriyle giriş yapın. Giriş yaptıktan sonra, menüdeki kullanıcı adınıza tıklayarak "Yönetim Paneli" linkine erişebilirsiniz.

---

## 💻 Kullanılan Teknolojiler

- **Backend:** PHP 8+
- **Veritabanı:** MySQL (PDO ile )
- **Frontend:** HTML5, CSS3, JavaScript
- **Framework/Kütüphane:** Bootstrap 5
- **İkonlar:** Font Awesome
- **API:** Quran.com API v4
