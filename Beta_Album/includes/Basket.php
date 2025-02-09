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
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepetim</title>
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/backgraund.css">
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/basket.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                foreach ($basket as $key => $item) {
                    echo "<div class='basket-itemmm' data-id='{$item['urun_id']}'>";
                    echo "<div class='product-imagee'><img src='/BETA_ALBUM/Beta_Album/image/{$item["urun_gorsel"]}' alt=''></div>";
                    echo "<div style='display: inline-block; margin-left: 3%; text-align: center;'>";

                    $item_total = $item['urun_fiyat'] * $item['adet'];
                    $total_price += $item_total;

                    echo "<div class='product-name'>{$item['urun_ad']}</div>";
                    echo "<div class='quantity-control'>
                        <button class='qty-btn decrease-qty' data-id='{$item['urun_id']}' aria-label='Adeti Azalt'>−</button>
                        <span class='qty'>" . htmlspecialchars($item['adet']) . "</span>
                        <button class='qty-btn increase-qty' data-id='{$item['urun_id']}' aria-label='Adeti Artır'>+</button>
                        </div>";

                    // **Düzeltme: PHP'de doğru fiyat formatı**
                    echo "<div class='product-price'>" . number_format($item_total, 2, '.', '') . " TL</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<hr>";
                }
                ?>
            </div>
            
        <?php endif; ?>

        <form id="order-form" class="order-form">
            <p class="basket-total" style='text-align: center;'><strong>Toplam Fiyat:</strong> <span id="total-price"><?php echo number_format($total_price, 2, '.', ''); ?></span> TL</p>
            <label for="address" class="form-label">Teslimat Adresi</label>
            <textarea id="address" name="address" class="form-input" placeholder="Adresinizi buraya yazın..." required></textarea>
            <button type="submit" id="place-order" class="order-button">Satın Al</button>
        </form>

<script>
    $(document).ready(function () {
    $(document).on("click", ".increase-qty, .decrease-qty", function () {
        var button = $(this);
        var productId = button.data("id");
        var action = button.hasClass("increase-qty") ? "increase" : "decrease";

        $.ajax({
            url: "update_basket.php",
            type: "POST",
            data: { urun_id: productId, action: action },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    window.location.reload(); // **Sayfayı yenile**
                } else {
                    alert("Sepet güncellenemedi!");
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Hatası:", error);
            }
        });
    });
});

</script>

    </div>
    <?php include('footer.php'); ?>
</body>
</html>
