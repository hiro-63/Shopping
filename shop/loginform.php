<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>2年B組24番 広瀬朱里</title>

</head>
<link rel="stylesheet" href="shop.css">

<body>

    <!-- ヘッダー -->
    <header class="site-header">
        <div class="logo-area">
            <h1>🛍 ようこそ！ショッピングサイトへ！</h1>
        </div>

    </header>

    <nav class="main-nav">
        <ul> <a href="loginform.php">ログイン</a>
            <a href="tourokuform.php">会員登録</a>
        </ul>
        <hr>
    </nav>

    <main>
        <?php
        session_cache_limiter('none');
        session_start();

        if (isset($_SESSION['login'])) {
            echo '<div class="login-message">';
            echo '<p>' . $_SESSION['login']['name'] . ' 様はすでにログインしています。</p>';
            echo '<a href="home.php" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #58d68d; color: white; border-radius: 5px; text-decoration: none;">ホームへ</a>';
            echo '</div>';
        } else {
            echo '<div class="login-message">';
            echo '<form action="home.php" method="POST" style="margin-top: 10px;">';
            echo '<label for="username">ユーザーID:</label><br>';
            echo '<input type="text" id="username" name="username" required><br><br>';
            echo '<label for="password">パスワード:</label><br>';
            echo '<input type="password" id="password" name="password" required><br><br>';

            // ボタンを横並びにするためのラッパーdiv
            echo '<div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">';
            echo '<input type="submit" value="ログイン" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px; text-decoration: none; font-size: 18px;">';
            echo '<a href="tourokuform.php" style="padding: 10px 20px; background-color: #f39c12; color: white; border-radius: 5px; text-decoration: none;">新規登録</a>';
            echo '</div>';

            echo '</form>';

        }
        ?>
    </main>
    <!-- フッター -->
    <footer class="site-footer">
        <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
    </footer>

</body>

</html>