<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/backgraund.css">
    <link rel="stylesheet" href="../css/vesikalikyap.css">
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <title>Vesikalık Yap</title>
</head>
<body>
<?php include('navbar.php');?> 
<div class="main"> 
 
<?php
// Yükleme dizini
$target_dir = "../image/vesikaliklar/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

$uploadOk = 1;
$allowed_types = ["jpg", "jpeg", "png"];
$filigranli_dosya_yolu = "";

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

            // Resmi oluştur
            if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
                $image = imagecreatefromjpeg($target_file);
            } elseif ($imageFileType == "png") {
                $image = imagecreatefrompng($target_file);
            }

            // Orijinal resmin boyutlarını al
            $original_width = imagesx($image);
            $original_height = imagesy($image);

            // Yeni yüksekliği belirle (227px olarak)
            $new_height = 227;
            $new_width = 189;

            // Eğer resmin eni boyundan uzunsa
            if ($original_width > $original_height) {
                // Resmin boyunu 227px yaparken enini orantılı şekilde küçült
                $new_width = ($original_width / $original_height) * $new_height;

                // Yeni resim oluştur
                $new_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

                // Sağdan ve soldan kırpma işlemi
                $crop_x = ($new_width - 189) / 2;
                $crop_y = 0;

                $cropped_image = imagecreatetruecolor(189, 227);
                imagecopy($cropped_image, $new_image, 0, 0, $crop_x, $crop_y, 189, 227);
            }
            // Eğer resmin boyu eninden uzunsa
            else {
                // Resmin enini 189px yaparken boyunu orantılı şekilde küçült
                $new_height = ($original_height / $original_width) * $new_width;

                // Yeni resim oluştur
                $new_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

                // Üstten ve alttan kırpma işlemi
                $crop_x = 0;
                $crop_y = ($new_height - 227) / 2;

                $cropped_image = imagecreatetruecolor(189, 227);
                imagecopy($cropped_image, $new_image, 0, 0, $crop_x, $crop_y, 189, 227);
            }

            // Filigransız resmi kaydet
            $original_image_path = $target_file;
            imagejpeg($cropped_image, $original_image_path, 90);  // Filigransız resmi kaydediyoruz

            // Filigranlı resim oluşturulacak
            // Arka plan resmini yükle
            $background_image = imagecreatefromjpeg("../image/vesikaliklar/imgSize.jpeg");

            // Arka planın boyutlarını al
            $bg_width = 220;
            $bg_height = 271;

            // Arka planın üzerine kırpılmış resmi yerleştir
            imagecopy($background_image, $cropped_image, ($bg_width - 189) / 2, ($bg_height - 227) / 2, 0, 0, 189, 227);

            // Yazı rengi (Yarı saydam siyah)
            $text_color = imagecolorallocatealpha($background_image, 0, 0, 0, 100); // 100 şeffaflık seviyesi
            // Yazıyı ekleyelim
            imagestring($background_image, 5, 30, 30, "BETA COLOR", $text_color);
            imagestring($background_image, 5, 100, 50, "BETA COLOR", $text_color);
            imagestring($background_image, 5, 30, 70, "BETA COLOR", $text_color);
            imagestring($background_image, 5, 100, 90, "BETA COLOR", $text_color);
            imagestring($background_image, 5, 30, 110, "BETA COLOR", $text_color);
            imagestring($background_image, 5, 100, 130, "BETA COLOR", $text_color);
            imagestring($background_image, 5, 30, 150, "BETA COLOR", $text_color);
            imagestring($background_image, 5, 100, 170, "BETA COLOR", $text_color);
            imagestring($background_image, 5, 30, 190, "BETA COLOR", $text_color);
            imagestring($background_image, 5, 100, 210, "BETA COLOR", $text_color);
            imagestring($background_image, 5, 30, 230, "BETA COLOR", $text_color);
            

            // Filigranlı resmi kaydet
            $filigranli_name = "filigranlı_" . $unique_name;
            $filigranli_dosya_yolu = $target_dir . $filigranli_name;

            // Filigranlı resmin kaydedilmesi
            if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
                imagejpeg($background_image, $filigranli_dosya_yolu, 90);
            } elseif ($imageFileType == "png") {
                imagepng($background_image, $filigranli_dosya_yolu, 9);
            }

            imagedestroy($image);
            imagedestroy($new_image);
            imagedestroy($cropped_image);
            imagedestroy($background_image);

        } else {
            echo "Dosya yüklenirken hata oluştu.<br>";
        }
    }
}
?>


<div class="container"> 
    <h1 class="page-title">VESİKALIK OLUŞTURUN</h1>
    <div class="container">
    <div class="row">
        <div class="col-sm-5" style="padding: 8px 8px 12px 8px;">
        <p style="margin-top: 1%; margin-bottom: 3%;">
    Lütfen sağ tarafta görünen şekilde beyaz bir duvarın önüne geçerek ve fotoğrafta kendinizi ortalayarak çekindiğiniz bir fotoğraf ile işlem yapınız.
</p>
<form action="" method="post" enctype="multipart/form-data" class="upload-form">
                <input type="file" name="fileToUpload" accept="image/jpeg, image/png" required class="file-input">
                <input type="submit" value="Yükle" name="submit" class="btn-primary">
            </form>

            <div class="image-preview">
                <hr>
                <?php if (!empty($filigranli_dosya_yolu)) : ?>
                    <h3 class="preview-title">Önizleme:</h3>
                    <img src="<?= $filigranli_dosya_yolu ?>" alt="Yüklenen Filigranlı Resim" class="uploaded-image">
                    <div style="display: flex; justify-content:center;">
                        <button id="paymentButton" class="btn-secondary">Ödeme Yap</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-sm-5 offset-sm-1" style="margin-bottom: 3%; padding: 8px 8px 12px 8px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6" style="text-align:center;">
                        <h4>Öncesi</h4>
                        <img src="../image/source03.png" class="center-block img-responsive img-thumbnail" alt="beta albüm">
                    </div>
                    <div class="col-sm-6" style="text-align:center;">
                        <h4>Sonrası</h4>
                        <img src="../image/canada_visa_photo.webp" class="center-block img-responsive img-thumbnail" alt="beta albüm">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        

</div>
    </div>
    <?php include('footer.php');?>
</body>
</html>
