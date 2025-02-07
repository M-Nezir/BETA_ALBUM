<?php
session_start();
include('config.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = $conn->prepare("SELECT * FROM kullanicilar WHERE id = ?");
    $query->execute([$user_id]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üye Giriş / Hesabım</title>
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/backgraund.css">
</head>
<body class="body">
    <?php include('navbar.php'); ?>
    <div class="main">
        <?php if (isset($_SESSION['user_id'])): ?>
            <h1 class='head'>HESABIM</h1>  
            <p>Ad: <?= htmlspecialchars($user['ad']) ?></p>
            <p>Soyad: <?= htmlspecialchars($user['soyad']) ?></p>
            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
            <p>Telefon: <?= htmlspecialchars($user['telefon']) ?></p>
            <a href="includes/logout.php">Çıkış Yap</a>
        <?php else: ?>
            <h1 class='head'>GİRİŞ</h1>
            <form action="login_process.php" method="POST">
                <input type="email" name="email" placeholder="E-posta" required>
                <input type="password" name="password" placeholder="Şifre" required>
                <button type="submit">Giriş Yap</button>
            </form>

            <h2>Üye Ol</h2>
            <form action="register_process.php" method="POST">
                <input type="text" name="ad" placeholder="Ad" required>
                <input type="text" name="soyad" placeholder="Soyad" required>
                <input type="text" name="telefon" placeholder="Telefon Numarası" required>
                <input type="text" name="tc_kimlik" placeholder="T.C. Kimlik Numarası" required>
                <input type="email" name="email" placeholder="E-posta" required>
                <input type="password" name="password" placeholder="Şifre" required>
                <button type="submit">Üye Ol</button>
            </form>
        <?php endif; ?>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
