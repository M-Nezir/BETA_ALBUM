<?php
require_once "config.php"; // Veritabanı bağlantısını çağır

if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    $query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');

    // SQL Sorgusu (Ürün isminde geçenleri arar)
    $stmt = $conn->prepare("SELECT * FROM urunler WHERE urun_ad LIKE ?");
    $param = "%$query%";
    $stmt->bind_param("s", $param);
    $stmt->execute();
    $result = $stmt->get_result(); // Sonuçları al
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Arama Sonuçları</title>
    <link href="/BETA_ALBUM/Beta_Album/bootstrap/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .product-img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .product-title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .product-price {
            color: #28a745;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include('navbar.php');?>
<div style="display: flex; align-items: center;">   
            <h2 class="mb-4" style="display: inline-block; margin-left: 10%;">Arama Sonuçları</h2>

        <form id="search-form" action="/BETA_ALBUM/Beta_Album/includes/search.php" method="GET" style=" display: inline-block; margin-left: 10%; margin-bottom: 6%; position: relative;">
                        <input type="text" name="query" placeholder="Ürün ara..." required>
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>


        </div>
    <div class="container mt-4" style="padding-bottom: 300px;">
        
     
        <div class="row">
            <?php if (isset($result) && $result->num_rows > 0): ?>
                <?php while ($urun = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="product-card">
                            <a href="/BETA_ALBUM/Beta_Album/includes/product_detail?urun_id=<?= $urun['urun_id']; ?>">
                            <img src="/BETA_ALBUM/Beta_Album/image/<?= htmlspecialchars($urun['urun_gorsel']); ?>" 
                                alt="<?= htmlspecialchars($urun['urun_ad']); ?>" 
                                class="product-img">
                            </a>
                            <div class="product-title"><?= htmlspecialchars($urun['urun_ad']); ?></div>
                            <div class="product-price"><?= $urun['urun_fiyat']; ?> ₺</div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>Sonuç bulunamadı.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include('footer.php');?>
</body>
</html>
