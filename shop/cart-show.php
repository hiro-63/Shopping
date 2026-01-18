<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>カートの中身｜ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>
    <?php require 'defo.php'; ?>
    <?php
    session_start();

    require 'config.php';

    try {
        $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // この部分を追加（カートページのPHP内）
        $_SESSION['order_id'] = uniqid("order_");

        // 商品追加処理
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $count = isset($_POST['count']) ? (int) $_POST['count'] : 1;

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $found = false;

            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $id) {
                    // 個数を上書き（増やさない）
                    $item['count'] = $count;
                    $found = true;
                    break;
                }
            }
            unset($item); // 参照解除
    
            if (!$found) {
                $_SESSION['cart'][] = [
                    'id' => $id,
                    'name' => $name,
                    'price' => $price,
                    'count' => $count
                ];
            }
        }


        // 商品削除処理
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
            $deleteId = $_POST['delete'];
            foreach ($_SESSION['cart'] as $index => $item) {
                if ($item['id'] == $deleteId) {
                    unset($_SESSION['cart'][$index]);
                    $_SESSION['cart'] = array_values($_SESSION['cart']); 
                    break;
                }
            }
        }

        $dbh = null;
    } catch (PDOException $e) {
        print "エラー!: " . $e->getMessage() . "<br/>";
        die();
    }
    ?>

    <div class="cart-list">
        <?php
        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item):
                $subtotal = $item['price'] * $item['count'];
                $total += $subtotal;
                ?>
                <div class="cart-card">
                    <img class="product-img" src="image/<?= htmlspecialchars($item['id']) ?>.jpg?<?= date("YmdHis") ?>"
                        alt="...">

                    <div class="cart-details">
                        <p>商品名：<?= htmlspecialchars($item['name']) ?></p>
                        <p>価格：<?= htmlspecialchars($item['price']) ?>円</p>
                        <p>個数：<?= htmlspecialchars($item['count']) ?></p>
                        <p>小計：<?= $subtotal ?>円</p>
                    </div>

                    <form method="POST">
                        <input type="hidden" name="delete" value="<?= htmlspecialchars($item['id']) ?>">
                        <input type="submit" value="削除する"
                            style="padding: 10px 20px; background-color: #e74c3c; color: white; border: none; border-radius: 5px;">
                    </form>
                </div>
                <?php
            endforeach;
        }
        ?>
    </div>

    <div class="login-message">
        <p class="total">合計金額：<?= $total ?>円</p>

        <form action="complete.php" method="POST">
            <input type="submit" value="購入する"
                style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px;">
        </form>
    </div>

    <!-- フッター -->
    <footer class="site-footer">
        <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
    </footer>

    <!-- モーダル表示用スクリプト -->
    <script>
        if (sessionStorage.getItem('showCartModal') === 'true') {
            sessionStorage.removeItem('showCartModal');
            if (confirm("カートに商品を追加しました。\n購入を続けますか？")) {
                window.location.href = "goods.php"; // OK → 商品一覧に戻る
            }
        }
    </script>
</body>


</html>


