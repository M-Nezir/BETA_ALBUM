<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = $conn->prepare("SELECT sepet FROM kullanicilar WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$query->close();

$basket = !empty($user['sepet']) ? json_decode($user['sepet'], true) : [];
$total_price = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepetim</title>
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/backgraund.css">
</head>
<body class="body">
    <?php include('navbar.php'); ?>
    <div class="main">
        <h1 class='head'>SEPETİM</h1>

        <?php if (empty($basket)) : ?>
            <p>Sepete henüz ürün eklemediniz.</p>
        <?php else : ?>
            <ul>
                <?php
                foreach ($basket as $item) {
                    $item_total = $item['urun_fiyat'] * $item['adet'];
                    $total_price += $item_total;
                    echo "<li>{$item['urun_ad']} - {$item['adet']} adet - " . number_format($item_total, 2) . " TL</li>";
                }
                ?>
            </ul>
            <p><strong>Toplam Fiyat:</strong> <?php echo number_format($total_price, 2); ?> TL</p>
        <?php endif; ?>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
