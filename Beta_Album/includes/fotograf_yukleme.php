<?php
session_start();
/*if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}*/

include('navbar.php');
include 'config.php'; // Veritabanı bağlantısı

// Kullanıcı giriş yapmış mı kontrol et

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kategori = $_POST['kategori']; // "Biyometrik" veya "Vesikalık"
    $ebat = $_POST['ebat'];
    $kagit_yuzeyi = $_POST['kagit_yuzeyi'];
    $fotograf_sayisi = $_POST['fotograf_sayisi'];

    // Dosya yükleme işlemi
    $hedef_dosya = "";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $dosya_adi = basename($_FILES['foto']['name']);
        $hedef_klasor = "../image/";
        $hedef_dosya = $hedef_klasor . $dosya_adi;
        move_uploaded_file($_FILES['foto']['tmp_name'], $hedef_dosya);
    }

    // Seçenekleri JSON olarak hazırla (Düzenleme yapılıyor)
    $urun_bilgisi = [
        'kategori' => $kategori,
        'ebat' => $ebat,
        'kagit_yuzeyi' => $kagit_yuzeyi,
        'fotograf_sayisi' => $fotograf_sayisi,
        'foto' => $hedef_dosya
    ];

    // Ürün bilgilerini düzenle
    $urun_bilgisi['kategori'] = strtoupper($urun_bilgisi['kategori']); // Kategori büyük harfe çevir
    $urun_bilgisi['ebat'] = htmlspecialchars($urun_bilgisi['ebat']); // Ebatı güvenli hale getir
    $urun_bilgisi['kagit_yuzeyi'] = htmlspecialchars($urun_bilgisi['kagit_yuzeyi']); // Kağıt yüzeyini güvenli hale getir
    $urun_bilgisi['fotograf_sayisi'] = (int)$urun_bilgisi['fotograf_sayisi']; // Fotoğraf sayısını tam sayı yap

    // JSON formatına çevir
    $urun_bilgisi_json = json_encode($urun_bilgisi);

    // Kullanıcının mevcut sepet verisini çek
    $query = $conn->prepare("SELECT sepet FROM kullanicilar WHERE user_id = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    
    // Mevcut sepeti al
    $mevcut_sepet = $row && $row['sepet'] ? json_decode($row['sepet'], true) : [];
    $mevcut_sepet[] = $urun_bilgisi_json; // Ürün bilgilerini sepete ekle

    // Yeni sepet bilgisini güncelle
    $yeni_sepet = json_encode($mevcut_sepet);
    $update = $conn->prepare("UPDATE kullanicilar SET sepet = ? WHERE user_id = ?");
    $update->bind_param("si", $yeni_sepet, $user_id);
    $update->execute();

    echo "<script>alert('Ürün sepete eklendi!'); window.location.href='fotograf_yukleme.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../image/beyaz logo.png">
    <link rel="stylesheet" href="../css/backgraund.css">
    <style>
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-top: 3%;
            border: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 50% !important;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .form {
            display: flex;
            flex-direction: column;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fafafa;
        }
        .form-title {
            text-align: center;
            margin-bottom: 10px;
        }
        .form-label {
            font-weight: bold;
            margin-top: 10px;
        }
        .form-select, .form-input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
        }
        .btn {
            background: #28a745!important;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn:hover {
            background: #218838!important;
        }

        .hidden {
        visibility: hidden;
        opacity: 0;
        height: 0;
        overflow: hidden;
        transition: opacity 0.3s ease, height 0.3s ease;
    }
    .visible {
        visibility: visible;
        opacity: 1;
        height: auto;
        transition: opacity 0.3s ease, height 0.3s ease;
    }

    .toggleButton{
        background:rgb(0, 218, 47);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            margin-bottom: 10px;

    }
    .toggleButton:hover {
        background: #28a745;
        }
    .toggle-class{
        display: flex;
        align-items: center;
    }

    .uyari_resim{

        margin-top: 3%;
    }
    </style>
    <title>Fotoğraf Yükleme</title>


</head>
<body>
    <div class="main">
        <img src="../image/vesikalık.jpg" alt="" style="height: 100%; width: 100%;">
        <h1 style="margin-left: 10%; margin-top: 5%; margin-bottom: 5%;">Biyometrik Fotoğraf ve Vesikalık Fotoğraf</h1>
        <div style="text-align: center;">
            <h2 style="margin-top: 3%;">Vesikalık Fotoğraf</h2>
            <h5>Fotoğrafınız sizin gönderdiğiniz şekilde hiçbir bir oynama(fon değişimi, rötuş vb.) yapılmadan basılacaktır.</h5>
            <div style="display: flex; gap: 4%; align-items: center; justify-content: center;">
                <div>
                    <img src="../image/vs01.jpg" alt="">
                    <div>4,5x6 cm (4 adet) </div>
                </div>
                <div>
                    <img src="../image/vs02.jpg" alt="">
                    <div>3,2x4,5 cm (9 adet)</div>
                </div>
                <div>
                    <img src="../image/vs03.jpg" alt="">
                    <div>6x9 cm (2 adet) </div>
                </div>
        </div>
    </div>
    
    <div style="text-align: center;">
            <h1 style="margin-top: 3%;">Biyometrik Fotoğraf</h1>
            <h5>Fotoğrafınız seçtiğiniz biyometrik ölçüsünde ve biyometrik standartlarına uygun olarak fon değişimi yapılarak basılacaktır.</h5>
            <div style="display: flex; gap: 4%; align-items: center; justify-content: center;">
                <div>
                    <img src="../image/by01.jpg" alt="">
                    <div>35x45 mm <br>
                    <b>Schengen vize ölçüsü</b></div>
                </div>
                <div>
                    <img src="../image/by02.jpg" alt="">
                    <div>50x50 mm <br>
                    <b>Amerika vize ölçüsü</b></div>
                </div>
                <div>
                    <img src="../image/by03.jpg" alt="">
                    <div>50x60 mm <br>
                    <b>Kimlik, ehliyet, pasaport ve birçok <br>ülkenin vize ölçüsü</b></div>
                </div>
        </div>
    </div>


<div class="container">

        <h4 class="title"><button id="biyometrikButton" class="toggleButton">Biyometrik</button>
        <button id="vesikalikButton" class="toggleButton">Vesikalık</button></h4>
        
        <form action="" method="POST" enctype="multipart/form-data" class="form">
            <h2 class="form-title">Biyometrik Fotoğraf</h2>
            <input type="hidden" name="kategori" value="Biyometrik">
            <label class="form-label">Ebat:</label>
            <select name="ebat" class="form-select">
            <option>Lütfen Ebat Seçiniz</option>
                <option value="35x45 mm">35x45 mm</option>
                <option value="50x50 mm">50x50 mm</option>
                <option value="50x60 mm">50x60 mm</option>
            </select>
            <label class="form-label">Kağıt Yüzeyi:</label>
            <select name="kagit_yuzeyi" class="form-select">
                <option value="Parlak">Parlak</option>
                <option value="Mat">Mat</option>
            </select>
            <label class="form-label">Fotoğraf Sayısı:</label>
            <select name="fotograf_sayisi" class="form-select">
        
                <option value="4">4 adet</option>
                <option value="8">8 adet</option>
                <option value="12">12 adet</option>
                <option value="24">24 adet</option>
            </select>
            <label class="form-label">Fiyat:</label> 
            <span id="biyometrik_fiyat" class="price"> - TL</span>
            <label class="form-label">Fotoğraf Seç:</label>
            <input type="file" name="foto" class="form-input">
            <button type="submit" class="btn">Sepete Ekle</button>
        </form>
        
        <form action="" method="POST" enctype="multipart/form-data" class="form">
            <h2 class="form-title">Vesikalık Fotoğraf</h2>
            <input type="hidden" name="kategori" value="Vesikalik">
            <label class="form-label">Ebat:</label>
            <select name="ebat" id="vesikalik_ebat" class="form-select" onchange="updateFotografSayisi()">
                <option>Lütfen Ebat Seçiniz</option>
                <option value="3,2x4,5 cm (9 Adet)">3,2x4,5 cm (9 Adet)</option>
                <option value="4,5x6 cm (4 Adet)">4,5x6 cm (4 Adet)</option>
                <option value="6x9 cm (2 Adet)">6x9 cm (2 Adet)</option>
            </select>
            <label class="form-label">Kağıt Yüzeyi:</label>
            <select name="kagit_yuzeyi" class="form-select">
                <option value="Parlak">Parlak</option>
                <option value="Mat">Mat</option>
            </select>
            <label class="form-label">Fotoğraf Sayısı:</label>
            <select name="fotograf_sayisi" id="vesikalik_fotograf_sayisi" class="form-select"></select>
            <label class="form-label">Fiyat:</label> 
            <span id="vesikalik_fiyat" class="price">- TL</span>
            <label class="form-label">Fotoğraf Seç:</label>
            <input type="file" name="foto" class="form-input">
            <button type="submit" class="btn">Sepete Ekle</button>
        </form>
    </div>



    <div style="text-align: center;">
    <h1 style="margin-top: 3%;"> Biyometrik fotoğrafta dikkat etmeniz gerekenler;</h1>
        <div>
             <img src="../image/dk001.jpg" alt="" class="uyari_resim">
            <div> Yüz, fotoğraf üzerinde ortalanmış olarak saç modeliyle birlikte tamamen görünür olmalıdır.</div>
        </div>

        <div>
             <img src="../image/dk002.jpg" alt="" class="uyari_resim">
            <div> Fotoğrafta leke ve bükülmeler olmamalıdır. Renkler nötr olmalı ve yüzün doğal renklerini yansıtmalıdır.
            </div>
        </div>

        <div>
             <img src="../image/dk003.jpg" alt="" class="uyari_resim">
            <div> Gözler açık konumda olmalı ve net olarak görünmelidir. Saçlar gözleri ve kaç bitimini kapatmamalı, <br> fotoğraf çekilirken doğrudan kameraya bakılmalıdır.</div>
        </div>

        <div>
             <img src="../image/dk004.jpg" alt="" class="uyari_resim">
            <div> Başın konumu dik olmalı, baş herhangi bir yöne dönük olmamalıdır. Fotoğraf gülme vb. mimikler olmadan, <br> ağız kapalı olarak çekilmelidir.</div>
        </div>

        <div>
             <img src="../image/dk005.jpg" alt="" class="uyari_resim">
            <div> Işık yüze eşit ölçüde yansıtılmalı, yansıma veya gölgeler bulunmamalıdır. Fotoğrafta "kırmızı-göz" bulunmamalıdır.</div>
        </div>

        <div>
             <img src="../image/dk006.jpg" alt="" class="uyari_resim">
            <div> Gözler net bir şekilde görünmeli, gözlük camı üzerinde yansımalar bulunmamalı, renkli cam veya güneş gözlüğü kullanılmamalıdır. <br>
            Gözlük camının kenarı veya çerçevesi gözleri kapatmamalı ya da gözleri kapatacak ölçüde kalın olmamalıdır.</div>
        </div>

        <div>
             <img src="../image/dk007.jpg" alt="" class="uyari_resim">
            <div>Kişinin zorunlu olarak kullandığı gözlük ve benzeri aksesuarlar dışında fotoğrafta şapka, başlık, pipo, vb. nesneler bulunmamalıdır.</div>
        </div>

        <div>
             <img src="../image/dk008.jpg" alt="" class="uyari_resim">
            <div>Başörtülü fotoğraflarda yüz çene ucundan alına kadar görünür olmalı, kaç bitimi gözükmeli, yüzün üzerinde gölgeler oluşmamalıdır.</div>
        </div>
    </div>

    </div>
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
                    if(sonuc.fiyat == "Lütfen Yukarıdaki Kısımları Eksiksiz Doldurunuz!"){
                        $(fiyatLabel).text(sonuc.fiyat);
                    }
                    else{
                        $(fiyatLabel).text(sonuc.fiyat + " TL");
                    }
                    
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
            fiyatGuncelle("input[name='kategori'][value='Vesikalik']", 
                        "#vesikalik_ebat", 
                        "#vesikalik_fotograf_sayisi", 
                        "#vesikalik_fiyat");
        });
    });
    </script>



<script>
document.getElementById("biyometrikButton").addEventListener("click", function() {
    document.querySelector("form:nth-of-type(1)").classList.add("visible");
    document.querySelector("form:nth-of-type(1)").classList.remove("hidden");
    document.querySelector("form:nth-of-type(2)").classList.add("hidden");
    document.querySelector("form:nth-of-type(2)").classList.remove("visible");
});

document.getElementById("vesikalikButton").addEventListener("click", function() {
    document.querySelector("form:nth-of-type(2)").classList.add("visible");
    document.querySelector("form:nth-of-type(2)").classList.remove("hidden");
    document.querySelector("form:nth-of-type(1)").classList.add("hidden");
    document.querySelector("form:nth-of-type(1)").classList.remove("visible");
});

// Sayfa yüklendiğinde biyometrik form açık olsun
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("form:nth-of-type(1)").classList.add("visible");
    document.querySelector("form:nth-of-type(2)").classList.add("hidden");
});
</script>
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
    <script>
function guncelleFiyat() {
    let kategori = document.getElementById("kategori").value;
    let ebat = document.getElementById("ebat").value;
    let adet = document.getElementById("adet").value;
    
    let formData = new FormData();
    formData.append("kategori", kategori);
    formData.append("ebat", ebat);
    formData.append("adet", adet);

    fetch("get_fiyat.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("vesikalik_fiyat").innerText = data.fiyat;
    })
    .catch(error => console.error("Hata:", error));
}
</script>

<?php include('footer.php'); ?>
</body>
</html>
