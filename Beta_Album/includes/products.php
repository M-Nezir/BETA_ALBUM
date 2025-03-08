<?php
include('config.php');

// GET parametresini kontrol et
$id = isset($_GET['Kategori']) ? intval($_GET['Kategori']) : 0;

if ($id == '9') {
    header('Location: fotograf_yukleme.php');
}

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
    <link rel="icon" type="image/png" href="../image/beyaz logo.png">
    <title><?php echo $kategori ? htmlspecialchars($kategori['kategori_ad']) : 'Kategori Bulunamadı'; ?></title>
    <link rel="stylesheet" href="../css/backgraund.css">
    <link rel="stylesheet" href="../css/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
<style>.whatsapp-button {
    position: fixed;
    bottom: 50px;
    right: 150px;
    width: 50px;
    height: 50px;
    z-index: 1000;
}

.whatsapp-button i {
    font-size: 80px !important;
    z-index: 1000;
}
.whatsapp-button i:hover {
    font-size: 90px !important;
    z-index: 1000;
}
@media (max-width: 768px) {
    .whatsapp-button {
        display: none;}
}
</style>
<a href="https://wa.me/+905369771595" class="whatsapp-button" target="_blank" >
<i class="fa-brands fa-square-whatsapp" style="color: #00ff40;"></i>
</a>
<?php include('navbar.php');?>
    <div class="main" style="padding-bottom: 10%;">
        <h1 class='head'><?php echo $kategori ? htmlspecialchars($kategori['kategori_ad']) : 'Kategori Bulunamadı'; ?></h1>
        
        <div class="product-list">
            <?php
            if ($urun_result && $urun_result->num_rows > 0) {
                while ($row = $urun_result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<a href='product_detail?urun_id=" . htmlspecialchars($row['urun_id']) . "' style='text-decoration: none; color: black;'>";
                    echo "<div class='productimage'>";
                    echo "<img src='../image/" . htmlspecialchars($row['urun_gorsel']) . "' alt='Ürün Görseli'>";
                    echo "</div>";
                    echo "<h4>" . htmlspecialchars($row['urun_ad']) . "</h4>";
                    echo "<p>Fiyat: " . htmlspecialchars($row['urun_fiyat']) . " TL</p>";
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
