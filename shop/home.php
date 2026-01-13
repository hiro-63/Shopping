<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>2年B組24番 広瀬朱里</title>
    <link rel="stylesheet" href="shop.css"> <!-- ← headの中に移動 -->
</head>

<table>

    <body>
        <?php require 'defo.php'; ?>

        <?php session_cache_limiter('none'); ?>
        <?php session_start(); ?>

        <?php

        $user = "root";
        $pass = "";
        try {

            $dbh = new PDO("mysql:host=localhost;dbname=single", $user, $pass);
            $sql = "SELECT * FROM login WHERE login = ? AND password = ?;";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([$_POST['username'], $_POST['password']]);

            foreach ($stmt as $row) {
                $_SESSION['login'] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'address' => $row['address'],
                    'login' => $row['login'],
                    'password' => $row['password']
                ];
            }

            if (isset($_SESSION['login'])) {
                echo ' <div class="login-message">';
                echo 'いらっしゃいませ! ' . $_SESSION['login']['name'] . ' 様';
                echo '</div>';
            } else {
                echo ' <div class="login-message">';
                echo 'ログインまたはパスワードが違います! ';
                echo '</div>';
            }

            $dbh = null;

        } catch (PDOException $e) {
            print "エラー!: " . $e->getMessage() . "<br/>";
            die();
        }
        ?>
        <!-- フッター -->
        <footer class="site-footer">
            <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
        </footer>

    </body>
</table>

</html>