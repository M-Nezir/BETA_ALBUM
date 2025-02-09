<?php
session_start();
require_once "config.php"; // Veritabanı bağlantısını içe aktar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['admin_email'];
    $password = $_POST['admin_password'];

    $stmt = $conn->prepare("SELECT admin_id, admin_email, admin_password FROM admin WHERE admin_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id, $admin_email, $admin_password);
        $stmt->fetch();
        
        // 🔥 HATALI KISIM DÜZELTİLDİ: Şifre doğrulama `password_verify()` ile yapıldı.
        if (password_verify($password, $admin_password)) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_email'] = $admin_email;
            header("Location: ../admin_panel/admin_panel.php");
            exit();
        } else {
            echo "❌ Hatalı şifre. Tekrar deneyin.";
        }
    } else {
        echo "❌ Bu e-posta ile kayıtlı admin bulunamadı.";
    }
    $stmt->close();
    $conn->close();
}
?>
