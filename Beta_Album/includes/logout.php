<?php
session_start();
session_destroy(); //tüm oturum verilerini sil
header("Location: ../index.php"); //kullanıcıyı giriş sayfasına yönlendir
exit();
?>
