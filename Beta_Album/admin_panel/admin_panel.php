<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/adminlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/admin_panel.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Admin Panel</title>
</head>
<body>

<div class="menu">

   <div class="header-container">
    <a href="/BETA_ALBUM/Beta_Album/admin_panel/admin_panel.php" style="text-decoration: none; color: black;">
   <b class="header">BETA ALBUM&trade;</b> <br>
   Admin Panel
   </a>
   </div>

   <div class="menu-item">
    <a href="/BETA_ALBUM/Beta_Album/admin_panel/add_product.php"><i class="fa-solid fa-plus"></i>Ürün Ekle</a>
   </div>

   <div class="menu-item">
    <a href="/BETA_ALBUM/Beta_Album/admin_panel/del_product.php"><i class="fa-solid fa-trash"></i>Ürün Sil</a>
   </div>

   <div class="menu-item">
    <a href="/BETA_ALBUM/Beta_Album/admin_panel/upload_product.php"><i class="fa fa-edit"></i>Ürün Güncelle</a>
   </div>

    <div class="menu-item">
     <a href="/BETA_ALBUM/Beta_Album/admin_panel/view_orders.php"><i class="fa-solid fa-truck-fast"></i>Siparişleri Görüntüle</a>
    </div>

    <div class="menu-item">
        <a href="../includes/logout.php">
            <button>Çıkış Yap</button>
        </a>
    </div>

</div>
<div style="margin-left: 20%;">
    <h1 style="margin-top: 0; margin-left: 32%; padding-top: 3%; ">Admin Panele Hoşgeldiniz</h1>
    <span>Admin panelde sipariş takibi ayrıca ürün ekleme,silme ve güncelleme işlemlerini yapabilirsiniz</span>
</div>


</body>
</html>