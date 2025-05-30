<?php
session_start();
include('navbar.php'); // Veritabanı bağlantısı

// Kullanıcı giriş yapmış mı kontrol et
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Kullanıcının siparişlerini getir
$stmt = $conn->prepare("SELECT * FROM siparisler WHERE user_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../image/beyaz logo.png">
    <title>Siparişlerim</title>
    <style>
        .order-container { max-width: 600px; margin: 0 auto; }
        .order-card { background: rgb(220, 220, 220); padding: 15px; margin: 10px 0; border-radius: 8px; }
        .order-card h3 { margin: 0 0 10px; color: #333; }
        .order-status { font-weight: bold; color: #d35400; }
        .product-img { width: 50px; height: 50px; margin-right: 10px; border-radius: 5px; object-fit: cover; }
    </style>
</head>
<body>
<div class="order-container">
    <h2 style="margin: 3%;">Siparişlerim</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="order-card">
                <h3>Sipariş No: <?php echo $row['order_id']; ?></h3>
                <p><strong>Tarih:</strong> <?php echo $row['order_date']; ?></p>
                <p><strong>Toplam Fiyat:</strong> <?php echo number_format($row['total_price'], 2); ?> ₺</p>
                <p><strong>Adres:</strong> <?php echo $row['address']; ?></p>
                <p class="order-status"><strong>Durum:</strong> <?php echo $row['status']; ?></p>
                
                <details>
                    <summary>Ürünleri Gör</summary>
                    <ul>
                        <?php
                        $order_details = json_decode($row['order_details'], true);
                        foreach ($order_details as $item) {
                            if (is_string($item)) {
                                $item = json_decode($item, true); // Escape edilmiş JSON'u çöz
                            }
                            
                            if (isset($item['urun_id'])) {
                                // Standart ürünler
                                $urun_id = $item['urun_id'];
                                $urun_adet = $item['adet'];

                                $urun_stmt = $conn->prepare("SELECT urun_ad, urun_fiyat, urun_gorsel FROM urunler WHERE urun_id = ?");
                                $urun_stmt->bind_param("i", $urun_id);
                                $urun_stmt->execute();
                                $urun_result = $urun_stmt->get_result();
                                
                                if ($urun = $urun_result->fetch_assoc()) {
                                    $urun_gorsel = !empty($urun['urun_gorsel']) ? "../image/" . $urun['urun_gorsel'] : "../image/default.jpg";
                                    echo "<li>
                                        <img src='{$urun_gorsel}' class='product-img' alt='{$urun['urun_ad']}'>
                                        <strong>{$urun['urun_ad']}</strong> - {$urun_adet} adet - 
                                        <strong>{$urun['urun_fiyat']} ₺</strong>
                                    </li>";
                                }
                                $urun_stmt->close();
                            } else {
                                // Vesikalık/Biyometrik Ürünler
                                echo "<li>
                                    <strong>Kategori:</strong> {$item['kategori']} - 
                                    <strong>Ebat:</strong> {$item['ebat']} - 
                                    <strong>Kağıt Yüzeyi:</strong> {$item['kagit_yuzeyi']} - 
                                    <strong>Fotoğraf Sayısı:</strong> {$item['fotograf_sayisi']} 
                                    <br>
                                    <img src='{$item['foto']}' class='product-img' alt='Fotoğraf'>
                                </li>";
                            }
                        }
                        ?>
                    </ul>
                </details>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Henüz bir siparişiniz bulunmamaktadır.</p>
    <?php endif; ?>
</div>
<?php include('footer.php'); ?>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
