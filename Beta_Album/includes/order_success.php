<?php
session_start();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Başarılı</title>
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/backgraund.css">
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/basket.css">
</head>
<body class="body">
    <?php include('navbar.php'); ?>

    <div class="main">
        <h1 class="head">Siparişiniz Başarıyla Alındı!</h1>
        <p class="success-message">Siparişiniz alındı ve işleme kondu. Teşekkür ederiz!</p>
        <p><a href="../index.php">Anasayfaya dön</a></p>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
