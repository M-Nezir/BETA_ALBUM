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
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/basket.css">
</head>
<body class="body">
    <?php include('navbar.php'); ?>
    <div class="main">
        <h1 class='head'>SEPETİM</h1>

        <?php if (empty($basket)) : ?>
    <p class="empty-basket-message">Sepete henüz ürün eklemediniz.</p>
<?php else : ?>
    <div class="basket-item">
        <?php
        foreach ($basket as $item) {
            echo "<div class='basket-itemmm'>";
            echo "<div class='product-imagee'><img src='/BETA_ALBUM/Beta_Album/image/{$item["urun_gorsel"]}' alt=''></div>";
            echo "<div style='display: inline-block; margin-left: 3%;'>";
            $item_total = $item['urun_fiyat'] * $item['adet'];
            $total_price += $item_total;
            echo "<div class='product-name'>{$item['urun_ad']}</div>";
            echo "<div class='product-quantity'>{$item['adet']} adet</div>";
            echo "<div class='product-price'>" . number_format($item_total, 2) . " TL</div>";
            echo "</div>";
            echo "</div>";
            echo "<hr>";
        }
        ?>
        
    </div>
    <p class="basket-total" style='margin-right: 2%;'><strong>Toplam Fiyat:</strong> <?php echo number_format($total_price, 2); ?> TL</p>
<?php endif; ?>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
