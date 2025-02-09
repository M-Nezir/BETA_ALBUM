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

$basket = !empty($user['sepet']) ? json_decode($user['sepet'], true) : [];

if (empty($basket)) {
    echo "empty_basket";
    exit();
}

// Toplam fiyatı hesapla
$total_price = 0;
foreach ($basket as $item) {
    $total_price += $item['urun_fiyat'] * $item['adet'];
}

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
