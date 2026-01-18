<?php
session_start();
require 'defo.php';

// ★ 削除処理はここで先に実行
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $deleteId = $_POST['delete'];
    if (isset($_SESSION['favorite'])) {
        $_SESSION['favorite'] = array_values(array_filter($_SESSION['favorite'], function ($fav) use ($deleteId) {
            return $fav['id'] != $deleteId;
        }));
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>お気に入り一覧</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>

    <h2>お気に入り</h2>

    <div class="cart-list">
        <?php if (!empty($_SESSION['favorite'])): ?>
            <?php foreach ($_SESSION['favorite'] as $item): ?>
                <div class="cart-card">
                    <img class="product-img" src="image/<?= htmlspecialchars($item['id']) ?>.jpg?<?= date("YmdHis") ?>"
                        alt="<?= htmlspecialchars($item['name']) ?>">

                    <div class="cart-details">
                        <p>商品名：<?= htmlspecialchars($item['name']) ?></p>
                        <p>価格：<?= htmlspecialchars($item['price']) ?>円</p>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">

                            <!-- 左側：個数入力 -->
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <label>個数：</label>
                                <input type="number" name="count" value="1" min="1" style="width: 60px;">
                            </div>

                            <!-- 右側：ボタン類 -->
                            <div style="display: flex; gap: 10px;">
                                <!-- カートに追加フォーム -->
                                <form method="POST" action="cart-show.php"
                                    style="display: flex; align-items: center; gap: 5px;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
                                    <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']) ?>">
                                    <input type="hidden" name="price" value="<?= htmlspecialchars($item['price']) ?>">
                                    <input type="submit" value="カートに追加"
                                        style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px;">
                                </form>

                                <!-- 削除フォーム -->
                                <form method="POST">
                                    <input type="hidden" name="delete" value="<?= htmlspecialchars($item['id']) ?>">
                                    <input type="submit" value="削除する"
                                        style="padding: 10px 20px; background-color: #e74c3c; color: white; border: none; border-radius: 5px;">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>お気に入りに登録された商品はありません。</p>
        <?php endif; ?>
    </div>

    <!-- フッター -->
    <footer class="site-footer">
        <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
    </footer>

</body>

</html>
