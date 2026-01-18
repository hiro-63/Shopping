<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>登録｜ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>

    <body>
       <?php session_cache_limiter('none'); 
        session_start(); 
        require 'config.php';

        if (isset($_SESSION['login'])) {
            require 'defo.php';
         } else { 
        ?>
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
        <?php 
        } 
 
        try {

            // 接続
            $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass
);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

              echo '<div class="login-message"><p>お客様情報を更新しました。</p></div>';

            } else {
                // 新規登録（重複チェック）
                $stmt = $dbh->prepare("SELECT * FROM login WHERE login = ?");
                $stmt->execute([$_POST['login']]);
                $result = $stmt->fetch();

                if ($result) {
                    echo '<div class="login-message"><p>同じログイン名があります。変更してください。</p></div>';
                } else {
                    $sql = "INSERT INTO login (name, address, login, password) VALUES (?, ?, ?, ?)";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute([
                        $_POST['name'],
                        $_POST['address'],
                        $_POST['login'],
                        $_POST['password']
                    ]);
                 echo '<div class="login-message"><p>お客様情報を登録しました。</p></div>';
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

