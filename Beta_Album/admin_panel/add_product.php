<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/adminlogin.php");
    exit();
}

include('../includes/config.php');

// Kategori seçildiğinde ürünleri çek
if (isset($_GET['kategori_id'])) {
    $_SESSION['kategori_id'] = $_GET['kategori_id']; // Seçilen kategoriyi session'a kaydet
} elseif (!isset($_SESSION['kategori_id'])) {
    $_SESSION['kategori_id'] = null;
}

$id = $_SESSION['kategori_id'];

if ($id) {
    // kategori ismini al
    $kategori_sql = "SELECT kategori_ad FROM kategoriler WHERE kategori_id = ?";
    $stmt = $conn->prepare($kategori_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $kategori_result = $stmt->get_result();
    $kategori = $kategori_result->fetch_assoc();

    // kategori varsa ürünleri çek
    if ($kategori) {
        $urun_sql = "SELECT * FROM urunler WHERE kategori_id = ?";
        $stmt = $conn->prepare($urun_sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $urun_result = $stmt->get_result();
    } else {
        $urun_result = null;
    }
} else {
    $urun_result = null;
}

// Ürün ekleme işlemi
if (isset($_POST['add_product'])) {
    $urun_ad = $_POST['urun_ad'];
    $urun_fiyat = $_POST['urun_fiyat'];

    // Dosya yükleme işlemi
    $target_dir = "../image/"; // Kayıt edilecek dizin
    $target_file = $target_dir . basename($_FILES["urun_gorsel"]["name"]);
    move_uploaded_file($_FILES["urun_gorsel"]["tmp_name"], $target_file);

    $urun_gorsel = basename($_FILES["urun_gorsel"]["name"]); // DB'ye kaydedilecek dosya adı

    $insert_sql = "INSERT INTO urunler (urun_ad, urun_fiyat, urun_gorsel, kategori_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sdsi", $urun_ad, $urun_fiyat, $urun_gorsel, $id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Ürün başarıyla eklendi.';
    } else {
        $_SESSION['error_message'] = 'Ürün ekleme işlemi başarısız oldu.';
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "?kategori_id=" . $id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/add_products.css">
    <title>Ürün Yönetimi</title>
</head>
<body>
<?php include('admin_panel.php'); ?>
<div class="all">
    <div class="headers">
        <?php 
        echo "<form method='GET' action=''>";
        echo "<select name='kategori_id' id='kategori' onchange='this.form.submit()'>";
        echo "<option value='' disabled selected>Kategori Seçiniz</option>"; // Başlangıç seçeneği
        $sql = "SELECT * FROM kategoriler";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['kategori_id'] . "'" . ($id == $row['kategori_id'] ? ' selected' : '') . ">" . $row['kategori_ad'] . "</option>";
            }
        } else {
            echo "<option>Hiç kategori bulunmamaktadır.</option>";
        }
        echo "</select>";
        echo "</form>";
        ?>
        <span>Ürün Ekle</span>
    </div>

    <div class="add-product-form" style="margin-left: 35%;">

<form method="POST" action="" enctype="multipart/form-data">
<div style="text-align: center; background-color:rgb(204, 204, 204); display: flex; flex-direction: column; justify-content: center; align-items: center; margin: 0;">
    <h1 style="margin: 0; padding: 5%;">YENİ ÜRÜN</h1>
    <?php if ($id && isset($kategori['kategori_ad'])): ?>
        <p style="margin: 0;">Seçili Kategori: <strong><?php echo htmlspecialchars($kategori['kategori_ad']); ?></strong></p>
    <?php endif; ?>
</div>

<div class="input-container">
    <label>Ürün Adı:</label>
    <input type="text" name="urun_ad" required>
</div>
<div class="input-container">
    <label>Ürün Fiyatı:</label>
    <input type="number" name="urun_fiyat" step="0.01" required>
</div>
<div class="input-container" style="margin-bottom: 5%;">
    <label>Ürün Görseli:</label>
    <input type="file" class="search_image" name="urun_gorsel" accept="image/*" required>
</div>
<button type="submit" name="add_product" class="add-button">+ Ekle</button>
</form>
</div>


    <div class="product-list">
        <?php
        if ($urun_result && $urun_result->num_rows > 0) {
            while ($row = $urun_result->fetch_assoc()) {
                
                echo "<div class='product'>"; 
                echo "<div style='height: 50vh; width: 50vh;'>";
                echo "<img src='../image/" . htmlspecialchars($row['urun_gorsel']) . "' alt='Ürün Görseli'>";
                echo "</div>";
                echo "<h4>" . htmlspecialchars($row['urun_ad']) . "</h4>";
                echo "<p>Fiyat: " . htmlspecialchars($row['urun_fiyat']) . " TL</p>";
                echo "</div>";
            }
        } else {
            echo "<div class='error-container'><p class='error'>Bu kategoride ürün bulunmamaktadır<br> lütfen sol üstten yeni bir kategori seçiniz.</p></div>";
        }
        ?>
    </div>
</div>

<?php
if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
    unset($_SESSION['error_message']);
}
?>
</body>
</html>
