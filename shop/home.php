<?php
session_cache_limiter('none');
session_start();
require 'config.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ホーム｜ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>

<?php require 'defo.php'; ?>

<?php
// POSTデータの存在チェック
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

try {
    $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ログインユーザー検索
    $sql = "SELECT * FROM login WHERE login = ? AND password = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$username, $password]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['login'] = [
            'id'      => $user['id'],
            'name'    => $user['name'],
            'address' => $user['address'],
            'login'   => $user['login']
        ];

        echo '<div class="login-message">';
        echo 'いらっしゃいませ！ ' . htmlspecialchars($_SESSION["login"]["name"]) . ' 様';
        echo '</div>';
    } else {
        echo '<div class="login-message">';
        echo 'ログインまたはパスワードが違います。';
        echo '</div>';
    }

    $dbh = null;

} catch (PDOException $e) {
    echo "エラー: " . htmlspecialchars($e->getMessage());
    exit;
}
?>

<!-- フッター -->
<footer class="site-footer">
    <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
</footer>

</body>
</html>
