<?php
// Oturumu başlat ve yetkilendirme kontrolü
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/adminlogin");
    exit();
}

// Veritabanı bağlantısı
include '../includes/config.php'; // Bağlantı dosyanı buraya ekle

// Eğer form gönderildiyse güncelleme yap
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['prices'] as $id => $new_price) {
        $id = intval($id);
        $new_price = floatval($new_price);
        $query = "UPDATE fotograf_fiyatlari SET fiyat = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("di", $new_price, $id);
        $stmt->execute();
    }
    $success = "Fiyatlar başarıyla güncellendi!";
}

// Mevcut fiyatları çek
$query = "SELECT * FROM fotograf_fiyatlari ORDER BY kategori, ebat, adet";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotoğraf Fiyatlarını Güncelle</title>
    <style>

.table-container{
    margin-left: 20%;
}
.page-title {
    text-align: center;
    color: #34495e;
    font-size: 24px;
    margin-bottom: 20px;
    margin-top: 0;
    padding-top: 3%;
}

.success-message {
    color: #27ae60;
    text-align: center;
    font-weight: bold;
}

.price-update-form {
    max-width: 800px;
    margin: auto;
    background-color: #ecf0f1;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.price-table {
    width: 100%;
    border-collapse: collapse;
}

.table-header {
    background-color: #34495e;
    color: white;
    font-weight: bold;
}

.table-row:nth-child(even) {
    background-color: #f8f9fa;
}

.category-cell, .size-cell, .quantity-cell, .price-cell {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.price-input {
    width: 80px;
    padding: 5px;
    border: 1px solid #bdc3c7;
    border-radius: 5px;
    text-align: center;
}

.update-button {
    display: block;
    width: 100%;
    background-color: #2980b9;
    color: white;
    padding: 10px;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    margin-top: 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.update-button:hover {
    background-color: #1f618d;
}
.metin{
    display: none;
}

.uyari{
    display: block;
    text-align: center;
}
    </style>
</head>
<body>
<?php include('admin_panel.php'); ?>
<div class="table-container">


<h2 class="page-title">Fotoğraf Fiyatlarını Güncelle</h2>
<span class="uyari"><span style="color: red; font-size: 150%;">UYARI:</span> güncelleme Yaptıktan Sonra En Altta Bulunan "Fiyatları Güncelle" Butonuna Tıklamayı Unutmayınız!</span>
<?php if (isset($success)) echo "<p class='success-message'>$success</p>"; ?>

<form method="post" class="price-update-form">
    <table border="1" class="price-table">
        <tr class="table-header">
            <th class="column-category">Kategori</th>
            <th class="column-size">Ebat</th>
            <th class="column-quantity">Adet</th>
            <th class="column-price">Fiyat (TL)</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="table-row">
                <td class="category-cell"><?php echo htmlspecialchars($row['kategori']); ?></td>
                <td class="size-cell"><?php echo htmlspecialchars($row['ebat']); ?></td>
                <td class="quantity-cell"><?php echo htmlspecialchars($row['adet']); ?></td>
                <td class="price-cell">
                    <input type="number" step="0.01" name="prices[<?php echo $row['id']; ?>]" 
                           value="<?php echo htmlspecialchars($row['fiyat']); ?>" required class="price-input">
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <button type="submit" class="update-button">Fiyatları Güncelle</button>
</form>
</div>

</body>
</html>
