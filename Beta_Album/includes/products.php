<?php
include('config.php');
include('navbar.php');

// GET parametresini kontrol et
$id = isset($_GET['Kategori']) ? intval($_GET['Kategori']) : 0;

// kategori ismini al
$kategori_sql = "SELECT kategori_ad FROM kategoriler WHERE kategori_id = ?";
$stmt = $conn->prepare($kategori_sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$kategori_result = $stmt->get_result();
$kategori = $kategori_result->fetch_assoc();

// kategori varsa ürünleri çek
if ($kategori) {
    $urun_sql = "SELECT * FROM urunler WHERE kategori_id = ?";
    $stmt = $conn->prepare($urun_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $urun_result = $stmt->get_result();
} else {
    $urun_result = null;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $kategori ? htmlspecialchars($kategori['kategori_ad']) : 'Kategori Bulunamadı'; ?></title>
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/backgraund.css">
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/products.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="main">
        <h1 class='head'><?php echo $kategori ? htmlspecialchars($kategori['kategori_ad']) : 'Kategori Bulunamadı'; ?></h1>
        
        <div class="product-list">
            <?php
            if ($urun_result && $urun_result->num_rows > 0) {
                while ($row = $urun_result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<img src='/BETA_ALBUM/Beta_Album/image/" . htmlspecialchars($row['urun_gorsel']) . "' alt='Ürün Görseli'>";
                    echo "<h4>" . htmlspecialchars($row['urun_ad']) . "</h4>";
                    echo "<p>Fiyat: " . htmlspecialchars($row['urun_fiyat']) . " TL</p>";
                    echo "<a href='/BETA_ALBUM/Beta_Album/includes/product_detail.php?urun_ad=" . htmlspecialchars($row['urun_ad']) . "'>";
                    echo "<div class='add-to-cart'>";
                    echo "<i class='fa-solid fa-cart-shopping'></i>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                }
            } else {
                echo"<div class='error-container'>";
                echo "<p class='error'>Maalesef Bu Kategoride Ürün Bulunmamaktadır.</p>";
                echo"<i class='fa-solid fa-xmark'></i>";
                echo"</div>";
            }
            ?>
        </div>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>
