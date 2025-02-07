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
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        //giriş başarılı. oturum aç
        $_SESSION['user_id'] = $user['id'];
        header("Location: login.php"); //kullanıcı giriş yaptıktan sonra yönlendir
        exit();
    } else {
        die("Geçersiz e-posta veya şifre.");
    }
} else {
    die("Geçersiz istek.");
}
?>
