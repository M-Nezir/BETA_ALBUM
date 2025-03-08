<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    echo "error";
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['key'])) {
    $key = $_POST['key'];

    $query = $conn->prepare("SELECT sepet FROM kullanicilar WHERE user_id = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();
    $query->close();

    if ($user) {
        $basket = json_decode($user['sepet'], true);
        if (json_last_error() === JSON_ERROR_NONE && isset($basket[$key])) {
            unset($basket[$key]);
            $updated_basket = json_encode(array_values($basket));
            
            $update_query = $conn->prepare("UPDATE kullanicilar SET sepet = ? WHERE user_id = ?");
            $update_query->bind_param("si", $updated_basket, $user_id);
            $update_query->execute();
            $update_query->close();

            echo "success";
        }
    }
}
?>
