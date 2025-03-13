<?php
session_start();
include('config.php');

// Eğer kullanıcı giriş yapmamışsa yönlendirme yap
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$user_id = $_SESSION['user_id'];

// Kullanıcının sepetini veritabanından al
$query = $conn->prepare("SELECT sepet FROM kullanicilar WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$query->close();

$basket = [];
if (!empty($user['sepet'])) {
    $decoded = json_decode($user['sepet'], true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $basket = $decoded;
    }
}

$urun_id = $_POST['urun_id']; // Ürün ID'si
$action = $_POST['action']; // Artırma ya da eksiltme işlemi
$found = false;

foreach ($basket as &$item) {
    // Normal ürün için işlem
    if (isset($item['urun_id']) && $item['urun_id'] == $urun_id && !isset($item['kategori']) && !isset($item['ebat'])) {
        // Eğer artış yapılacaksa
        if ($action == 'increase') {
            $item['adet']++;
        } elseif ($action == 'decrease' && $item['adet'] > 1) {
            // Eğer azalma yapılacaksa ve adet 1'den fazla ise azalt
            $item['adet']--;
        }
        $found = true;
        break;
    }
    // Fotoğraf baskı ürünü için işlem
    elseif (isset($item['kategori']) && isset($item['ebat'])) {
        if ($action == 'increase') {
            $item['fotograf_sayisi']++; // Fotoğraf sayısını artır
        } elseif ($action == 'decrease' && $item['fotograf_sayisi'] > 1) {
            $item['fotograf_sayisi']--; // Fotoğraf sayısını azalt
        }
        $found = true;
        break;
    }
}

// Sepet güncelleme işlemi
if ($found) {
    // Güncellenen sepete tekrar json formatında dönüştür
    $updated_basket = json_encode($basket);
    
    // Veritabanını güncelle
    $update_query = $conn->prepare("UPDATE kullanicilar SET sepet = ? WHERE user_id = ?");
    $update_query->bind_param("si", $updated_basket, $user_id);
    $update_query->execute();
    $update_query->close();
    
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
