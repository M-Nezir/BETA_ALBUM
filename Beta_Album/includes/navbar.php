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
    "Vesikalık"       => [9, 10],
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="login">Üye Giriş / Hesabım</a></li> |
            <li><a href="about_us">Hakkımızda</a></li> |
            <li><a href="contact">İletişim</a></li> |
            <li><a href="basket">Sepetim</a></li> |
            <li><a href="basket">Kasaya git</a></li>
        </ul>
    </nav>
</header>

<nav class="fixed">
    <ul class="menu">
        <li><a class="icon" href="../index"><img src="../image/betaalbümyatay.svg" alt="Logo" width="140"></a></li>
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
                                    <a class="category" href="products?Kategori=<?= $category_id; ?>">
                                        <p><?= htmlspecialchars($categories[$category_id]); ?></p>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                </li>
                
            
            
        </div>
        <li class="search-icon-container">
            <a class="search_icon" id="search-btn" href="search"><i class="fas fa-search"></i></a>
            <a class="search_icon" href="login"><i class="fas fa-user"></i></a>
            <a class="search_icon" href="basket"><i class="fa-solid fa-basket-shopping"></i></a>
        </li>
    </ul>
</nav>

<div class="hamburger-button">
    <a href="../index"  class="icon_mobile left"><img src="../image/betaalbümyatay.svg" alt="Logo" width="140" height=auto></a>
    <a class="search_icon_mobile"href=""><i class="fas fa-search"></i></a>
    <a class="search_icon_mobile" href="login"><i class="fas fa-user"></i></a>
    <a class="search_icon_mobile" href="basket"><i class="fa-solid fa-basket-shopping"></i></a>
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
                                  <a href="products?Kategori=<?= $category_id; ?>" 
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
                <a href="login" class="list-group-item list-group-item-action menu-item">Üye Giriş / Hesabım</a>
                <a href="about_us" class="list-group-item list-group-item-action menu-item">Hakkımızda</a>
                <a href="contact" class="list-group-item list-group-item-action menu-item">İletişim</a>
                <a href="basket" class="list-group-item list-group-item-action menu-item">Sepetim</a>
                <a href="basket" class="list-group-item list-group-item-action menu-item">Kasaya git</a>
        
            </div>
      </div>

     
      </div>
    </div>
</div>

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
