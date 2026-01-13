<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>2年B組24番 広瀬朱里</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>


    <?php
    session_start();
    require 'defo.php';

    // カートが空なら購入処理を中止
    if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
        echo "<h2>カートが空です。購入できません。</h2>";
        echo '<a href="goods.php">商品一覧に戻る</a>';
        exit;
    }
    $user = "root";
    $pass = "";

    try {
        $dbh = new PDO("mysql:host=localhost;dbname=single", $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 注文番号がなければ生成
        if (!isset($_SESSION['order_id'])) {
            $_SESSION['order_id'] = uniqid("order_");
        }

        $order_id = $_SESSION['order_id'];
        $purchase_date = date("Y-m-d H:i:s");

        // カート内容をDBに保存
        $total = 0;
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $item) {
                $subtotal = $item['price'] * $item['count'];
                $total += $subtotal;

                $stmt = $dbh->prepare("INSERT INTO purchase_history (order_id, product_id, product_name, price, count, subtotal, purchase_date)
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $order_id,
                    $item['id'],
                    $item['name'],
                    $item['price'],
                    $item['count'],
                    $subtotal,
                    $purchase_date
                ]);
            }
        }

        $dbh = null;
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
        exit;
    }
    ?>

    <h2>ご注文ありがとうございます！</h2>

    <div class="order-summary">
        <?php if (isset($_SESSION['order_id'])): ?>
            <p>注文番号: <?= htmlspecialchars($_SESSION['order_id']) ?> ／ 合計金額: <?= $total ?>円</p>
        <?php else: ?>
            <p>注文番号が取得できませんでした。 ／ 合計金額: <?= $total ?>円</p>
        <?php endif; ?>
    </div>

    <div class="cart-list">
        <?php
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0):
            foreach ($_SESSION['cart'] as $item):
                $subtotal = $item['price'] * $item['count'];
                ?>
                <div class="cart-card">
                    <img class="product-img" src="image/<?= htmlspecialchars($item['id']) ?>.jpg?<?= date("YmdHis") ?>"
                        alt="商品画像">

                    <div class="cart-details">
                        <p>商品名：<?= htmlspecialchars($item['name']) ?></p>
                        <p>価格：<?= htmlspecialchars($item['price']) ?>円</p>
                        <p>個数：<?= htmlspecialchars($item['count']) ?></p>
                        <p>小計：<?= $subtotal ?>円</p>
                    </div>
                </div>
                <?php
            endforeach;
        else:
            ?>
            <p>購入された商品はありません。</p>
        <?php endif; ?>
    </div>
    <!-- カート一覧の下に追加 -->
    <div class="login-message">
        <form action="clear_cart.php" method="post">
            <input type="submit" value="商品一覧へ"
                style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px;">
        </form>
    </div>
    <!-- フッター -->
    <footer class="site-footer">
        <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
    </footer>

</body>

</html>