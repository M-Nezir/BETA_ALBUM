<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = $conn->prepare("SELECT sepet FROM kullanicilar WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$query->close();

// Sepet verisini JSON formatında doğru şekilde çözümle
$basket = [];
if (!empty($user['sepet'])) {
    $decoded = json_decode($user['sepet'], true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $basket = $decoded;
    }
}

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
    <link rel="icon" type="image/png" href="../image/beyaz logo.png">
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
                    // Eğer JSON verisi string olarak saklanmışsa decode edelim
                    if (is_string($item)) {
                        $item = json_decode($item, true);
                    }

                    // Eğer veri hala dizi değilse hatayı önlemek için atla
                    if (!is_array($item)) {
                        continue;
                    }

                    echo "<div class='basket-itemmm'>";

                    // Eğer standart bir ürünse
                    if (isset($item['urun_id'])) {
                        $item_total = $item['urun_fiyat'] * $item['adet'];
                        $total_price += $item_total;

                        echo "<div class='product-imagee'><img src='/BETA_ALBUM/Beta_Album/image/" . htmlspecialchars($item["urun_gorsel"]) . "' alt=''></div>";
                        echo "<div style='display: inline-block; margin-left: 3%; text-align: center;'>";
                        echo "<div class='product-name'>" . htmlspecialchars($item['urun_ad']) . "</div>";
                        echo "<div class='quantity-control'>
                            <button class='qty-btn decrease-qty' data-id='{$item['urun_id']}' aria-label='Adeti Azalt'>−</button>
                            <span class='qty'>" . htmlspecialchars($item['adet']) . "</span>
                            <button class='qty-btn increase-qty' data-id='{$item['urun_id']}' aria-label='Adeti Artır'>+</button>
                            </div>";
                        echo "<div class='product-price'>" . number_format($item_total, 2, '.', '') . " TL</div>";

                    } 
                    // Eğer vesikalık/biyometrik fotoğrafsa
                    else if (isset($item['kategori']) && isset($item['ebat'])) {
                        echo "<div class='product-imagee'><img src='" . htmlspecialchars($item["foto"]) . "' alt=''></div>";
                        echo "<div style='display: inline-block; margin-left: 3%; text-align: center;'>";
                        echo "<div class='product-name'>" . htmlspecialchars($item['kategori']) . " - " . htmlspecialchars($item['ebat']) . "</div>";
                        echo "<div class='product-details'>
                                <p><strong>Kağıt Yüzeyi:</strong> " . htmlspecialchars($item['kagit_yuzeyi']) . "</p>
                                <p><strong>Fotoğraf Sayısı:</strong> " . htmlspecialchars($item['fotograf_sayisi']) . "</p>
                              </div>";
                        echo "<div class='product-price'>Özel Fiyatlandırma</div>";
                    }

                    echo "</div>";
                    echo "</div>";
                    echo "<hr>";
                }
                ?>
            </div>
            
        <?php endif; ?>

        <form id="order-form" class="order-form" action="order_process.php" method="POST">
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
                        window.location.reload();
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
