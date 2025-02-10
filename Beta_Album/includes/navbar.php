<?php
include_once 'config.php'; // Veritabanı bağlantısını dahil et

// Kategorileri veritabanından çek
$query = "SELECT * FROM kategoriler";
$result = mysqli_query($conn, $query);

// Kategorileri gruplamak için boş bir array oluştur
$category_groups = [
    "Panoramik Albüm" => [1, 2],
    "Fotoğraf Baskı"   => [3, 4, 5],
    "Canvas"          => [6, 7, 8],
    "Vesikalık"       => [9],
    "PS Tasarım"      => [10]
];

$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[$row['kategori_id']] = $row['kategori_ad'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beta Album</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="/BETA_ALBUM/Beta_Album/bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="/BETA_ALBUM/Beta_Album/bootstrap/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/index.css">
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="/BETA_ALBUM/Beta_Album/includes/login.php">Üye Giriş / Hesabım</a></li> |
            <li><a href="/BETA_ALBUM/Beta_Album/includes/about_us.php">Hakkımızda</a></li> |
            <li><a href="/BETA_ALBUM/Beta_Album/includes/contact.php">İletişim</a></li> |
            <li><a href="/BETA_ALBUM/Beta_Album/includes/basket.php">Sepetim</a></li> |
            <li><a href="/BETA_ALBUM/Beta_Album/includes/basket.php">Kasaya git</a></li>
        </ul>
    </nav>
</header>

<nav class="fixed">
    <ul class="menu">
        <li><a class="icon" href="/BETA_ALBUM/Beta_Album/index.php"><img src="/BETA_ALBUM/Beta_Album/image/betaalbümyatay.svg" alt="Logo" width="140"></a></li>
        <div class="center">
            <?php foreach ($category_groups as $group_name => $category_ids): ?>
                <li class="dropdown">
                    <a class="categoryList" href="#"><?= htmlspecialchars($group_name); ?> ▽</a>
                    <div class="dropdown-content">
                        <?php foreach ($category_ids as $category_id): ?>
                            <?php if (isset($categories[$category_id])): ?>
                                <div class="dropdown-item">
                                    <a class="category" href="/BETA_ALBUM/Beta_Album/includes/products.php?Kategori=<?= $category_id; ?>">
                                        <p><?= htmlspecialchars($categories[$category_id]); ?></p>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </div>
        <li class="search-icon-container">
            <a class="search_icon" id="search-btn" href="/BETA_ALBUM/Beta_Album/includes/search.php"><i class="fas fa-search"></i></a>
            <a class="search_icon" href="/BETA_ALBUM/Beta_Album/includes/login.php"><i class="fas fa-user"></i></a>
            <a class="search_icon" href="/BETA_ALBUM/Beta_Album/includes/basket.php"><i class="fa-solid fa-basket-shopping"></i></a>
        </li>
    </ul>
</nav>

</body>
</html>
