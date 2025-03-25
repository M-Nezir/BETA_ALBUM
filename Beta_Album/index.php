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
    "Vesikalık"       => [9,10],
    "PS Tasarım"      => [11],
    "Beta Yıllık"      => []
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="image/beyaz logo.png">
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
                <?php if ($group_name == "Beta Yıllık") : ?>
                    <a class="categoryList" href="https://betayillik.com/"><?= htmlspecialchars($group_name); ?> ▽</a>
                    <?php else : ?>
                    <a class="categoryList" href=""><?= htmlspecialchars($group_name); ?> ▽</a>
                    <?php endif; ?>
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
</div>
<style>.whatsapp-button {
    position: fixed;
    bottom: 50px;
    right: 50px;
    width: 50px;
    height: 50px;
    z-index: 1000;
}

.whatsapp-button i {
    font-size: 80px !important;
    z-index: 1000;
}
.whatsapp-button i:hover {
    font-size: 90px !important;
    z-index: 1000;
}
@media (max-width: 768px) {
    .whatsapp-button {
        display: none;}
}
</style>
<a href="https://wa.me/+905369771595" class="whatsapp-button" target="_blank" >
<i class="fa-brands fa-square-whatsapp" style="color: #00ff40;"></i>
</a>
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

    <section id="about" class="about">
    <div class="about-container">
        <div class="content">
            <h3 class="kisa_yazi">Yılların Albüm İmalatı Tecrübesi ile Yanınızdayız</h3>
            <div class="uzun_yazi_container">
                <p class="uzun_yazi">
                    Beta Albüm, yılların verdiği tecrübe ile yüksek kaliteli fotoğraf albümleri üreten ve bunları e-ticaret platformları üzerinden müşterilerine sunan öncü bir firmadır. Özel tasarım ve dayanıklı malzemelerle üretilen albümlerimiz, düğün, mezuniyet, bebek, seyahat ve özel anılarınızı en şık şekilde saklamanızı sağlar. 
                </p>
            </div>
        </div>

        <div class="content">
            <h3 class="kisa_yazi">Neden Beta Albümü Tercih Etmelisiniz?</h3>
            <div class="uzun_yazi_container">
                <p class="uzun_yazi">
                    ✔ Yüksek kaliteli baskı ve malzeme <br>
                    ✔ Kişiye özel tasarım seçenekleri <br>
                    ✔ Güvenli alışveriş ve hızlı teslimat <br>
                    ✔ Profesyonel müşteri desteği <br>
                    ✔ Yenilikçi ve estetik albüm tasarımları
                </p>
            </div>
        </div>
    </div>
</section>

    <!------------------------------------------------------- Osmo [https://osmo.supply/] --------------------------------------->
    <style>
        /* ------- Osmo [https://osmo.supply/] ------- */
/* Osmo UI: https://slater.app/10324/23333.css */


.cloneable {
  padding: var(--container-padding);
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  display: flex;
  position: relative;
  background-image: url('<?php echo $main_image; ?>');
  
}

.cloneable::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.3); /* Beyaz, %50 opak */
}


.looping-words {
  height: 2.7em;
  padding-left: .1em;
  padding-right: .1em;
  font-size: 11vw;
  line-height: .9;
  position: relative;
  z-index: 5;
}

.looping-words__list {
  text-align: center;
  text-transform: uppercase;
  white-space: nowrap;
  flex-flow: column;
  align-items: center;
  margin: 0;
  padding: 0;
  font-family: PP Neue Corp, sans-serif;
  font-weight: 700;
  list-style: none;
  display: flex;
  position: relative;
}

.looping-words__list.is--primary {
  color: var(--color-primary);
}

.looping-words__list.is--gray {
  color: var(--color-neutral-500);
}

.looping-words__fade {
  background-image: linear-gradient(180deg, var(--color-neutral-300) 5%, transparent 40%, transparent 60%, var(--color-neutral-300) 95%);
  pointer-events: none;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
}

.looping-words__fade.is--radial {
  background-image: radial-gradient(circle closest-side at 50% 50%, transparent 64%, var(--color-neutral-400) 93%);
  width: 140%;
  display: block;
  left: -20%;
}

.looping-words__selector {
  pointer-events: none;
  width: 100%;
  height: .9em;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.looping-words__edge {
  border-top: .035em solid var(--color-primary);
  border-left: .035em solid var(--color-primary);
  width: .125em;
  height: .125em;
  position: absolute;
  top: 0;
  left: 0;
}

.looping-words__edge.is--2 {
  left: auto;
  right: 0;
  transform: rotate(90deg);
}

.looping-words__edge.is--3 {
  inset: auto 0 0 auto;
  transform: rotate(180deg);
}

.looping-words__edge.is--4 {
  top: auto;
  bottom: 0;
  transform: rotate(270deg);
}

.looping-words__containers {
  width: 100%;
  height: 100%;
  position: relative;
  overflow: hidden;
}

.looping-words__p {
  margin: 0;
}

@font-face {
  font-family: 'PP Neue Corp';
  src: url('https://cdn.prod.website-files.com/6717aac16c9ea22eeef1e79e/6717de2d56e40b921572d2d9_PPNeueCorp-TightUltrabold.woff2') format('woff2');
  font-weight: 700;
  font-style: normal;
  font-display: swap;
}
    </style>
<section class="cloneable">
    <div class="looping-words">
      <div class="looping-words__containers">
        <ul data-looping-words-list="" class="looping-words__list">
          <li class="looping-words__list">
            <p class="looping-words__p">EXSCLUSİVE</p>
          </li>
          <li class="looping-words__list">
            <p class="looping-words__p">KAMPANYALI</p>
          </li>
          <li class="looping-words__list">
            <p class="looping-words__p">VESİKALIK</p>
          </li>
          <li class="looping-words__list">
            <p class="looping-words__p">BİYOMETRİK</p>
          </li>
          <li class="looping-words__list">
            <p class="looping-words__p">PHOTOSHOP</p>
          </li>
        </ul>
      </div>
      <div class="looping-words__fade"></div>
      <div data-looping-words-selector="" class="looping-words__selector">
        <div class="looping-words__edge"></div>
        <div class="looping-words__edge is--2"></div>
        <div class="looping-words__edge is--3"></div>
        <div class="looping-words__edge is--4"></div>
      </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script>// ------- Osmo [https://osmo.supply/] ------- //

document.addEventListener('DOMContentLoaded', function() {
  const wordList = document.querySelector('[data-looping-words-list]');
  const words = Array.from(wordList.children);
  const totalWords = words.length;
  const wordHeight = 100 / totalWords; // Offset as a percentage
  const edgeElement = document.querySelector('[data-looping-words-selector]');
  let currentIndex = 0;
  function updateEdgeWidth() {
    const centerIndex = (currentIndex + 1) % totalWords;
    const centerWord = words[centerIndex];
    const centerWordWidth = centerWord.getBoundingClientRect().width;
    const listWidth = wordList.getBoundingClientRect().width;
    const percentageWidth = (centerWordWidth / listWidth) * 100;
    gsap.to(edgeElement, {
      width: `${percentageWidth}%`,
      duration: 0.5,
      ease: 'Expo.easeOut',
    });
  }
  function moveWords() {
    currentIndex++;
    gsap.to(wordList, {
      yPercent: -wordHeight * currentIndex,
      duration: 1.2,
      ease: 'elastic.out(1, 0.85)',
      onStart: updateEdgeWidth,
      onComplete: function() {
        if (currentIndex >= totalWords - 3) {
          wordList.appendChild(wordList.children[0]);
          currentIndex--;
          gsap.set(wordList, { yPercent: -wordHeight * currentIndex });
          words.push(words.shift());
        }
      }
    });
  }
  updateEdgeWidth();
  gsap.timeline({ repeat: -1, delay: 1 })
    .call(moveWords)
    .to({}, { duration: 2 })
    .repeat(-1);
});</script>

     <!---------------------------------------------- Osmo [https://osmo.supply/] --------------------------------------------------------->
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
            <li><a href="https://www.google.com/maps?q=SÜMER MAH. INÖNÜ CAD. NO: 102 A IÇ KAPI NO: A EREGLI/
KONYA" target="_blank"><i class="fa-solid fa-location-dot"></i>SÜMER MAH. INÖNÜ CAD. NO: 102 A <br> &nbsp;&nbsp;&nbsp;&nbsp;IÇ KAPI NO: A EREGLI/
            KONYA</a></li>
            <li><a href="tel:+905369771595"><i class="fa-solid fa-phone"></i>Telefon: +90 536 977 15 95</a></li>
            <li mailto=><a href="mailto:beta.color@hotmail.com"><i class="fa-solid fa-envelope"></i>Mail: beta.color@hotmail.com</a></li>
        </ul> 
    </div> 

</div>

<div  class="logo">
    <div>
        <a class="footer_icon" href="index"><img src="image/betaalbümkare.svg" alt="Logo" width="200" height="200"></a>

    </div> 
    <div class="text">
        Hizmetlerimiz Hakkında sorularınız mı var? Bize
         <a href="mailto:beta.color@hotmail.com" style="color: #FFA500;">beta.color@hotmail.com </a>mail adresimizden yazabilir, hafta içi
         <span  style="color: #FFA500;">09.00 - 20.00 </span>saatleri arasında 
        <a href="tel:+905369771595" style="color: #FFA500;">+90 536 977 15 95</a> veya <a href="tel:+903327127514" style="color: #FFA500;">+90 332 712 75 14</a> numaralı telefonlardan ulaşabilirsiniz.
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
