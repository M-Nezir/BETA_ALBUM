<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/adminlogin.php");
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        select {
            padding: 5px;
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
        <h2>Siparişler</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>Sipariş ID</th>
                <th>Kullanıcı</th>
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
            $query = "SELECT s.*, k.user_name, k.user_surname, k.phoneNumber, k.email 
                      FROM siparisler s
                      JOIN kullanicilar k ON s.user_id = k.user_id
                      ORDER BY s.order_date DESC";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['order_id']}</td>";
                echo "<td>{$row['user_name']} {$row['user_surname']}</td>";
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

                // Sipariş durumunu güncellenebilir bir `<select>` menüsü olarak ekliyoruz
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

</body>
</html>
