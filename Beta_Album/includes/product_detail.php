<?php
session_start();
include('config.php'); // Veritabanına bağlan

if (!isset($_GET['urun_id'])) {
    die("Ürün bulunamadı.");
}

$urun_id = intval($_GET['urun_id']); // Güvenlik için ID'yi integer'a çevir

// Sorguyu hazırla
$query = $conn->prepare("SELECT urun_id, urun_ad, urun_gorsel, urun_fiyat, urun_aciklama FROM urunler WHERE urun_id = ?");
$query->bind_param("i", $urun_id);
$query->execute();
$result = $query->get_result();
$urun = $result->fetch_assoc();

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
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/product_details.css">
    <title><?php echo htmlspecialchars($urun['urun_ad']); ?></title>
</head>
<body>
<?php include('navbar.php'); ?>

<div class="main">
    <div style="display: flex; flex-direction: center;">
    <div style="display: inline-flex;  justify-content: flex-start; flex-direction: column;">
         <h1 class="head"><?php echo htmlspecialchars($urun['urun_ad']); ?></h1><br>
         <img class="imagess" src="/BETA_ALBUM/Beta_Album/image/<?php echo htmlspecialchars($urun['urun_gorsel']); ?>" alt="<?php echo htmlspecialchars($urun['urun_ad']); ?>" width="300"> <br>
         <div style=" width: 60%;word-wrap: break-word; overflow-wrap: break-word;">
         <p><strong>Fiyat:</strong> <?php echo number_format($urun['urun_fiyat'], 2); ?> TL</p>
         <?php if (!empty($urun['urun_aciklama'])): ?>
        <p><strong>Açıklama:</strong> <?php echo nl2br(htmlspecialchars($urun['urun_aciklama'])); ?></p>
    <?php endif; ?>

         </div>
     
    </div>
 
    </div>
  
   

    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="add_to_cart.php" method="POST">
            <input type="hidden" name="urun_id" value="<?php echo $urun['urun_id']; ?>">
            <input type="hidden" name="urun_ad" value="<?php echo htmlspecialchars($urun['urun_ad']); ?>">
            <input type="hidden" name="urun_fiyat" value="<?php echo $urun['urun_fiyat']; ?>">
            <label for="adet">Adet:</label>
            <input type="number" id="adet" name="adet" value="1" min="1" required>
            <button class="button" type="submit">Sepete Ekle</button>
        </form>
    <?php else: ?>
        <a href="login" class="add-to-cart-btn">Giriş Yap ve Sepete Ekle</a>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
</body>
</html>
