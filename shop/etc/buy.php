<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>購入｜ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>
<?php
session_start();
require 'defo.php';

// ログイン情報
$user_id = $_SESSION['login']['id'] ?? null;

// カート情報
$cart = $_SESSION['cart'] ?? [];

if (!$user_id) {
    echo "ログイン情報がありません。";
    exit;
}

if (empty($cart)) {
    echo "カートが空です。";
    exit;
}

try {
    $dbh = new PDO("mysql:host=localhost;dbname=single", "root", "");
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach ($cart as $item) {

        // 注文登録
        $stmt = $dbh->prepare(
            "INSERT INTO orders (user_id, product_id, count, price) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$user_id, $item['id'], $item['count'], $item['price']]);

        // 在庫更新
        $stmt = $dbh->prepare("UPDATE goods SET stock = stock - ? WHERE id = ?");
        $stmt->execute([$item['count'], $item['id']]);
    }

    // カートを空にする
    unset($_SESSION['cart']);

    echo "<h2>ご購入ありがとうございました！</h2>";
    echo "<p>注文が完了しました。</p>";

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>
</body>
</html>
