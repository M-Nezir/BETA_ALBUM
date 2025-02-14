<?php
session_start();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../image/beyaz logo.png">
    <title>Sipariş Başarılı</title>
    <link rel="stylesheet" href="../css/backgraund.css">
    <link rel="stylesheet" href="../css/basket.css">
    <style>

/* Sayfa Kapsayıcı */
.container {
    text-align: center;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 90%;
}

/* Başlık */
.title {
    color: #4CAF50;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 15px;
}

/* Mesaj */
.message {
    color: #333;
    font-size: 16px;
    margin-bottom: 20px;
}

/* Buton */
.btn {
    display: inline-block;
    background-color: #4CAF50;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    font-size: 16px;
    border: 1px solid black;
    border-radius: 5px;
    transition: background 0.3s ease-in-out;
}

.btn:hover {
    background-color: #388E3C;
}

    </style>
</head>
<body class="body">
    <?php include('navbar.php'); ?>

    <div class="main">
     
<div class="container">
    <div class="order-success">
        <h1 class="title">Siparişiniz Başarıyla Alındı!</h1>
        <p class="message">Teşekkür ederiz! Siparişiniz başarıyla alındı ve işleme konuldu. En kısa sürede hazırlanıp kargoya verilecektir.</p>
        <a href="siparislerim" class="btn">Siparişlerime Git</a>
    </div>
</div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
