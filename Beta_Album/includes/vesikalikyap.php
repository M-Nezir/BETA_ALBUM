<?php
// Yükleme dizini
$target_dir = "../image/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

$uploadOk = 1;
$allowed_types = ["jpg", "jpeg", "png"];

// Dosya yükleme işlemi
if (isset($_POST["submit"]) && isset($_FILES["fileToUpload"])) {
    $file_name = $_FILES["fileToUpload"]["name"];
    $file_tmp = $_FILES["fileToUpload"]["tmp_name"];
    $file_size = $_FILES["fileToUpload"]["size"];
    $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($imageFileType, $allowed_types)) {
        echo "Sadece JPG, JPEG ve PNG formatları desteklenmektedir.<br>";
        $uploadOk = 0;
    }

    if ($file_size > 5000000) {
        echo "Dosya boyutu çok büyük! Maksimum 5MB olmalıdır.<br>";
        $uploadOk = 0;
    }

    if ($uploadOk) {
        $unique_name = uniqid() . "." . $imageFileType;
        $target_file = $target_dir . $unique_name;

        if (move_uploaded_file($file_tmp, $target_file)) {
            echo "Dosya başarıyla yüklendi: " . htmlspecialchars($unique_name) . "<br>";

            // Resmi oluştur
            if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
                $image = imagecreatefromjpeg($target_file);
            } elseif ($imageFileType == "png") {
                $image = imagecreatefrompng($target_file);
            }

            if ($image) {
                $width = 189;
                $height = 227;
                $new_image = imagecreatetruecolor($width, $height);
                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));

                // Filigran ekle
                $text_color = imagecolorallocate($new_image, 255, 255, 255);
                imagestring($new_image, 3, 5, 35, "FILIGRAN", $text_color);

                // Yeni resmi kaydet
                if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
                    imagejpeg($new_image, $target_file, 90);
                } elseif ($imageFileType == "png") {
                    imagepng($new_image, $target_file, 9);
                }

                imagedestroy($image);
                imagedestroy($new_image);

                // Görseli göster
                echo "<h3>Filigranlı Resim:</h3>";
                echo "<img src='" . $target_file . "' alt='Yüklenen Resim'><br>";
            } else {
                echo "Resim işlenirken hata oluştu.<br>";
            }
        } else {
            echo "Dosya yüklenirken hata oluştu.<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resim Yükleme</title>
</head>
<body>
    <h1>Resim Yükleyin</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" required>
        <input type="submit" value="Yükle" name="submit">
    </form>
</body>
</html>
