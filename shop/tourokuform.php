<?php
session_cache_limiter('none');
session_start();
require 'config.php';

try｛
    $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

// ログインしている場合は現在の情報を取得
if (isset($_SESSION['login'])) {
    $id = $_SESSION['login']['id'];
    $name = $_SESSION['login']['name'];
    $address = $_SESSION['login']['address'];
    $login = $_SESSION['login']['login'];
} else {
    $name = $address = $login = "";
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>会員登録 / 会員情報変更｜ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>
    <?php if (isset($_SESSION['login'])) { ?>
        <?php require 'defo.php'; ?>
    <?php } else { ?>
        <!-- ヘッダー -->
        <header class="site-header">
            <div class="logo-area">
                <h1>ようこそ！ショッピングサイトへ！</h1>
            </div>
        </header>

        <!-- ナビゲーション -->
        <nav class="main-nav">
            <ul>
                <li><a href="loginform.php">ログイン</a></li>
                <li><a href="tourokuform.php">会員登録</a></li>
            </ul>
            <hr>
        </nav>
    <?php } ?>


    <main>
        <div class="login-message">
            <form action="touroku.php" method="POST" style="margin-top: 10px;">
                <label for="name">お名前:</label><br>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"
                    required><br><br>

                <label for="address">ご住所:</label><br>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>"
                    required><br><br>

                <label for="login">ログイン名:</label><br>
                <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($login); ?>"
                    required><br><br>

                <label for="password">パスワード:</label><br>
                <input type="password" id="password" name="password" <?php if (!isset($_SESSION['login']))
                    echo 'required'; ?>><br><br>

                <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
                    <input type="submit" value="<?php echo isset($_SESSION['login']) ? '更新' : '登録'; ?>"
                        style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px; font-size: 18px;">
                </div>
            </form>
        </div>
    </main>

    <footer class="site-footer">
        <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
    </footer>

</body>
</html>
