<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödeme Başarısız</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f8d7da;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
        }

        .error-icon {
            font-size: 50px;
            color: #dc3545;
        }

        h2 {
            color: #dc3545;
            margin: 15px 0;
        }

        p {
            margin-bottom: 20px;
            color: #333;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-retry {
            background-color: #dc3545;
            color: white;
        }

        .btn-home {
            background-color: #007bff;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <div class="error-container">
        <div class="error-icon">❌</div>
        <h2>Ödeme Başarısız!</h2>
        <p>Ödemeniz sırasında bir hata oluştu. Lütfen tekrar deneyin.</p>
        <a href="../index.php" class="btn btn-home">Anasayfaya Git</a>
    </div>

</body>
</html>
