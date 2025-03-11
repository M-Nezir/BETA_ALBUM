<?php
session_start();
include('config.php');

// Ürün zaten sepette var mı? Kontrol et
$found = false;
foreach ($basket as &$item) {
    if ($item['urun_id'] == $urun_id) {
        $item['adet'] += $adet; // Var olan ürünün adetini artır
        $found = true;
        break;
    }
}

if (!$found) {
    $basket[] = [
        'urun_id' => $urun_id,
        'urun_ad' => $urun_ad,
        'urun_fiyat' => $urun_fiyat,
        'adet' => $adet,
        'urun_gorsel' => $urun_gorsel
    ];
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$user_id = $_SESSION['user_id'];

// Formdan gelen veriler
$urun_id = intval($_POST['urun_id']);
$urun_ad = $_POST['urun_ad'];
$urun_fiyat = floatval($_POST['urun_fiyat']);
$adet = intval($_POST['adet']);

// Ürün bilgilerini veritabanından al
$query = $conn->prepare("SELECT urun_ad, urun_fiyat, urun_gorsel FROM urunler WHERE urun_id = ?");
$query->bind_param("i", $urun_id);
$query->execute();
$result = $query->get_result();
$urun = $result->fetch_assoc();

if (!$urun) {
    die("Ürün bulunamadı.");
}

$query->close();

// Ürün görselini al
$urun_gorsel = $urun['urun_gorsel']; 

// Kullanıcının mevcut sepetini al
$query = $conn->prepare("SELECT sepet FROM kullanicilar WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$query->close();

// Sepeti JSON formatında işle
$basket = [];
if (!empty($user['sepet'])) {
    $basket = json_decode($user['sepet'], true);

    // JSON decode başarısızsa hata yönetimi
    if (!is_array($basket)) {
        die("Sepet verisi bozulmuş olabilir! Lütfen temizleyin.");
    }
}

// Sepeti JSON formatında işle
$basket = [];
if (!empty($user['sepet'])) {
    $basket = json_decode($user['sepet'], true);

    // JSON decode başarısızsa hata ver ve içeriği göster
    if (!is_array($basket)) {
        die("Sepet JSON hatası! Geçersiz format: " . htmlspecialchars($user['sepet']));
    }
}

// Eğer ürün sepette yoksa yeni olarak ekle
if (!$found) {
    $basket[] = [
        'urun_id' => $urun_id,
        'urun_ad' => $urun_ad,
        'urun_fiyat' => $urun_fiyat,
        'adet' => $adet,
        'urun_gorsel' => $urun_gorsel // Ürün görselini de ekliyoruz
    ];
}

// Güncellenmiş sepeti JSON formatına çevir
$new_basket = json_encode($basket);

// Sepeti veritabanına kaydet
$update_query = $conn->prepare("UPDATE kullanicilar SET sepet = ? WHERE user_id = ?");
$update_query->bind_param("si", $new_basket, $user_id);
$update_query->execute();
$update_query->close();

// Sepet sayfasına yönlendir
header("Location: basket");
exit();
?>
