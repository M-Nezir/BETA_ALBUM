<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    echo "not_logged_in";
    exit();
}

$user_id = $_SESSION['user_id'];
$address = trim($_POST['address']);

// Kullanıcının sepetini çek
$query = $conn->prepare("SELECT sepet FROM kullanicilar WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$query->close();

$basket = (!empty($user['sepet']) && is_string($user['sepet'])) ? json_decode($user['sepet'], true) : [];

if (!is_array($basket)) {
    echo "<h2 style='text-align: center; color: red;'>Hata: Sepet Verisi JSON Formatında Değil!</h2>";
    echo "<pre>";
    var_dump($user['sepet']); // Sepet içeriğini göster
    echo "</pre>";
    exit();
}

// Sepet verisini yazdır
echo "<pre>";
print_r($basket);
echo "</pre>";

$total_price = 0;

foreach ($basket as $item) {
    // Eğer ürün bir JSON string ise, diziye çevir
    if (is_string($item)) {
        $item = json_decode($item, true);

        // JSON dönüşümü başarısızsa, hata mesajı ver
        if (!is_array($item)) {
            echo "<h2 style='text-align: center; color: red;'>Hata: Geçersiz Sepet Verisi!</h2>";
            echo "<pre>";
            var_dump($item);
            echo "</pre>";
            exit();
        }
    }

    // Eğer ürünün fiyat bilgisi varsa standart ürün
    if (isset($item['urun_fiyat'], $item['adet'])) {
        $total_price += $item['urun_fiyat'] * $item['adet'];
    } 
    // Vesikalık/Biyometrik fotoğraf için hesaplama
    elseif (isset($item['fotograf_sayisi'])) {
        $foto_fiyat = 50; // Sabit fiyat örneği
        $total_price += $item['fotograf_sayisi'] * $foto_fiyat;
    }
}

// Toplam fiyatı ekrana yazdır
echo "Toplam Fiyat: " . $total_price;

// Siparişi kaydet
$order_details_json = json_encode($basket);
$order_date = date("Y-m-d H:i:s");

$insert_order = $conn->prepare("INSERT INTO siparisler (user_id, order_details, total_price, address, order_date, status) VALUES (?, ?, ?, ?, ?, 'Hazırlanıyor')");
$insert_order->bind_param("isdss", $user_id, $order_details_json, $total_price, $address, $order_date);

if ($insert_order->execute()) {
    // Sipariş tamamlandıktan sonra sepeti temizle
    $clear_cart = $conn->prepare("UPDATE kullanicilar SET sepet = NULL WHERE user_id = ?");
    $clear_cart->bind_param("i", $user_id);
    $clear_cart->execute();

    // Başarıyla tamamlandıysa, order_success.php sayfasına yönlendir
    header("Location: order_success.php");
    exit();
} else {
    echo "error"; // Sipariş başarısız oldu
}

$insert_order->close();
$conn->close();
?>
