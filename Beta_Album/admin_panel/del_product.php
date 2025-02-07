<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/adminlogin.php");
    exit();
}
?>

<?php
session_start(); // Session başlat

include('../includes/config.php');

// Kategori seçildiğinde ürünleri çek
if (isset($_GET['kategori_id'])) {
    $_SESSION['kategori_id'] = $_GET['kategori_id']; // Seçilen kategoriyi session'a kaydet
} elseif (!isset($_SESSION['kategori_id'])) {
    $_SESSION['kategori_id'] = null; // Eğer kategori seçilmemişse null ata
}

$id = $_SESSION['kategori_id']; // Session'daki kategori ID'yi al

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

// Ürün silme işlemi
if (isset($_POST['delete_product'])) {
    $urun_id = $_POST['urun_id'];
    $delete_sql = "DELETE FROM urunler WHERE urun_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $urun_id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Ürün başarıyla silindi.';
        header("Location: " . $_SERVER['PHP_SELF'] . "?kategori_id=" . $id); // Sayfayı yenilerken kategori bilgisini koru
        exit;
    } else {
        $_SESSION['error_message'] = 'Ürün silme işlemi başarısız oldu.';
        header("Location: " . $_SERVER['PHP_SELF'] . "?kategori_id=" . $id); // Sayfayı yenilerken kategori bilgisini koru
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/del_products.css">
    <title>Ürün Sil</title>
</head>
<body>
<?php include('admin_panel.php');?>

<div class="all">
    <div class="headers">
        <?php 
        // Kategorileri select box içinde listele
        echo "<form method='GET' action=''>";
        echo "<select name='kategori_id' id='kategori' onchange='this.form.submit()'>";
        $sql = "SELECT * FROM kategoriler";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Kategorileri çek
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['kategori_id'] . "'" . ($id == $row['kategori_id'] ? ' selected' : '') . ">" . $row['kategori_ad'] . "</option>";
            }
        } else {
            echo "<option>Hiç kategori bulunmamaktadır.</option>";
        }
        echo "</select>";
        echo "</form>";
        ?>
        <span>Ürün Sil</span>
    </div>

    <div class="product-list">
       <?php

        // Seçilen kategoriye ait ürünleri listele
        if ($urun_result && $urun_result->num_rows > 0) {
            while ($row = $urun_result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<img src='/BETA_ALBUM/Beta_Album/image/" . htmlspecialchars($row['urun_gorsel']) . "' alt='Ürün Görseli'>";
                echo "<h4>" . htmlspecialchars($row['urun_ad']) . "</h4>";
                echo "<p>Fiyat: " . htmlspecialchars($row['urun_fiyat']) . " TL</p>";
                echo "<form method='POST' action=''>";
                echo "<input type='hidden' name='urun_id' value='" . $row['urun_id'] . "'>";
                echo "<button type='submit' name='delete_product' class='product_del'>Sil</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<div class='error-container'>";
            echo "<p class='error'>Maalesef Bu Kategoride Ürün Bulunmamaktadır.</p>";
            echo "<i class='fa-solid fa-xmark'></i>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<?php
// Sayfa yeniden yüklendikten sonra session'dan mesajı alıp göster
if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']); // Mesajı gösterdikten sonra session'dan kaldır
}

if (isset($_SESSION['error_message'])) {
    echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
    unset($_SESSION['error_message']); // Mesajı gösterdikten sonra session'dan kaldır
}
?>

</body>
</html>
