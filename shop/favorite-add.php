<?php
session_start();
require 'defo.php';

$user = "root";
$pass = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    try {
        $dbh = new PDO("mysql:host=localhost;dbname=single", $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 商品情報をDBから取得
        $stmt = $dbh->prepare("SELECT id, name, price FROM goods WHERE id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // 重複チェック
            $exists = false;
            if (isset($_SESSION['favorite'])) {
                foreach ($_SESSION['favorite'] as $fav) {
                    if ($fav['id'] == $id) {
                        $exists = true;
                        break;
                    }
                }
            }
            if (!$exists) {
                $_SESSION['favorite'][] = $item;
            }
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => '商品が見つかりません']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
