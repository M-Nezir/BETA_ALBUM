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
            <div class="pc_icinn">
                <a href="/BETA_ALBUM/Beta_Album/includes/products?Kategori=3" style="height: auto; width: auto; text-decoration: none; color: black;">
                    <div style="display: flex; align-items: center; padding-bottom: 3%; padding-top: 3%;">
                        <div style="display: inline-block; height: 80%; width: 40%; border: 1px solid black; padding: 0; overflow: hidden; margin-left: 10%;">
                            <img src="image/Leo.jpg" alt="" style="height: 100%; width: 100%; object-fit: cover;">
                        </div>
                        <div style="height: 5%; width: 40%;">
                            <h1 style="display: inline-block; margin-left: 10%; text-decoration: underline;">EXCLUSIVE ALBÜMLER</h1>
                        </div>
                    </div>
                </a>
                <hr>
                <a href="/BETA_ALBUM/Beta_Album/includes/products?Kategori=4" style="height: auto; width: auto; text-decoration: none; color: black;">
                    <div style="display: flex; align-items: center; padding-bottom: 3%; padding-top: 3%;">
                        <div style="height: 5%; width: 40%;">
                            <h1 style="display: inline-block; margin-left: 10%; text-decoration: underline;">KAMPANYALI ALBÜMLER</h1>
                        </div>
                        <div style="display: inline-block; height: 80%; width: 40%; border: 1px solid black; padding: 0; overflow: hidden; margin-left: 10%;">
                            <img src="image/Cara.jpg" alt="" style="height: 100%; width: 100%; object-fit: cover;">
                        </div> 
                    </div>
                </a>
                <hr>
                <a href="/BETA_ALBUM/Beta_Album/includes/products?Kategori=6" style="height: auto; width: auto; text-decoration: none; color: black;">
                    <div style="display: flex; align-items: center; padding-bottom: 3%; padding-top: 3%;">
                        <div style="display: inline-block; height: 80%; width: 40%; border: 1px solid black; padding: 0; overflow: hidden; margin-left: 10%;">
                            <img src="image/Lion.jpg" alt="" style="height: 100%; width: 100%; object-fit: cover;">
                        </div>
                        <div style="height: 5%; width: 40%;">
                            <h1 style="display: inline-block; margin-left: 10%; text-decoration: underline;">LABORATUVAR BASKI</h1>
                        </div>
                    </div>
                </a>
                <hr>
                <a href="/BETA_ALBUM/Beta_Album/includes/products?Kategori=7" style="height: auto; width: auto; text-decoration: none; color: black;">
                    <div style="display: flex; align-items: center; padding-bottom: 3%; padding-top: 3%;">
                        <div style="height: 5%; width: 40%;">
                            <h1 style="display: inline-block; margin-left: 10%; text-decoration: underline;">FOTOKİTAP</h1>
                        </div>
                        <div style="display: inline-block; height: 80%; width: 40%; border: 1px solid black; padding: 0; overflow: hidden; margin-left: 10%;">
                            <img src="image/Mia.jpg" alt="" style="height: 100%; width: 100%; object-fit: cover;">
                        </div>
                    </div>
                </a>
            </div>









            <div class="mobile_icinn" style="width: 100%; max-width: 600px; margin: auto;">
    <a href="/BETA_ALBUM/Beta_Album/includes/products?Kategori=3" style="display: block; text-decoration: none; color: black;">
        <div style="display: flex; flex-direction: column; align-items: center; padding: 5% 0;">
            <div style="width: 80%; max-width: 250px; border: 1px solid black; overflow: hidden;">
                <img src="image/Leo.jpg" alt="" style="width: 100%; height: auto; object-fit: cover;">
            </div>
            <div style="width: 100%; text-align: center; margin-top: 10px;">
                <h1 style="font-size: 18px; text-decoration: underline;">EXCLUSIVE ALBÜMLER</h1>
            </div>
        </div>
    </a>
    <hr style="width: 90%; margin: auto;">

    <a href="/BETA_ALBUM/Beta_Album/includes/products?Kategori=4" style="display: block; text-decoration: none; color: black;">
        <div style="display: flex; flex-direction: column; align-items: center; padding: 5% 0;">
            
            <div style="width: 80%; max-width: 250px; border: 1px solid black; overflow: hidden;">
                <img src="image/Cara.jpg" alt="" style="width: 100%; height: auto; object-fit: cover;">
            </div> 
            <div style="width: 100%; text-align: center; margin-bottom: 10px;">
                <h1 style="font-size: 18px; text-decoration: underline;">KAMPANYALI ALBÜMLER</h1>
            </div>
        </div>
    </a>
    <hr style="width: 90%; margin: auto;">

    <a href="/BETA_ALBUM/Beta_Album/includes/products?Kategori=6" style="display: block; text-decoration: none; color: black;">
        <div style="display: flex; flex-direction: column; align-items: center; padding: 5% 0;">
            <div style="width: 80%; max-width: 250px; border: 1px solid black; overflow: hidden;">
                <img src="image/Lion.jpg" alt="" style="width: 100%; height: auto; object-fit: cover;">
            </div>
            <div style="width: 100%; text-align: center; margin-top: 10px;">
                <h1 style="font-size: 18px; text-decoration: underline;">LABORATUVAR BASKI</h1>
            </div>
        </div>
    </a>
    <hr style="width: 90%; margin: auto;">

    <a href="/BETA_ALBUM/Beta_Album/includes/products?Kategori=7" style="display: block; text-decoration: none; color: black;">
        <div style="display: flex; flex-direction: column; align-items: center; padding: 5% 0;">
            
            <div style="width: 80%; max-width: 250px; border: 1px solid black; overflow: hidden;">
                <img src="image/Mia.jpg" alt="" style="width: 100%; height: auto; object-fit: cover;">
            </div>
            <div style="width: 100%; text-align: center; margin-bottom: 10px;">
                <h1 style="font-size: 18px; text-decoration: underline;">FOTOKİTAP</h1>
            </div>
        </div>
    </a>
</div>

        </div>
    </section>

    <?php include('includes/footer.php');?>

</body>
</html>
