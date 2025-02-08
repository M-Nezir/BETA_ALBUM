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

// Ürün güncelleme işlemi
if (isset($_POST['update_product'])) {
    $urun_id = $_POST['urun_id'];
    $urun_ad = $_POST['urun_ad'];
    $urun_fiyat = $_POST['urun_fiyat'];

    if (isset($_FILES["urun_gorsel"]) && $_FILES["urun_gorsel"]["error"] == 0) {
        // Dosya yükleme işlemi
        $target_dir = "../image/"; // Kayıt edilecek dizin
        $target_file = $target_dir . basename($_FILES["urun_gorsel"]["name"]);
        move_uploaded_file($_FILES["urun_gorsel"]["tmp_name"], $target_file);

        $urun_gorsel = basename($_FILES["urun_gorsel"]["name"]); // DB'ye kaydedilecek dosya adı

        $update_sql = "UPDATE urunler SET urun_ad = ?, urun_fiyat = ?, urun_gorsel = ? WHERE urun_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sdsi", $urun_ad, $urun_fiyat, $urun_gorsel, $urun_id);
    } else {
        $update_sql = "UPDATE urunler SET urun_ad = ?, urun_fiyat = ? WHERE urun_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sdi", $urun_ad, $urun_fiyat, $urun_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Ürün başarıyla güncellendi.';
    } else {
        $_SESSION['error_message'] = 'Ürün güncelleme işlemi başarısız oldu.';
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
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/upload_products.css">
    <title>Ürün Yönetimi</title>

    <script>
        // JavaScript: Formları açma/kapama işlemi
        function toggleUpdateForm(urun_id) {
            // Tüm formları kapat
            var forms = document.querySelectorAll('.upload-container');
            forms.forEach(function(form) {
                form.style.display = 'none';
            });

            // Seçilen ürünün formunu göster
            var form = document.getElementById('updateForm' + urun_id);
            if (form) {
                form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
            }
        }
    </script>
</head>
<body>
<?php include('admin_panel.php'); ?>
<div class="all">
    <div class="headers">
        <?php 
        echo "<form method='GET' action=''>";
        echo "<select name='kategori_id' id='kategori' onchange='this.form.submit()'>";
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
        <span>Ürün Güncelle</span>
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
                echo "<button  style='width: 100%;' onclick=\"toggleUpdateForm(" . $row['urun_id'] . ")\">Güncelle</button>";

                // Güncelleme formunu gizli olarak göster
                echo "<div id='updateForm" . $row['urun_id'] . "' style='display:none;' class='upload-container'>";
                echo "<form method='POST' action='' enctype='multipart/form-data'>";
                echo "<input type='hidden' name='urun_id' value='" . $row['urun_id'] . "'>";
                
                // Ürün Adı
                echo "<div style='margin-bottom: 10px;'>";
                echo "<label>Ürün Adı:</label>";
                echo "<input type='text' name='urun_ad' value='" . htmlspecialchars($row['urun_ad']) . "' required>";
                echo "</div>";
                
                // Ürün Fiyatı
                echo "<div style='margin-bottom: 10px;'>";
                echo "<label>Ürün Fiyatı:</label>";
                echo "<input type='number' name='urun_fiyat' step='0.01' value='" . htmlspecialchars($row['urun_fiyat']) . "' required>";
                echo "</div>";
                
                // Ürün Görseli
                echo "<div style='margin-bottom: 10px;'>";
                echo "<label>Ürün Görseli:</label>";
                echo "<input type='file' name='urun_gorsel' accept='image/*'>";
                echo "</div>";

                echo "<div style='text-align: center;'>";
                echo "<button type='submit' name='update_product'>Güncelle</button>";
                echo "</div>";

                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='error-container'><p class='error'>Bu kategoride ürün bulunmamaktadır.</p></div>";
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
