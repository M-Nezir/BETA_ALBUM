<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //formdan gelen verileri alma
    $user_name = trim($_POST['user_name']);
    $user_surname = trim($_POST['user_surname']);
    $phoneNumber = trim($_POST['phoneNumber']);
    $tcKimlik = trim($_POST['tcKimlik']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    //boş alan kontrolü
    if (empty($user_name) || empty($user_surname) || empty($phoneNumber) || empty($tcKimlik) || empty($email) || empty($password)) {
        die("Lütfen tüm alanları doldurun.");
    }

    //e-posta veya TC zaten kayıtlı mı?
    $query = $conn->prepare("SELECT * FROM kullanicilar WHERE email = ? OR tcKimlik = ?");
    $query->bind_param("ss", $email, $tcKimlik);
    $query->execute();
    $result = $query->get_result(); 

    if ($result->num_rows > 0) {  // rowCount() yerine num_rows kullanıyoruz
        die("Bu e-posta veya T.C. Kimlik Numarası zaten kayıtlı.");
    }

    //şifreyi hashleme
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    //kullanıcıyı veritabanına ekle
    $query = $conn->prepare("INSERT INTO kullanicilar (user_name, user_surname, phoneNumber, tcKimlik, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $insert = $query->execute([$user_name, $user_surname, $phoneNumber, $tcKimlik, $email, $hashed_password]);

    if ($insert) {
        $_SESSION['user_id'] = $conn->insert_id; // lastInsertId() yerine insert_id kullan
        header("Location: login.php");
        exit();
    } else {
        die("Kayıt işlemi başarısız oldu.");
    }    
} else {
    die("Geçersiz istek.");
}
?>
