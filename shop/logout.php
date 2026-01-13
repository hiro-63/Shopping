<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>2年B組24番 広瀬朱里</title>

</head>
<link rel="stylesheet" href="shop.css">

<table>

    <body>
        <header class="site-header">
            <div class="logo-area">
                <h1>🛍 ようこそ！ショッピングサイトへ！</h1>
            </div>
        </header>

        <nav class="main-nav">
            <a href="loginform.php">ログイン</a>
            <a href="tourokuform.php">会員登録</a>
            <hr>
        </nav>
        <div class="login-message">
            <p>ログアウトしました</p>
            <a href="loginform.php"
                style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #5dade2; color: white; border-radius: 5px; text-decoration: none;">ログイン画面へ</a>
        </div>
        <?php session_cache_limiter('none'); ?>
        <?php session_start(); ?>

        <?php unset($_SESSION['login']); ?>

        <?php if (isset($_SESSION['login'])) { ?>

            <a href="loginform.php">ログイン</a>
            <a href="logoutform.php">ログアウト</a>
            <a href="tourokuform.php">会員登録</a>
            <hr>
        <?php } ?>
        <!-- フッター -->
        <footer class="site-footer">
            <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
        </footer>

    </body>
</table>

</html>