<?php
session_start();

require_once('./php/funcs.php');

loginCheck();
$user_name = $_SESSION['name'];
$role_flg = $_SESSION['role_flg'];

$no = $_GET['no'];

$pdo = db_conn();

$stmt1 = $pdo->prepare(
    "SELECT * FROM product_planning
    LEFT JOIN category ON product_planning.category=category.category_id 
    WHERE item_no2=:no;
    ");
$stmt1->bindValue(':no',$no,PDO::PARAM_STR);
$status1 = $stmt1->execute();
if ($status1 == false) {
    sql_error($status1);
} else {
    $result1 = $stmt1->fetch();
    }

$stmt2 = $pdo->prepare(
    "SELECT * FROM sku 
    LEFT JOIN category ON sku.category=category.category_id
    WHERE item_no2=:no;
    ");
$stmt2->bindValue(':no',$no,PDO::PARAM_STR);
$sku_list="";
$status2 = $stmt2->execute();
if ($status2 == false) {
    sql_error($status2);
} else {
    while( $result2 = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
        $sku_list .='<tr>';
        $sku_list .='<td>'.$result2["item_no2"].'</td>';
        $sku_list .='<td>'.$result2["sku_no"].'</td>';
        $sku_list .='<td>'.$result2["category_name"].'</td>';
        $sku_list .='<td>'.$result2["color"].'</td>';
        $sku_list .='<td>'.$result2["size"].'</td>';
        $sku_list .='<td>'.$result2["a"].'</td>';
        $sku_list .='<td>'.$result2["b"].'</td>';
        $sku_list .='<td>'.$result2["c"].'</td>';
        $sku_list .='<td>'.$result2["d"].'</td>';
        }
    }

$stmt6 = $pdo->prepare("SELECT * FROM image WHERE item_no2=:no");
$stmt6->bindValue(':no',$no,PDO::PARAM_STR);
$status6 = $stmt6->execute();     
$image="";
     if ($status6 == false){
         sql_error($status6);
     } else {
         while( $r6 =$stmt6->fetch(PDO::FETCH_ASSOC)){
            $image .= '<a href="./image/'.$r6["img_path"].'" target="_blank"><img src="image/'.$r6["img_path"].'"></a>';
         }
     }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKU一覧</title>
</head>
<body>
<!-- ヘッダー系の対応 -->
<header>
    <h1>Product Management Tool</h1>
    <p>user:  <?= $user_name.'('.$role_flg.')'?></p>
    <a href="./php/logout.php"><p>Log OUT</p></a>
</header>
<a href="./main.php">HOMEに戻る</a><br>
<!-- メインコンテンツ -->
<div class="info">
    <h2>商品番号：<?= $result1['item_no2']?></h2>
    <h2>商品名：<?= $result1['item_name']?></h2>
</div>
<div class="new">
    <form action="./php/sku_registration.php" method="post">
    <fieldset>
        <table>
                <input type="hidden" name="item_no2" value="<?= $result1['item_no2'] ?>">
                <input type="hidden" name="item_no1" value="<?= $result1['item_no1'] ?>">
                <input type="hidden" name="category" value="<?= $result1['category'] ?>">
            <tr>
                <th>カラー</th>
                <td>
                <select name="color">
                    <option value="11">ホワイト</option>
                    <option value="20">ブラック</option>
                    <option value="50">ベージュ</option>
                    <option value="65">カーキ</option>
                    <option value="77">ネイビー</option>
                </select>
                </td>
            </tr>
            <tr>
                <th>サイズ</th>
                <td>
                <select name="size">
                    <option value="3">S</option>
                    <option value="4">M</option>
                    <option value="5">L</option>
                    <option value="6">LL</option>
                    <option value="9">フリーサイズ</option>
                </select>
                </td>
            </tr>
            <tr>
                <th>着丈/ウエスト</th>
                <td><input type="text" name="a"></td>
            </tr>
            <tr>
                <th>肩幅/ヒップ</th>
                <td><input type="text" name="b"></td>
            </tr>            
            <tr>
                <th>身幅/股上</th>
                <td><input type="text" name="c"></td>
            </tr>            
            <tr>
                <th>裄丈/股下</th>
                <td><input type="text" name="d"></td>
            </tr>            
            </table>
            <input type="submit" value="登録">
    </fieldset>    
    </form>
</div>

<div class="img">
    <p>関連を保存</p>
        <div class="upload_area">
            <form action="./php/image_up.php" method="post" enctype="multipart/form-data">
            <input type="file" accept="image/*" name="image"><br>
            <select name="type">
                <option value="sample">サンプル画像</option>
                <option value="ec">EC画像</option>
            </select><br>
            <input type="hidden" name="item_no2" value="<?= $result1['item_no2'] ?>">
            <input type="submit" value="画像を保存">
            </form>
        </div>
    <div class="image_area">
        <?=$image?>    
    </div>
</div>

<div class="list">
    <table>
        <tr>
            <th>商品番号</th>
            <th>SKU番号</th>
            <th>カテゴリー</th>
            <th>カラー</th>
            <th>サイズ</th>
            <th>着丈</th>
            <th>肩幅</th>
            <th>身幅</th>
            <th>裄丈</th>
        </tr>
        <tr>
            <?= $sku_list ?>
        </tr>
    </table>
</div>



</body>
</html>