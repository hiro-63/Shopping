<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>2年B組24番 広瀬朱里</title>

</head>
<link rel="stylesheet" href="shop.css">

<table>

    <body>
        <?php session_cache_limiter('none'); ?>
        <?php session_start(); ?>


        <?php if (isset($_SESSION['login'])) { ?>
            <?php require 'defo.php'; ?>
        <?php } else { ?>
            <!-- ヘッダー -->
            <header class="site-header">
                <div class="logo-area">
                    <h1>🛍 ようこそ！ショッピングサイトへ！</h1>
                </div>
            </header>

            <!-- ナビゲーション -->
            <nav class="main-nav">
                <ul>
                    <a href="loginform.php">ログイン</a>
                    <a href="tourokuform.php">会員登録</a>
                </ul>
                <hr>
            </nav>
        <?php } ?>

        <?php
        $user = "root";
        $pass = "";
        try {

            // 接続
            $dbh = new PDO("mysql:host=localhost;dbname=single", $user, $pass);

            if (isset($_SESSION['login'])) {
                // ログイン状態 → UPDATE処理]
                // ここ変更する
                $id = $_SESSION['login']['id'];
                $sql = "UPDATE `login` SET `name`=?,`address`=?,`login`=?,`password`=? WHERE `id`=?";
                $stmt = $dbh->prepare($sql);
                $stmt->execute([
                    $_POST['name'],
                    $_POST['address'],
                    $_POST['login'],
                    $_POST['password'],
                    $id
                ]);
                $_SESSION['login'] = [
                    'id' => $id,
                    'name' => $_POST['name'],
                    'address' => $_POST['address'],
                    'login' => $_POST['login'],
                    'password' => $_POST['password']
                ];

                echo ' <div class="login-message">';
                echo ' <p>お客様情報を更新しました</p>';
                echo '  </div>';

            } else {
                // 未ログイン → INSERT処理（重複チェックあり）
                $stmt = $dbh->prepare("SELECT * FROM login WHERE login = ?");
                $stmt->execute([$_POST['login']]);
                $result = $stmt->fetch();

                if ($result) {
                    echo ' <div class="login-message">';
                    echo '<p>同じログイン名があります。変更してください。</p>';
                    echo '</div>';
                } else {
                    $sql = "INSERT INTO login (name, address, login, password) VALUES (?, ?, ?, ?)";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute([
                        $_POST['name'],
                        $_POST['address'],
                        $_POST['login'],
                        $_POST['password']
                    ]);
                    echo ' <div class="login-message">';
                    echo '<p>お客様情報を登録しました。</p>';
                    echo '</div>';

                }
            }

            $dbh = null;

        } catch (PDOException $e) {
            print "エラー!: " . $e->getMessage() . "<br/>";
            die();
        }
        ?>
        <footer class="site-footer">
            <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
        </footer>

    </body>
</table>

</html>