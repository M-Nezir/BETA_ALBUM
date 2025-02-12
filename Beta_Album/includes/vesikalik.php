<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotoğraf Yükleme</title>
    <style>
       .heading {
    font-size: 24px;
    text-align: center;
    margin-top: 3%;
}

.container {
    display: flex;
    justify-content: space-around;
    padding: 20px;
}

.category {
    width: 45%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 15%;
}

.category-title {
    font-size: 20px;
    text-align: center;
}

.photo-form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.label {
    margin-bottom: 5px;
}

.select, .file-input {
    margin-bottom: 15px;
    padding: 8px;
    width: 100%;
}

.price {
    font-size: 16px;
    color: green;
    margin-bottom: 10px;
}

.submit-button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.submit-button:hover {
    background-color: #45a049;
}

.file-input {
    padding: 6px;
}

    </style>
</head>
<body>
<?php include('navbar.php'); ?>
<h2 class="heading">Fotoğraf Yükleme</h2>
<div class="container">
    <div class="category biometric-photo">
        <h3 class="category-title">Biyometrik Fotoğraf</h3>
        <form class="photo-form" action="" method="post" enctype="multipart/form-data">
            <label class="label">Ebat:</label>
            <select class="select" name="biometric_size">
                <option value="35x45">35x45 mm</option>
                <option value="50x50">50x50 mm</option>
                <option value="50x60">50x60 mm</option>
            </select>
            <br><br>
            <label class="label">Kağıt Yüzeyi:</label>
            <select class="select" name="biometric_paper_surface">
                <option value="parlak">Parlak</option>
                <option value="mat">Mat</option>
            </select>
            <br><br>
            <label class="label">Fotoğraf Sayısı:</label>
            <select class="select" name="biometric_count">
                <option value="4">4 adet</option>
                <option value="8">8 adet</option>
                <option value="12">12 adet</option>
                <option value="24">24 adet</option>
            </select>
            <br><br>
            <label class="label">Fotoğraf Seçin:</label>
            <input class="file-input" type="file" name="photo" required>
            <br><br>
            <p class="price">Fiyat: 49,90 TL</p>
            <button class="submit-button" type="submit">Yükle</button>
        </form>
    </div>
    <div class="category vesikalik-photo">
        <h3 class="category-title">Vesikalık Fotoğraf</h3>
        <form class="photo-form" action="" method="post" enctype="multipart/form-data">
            <label class="label">Ebat:</label>
            <select class="select" name="vesikalik_size">
                <option value="3.2x4.5">3,2x4,5 cm (9 Adet)</option>
                <option value="4.5x6">4,5x6 cm (4 Adet)</option>
                <option value="6x9">6x9 cm (2 Adet)</option>
            </select>
            <br><br>
            <label class="label">Kağıt Yüzeyi:</label>
            <select class="select" name="vesikalik_paper_surface">
                <option value="parlak">Parlak</option>
                <option value="mat">Mat</option>
            </select>
            <br><br>
            <label class="label">Fotoğraf Sayısı:</label>
            <select class="select" name="vesikalik_count">
                <option value="9">9 adet</option>
                <option value="18">18 adet</option>
                <option value="27">27 adet</option>
                <option value="36">36 adet</option>
                <option value="45">45 adet</option>
            </select>
            <br><br>
            <label class="label">Fotoğraf Seçin:</label>
            <input class="file-input" type="file" name="photo" required>
            <br><br>
            <p class="price">Fiyat: 49,90 TL</p>
            <button class="submit-button" type="submit">Yükle</button>
        </form>
    </div>
</div>
<?php include('footer.php');?>
</body>
</html>