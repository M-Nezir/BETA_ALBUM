<?php
session_start();

$target_dir = "../image/";
$watermark_path = "betaalbümkare.png";

if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

if (isset($_POST["upload"]) && isset($_FILES["fileToUpload"])) {
    $file_name = $_FILES["fileToUpload"]["name"];
    $file_tmp = $_FILES["fileToUpload"]["tmp_name"];
    $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_types = ["jpg", "jpeg", "png"];
    
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Sadece JPG, JPEG ve PNG formatları desteklenmektedir.";
    } else {
        $unique_name = uniqid() . "." . $imageFileType;
        $target_file = $target_dir . $unique_name;
        
        if (move_uploaded_file($file_tmp, $target_file)) {
            $_SESSION['uploaded_image'] = $target_file;
            echo "Dosya başarıyla yüklendi. <br>";
        }
    }
}

if (isset($_POST["purchase"])) {
    if (isset($_SESSION['uploaded_image'])) {
        $imagePath = $_SESSION['uploaded_image'];
        unset($_SESSION['uploaded_image']); // Satın alma işlemi gerçekleştiğinde session temizlenir
        echo "Satın alma başarılı! Filigransız resminiz: <br>";
        echo "<img src='$imagePath' alt='Filigransız Resim'><br>";
    }
}

if (!isset($_POST["purchase"]) && isset($_SESSION['uploaded_image'])) {
    register_shutdown_function(function() {
        if (file_exists($_SESSION['uploaded_image'])) {
            unlink($_SESSION['uploaded_image']);
        }
        unset($_SESSION['uploaded_image']);
    });
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Resim Yükleme</title>
</head>
<body>
    <h1>Resim Yükleyin</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" required>
        <input type="submit" value="Yükle" name="upload">
    </form>
    
    <?php if (isset($_SESSION['uploaded_image'])): ?>
        <h2>Önizleme</h2>
        <img src="<?php echo $_SESSION['uploaded_image']; ?>" alt="Önizleme" width="200"><br>
        <form action="" method="post">
            <input type="submit" value="Satın Al" name="purchase">
        </form>
    <?php endif; ?>
</body>
</html>
