<?php
session_start();

require_once('./php/funcs.php');

loginCheck();
$user_name = $_SESSION['name'];
$role_flg = $_SESSION['role_flg'];


$pdo = db_conn();

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

$stmt2 = $pdo->prepare("SELECT * FROM category");
$status2 = $stmt2->execute();
$category="";
    if ($status2 == false) {
        sql_error($status2);
    } else {
        while( $r2 = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
            $category .='<option value='.h($r2['category_id']).'>'.h($r2['category_name']).'</option>';
            }
        }

$stmt3 = $pdo->prepare("SELECT * FROM season");
$status3 = $stmt3->execute();
$season="";
            if ($status3 == false) {
                sql_error($status3);
            } else {
                while( $r3 = $stmt3->fetch(PDO::FETCH_ASSOC)){ 
                    $season .='<option value='.h($r3['season_id']).'>'.h($r3['season_name']).'</option>';
                    }
                }

$stmt4 = $pdo->prepare("SELECT * FROM janre");
$status4 = $stmt4->execute();
$janre="";
    if ($status4 == false) {
        sql_error($status4);
    } else {
        while( $r4 = $stmt4->fetch(PDO::FETCH_ASSOC)){ 
            $janre .='<option value='.h($r4['janre_id']).'>'.h($r4['janre_name']).'</option>';
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
    <title>商品管理</title>
</head>
<body>
<header>
    <h1>Product Management Tool</h1>
    <p>user:  <?= $user_name.'('.$role_flg.')'?></p>
    <a href="./php/logout.php"><p>Log OUT</p></a>
</header>

<h2>商品管理</h2>
<a href="./main.php">HOMEに戻る</a><br>
<a href="./product_list.php">登録ずみ商品リスト</a>
<div class="prd_reg">
    <h3>商品登録</h3>
    <form method="POST" action="./php/product_registeration.php">
        <div>
            <fieldset>
                <table>
                <label><tr><th>BRAND：</th>
                    <td><select name="brand">
                        <?= $brand ?>
                    </td></tr></label>
                <label><tr><th>GENRE：</th>
                    <td>
                        <select name="janre">
                            <?= $janre ?>
                        </select>
                    </td></tr></label>
                <label><tr><th>GENDER：</th>
                    <td>
                        <select name="gender">
                            <option value="2">Wemens</option>
                            <option value="1">Mens</option>
                            <option value="3">Unisex</option>    
                        </select>
                    </td></tr></label>
                <label><tr><th>YEAR：</th><td><input type="text" name="year"></td></tr></label>
                <label><tr><th>SEASON：</th>
                    <td><select name="season">
                        <?= $season ?>
                    </td></tr></label>
                <label><tr><th>CATEGORY：</th>
                    <td>
                        <select name="category">
                            <?= $category ?>
                        </select>
                        </td></tr></label>
                <label><tr><th>ITEM_NAME：</th><td><input type="text" name="item_name"></td></tr></label>
                <label><tr><th>PATTERN NO：</th><td><input type="text" name="pattern_id"></td></tr></label>
                <label><tr><th>FACTORY：</th>
                    <td>
                        <select name="factory_id">
                            <option value="1">test1</option>
                            <option value="2">test2</option>
                            <option value="3">test3</option>
                    </select>
                    </td></tr></label>
                </table>
                <input type="submit" value="登録">
            </fieldset>
        </div>
    </form>
</div>