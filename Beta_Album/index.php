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
                <h3 class="kisa_yazi">Yılların Albüm İmalatı Tecrübesi ile Yanınızdayız</h3>
                <div class="uzun_yazi_container">
                    <p class="uzun_yazi">
                    Beta Albüm, yılların verdiği tecrübe ile yüksek kaliteli fotoğraf albümleri üreten ve bunları e-ticaret platformları üzerinden müşterilerine sunan öncü bir firmadır. Özel tasarım ve dayanıklı malzemelerle üretilen albümlerimiz, düğün, mezuniyet, bebek, seyahat ve özel anılarınızı en şık şekilde saklamanızı sağlar. Müşteri memnuniyetini ön planda tutarak, kişiye özel baskı seçenekleri, farklı boyut ve kapak tasarımları ile geniş bir ürün yelpazesi sunuyoruz. Güvenilir alışveriş deneyimi ve hızlı teslimat anlayışımızla, unutulmaz anılarınızı en iyi şekilde korumanız için buradayız. Beta Albüm ile anılarınız ölümsüzleşsin!  
                    </p>
                </div>
            </div>
         
        </div>
    </section>

    <?php include('includes/footer.php');?>

</body>
</html>
