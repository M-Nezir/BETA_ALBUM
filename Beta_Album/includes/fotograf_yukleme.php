<?php
session_start();
include 'config.php'; // Veritabanı bağlantısı

// Kullanıcı giriş yapmış mı kontrol et
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kategori = $_POST['kategori']; // "Biyometrik" veya "Vesikalık"
    $ebat = $_POST['ebat'];
    $kagit_yuzeyi = $_POST['kagit_yuzeyi'];
    $fotograf_sayisi = $_POST['fotograf_sayisi'];
    
    // Dosya yükleme işlemi
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $dosya_adi = basename($_FILES['foto']['name']);
        $hedef_klasor = "uploads/";
        $hedef_dosya = $hedef_klasor . $dosya_adi;
        move_uploaded_file($_FILES['foto']['tmp_name'], $hedef_dosya);
    } else {
        $hedef_dosya = "";
    }

    // Seçenekleri JSON olarak hazırla
    $urun_bilgisi = json_encode([
        'kategori' => $kategori,
        'ebat' => $ebat,
        'kagit_yuzeyi' => $kagit_yuzeyi,
        'fotograf_sayisi' => $fotograf_sayisi,
        'foto' => $hedef_dosya
    ]);

    // Kullanıcının mevcut sepet verisini çek
    $query = $conn->prepare("SELECT sepet FROM kullanicilar WHERE user_id = ?");
    $query->execute([$user_id]);
    $row = $query->fetch(PDO::FETCH_ASSOC);
    
    $mevcut_sepet = $row['sepet'] ? json_decode($row['sepet'], true) : [];
    $mevcut_sepet[] = $urun_bilgisi;
    
    // Yeni sepet bilgisi ile güncelle
    $yeni_sepet = json_encode($mevcut_sepet);
    $update = $conn->prepare("UPDATE kullanicilar SET sepet = ? WHERE user_id = ?");
    $update->execute([$yeni_sepet, $user_id]);
    
    echo "<script>alert('\u00dcr\u00fcn sepete eklendi!'); window.location.href='fotograf_yukleme.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotoğraf Yükleme</title>
    <script>
        function updateFotografSayisi() {
            var ebat = document.getElementById("vesikalik_ebat").value;
            var fotografSayisi = document.getElementById("vesikalik_fotograf_sayisi");
            fotografSayisi.innerHTML = "";
            
            var adetler = {
                "3,2x4,5 cm (9 Adet)": [9, 18, 27, 36, 45],
                "4,5x6 cm (4 Adet)": [4, 8, 12, 24, 36],
                "6x9 cm (2 Adet)": [2, 4, 6, 8, 10]
            };
            
            if (ebat in adetler) {
                adetler[ebat].forEach(function(adet) {
                    var option = document.createElement("option");
                    option.value = adet;
                    option.textContent = adet + " adet";
                    fotografSayisi.appendChild(option);
                });
            }
        }
    </script>
</head>
<body>
    <h2>Fotoğraf Yükleme</h2>
    
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Biyometrik Fotoğraf</h3>
        <input type="hidden" name="kategori" value="Biyometrik">
        <label>Ebat:</label>
        <select name="ebat">
            <option value="35x45 mm">35x45 mm</option>
            <option value="50x50 mm">50x50 mm</option>
            <option value="50x60 mm">50x60 mm</option>
        </select>
        <label>Kağıt Yüzeyi:</label>
        <select name="kagit_yuzeyi">
            <option value="Parlak">Parlak</option>
            <option value="Mat">Mat</option>
        </select>
        <label>Fotoğraf Sayısı:</label>
        <select name="fotograf_sayisi">
            <option value="4">4 adet</option>
            <option value="8">8 adet</option>
            <option value="12">12 adet</option>
            <option value="24">24 adet</option>
        </select>
        <label>Fiyat:</label> 
        <span id="biyometrik_fiyat">- TL</span>
        <label>Fotoğraf Seç:</label>
        <input type="file" name="foto">
        <button type="submit">Sepete Ekle</button>
    </form>
    
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Vesikalık Fotoğraf</h3>
        <input type="hidden" name="kategori" value="Vesikalık">
        <label>Ebat:</label>
        <select name="ebat" id="vesikalik_ebat" onchange="updateFotografSayisi()">
            <option value="3,2x4,5 cm (9 Adet)">3,2x4,5 cm (9 Adet)</option>
            <option value="4,5x6 cm (4 Adet)">4,5x6 cm (4 Adet)</option>
            <option value="6x9 cm (2 Adet)">6x9 cm (2 Adet)</option>
        </select>
        <label>Kağıt Yüzeyi:</label>
        <select name="kagit_yuzeyi">
            <option value="Parlak">Parlak</option>
            <option value="Mat">Mat</option>
        </select>
        <label>Fotoğraf Sayısı:</label>
        <select name="fotograf_sayisi" id="vesikalik_fotograf_sayisi"></select>
        <label>Fiyat:</label> 
        <span id="vesikalik_fiyat">- TL</span>
        <label>Fotoğraf Seç:</label>
        <input type="file" name="foto">
        <button type="submit">Sepete Ekle</button>
    </form>

    <script>updateFotografSayisi();</script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        function fiyatGuncelle(kategoriSelector, ebatSelector, adetSelector, fiyatLabel) {
            var kategori = $(kategoriSelector).val();
            var ebat = $(ebatSelector).val();
            var adet = $(adetSelector).val();

            if (kategori && ebat && adet) {
                $.post("get_fiyat.php", { kategori: kategori, ebat: ebat, adet: adet }, function(data) {
                    var sonuc = JSON.parse(data);
                    $(fiyatLabel).text(sonuc.fiyat + " TL");
                });
            }
        }

        // Biyometrik Fotoğraf
        $("select[name='ebat'], select[name='fotograf_sayisi']").change(function() {
            fiyatGuncelle("input[name='kategori'][value='Biyometrik']", 
                        "select[name='ebat']", 
                        "select[name='fotograf_sayisi']", 
                        "#biyometrik_fiyat");
        });

        // Vesikalık Fotoğraf
        $("#vesikalik_ebat, #vesikalik_fotograf_sayisi").change(function() {
            fiyatGuncelle("input[name='kategori'][value='Vesikalık']", 
                        "#vesikalik_ebat", 
                        "#vesikalik_fotograf_sayisi", 
                        "#vesikalik_fiyat");
        });
    });
    </script>

    
</body>
</html>
