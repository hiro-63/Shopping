<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>注文履歴｜ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>
    <?php require 'defo.php'; ?>
    <?php
    session_start();
    require 'config.php';

    try {
        $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass
);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $dbh->query("SELECT * FROM purchase_history ORDER BY purchase_date DESC");
        $histories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 注文番号ごとにグループ化
        $grouped = [];
        foreach ($histories as $history) {
            $orderId = $history['order_id'];
            if (!isset($grouped[$orderId])) {
                $grouped[$orderId] = [
                    'purchase_date' => $history['purchase_date'],
                    'items' => []
                ];
            }
            $grouped[$orderId]['items'][] = $history;
        }

        $dbh = null;
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
        exit;
    }
    ?>

    <h2>購入履歴</h2>

    <?php foreach ($grouped as $orderId => $data): ?>
        <h3>注文番号：<?= htmlspecialchars($orderId) ?></h3>
        <p>購入日時：<?= htmlspecialchars($data['purchase_date']) ?></p>

        <div class="cart-list">
            <?php foreach ($data['items'] as $item): ?>
                <div class="cart-card">
                    <img class="product-img" src="image/<?= htmlspecialchars($item['product_id']) ?>.jpg?<?= date("YmdHis") ?>"
                        alt="商品画像">

                    <div class="cart-details">
                        <p>商品名：<?= htmlspecialchars($item['product_name']) ?></p>
                        <p>価格：<?= htmlspecialchars($item['price']) ?>円</p>
                        <p>個数：<?= htmlspecialchars($item['count']) ?></p>
                        <p>小計：<?= htmlspecialchars($item['subtotal']) ?>円</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    <!-- フッター -->
    <footer class="site-footer">
        <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
    </footer>

</body>


</html>
