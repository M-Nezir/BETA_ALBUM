<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beta_album";

//bağlantı oluşturma
$conn = new mysqli($servername, $username, $password, $dbname);

//bağlantıyı kontrol etme
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}
?>
