<?php
include 'config.php'; // Veritabanı bağlantısı

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kategori = $_POST['kategori'];
    $ebat = $_POST['ebat'];
    $adet = intval($_POST['adet']);

    $stmt = $conn->prepare("SELECT fiyat FROM fotograf_fiyatlari WHERE kategori = ? AND ebat = ? AND adet = ?");
    $stmt->bind_param("ssi", $kategori, $ebat, $adet);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode(["fiyat" => $row['fiyat']]);
    } else {
        echo json_encode(["fiyat" => "Fiyat bulunamadı"]);
    }
}
?>
