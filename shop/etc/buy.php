<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>購入｜ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>
<link rel="stylesheet" href="shop.css">

<body>
    <?php require 'defo.php'; ?>
    <?php

    session_start();
    $id = $_SESSION['login']['id'];
    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        echo "カートが空です。";
        exit;
    }

    try {
        $dbh = new PDO("mysql:host=localhost;dbname=single", "root", "");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        foreach ($cart as $item) {
            $stmt = $dbh->prepare("INSERT INTO orders (user_id, product_id, count, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $item['id'], $item['count'], $item['price']]);

            $stmt = $dbh->prepare("UPDATE goods SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$item['count'], $item['id']]);
        }

        unset($_SESSION['cart']);

        echo "<h2>ご購入ありがとうございました！</h2>";
        echo "<p>注文が完了しました。</p>";

    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
    ?>
</body>


</html>
