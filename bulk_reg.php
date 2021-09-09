<?php
session_start();

require_once('./php/funcs.php');

loginCheck();
$user_name = $_SESSION['name'];
$role_flg = $_SESSION['role_flg'];

$pdo = db_conn();

//ブランドコード
$stmt1 = $pdo->prepare("SELECT * FROM brand");
$status1 = $stmt1->execute();
$brand="";
if ($status1 == false) {
    sql_error($status1);
} else {
    while( $r1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
        $brand .='<option value='.h($r1['id']).'>'.h($r1['brand_name']).'</option>';
        }
    }

$stmt2 = $pdo->prepare("SELECT item_no2 FROM product_planning");
$status2 = $stmt2->execute();
$item_no="";
if ($status2 == false) {
    sql_error($status2);
} else {
    while( $r2 = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
        $item_no .='<option value='.h($r2['item_no2']).'>'.h($r2['item_no2']).'</option>';
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product_planning.css">
    <title>バルク登録商品</title>
</head>
<body>
<header>
    <h1>Product Management Tool</h1>
    <p>user:  <?= $user_name.'('.$role_flg.')'?></p>
    <a href="./php/logout.php"><p>Log OUT</p></a>
</header>

<h2>バルク登録</h2>
<a href="./main.php">HOMEに戻る</a><br>
<a href="./bulk.php">バルク一覧に戻る</a>
<div class="bulk_reg">
    <h3>バルク登録</h3>
    <form method="POST" action="./php/bulk_registration.php">
        <div>
            <fieldset>
                <table>
                <label><tr><th>契約番号：</th><td><input type="text" name="contract_no"></td></tr></label>
                <label><tr><th>輸入予定日</th><td><input type="date" name="at_date"></td></tr></label>
                <label><tr><th>BRAND：</th>
                    <td><select name="brand">
                        <?= $brand ?>
                    </td></tr></label>
                <label><tr><th>商品番号：</th>
                    <td>
                        <select name="item_no">
                        <?= $item_no ?>
                    </select>
                    </td></tr></label>
                    <label><tr><th>カラー：</th>
                    <td>
                        <select name="color">
                        <option value="Black">ブラック</option>
                        <option value="White">ホワイト</option>
                        <option value="Kahki">カーキ</option>
                    </select>
                    </td></tr></label>
                <label>
                    <tr><th>SSサイズ</th><td><input type="text" name="SS"></td></tr></label>
                <label>
                    <tr><th>Sサイズ</th><td><input type="text" name="S"></td></tr></label>
                <label>
                    <tr><th>Mサイズ</th><td><input type="text" name="M"></td></tr></label>
                <label>
                    <tr><th>Lサイズ</th><td><input type="text" name="L"></td></tr></label>
                <label>
                    <tr><th>LLサイズ</th><td><input type="text" name="LL"></td></tr></label>
                </table>
                <input type="submit" value="登録">
            </fieldset>
        </div>
    </form>
</div>
