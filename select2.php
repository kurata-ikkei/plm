<?php
require_once('./php/funcs.php');
$pdo = db_conn();
$stmt = $pdo->prepare("SELECT * FROM product LEFT JOIN img_table ON product.item_no = img_table.prod_no WHERE img_table.main_flg=1 ORDER BY product.category, product.gender");
$status = $stmt->execute();

$item="";

if($status==false) {
    sql_error($stmt);
}else{
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
      $item .='<div class="item">';
      $item .='<a href="./product.php?no='.h($result['item_no']).'"><img src="./img/'.h($result['img_path']).'">';
      $item .='<p>'.h($result['item_no']).'</p><br>';
      $item .='<p>'.h($result['item_name']).'</p><br>';
      $item .='<p>'.h($result['item_price']).'円（税込）</p></a>';
      $item .='</div>';
    }
}



?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/select2.css">
    <title>商品一覧</title>
</head>
<body>
<a href="./login.php">管理者向けログイン画面に戻る</a>
    <h1>ECサイト（テスト）</h1>
    <div class="navigation">
        <h2>会員登録（未実装）</h2>
        <h2>ログイン（未実装）</h2>
        <div class="container">
            <?= $item ?>
        </div>
        
    </div>
</body>
</html>