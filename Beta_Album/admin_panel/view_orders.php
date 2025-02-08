<?php
session_start();
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
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/products_operations.css">
    <style>
        .metin{
    display: none;
}
    </style>
    <title>Siparişler</title>
</head>
<body>
<?php include('admin_panel.php');?>
<div class="all">
    <div class="headers">
        Siparişler
    </div>

</div>
    
</body>
</html>