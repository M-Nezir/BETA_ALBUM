<?php
session_start();
include('config.php');

header("Content-Type: application/json");

if (!isset($_SESSION['user_id']) || !isset($_POST['urun_id']) || !isset($_POST['action'])) {
    echo json_encode(["status" => "error", "message" => "Eksik veri gönderildi"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['urun_id'];
$action = $_POST['action'];

$query = $conn->prepare("SELECT sepet FROM kullanicilar WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$query->close();

$basket = !empty($user['sepet']) ? json_decode($user['sepet'], true) : [];

$total_price = 0;
$new_quantity = 0;
$new_item_total = 0;

foreach ($basket as $key => &$item) {
    if ($item['urun_id'] == $product_id) {
        if ($action == "increase") {
            $item['adet'] += 1;
        } elseif ($action == "decrease") {
            $item['adet'] -= 1;
            if ($item['adet'] <= 0) {
                unset($basket[$key]);
                continue;
            }
        }
        $new_quantity = $item['adet'];
        $new_item_total = $new_quantity * $item['urun_fiyat'];
    }
}

$basket = array_values($basket);
$updated_basket = json_encode($basket);

$update_query = $conn->prepare("UPDATE kullanicilar SET sepet = ? WHERE user_id = ?");
$update_query->bind_param("si", $updated_basket, $user_id);
$update_query->execute();
$update_query->close();

foreach ($basket as $item) {
    $total_price += $item['urun_fiyat'] * $item['adet'];
}

echo json_encode([
    "status" => "success",
    "new_quantity" => $new_quantity,
    "new_item_total" => number_format($new_item_total, 2, '.', ''),
    "new_total_price" => number_format($total_price, 2, '.', '')
]);
exit();
