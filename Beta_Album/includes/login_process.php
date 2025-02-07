<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    //boş alan kontrolü
    if (empty($email) || empty($password)) {
        die("Lütfen tüm alanları doldurun.");
    }

    //kullanıcıyı veritabanında bul
    $query = $conn->prepare("SELECT * FROM kullanicilar WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();  // Sonuçları al

    if ($user = $result->fetch_assoc()) {  
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
    
            header("Location: login.php");
        exit();
        } else {
            die("Geçersiz e-posta veya şifre.");
        }
    } else {
        die("Bu e-posta ile kayıtlı bir kullanıcı bulunamadı.");
    }    
} else {
    die("Geçersiz istek.");
}
?>
