<?php
include('config.php'); // Veritabanına bağlan

if (!isset($_GET['urun_id'])) {
    die("Ürün bulunamadı.");
}

$urun_id = intval($_GET['urun_id']); // Güvenlik için ID'yi integer'a çevir

// Sorguyu hazırla
$query = $conn->prepare("SELECT urun_ad, urun_gorsel, urun_fiyat, urun_aciklama FROM urunler WHERE urun_id = ?");
$query->bind_param("i", $urun_id);
$query->execute();

// Sonuçları al
$result = $query->get_result();
$urun = $result->fetch_assoc();

// Eğer ürün yoksa hata ver
if (!$urun) {
    die("Ürün bulunamadı.");
}

$query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/backgraund.css">
    <title><?php echo htmlspecialchars($urun['urun_ad']); ?></title>
</head>
<body>
<?php include('navbar.php'); ?>

<div class="main">
    <h1 class="head"><?php echo htmlspecialchars($urun['urun_ad']); ?></h1>
    <img src="/BETA_ALBUM/Beta_Album/image/<?php echo htmlspecialchars($urun['urun_gorsel']); ?>" alt="<?php echo htmlspecialchars($urun['urun_ad']); ?>" width="300">
    <p><strong>Fiyat:</strong> <?php echo number_format($urun['urun_fiyat'], 2); ?> TL</p>

    <?php if (!empty($urun['urun_aciklama'])): ?>
        <p><strong>Açıklama:</strong> <?php echo nl2br(htmlspecialchars($urun['urun_aciklama'])); ?></p>
    <?php endif; ?>

    <a href="login.php" class="add-to-cart-btn">Sepete Ekle</a>
</div>

<?php include('footer.php'); ?>
</body>
</html>
