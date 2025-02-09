<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beta Album</title>
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/index.css">
</head>
<body>
    <?php 
    include('includes/navbar.php'); 
    include('includes/config.php'); // Veritabanı bağlantısı

    // Ana ekran fotoğrafını veritabanından al
    $query = "SELECT main_image FROM settings LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $main_image = $row['main_image'] ?? 'image/main.jpeg'; // Eğer veritabanında kayıt yoksa varsayılan görsel
    ?>

    <div class="slider">
        <img style="object-fit: cover; object-position: center; width: 100%; height: 100%;" src="<?php echo $main_image; ?>" alt="">
    </div>

    <section id="about" class="about" style="padding-top: 50px;">
        <div class="row">
            <div class="content">
                <h3>Yılların Albüm İmalatı Tecrübesi ile Yanınızdayız</h3>
                <div style="width: 100%; display: flex; justify-content: center;">
                    <p style="padding: 10px 40px; width: 80%; margin-top:20px">
                    Beta Albüm, yılların verdiği tecrübe ile yüksek kaliteli fotoğraf albümleri üreten ve bunları e-ticaret platformları üzerinden müşterilerine sunan öncü bir firmadır. Özel tasarım ve dayanıklı malzemelerle üretilen albümlerimiz, düğün, mezuniyet, bebek, seyahat ve özel anılarınızı en şık şekilde saklamanızı sağlar. Müşteri memnuniyetini ön planda tutarak, kişiye özel baskı seçenekleri, farklı boyut ve kapak tasarımları ile geniş bir ürün yelpazesi sunuyoruz. Güvenilir alışveriş deneyimi ve hızlı teslimat anlayışımızla, unutulmaz anılarınızı en iyi şekilde korumanız için buradayız. Beta Albüm ile anılarınız ölümsüzleşsin!  
                    </p>
                </div>
            </div>
            <div>
                <a href="/BETA_ALBUM/Beta_Album/includes/products.php?Kategori=3" style="height: auto; width: auto; text-decoration: none; color: black;">
                    <div style="display: flex; align-items: center; padding-bottom: 3%; padding-top: 3%;">
                        <div style="display: inline-block; height: 80%; width: 40%; border: 1px solid black; padding: 0; overflow: hidden; margin-left: 10%;">
                            <img src="image/1-600x430_002.jpg" alt="" style="height: 100%; width: 100%; object-fit: cover;">
                        </div>
                        <div style="height: 5%; width: 40%;">
                            <h1 style="display: inline-block; margin-left: 10%; text-decoration: underline;">EXCLUSIVE ALBÜMLER</h1>
                        </div>
                    </div>
                </a>
                <hr>
                <a href="/BETA_ALBUM/Beta_Album/includes/products.php?Kategori=4" style="height: auto; width: auto; text-decoration: none; color: black;">
                    <div style="display: flex; align-items: center; padding-bottom: 3%; padding-top: 3%;">
                        <div style="height: 5%; width: 40%;">
                            <h1 style="display: inline-block; margin-left: 10%; text-decoration: underline;">KAMPANYALI ALBÜMLER</h1>
                        </div>
                        <div style="display: inline-block; height: 80%; width: 40%; border: 1px solid black; padding: 0; overflow: hidden; margin-left: 10%;">
                            <img src="image/1-600x430_005.jpg" alt="" style="height: 100%; width: 100%; object-fit: cover;">
                        </div> 
                    </div>
                </a>
                <hr>
                <a href="/BETA_ALBUM/Beta_Album/includes/products.php?Kategori=6" style="height: auto; width: auto; text-decoration: none; color: black;">
                    <div style="display: flex; align-items: center; padding-bottom: 3%; padding-top: 3%;">
                        <div style="display: inline-block; height: 80%; width: 40%; border: 1px solid black; padding: 0; overflow: hidden; margin-left: 10%;">
                            <img src="image/1-600x430_006.jpg" alt="" style="height: 100%; width: 100%; object-fit: cover;">
                        </div>
                        <div style="height: 5%; width: 40%;">
                            <h1 style="display: inline-block; margin-left: 10%; text-decoration: underline;">LABORATUVAR BASKI</h1>
                        </div>
                    </div>
                </a>
                <hr>
                <a href="/BETA_ALBUM/Beta_Album/includes/products.php?Kategori=7" style="height: auto; width: auto; text-decoration: none; color: black;">
                    <div style="display: flex; align-items: center; padding-bottom: 3%; padding-top: 3%;">
                        <div style="height: 5%; width: 40%;">
                            <h1 style="display: inline-block; margin-left: 10%; text-decoration: underline;">FOTOKİTAP</h1>
                        </div>
                        <div style="display: inline-block; height: 80%; width: 40%; border: 1px solid black; padding: 0; overflow: hidden; margin-left: 10%;">
                            <img src="image/1-600x430_004.jpg" alt="" style="height: 100%; width: 100%; object-fit: cover;">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php');?>

</body>
</html>
