<?php
session_start();
require 'config.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>注文履歴｜ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>

<?php require 'defo.php'; ?>

<?php
try {
    $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 購入履歴取得
    $stmt = $dbh->query("SELECT * FROM purchase_history ORDER BY purchase_date DESC");
    $histories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 注文番号ごとにグループ化
    $grouped = [];
    foreach ($histories as $history) {
        $orderId = $history['order_id'];

        if (!isset($grouped[$orderId])) {
            $grouped[$orderId] = [
                'purchase_date' => $history['purchase_date'],
                'items' => []
            ];
        }

        $grouped[$orderId]['items'][] = $history;
    }

    $dbh = null;

} catch (PDOException $e) {
    echo "エラー: " . htmlspecialchars($e->getMessage());
    exit;
}
?>

<h2>購入履歴</h2>

<?php foreach ($grouped as $orderId =>
