<?php
session_start();
require_once "../includes/config.php"; // Veritabanı bağlantısı

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/adminlogin");
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
    <link rel="stylesheet" href="../css/admin_panel.css">
    <link rel="stylesheet" href="../css/update_admin.css">
</head>
<?php include('admin_panel.php'); ?>
<body>
<div class="admina_container">
    <div class="admina_title">Admin Bilgilerini Güncelle</div>
    <form method="POST">
    <div class="admina_message admina_success"><?php if ($success) echo $success; ?></div>
    <div class="admina_message admina_error"><?php if ($error) echo $error; ?></div>

    <div class="admina_form">
        <div class="admina_label">Yeni Email:</div>
        <div class="admina_input">
            <input class="admina_input_field" type="email" name="new_email" required>
        </div>

        <div class="admina_label">Yeni Şifre:</div>
        <div class="admina_input">
            <input class="admina_input_field" type="password" name="new_password" required>
        </div>

        <div class="admina_button">
            <button class="admina_submit" type="submit">Güncelle</button>
        </div>
    </div>
    </form>
</div>

</body>
</html>
