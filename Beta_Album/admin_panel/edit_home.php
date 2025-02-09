<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/adminlogin.php");
    exit();
}

include('../includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["new_image"])) {
    $target_dir = "../image/";
    $target_file = $target_dir . basename($_FILES["new_image"]["name"]);

    if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
        $file_path = "image/" . basename($_FILES["new_image"]["name"]);

        // Veritabanındaki resmi güncelle
        $updateQuery = "UPDATE settings SET main_image = '$file_path' WHERE id = 1";
        mysqli_query($conn, $updateQuery);

        header("Location: edit_home.php?success=1");
        exit();
    } else {
        $error = "Dosya yüklenirken bir hata oluştu.";
    }
}

// Mevcut resmi al
$query = "SELECT main_image FROM settings LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$main_image = $row['main_image'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/edit_home.css">
    <title>Ana Ekranı Düzenle</title>
</head>
<body>
<?php include('admin_panel.php'); ?>
<div class="image_updatee">
<div class="update-container">
    <div class="update-title">Ana Sayfa Fotoğrafını Güncelle</div>

    <?php if (isset($_GET['success'])) { ?>
        <div class="update-message success-message">Görsel başarıyla güncellendi!</div>
    <?php } ?>
    <?php if (isset($error)) { ?>
        <div class="update-message error-message"><?php echo $error; ?></div>
    <?php } ?>

    <form action="" method="post" enctype="multipart/form-data" class="update-form">
        <div class="form-group">
            <div class="form-label">Mevcut Görsel:</div>
            <div class="form-image">
                <img src="<?php echo "/BETA_ALBUM/Beta_Album/$main_image"; ?>" alt="Mevcut Görsel" class="current-image">
            </div>
        </div>

        <div class="form-group">
            <label for="new_image" class="form-label">Yeni Görsel Seç:</label>
            <input type="file" name="new_image" id="new_image" class="form-input" required>
        </div>

        <div class="form-group">
            <button type="submit" class="form-button">Güncelle</button>
        </div>
    </form>
</div>

</div>
</body>
</html>
