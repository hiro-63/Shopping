<?php
session_start();

// カートと注文番号を削除
unset($_SESSION['cart']);
unset($_SESSION['order_id']);

// 商品一覧ページに移動
header("Location: goods.php");
exit;
?>