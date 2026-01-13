<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログアウト画面 - ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>

    <!-- ログアウト確認 -->
    <main>

        <?php
        session_cache_limiter('none');
        session_start();
        require 'defo.php';

        if (isset($_SESSION['login'])) {
            echo '<div class="login-message">';
            echo '<p>' . $_SESSION['login']['name'] . ' 様、ログアウトしますか？</p>';
            echo '<div style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">';
            echo '<form action="logout.php" method="POST">';
            echo '<input type="submit" value="はい" style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px;">';
            echo '</form>';
            echo '<button onclick="history.back()" style="padding: 10px 20px; background-color: #ccc; border: none; border-radius: 5px;">戻る</button>';
            echo '</div>';

            echo '</div>';
        } else {
            echo '<div class="login-message">';
            echo '<p>ログインしていません。</p>';
            echo '<a href="loginform.php" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #5dade2; color: white; border-radius: 5px; text-decoration: none;">ログイン画面へ</a>';
            echo '</div>';
        }
        ?>
    </main>
    <footer class="site-footer">
        <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
    </footer>

</body>

</html>