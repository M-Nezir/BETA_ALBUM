<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: ../admin_panel/admin_panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giriş</title>
</head>
<body>
    <h2>Admin Girişi</h2>
    <form action="admin_login_process.php" method="POST">
        <label for="email">E-Posta:</label>
        <input type="email" name="admin_email" required>
        <br>
        <label for="password">Şifre:</label>
        <input type="password" name="admin_password" required>
        <br>
        <button type="submit">Giriş Yap</button>
    </form>
</body>
</html>
