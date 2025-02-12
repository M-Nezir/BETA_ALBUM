<?php
session_start();
include('config.php');

$user = null; // Kullanıcı bilgisini tutacak değişken

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Kullanıcı bilgilerini çek
    $query = $conn->prepare("SELECT * FROM kullanicilar WHERE user_id = ?");
    $query->bind_param("i", $user_id); // `id` integer olduğu için "i" parametresi
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üye Giriş / Hesabım</title>
    <link rel="stylesheet" href="../css/backgraund.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body class="body">
    <?php include('navbar.php'); ?>
    <div class="main">
        <?php if ($user): ?>
            <h1 class='head'>HESABIM</h1>
            <div class="login_user" >

            <p>Ad: <?= htmlspecialchars($user['user_name']) ?></p>
            <p>Soyad: <?= htmlspecialchars($user['user_surname']) ?></p>
            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
            <p>Telefon: <?= htmlspecialchars($user['phoneNumber']) ?></p>
            <a href="logout">Çıkış Yap</a>
            </div>
            <div style="display: flex; justify-content: center;">
            <div class="welcome-container">
            Hoş geldin <?= htmlspecialchars($user['user_name']) ?>!
              <div>
              <p class="welcome-message">
        Sepetine buradan ulaşabilirsin:
    </p>
    <a href="Basket" class="basket-link">
        <div class="basket-button">
            <h3>SEPETİME GİT</h3>
        </div>
    </a>
              </div>
              <div>   <p class="welcome-message">Siparişlerine Buradan Ulaşabilirsin:</p>
    <a href="siparislerim" class="basket-link">
        <div class="basket-button">
            <h3>SİPARİŞLERİM</h3>
        </div>
    </a></div>
  </div>
</div>
           
        <?php else: ?>

            <section class="forms-section" style="background-color:rgb(146, 146, 146);">
  <div class="forms" style="background-color:rgb(177, 177, 177);">
    <div class="form-wrapper is-active">
      <button type="button" class="switcher switcher-login">
        Giriş Yap
        <span class="underline"></span>
      </button>
      <form class="form form-login" action="login_process.php" method="POST">
        <fieldset>
          <legend>Lütfen giriş yapmak için e-posta ve şifrenizi girin.</legend>
          <div class="input-block">
            <label for="login-email" style="color: black;">E-posta</label>
            <input id="login-email" type="email" name="email" required>
          </div>
          <div class="input-block">
            <label for="login-password" style="color: black;">Şifre</label>
            <input id="login-password" type="password" name="password" required>
          </div>
        </fieldset>
        <button type="submit" class="btn-login">Giriş Yap</button>
      </form>
    </div>
    <div class="form-wrapper">
      <button type="button" class="switcher switcher-signup">
        Üye Ol
        <span class="underline"></span>
      </button>
      <form class="form form-signup" action="register_process.php" method="POST">
        <fieldset>
          <legend>Lütfen kayıt olmak için bilgilerinizi girin.</legend>
          <div style="display: block;">
          <div class="input-block">
            <label for="signup-name" style="color: black;">Ad</label>
            <input id="signup-name" type="text" name="user_name" required>
          </div>
          <div class="input-block">
            <label for="signup-surname" style="color: black;">Soyad</label>
            <input id="signup-surname" type="text" name="user_surname" required>
          </div>
          </div>
          <div style="display: block;">
          <div class="input-block">
            <label for="signup-phone" style="color: black;">Telefon Numarası</label>
            <input id="signup-phone" type="text" name="phoneNumber" required>
          </div>
          <div class="input-block">
            <label for="signup-tc" style="color: black;">T.C. Kimlik Numarası</label>
            <input id="signup-tc" type="text" name="tcKimlik" required>
          </div>
          </div>
          <div style="display: block;">
          <div class="input-block">
            <label for="signup-email" style="color: black;">E-posta</label>
            <input id="signup-email" type="email" name="email" required>
          </div>
          <div class="input-block">
            <label for="signup-password" style="color: black;">Şifre</label>
            <input id="signup-password" type="password" name="password" required>
          </div>
          </div>
        </fieldset>
        <button type="submit" class="btn-signup">Üye Ol</button>
      </form>
    </div>
  </div>
</section>

            </div>

        <?php endif; ?>

        
    </div>
    <?php include('footer.php'); ?>

    <script>
    const switchers = [...document.querySelectorAll('.switcher')]

switchers.forEach(item => {
	item.addEventListener('click', function() {
		switchers.forEach(item => item.parentElement.classList.remove('is-active'))
		this.parentElement.classList.add('is-active')
	})
})
</script>
</body>
</html>
