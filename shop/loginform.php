<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ログイン｜ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>

<header class="site-header">
    <div class="logo-area">
        <h1>ようこそ！ショッピングサイトへ！</h1>
    </div>
</header>

<nav class="main-nav">
    <ul>
        <li><a href="loginform.php">ログイン</a></li>
        <li><a href="tourokuform.php">会員登録</a></li>
    </ul>
    <hr>
</nav>

<main>
<?php
session_cache_limiter('none');
session_start();

if (isset($_SESSION['login'])):
?>
    <div class="login-message">
        <p><?= htmlspecialchars($_SESSION['login']['name']) ?> 様はすでにログインしています。</p>
        <a href="home.php"
           style="display:inline-block;margin-top:10px;padding:10px 20px;background-color:#58d68d;color:white;border-radius:5px;text-decoration:none;">
           ホームへ
        </a>
    </div>

<?php else: ?>

    <div class="login-message">
        <form action="home.php" method="POST" style="margin-top: 10px;">
            <label for="username">ユーザーID:</label><br>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">パスワード:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <div style="display:flex;justify-content:center;gap:10px;margin-top:20px;">
                <input type="submit" value="ログイン"
                       style="padding:10px 20px;background-color:#3498db;color:white;border:none;border-radius:5px;font-size:18px;">
                <a href="tourokuform.php"
                   style="padding:10px 20px;background-color:#f39c12;color:white;border-radius:5px;text-decoration:none;">
                   新規登録
                </a>
            </div>
        </form>
    </div>

<?php endif; ?>
</main>

<footer class="site-footer">
    <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
</footer>

</body>
</html>
