<?php
include('../includes/config.php'); // Veritabanı bağlantısı

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    // SQL Injection'a karşı koruma
    $order_id = mysqli_real_escape_string($conn, $order_id);
    $new_status = mysqli_real_escape_string($conn, $new_status);

    // Sipariş durumunu güncelleme
    $query = "UPDATE siparisler SET status = '$new_status' WHERE order_id = '$order_id'";
    if (mysqli_query($conn, $query)) {
        echo "Sipariş durumu güncellendi.";
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}
?>
