<?php
// Yükleme dizini
$target_dir = "../image"; // Burada yüklenen resimleri kaydedeceğiz
$uploadOk = 1;

// Dosya adı
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Resmin bir resim olup olmadığını kontrol et
if(isset($_POST["submit"])) {
    if (isset($_FILES["fileToUpload"])) {
        // Dosya var mı kontrol et
        if ($_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK) {
            echo "Dosya yüklenirken bir hata oluştu.<br>";
            $uploadOk = 0;
        } else {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "Dosya bir resim: " . $check["mime"] . ".<br>";
                $uploadOk = 1;
            } else {
                echo "Bu dosya bir resim değil.<br>";
                $uploadOk = 0;
            }
        }
    } else {
        echo "Dosya seçilmedi.<br>";
        $uploadOk = 0;
    }
}

// Dosya zaten var mı kontrol et
if (file_exists($target_file)) {
    echo "Üzgünüz, bu dosya zaten var.<br>";
    $uploadOk = 0;
}

// Dosya boyutunu kontrol et (maksimum 5MB)
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Üzgünüz, dosyanız çok büyük.<br>";
    $uploadOk = 0;
}

// Belirli dosya uzantılarına izin ver (JPEG, PNG, GIF)
if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
    echo "Üzgünüz, sadece JPG, JPEG ve PNG dosyalarına izin verilmektedir.<br>";
    $uploadOk = 0;
}

// Eğer $uploadOk 0 ise, yükleme engellendi
if ($uploadOk == 0) {
    echo "Üzgünüz, dosyanız yüklenemedi.<br>";
} else {
    // Benzersiz dosya ismi oluştur (çakışmayı önlemek için)
    $unique_name = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $unique_name;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Dosyanız başarıyla " . htmlspecialchars(basename($unique_name)) . " olarak yüklendi.<br>";

        // Yüklenen resmi al
        if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
            $image = imagecreatefromjpeg($target_file);
        } elseif ($imageFileType == "png") {
            $image = imagecreatefrompng($target_file);
        }

        if ($image === false) {
            echo "Resim yüklenirken bir hata oluştu.<br>";
        } else {
            // Resmin boyutlarını 60mm x 50mm olarak ayarla
            $width = 60;
            $height = 50;
            $new_image = imagescale($image, $width, $height);

            // Yeni resmi kaydedin
            imagejpeg($new_image, $target_file);

            // Hafızayı temizle
            imagedestroy($image);
            imagedestroy($new_image);

            // Resmi ekranda göster
            echo "<h3>Yüklenen Resim:</h3>";
            echo "<img src='" . $target_file . "' alt='Yüklenen Resim'><br>";
        }
    } else {
        echo "Üzgünüz, dosyanız yüklenirken bir hata oluştu.<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resim Yükleme ve Görüntüleme</title>
</head>
<body>
    <h1>Resim Yükleyin ve Görüntüleyin</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Resminizi seçin:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" required>
        <input type="submit" value="Resim Yükle" name="submit">
    </form>
</body>
</html>
