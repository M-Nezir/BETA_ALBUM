<?php
session_start();
include('config.php');

$user = null; // Kullanıcı bilgisini tutacak değişken

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Kullanıcı bilgilerini çek
    $query = $conn->prepare("SELECT * FROM kullanicilar WHERE user_id = ?");
    $query->bind_param("i", $user_id); // `id` integer olduğu için "i" parametresi
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
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
        <?php if ($user): ?>
            <h1 class='head'>HESABIM</h1>  
            <p>Ad: <?= htmlspecialchars($user['user_name']) ?></p>
            <p>Soyad: <?= htmlspecialchars($user['user_surname']) ?></p>
            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
            <p>Telefon: <?= htmlspecialchars($user['phoneNumber']) ?></p>
            <a href="logout.php">Çıkış Yap</a>
        <?php else: ?>
            <h1 class='head'>GİRİŞ</h1>
            <form action="login_process.php" method="POST">
                <input type="email" name="email" placeholder="E-posta" required>
                <input type="password" name="password" placeholder="Şifre" required>
                <button type="submit">Giriş Yap</button>
            </form>

            <h2>Üye Ol</h2>
            <form action="register_process.php" method="POST">
                <input type="text" name="user_name" placeholder="Ad" required>
                <input type="text" name="user_surname" placeholder="Soyad" required>
                <input type="text" name="phoneNumber" placeholder="Telefon Numarası" required>
                <input type="text" name="tcKimlik" placeholder="T.C. Kimlik Numarası" required>
                <input type="email" name="email" placeholder="E-posta" required>
                <input type="password" name="password" placeholder="Şifre" required>
                <button type="submit">Üye Ol</button>
            </form>
        <?php endif; ?>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
