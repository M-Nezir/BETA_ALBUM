<?php
session_start();
require_once "../includes/config.php"; // Veritabanı bağlantısı

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/adminlogin.php");
    exit();
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST["new_email"];
    $new_password = $_POST["new_password"];
    $admin_id = 1; // Tek admin olduğu için ID sabit

    if (!empty($new_email) && !empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $query = "UPDATE admin SET admin_email = ?, admin_password = ? WHERE admin_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $new_email, $hashed_password, $admin_id);

        if ($stmt->execute()) {
            $success = "Admin bilgileri başarıyla güncellendi!";
        } else {
            $error = "Güncelleme sırasında bir hata oluştu.";
        }

        $stmt->close();
    } else {
        $error = "Lütfen tüm alanları doldurun.";
    }
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Bilgilerini Güncelle</title>
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/admin_panel.css">
</head>
<body>
    <div class="container">
        <h2>Admin Bilgilerini Güncelle</h2>
        <?php if ($success) echo "<p style='color: green;'>$success</p>"; ?>
        <?php if ($error) echo "<p style='color: red;'>$error</p>"; ?>

        <form method="POST">
            <label for="new_email">Yeni Email:</label>
            <input type="email" name="new_email" required>

            <label for="new_password">Yeni Şifre:</label>
            <input type="password" name="new_password" required>

            <button type="submit">Güncelle</button>
        </form>
        <br>
        <a href="admin_panel.php">Geri Dön</a>
    </div>
</body>
</html>
