<?php
session_start();
session_destroy(); //tüm oturum verilerini sil
header("Location: ../index"); //kullanıcıyı giriş sayfasına yönlendir
exit();
?>
