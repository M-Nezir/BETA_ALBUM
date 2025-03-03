<?php
// Yükleme dizini
$upload_dir = "uploads/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Fotoğraf işleme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photo'])) {
    $file_name = time() . "_" . basename($_FILES["photo"]["name"]);
    $target_file = $upload_dir . $file_name;
    $clean_file = $upload_dir . "clean_" . $file_name;

    $allowed_types = ["image/jpeg", "image/png"];
    $file_type = mime_content_type($_FILES["photo"]["tmp_name"]);

    if (!in_array($file_type, $allowed_types)) {
        die("Sadece JPG ve PNG dosyaları yüklenebilir.");
    }

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        resizeImage($target_file, 600, 800);
        copy($target_file, $clean_file);
        addWatermark($target_file, "Filigran - Ödeme Sonrası Kaldırılacak");
    } else {
        die("Yükleme sırasında hata oluştu.");
    }
}

// Fotoğraf yeniden boyutlandırma
function resizeImage($file, $width, $height) {
    $image = imagecreatefromstring(file_get_contents($file));
    $resized = imagescale($image, $width, $height);
    imagejpeg($resized, $file);
}

// Filigran ekleme
function addWatermark($file, $text) {
    $image = imagecreatefromjpeg($file);
    $color = imagecolorallocate($image, 255, 0, 0);
    $font = 5;
    $x = imagesx($image) / 4;
    $y = imagesy($image) - 30;
    imagestring($image, $font, $x, $y, $text, $color);
    imagejpeg($image, $file);
}

// Ödeme sonrası dosya indirme
if (isset($_GET['file'])) {
    $file_name = $_GET['file'];
    $clean_file = $upload_dir . "clean_" . $file_name;

    if (!file_exists($clean_file)) {
        die("Dosya mevcut değil.");
    }

    echo "<h2>Ödeme Başarılı!</h2>";
    echo "<p>Filigransız fotoğrafınızı aşağıdan indirebilirsiniz.</p>";
    echo "<a href='$clean_file' download>İndir</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2 Saniyede Vesikalık</title>
</head>
<body>
    <h2>Fotoğraf Yükleyin</h2>
    <form action="vesikalik.php" method="post" enctype="multipart/form-data">
        <input type="file" name="photo" accept="image/*" required>
        <input type="submit" value="Vesikalık Yap">
    </form>

    <?php if (!empty($target_file)): ?>
        <h2>Filigranlı Vesikalık Fotoğraf</h2>
        <img src="<?= $target_file ?>" width="150">
        <br>
        <a href="vesikalik.php?file=<?= urlencode($file_name) ?>">Ödeme Yap ve Filigranı Kaldır</a>
    <?php endif; ?>
</body>
</html>