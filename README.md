# Shopping
PHP と MySQL で作成したシンプルなショッピングサイトです。
ユーザー登録、ログイン、商品一覧、カート、購入処理など基本的な EC 機能を学べます。
決済機能搭載はありません。

## 機能
・会員登録 / ログイン / 会員情報編集
・商品一覧・商品詳細
・カート追加 / 数量変更 / 削除
・購入処理（注文番号生成・購入履歴保存）
・在庫管理

## 主なファイル
```
/shop
├── config.php          # DB接続設定
├── defo.php            # ヘッダー・ナビゲーション
│
├── goods.php           # 商品一覧
├── cart.php            # カート
├── buy_complete.php    # 購入完了
│
├── tourokuform.php     # 会員登録フォーム
├── touroku.php         # 会員登録処理
├── loginform.php       # ログインフォーム
├── login.php           # ログイン処理
├── logout.php          # ログアウト処理
│
├── shop.css            # スタイル
└── image/              # 商品画像
```

## セットアップ
#### リポジトリをクローン
#### config.php に DB 情報を設定
##### config.php の設定例 
####### プロジェクト直下に config.php を作成し、以下のようにデータベース情報を設定してください。 
```php 
<?php $db_host = "localhost"; $db_name = "shopping"; $db_user = "root"; $db_pass = "";
```

#### MySQL に必要なテーブルを作成(例)
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    address VARCHAR(255),
    login VARCHAR(100),
    password VARCHAR(255)
);

CREATE TABLE goods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    price INT,
    stock INT
);

CREATE TABLE purchase_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(50),
    product_id INT,
    product_name VARCHAR(100),
    price INT,
    count INT,
    subtotal INT,
    purchase_date DATETIME
);
```
#### ローカルサーバーで起動
コード
http://localhost/shop/

## 注意
学習用の簡易実装です。
商用利用する場合はセキュリティ対策を追加してください。
