<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $_GET['Kategori'];?></title>
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/backgraund.css">
</head>
<body>
    <?php include('navbar.php');?>

    <div class="main">
    <?php $id = $_GET['Kategori'];
    echo "<h1 class='head'>$id</h1>";
    ?>
    </div>

    <?php include('footer.php');?>
</body>
</html>