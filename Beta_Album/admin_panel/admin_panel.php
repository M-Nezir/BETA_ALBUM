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
    <style>
        .metin {
    width: 98%;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.metin h1 {
    padding-left: 50%;
    margin: 0;
    font-size: 24px;
    color: #333;
}

.metin span {
    margin-left: 20%;
    display: block;
    text-align: center;
    margin-top: 10px;
    font-size: 16px;
    color: #555;
}

    </style>
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
        <a href="/BETA_ALBUM/Beta_Album/admin_panel/update_admin.php">
            <i class="fa-solid fa-user-cog"></i> Admin Bilgilerini Güncelle
        </a>
    </div>

    <div class="menu-item">
        <a href="/BETA_ALBUM/Beta_Album/admin_panel/edit_home.php"><i class="fa-solid fa-image"></i>Ana Ekranı Düzenle</a>
    </div>

    <div class="menu-item">
        <a href="../includes/logout.php">
            <button>Çıkış Yap</button>
        </a>
    </div>

</div>
<div class="metin">
    <h1>Admin Panele Hoşgeldiniz</h1>
    <span>Admin panelde ürün ekleme, silme, güncelleme ve ayrıca sipariş takibi işlemlerini sol tarafta görmüş olsuğunuz menüden yapabilirsiniz.</span>
</div>


</body>
</html>