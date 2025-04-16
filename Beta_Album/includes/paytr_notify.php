<?php
##############################################
# PayTR Bildirim (Notification) Dosyası Örneği
##############################################

## PayTR Mağaza Ayarlarından al:
$merchant_key  = "oP5LJwkuGBjKWSJ4";
$merchant_salt = "2trHaAFf8cYJDYwY";

$post = $_POST;

## Gelen hash’i kontrol et
$hash = base64_encode(hash_hmac('sha256', $post['merchant_oid'] . $merchant_salt . $post['status'] . $post['total_amount'], $merchant_key, true));

if ($hash != $post['hash']) {
    die("PAYTR notification failed: INVALID HASH");
}

## Ödeme başarılıysa
if ($post['status'] == 'success') {
    $siparis_id = $post['merchant_oid'];
    $odenen_tutar = $post['total_amount'];

    // Burada siparişi veritabanında onayla vs.
    // Örnek: update orders set status='paid' where order_id = $siparis_id;

    // PayTR'ye cevap olarak "OK" dönmek zorundasın
    echo "OK";
} else {
    // Başarısız işlem (loglamak isteyebilirsin)
    die("PAYTR: Payment failed");
}
?>
