<?php //ログイン不要ページ
require_once('./php/funcs.php');
$pdo = db_conn();

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM product WHERE id=:id;");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ表示
$view = "";
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/select.css">
    <title>商品情報編集</title>
</head>
<body>
<header>商品詳細</header>
<a href="./select.php">一覧に戻る</a>
<div class="prod_info">
    <h1>商品情報確認</h1>
                <table>
                    <tr><th>item_no：</th><td><?= $result['item_no'] ?></td></tr>
                    <tr><th>target_year：</th><td><?= $result['year'] ?></td></tr>
                    <tr><th>terget_season：</th><td><?= $result['season'] ?></td></tr>
                    <tr><th>target_gender：</th><td><?= $result['gender'] ?></td></tr>
                    <tr><th>item_category：</th><td><?= $result['category'] ?></td></tr>
                    <tr><th>item_genre：</th><td><?= $result['genre'] ?></td></tr>
                    <tr><th>item_name：</th><td><?= $result['item_name'] ?></td></tr>
                    <tr><th>item_price：</th><td><?= $result['item_price'] ?></td></tr>
                    <tr><th>memo：</th><td><?= $result['memo'] ?></td></tr>
                </table>
</div>