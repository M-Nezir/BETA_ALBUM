<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: ../admin_panel/admin_panel");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../image/beyaz logo.png">
    <style>

.giriş {
    width: 300px;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.giriş h2 {
    margin-bottom: 15px;
    color: #333;
}

.giriş label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
    color: #555;
}

.giriş input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.giriş button {
    width: 100%;
    padding: 10px;
    margin-top: 15px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.giriş button:hover {
    background: #2980b9;
}

    </style>
    <title>Admin Giriş</title>
</head>
<body>
    <div class="giriş">
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
    </div>
</body>
</html>
