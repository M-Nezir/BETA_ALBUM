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
    <title>Ana Ekranı Düzenle</title>
</head>
<body>

<h2>Ana Sayfa Fotoğrafını Güncelle</h2>

<?php if (isset($_GET['success'])) { echo "<p style='color:green;'>Görsel başarıyla güncellendi!</p>"; } ?>
<?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

<form action="" method="post" enctype="multipart/form-data">
    <p>Mevcut Görsel:</p>
    <img src="<?php echo $main_image; ?>" width="300"><br><br>
    
    <label>Yeni Görsel Seç:</label>
    <input type="file" name="new_image" required><br><br>
    
    <button type="submit">Güncelle</button>
</form>

<a href="admin_panel.php">Admin Paneline Geri Dön</a>

</body>
</html>
