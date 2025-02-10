<?php
include_once '../includes/config.php'; // Veritabanı bağlantısını dahil et

// Tüm kategorileri çek
$query = "SELECT * FROM kategoriler";
$result = mysqli_query($conn, $query);

// Kategorileri listelemek için array
$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

// Kategori güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kategori_id = $_POST['kategori_id'];
    $yeni_ad = trim($_POST['yeni_ad']);

    if (!empty($kategori_id) && !empty($yeni_ad)) {
        $update_query = "UPDATE kategoriler SET kategori_ad = ? WHERE kategori_id = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "si", $yeni_ad, $kategori_id);

        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Kategori başarıyla güncellendi!";
        } else {
            $error_message = "Kategori güncellenirken hata oluştu!";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Lütfen tüm alanları doldurun!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/update_category.css">
    <title>Kategori Güncelle</title>
</head>
<body>
<?php include('admin_panel.php');?>
<div class="headerss">_</div>
<div style="display: flex; align-items: center; justify-content: center;">
<div class="container">
    
        <h1 class="title">Kategori Güncelle</h1>
        
        <?php if (isset($success_message)) : ?>
            <p class="success-message"><?= htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <?php if (isset($error_message)) : ?>
            <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form class="form" method="POST">
            <label class="label" for="kategori">Güncellenecek Kategori:</label>
            <select class="select" name="kategori_id" id="kategori">
                <option class="option" value="">Kategori Seçin</option>
                <?php foreach ($categories as $category) : ?>
                    <option class="option" value="<?= $category['kategori_id']; ?>">
                        <?= htmlspecialchars($category['kategori_ad']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label class="label" for="yeni_ad">Yeni Kategori Adı:</label>
            <input class="input" type="text" name="yeni_ad" id="yeni_ad" required>

            <button class="button" type="submit">Güncelle</button>
        </form>
    </div>
    </div>

</body>
</html>
