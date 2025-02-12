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
        
        // HATALI KISIM DÜZELTİLDİ: Şifre doğrulama `password_verify()` ile yapıldı.
        if (password_verify($password, $admin_password)) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_email'] = $admin_email;
            header("Location: ../admin_panel/admin_panel");
            exit();
        } else {
            echo "<h2 style='text-align: center; margin-top: 3%;'>❌ Hatalı şifre. Tekrar deneyin.</h2>
                    <div style='text-align: center;'><a href='adminlogin'> Tekrar Dene</a></div>";
        }
    } else {
        echo " <h2 style='text-align: center; margin-top: 3%;>❌ Bu e-posta ile kayıtlı admin bulunamadı.</h2>";
    }
    $stmt->close();
    $conn->close();
}
?>
