<?php
include_once 'includes/config.php'; // Veritabanı bağlantısını dahil et

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
    <link href="bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="includes/login">Üye Giriş / Hesabım</a></li> |
            <li><a href="includes/about_us">Hakkımızda</a></li> |
            <li><a href="includes/contact">İletişim</a></li> |
            <li><a href="includes/basket">Sepetim</a></li> |
            <li><a href="includes/basket">Kasaya git</a></li>
        </ul>
    </nav>
</header>

<nav class="fixed">
    <ul class="menu">
        <li><a class="icon" href="index"><img src="image/betaalbümyatay.svg" alt="Logo" width="140"></a></li>
        <div class="center">
            <?php foreach ($category_groups as $group_name => $category_ids): ?>
                <li class="dropdown">
                    <a class="categoryList" href="#"><?= htmlspecialchars($group_name); ?> ▽</a>
                    <div class="dropdown-content">
                        <?php foreach ($category_ids as $category_id): ?>
                            <?php if (isset($categories[$category_id])): ?>
                                <div class="dropdown-item">
                                    <a class="category" href="includes/products?Kategori=<?= $category_id; ?>">
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
            <a class="search_icon" id="search-btn" href="includes/search"><i class="fas fa-search"></i></a>
            <a class="search_icon" href="includes/login"><i class="fas fa-user"></i></a>
            <a class="search_icon" href="includes/basket"><i class="fa-solid fa-basket-shopping"></i></a>
        </li>
    </ul>
</nav>

<div class="hamburger-button">
    <a href="index"  class="icon_mobile left"><img src="image/betaalbümyatay.svg" alt="Logo" width="140" height=auto></a>
    <a class="search_icon_mobile"href=""><i class="fas fa-search"></i></a>
    <a class="search_icon_mobile" href="includes/login"><i class="fas fa-user"></i></a>
    <a class="search_icon_mobile" href="includes/basket"><i class="fa-solid fa-basket-shopping"></i></a>
<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
      ☰
    </button>
</div>


    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
      <div class="offcanvas-header" style="background-color: #f4e3d4; height:8%;">
      <span class="icon_mobile"><b>BETA ALBUM&trade;</b></span>
      </div>

      <div class="offcanvas-body p-0">
          <div class="list-group" id="menuList">
              <?php foreach ($category_groups as $group_name => $category_ids): ?>
                  <a href="#submenu<?= $category_ids[0] ?>" 
                    class="list-group-item list-group-item-action menu-item d-flex justify-content-between align-items-center dropdown-toggle">
                      <b><?= htmlspecialchars($group_name); ?></b>
                  </a>
                  <div class="collapse" id="submenu<?= $category_ids[0] ?>">
                      <div class="list-group">
                          <?php foreach ($category_ids as $category_id): ?>
                              <?php if (isset($categories[$category_id])): ?>
                                  <a href="includes/products?Kategori=<?= $category_id; ?>" 
                                    class="list-group-item list-group-item-action menu-item">
                                      <?= htmlspecialchars($categories[$category_id]); ?>
                                  </a>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </div>
                  </div>
              <?php endforeach; ?>
          </div>
      </div>

        <div class="single-items">
                <a href="includes/login" class="list-group-item list-group-item-action menu-item">Üye Giriş / Hesabım</a>
                <a href="includes/about_us" class="list-group-item list-group-item-action menu-item">Hakkımızda</a>
                <a href="includes/contact" class="list-group-item list-group-item-action menu-item">İletişim</a>
                <a href="includes/basket" class="list-group-item list-group-item-action menu-item">Sepetim</a>
                <a href="includes/basket" class="list-group-item list-group-item-action menu-item">Kasaya git</a>
        
            </div>
      </div>
    </div>
</div>


    <?php  
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

   
<div class="footer_container">
    <div class="footer-items">
        <ul>
            <li><h3>Bilgiler</h3></li>
            <li><a href="includes/distance_selling_agreement">Mesafeli Satış Sözleşmesi</a></li>
            <li><a href="includes/payment_and_delivery_information">Ödeme ve Teslimat Bilgileri</a></li>
            <li><a href="includes/about_us">Hakkımızda</a></li>
            <li><a href="includes/privacy_and_security">Gizlilik ve Güvenlik</a></li>
            <li><a href="includes/contact">İletişim</a></li>
        </ul>
    </div>

    <div class="footer-items">
        <ul>
            <li><h3>Ekstralar</h3></li>
            <li><a href="includes/campaigns">Kampanyalar</a></li>
            <li><a href="includes/adminlogin">Yönetici Girişi</a></li>
        </ul>
    </div>

    <div class="footer-items">
        <ul>
            <li><h3>Hesabım</h3></li>
            <li><a href="includes/login">Hesabım</a></li>
            <li><a href="includes/siparislerim">Siparişlerim</a></li>
        </ul>
    </div>

    <div class="footer-items">
        <ul>
            <li><h3>İletişim Bilgilerimiz</h3></li>
            <li><a href="https://www.google.com/maps?q=Ereğli / Konya" target="_blank"><i class="fa-solid fa-location-dot"></i>Ereğli / Konya</a></li>
            <li><a href="tel:+905369771595"><i class="fa-solid fa-phone"></i>Telefon: +90 536 977 15 95</a></li>
            <li mailto=><a href="mailto:betacolor@hotmail.com"><i class="fa-solid fa-envelope"></i>Mail: betacolor@hotmail.com</a></li>
        </ul> 
    </div> 

</div>

<div  class="logo">
    <div>
        <a class="footer_icon" href="index"><img src="image/betaalbümkare.svg" alt="Logo" width="200" height="200"></a>

    </div> 
    <div class="text">
        Hizmetlerimiz Hakkında sorularınız mı var? Bize
         <a href="mailto:betacolor@hotmail.com" style="color: #FFA500;">betacolor@hotmail.com </a>mail adresimizden yazabilir, hafta içi
         <span  style="color: #FFA500;">09.00 - 20.00 </span>saatleri arasında 
        <a href="tel:+905369771595" style="color: #FFA500;">+90 536 977 15 95</a> numaralı telefondan ulaşabilirsiniz.
    </div>
    <div class="img">
        <a href="https://www.google.com/search?q=facebook" target="_blank" class="facebook"><i class="fa-brands fa-facebook"></i></a>
        <a href="https://www.google.com/search?q=instagram" target="_blank"><i class="fa-brands fa-instagram"></i></a>
        <img src="image/odeme-guvenlik.png" alt="" style="bottom: 0; display: block;">
    </div>
</div>



<footer>
    &copy;2025 Beta Album Profosyonel Resim Albümü İmalatı.
</footer>



    <script>
// İşlev: tüm dropdown'ları kapat
function closeAllDropdowns(except = null) {
  document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
    const targetSelector = toggle.getAttribute('href');
    const targetCollapse = document.querySelector(targetSelector);
    if (targetCollapse.classList.contains('show') && toggle !== except) {
      let instance = bootstrap.Collapse.getInstance(targetCollapse);
      if (!instance) {
        instance = new bootstrap.Collapse(targetCollapse, { toggle: false });
      }
      instance.hide();
      toggle.classList.remove('active');
    }
  });
}

// Normal menü öğeleri aktiflik ayarı (dropdown olmayanlar)
const menuItems = document.querySelectorAll('.menu-item:not(.dropdown-toggle)');
menuItems.forEach(item => {
  item.addEventListener('click', function () {
    // Tüm menü öğelerindeki aktif sınıfı kaldır
    document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
    this.classList.add('active');
  });
});

// Dropdown toggle öğeleri için davranış
const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
dropdownToggles.forEach(toggle => {
  toggle.addEventListener('click', function (e) {
    e.preventDefault(); // Linkin varsayılan davranışını iptal et
    const targetSelector = this.getAttribute('href');
    const targetCollapse = document.querySelector(targetSelector);

    // Bootstrap Collapse instance'ını al veya oluştur
    let bsCollapse = bootstrap.Collapse.getInstance(targetCollapse);
    if (!bsCollapse) {
      bsCollapse = new bootstrap.Collapse(targetCollapse, { toggle: false });
    }

    // Eğer tıklanan dropdown açıksa, kapat; değilse diğerlerini kapatıp aç
    if (targetCollapse.classList.contains('show')) {
      bsCollapse.hide();
      this.classList.remove('active');
    } else {
      closeAllDropdowns(this);
      bsCollapse.show();
      this.classList.add('active');
    }
  });
});
</script>

<script>
  window.onscroll = function() {
      if (window.scrollY > 0) {
          document.body.classList.add("scrolled");
      } else {
          document.body.classList.remove("scrolled");
      }
  };
</script>


</body>
</html>
