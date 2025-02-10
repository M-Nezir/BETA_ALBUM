<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/adminlogin");
    exit();
}

include('../includes/config.php'); // Veritabanı bağlantısı
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BETA_ALBUM/Beta_Album/css/products_operations.css">
    <title>Siparişler</title>
    <style>
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            color: #333;
            table-layout: auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 9px;
            text-align: left;
            word-wrap: break-word;
            white-space: normal;
        }
        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        select:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .metin{
            display: none;
        }
    </style>
    <script>
        function updateStatus(orderId, newStatus) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_order_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Sipariş durumu güncellendi!");
                }
            };
            xhr.send("order_id=" + orderId + "&status=" + newStatus);
        }
    </script>
</head>
<body>
<?php include('admin_panel.php'); ?>

<div class="all">
    <div class="headers">
        <h2 style="margin-top: 1%; margin-bottom: 1%;">Siparişler</h2>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Sipariş ID</th>
                    <th>Kullanıcı</th>
                    <th>T.C. Kimlik</th> <!-- Yeni sütun eklendi -->
                    <th>Telefon</th>
                    <th>Email</th>
                    <th>Adres</th>
                    <th>Sipariş Detayları</th>
                    <th>Toplam Fiyat</th>
                    <th>Tarih</th>
                    <th>Durum</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT s.*, k.user_name, k.user_surname, k.phoneNumber, k.email, k.tcKimlik 
                          FROM siparisler s
                          JOIN kullanicilar k ON s.user_id = k.user_id
                          ORDER BY s.order_date DESC";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['order_id']}</td>";
                    echo "<td>{$row['user_name']} {$row['user_surname']}</td>";
                    echo "<td>{$row['tcKimlik']}</td>"; // Yeni sütun eklendi
                    echo "<td>{$row['phoneNumber']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['address']}</td>";

                    echo "<td>";
                    $orderDetails = json_decode($row['order_details'], true);
                    if (!empty($orderDetails)) {
                        echo "<table>";
                        foreach ($orderDetails as $item) {
                            echo "<tr>";
                            echo "<td><img src='/BETA_ALBUM/Beta_Album/image/{$item['urun_gorsel']}' class='product-image'></td>";
                            echo "<td>{$item['urun_ad']}</td>";
                            echo "<td>{$item['adet']} adet</td>";
                            echo "<td>{$item['urun_fiyat']} ₺</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "Sipariş detayları bulunamadı.";
                    }
                    echo "</td>";

                    echo "<td>{$row['total_price']} ₺</td>";
                    echo "<td>{$row['order_date']}</td>";

                    echo "<td>
                        <select onchange='updateStatus({$row['order_id']}, this.value)'>
                            <option value='Hazırlanıyor' " . ($row['status'] == 'Hazırlanıyor' ? 'selected' : '') . ">Hazırlanıyor</option>
                            <option value='Kargoda' " . ($row['status'] == 'Kargoda' ? 'selected' : '') . ">Kargoda</option>
                            <option value='Teslim Edildi' " . ($row['status'] == 'Teslim Edildi' ? 'selected' : '') . ">Teslim Edildi</option>
                        </select>
                    </td>";

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
