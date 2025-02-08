<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || !isset($_POST['address'])) {
    echo json_encode(["status" => "error"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$address = $_POST['address'];

// Kullanıcının sepetini al
$query = $conn->prepare("SELECT sepet FROM kullanicilar WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$query->close();

$basket = !empty($user['sepet']) ? json_decode($user['sepet'], true) : [];

if (empty($basket)) {
    echo json_encode(["status" => "empty"]);
    exit();
}

// Toplam fiyat hesapla
$total_price = 0;
foreach ($basket as $item) {
    $total_price += $item['urun_fiyat'] * $item['adet'];
}

// Siparişi veritabanına kaydet
$order_details = json_encode($basket);
$insert_query = $conn->prepare("INSERT INTO siparisler (user_id, order_details, total_price, address) VALUES (?, ?, ?, ?)");
$insert_query->bind_param("isds", $user_id, $order_details, $total_price, $address);
$insert_query->execute();
$insert_query->close();

// Sepeti temizle
$empty_cart = json_encode([]);
$update_query = $conn->prepare("UPDATE kullanicilar SET sepet = ? WHERE user_id = ?");
$update_query->bind_param("si", $empty_cart, $user_id);
$update_query->execute();
$update_query->close();

echo json_encode(["status" => "success"]);
exit();
?>
