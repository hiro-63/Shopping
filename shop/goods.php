<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>商品｜ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>
    <?php require 'defo.php'; ?>

    <div class="box" style="width: 100%; padding: 8px; font-size: 13px;">
        <div class="box-title" style="font-size: 16px; text-align: center;">おすすめ商品</div>
        <div class="product-list"
            style="display: flex; gap: 16px; justify-content: center; flex-wrap: nowrap; overflow-x: auto; padding: 10px;">
            <?php
            $products = [
                ['id' => 2, 'name' => 'TRY WITH US', 'price' => 2800],
                ['id' => 4, 'name' => 'SUMMER BEAT!', 'price' => 2600],
                ['id' => 7, 'name' => 'LOVE DIVE', 'price' => 1500],
            ];

            foreach ($products as $row) {
                echo '<div class="product-card" style="min-width: 140px; padding: 6px; font-size: 12px; background-color: #f9f9f9; box-shadow: 1px 1px 4px rgba(0,0,0,0.1); border-radius: 6px; text-align: center;">';
                echo '<img src="image/' . $row['id'] . '.jpg?' . date("YmdHis") . '" alt="' . $row['name'] . '" style="width: 100%; height: 80px; object-fit: cover; border-radius: 4px;">';
                echo '<h3 style="font-size: 13px; margin: 6px 0;">' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p style="margin: 4px 0;">価格：¥' . number_format($row['price']) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <form method="POST" action="" class="search-form-1">
        <label>
            <input type="text" name="text" placeholder="キーワードを入力"
                value="<?= isset($_POST['text']) ? htmlspecialchars($_POST['text']) : '' ?>">
        </label>
        <button type="submit" name="search" aria-label="検索"></button>
    </form>

    <?php
   require 'config.php';

    $text = '';
    if (isset($_POST['search'])) {
        $text = $_POST['text'];
    } elseif (isset($_POST['clear'])) {
        $text = '';
    }

    try {
        $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass
);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($text === '') {
            // 検索が空なら全件取得
            $sql = $dbh->query("SELECT * FROM goods");
        } else {
            // 検索語がある場合は部分一致検索
            $stmt = $dbh->prepare("SELECT * FROM goods WHERE name LIKE ?");
            $stmt->execute(["%{$text}%"]);
            $sql = $stmt;
        }

        echo '<div class="product-list">';
        foreach ($sql as $row) {
            echo '<div class="product-card">';
            echo '<img src="image/' . $row['id'] . '.jpg?' . date("YmdHis") . '">';

            // 商品名と価格を表示
            echo '<h3>' . htmlspecialchars($row['name'], ENT_QUOTES) . '</h3>';
            echo '<p>価格：¥' . number_format($row['price']) . '</p>';

            // カート＋お気に入りを同じフォームにまとめる
            echo '<form onsubmit="setCartFlag()" action="cart-show.php" method="post" style="display: flex; flex-direction: column; align-items: center;">';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
            echo '<input type="hidden" name="name" value="' . htmlspecialchars($row['name'], ENT_QUOTES) . '">';
            echo '<input type="hidden" name="price" value="' . $row['price'] . '">';

            echo '<p>個数：<select name="count">';
            for ($i = 1; $i <= 10; $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
            echo '</select></p>';

            // ボタンを横並びにするラッパー
            echo '<div style="display: flex; gap: 10px; justify-content: center;">';
            echo '<input type="submit" value="カートに入れる" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px;">';

            // お気に入り星ボタン（別フォーム不要）
            echo '<button type="button" class="favorite-star" onclick="toggleFavorite(this, ' . $row['id'] . ')">&#9734;</button>';
            echo '</div>';

            echo '</form>';
            echo '</div>';
        }
        echo '</div>';



        $dbh = null;
    } catch (PDOException $e) {
        print "エラー!: " . $e->getMessage() . "<br/>";
        die();
    }
    ?>

    <div id="cartModal" class="modal">
        <div class="modal-content">
            <p>カートに商品を追加しました！購入をつづけますか？</p>
            <button onclick="closeModal()">はい</button>
            <button onclick="location.href='cart-show.php'">カートを見る</button>
        </div>
    </div>

    <script>
        function setCartFlag() {
            sessionStorage.setItem('showCartModal', 'true');
        }
        function showModal() {
            document.getElementById('cartModal').style.display = 'block';
        }
        function closeModal() {
            document.getElementById('cartModal').style.display = 'none';
        }
        if (sessionStorage.getItem('showCartModal') === 'true') {
            showModal();
            sessionStorage.removeItem('showCartModal');
        }

    </script>
    <script>
        function toggleFavorite(el, productId) {
            el.classList.toggle('active');
            el.innerHTML = el.classList.contains('active') ? '★' : '☆';

            fetch('favorite-add.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + encodeURIComponent(productId)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log('お気に入り追加成功');
                    } else {
                        console.error(data.message);
                    }
                });
        }
    </script>

    <!-- フッター -->
    <footer class="site-footer">
        <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
    </footer>

</body>


</html>
