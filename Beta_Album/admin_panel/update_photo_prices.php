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
</head>
<body>

<div class="menu">
    <a href="admin_panel.php">← Admin Panele Dön</a>
</div>

<h2>Fotoğraf Fiyatlarını Güncelle</h2>

<?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post">
    <table border="1">
        <tr>
            <th>Kategori</th>
            <th>Ebat</th>
            <th>Adet</th>
            <th>Fiyat (TL)</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                <td><?php echo htmlspecialchars($row['ebat']); ?></td>
                <td><?php echo htmlspecialchars($row['adet']); ?></td>
                <td>
                    <input type="number" step="0.01" name="prices[<?php echo $row['id']; ?>]" 
                           value="<?php echo htmlspecialchars($row['fiyat']); ?>" required>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <button type="submit">Fiyatları Güncelle</button>
</form>

</body>
</html>
