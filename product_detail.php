<?php
session_start();

require_once('./php/funcs.php');

loginCheck();
$user_name = $_SESSION['name'];
$role_flg = $_SESSION['role_flg'];

$no = $_GET['no'];

$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM product_planning WHERE item_no2=:no;");
$stmt->bindValue(':no',$no,PDO::PARAM_STR);
$status = $stmt->execute();
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();
}

$stmt1 = $pdo->prepare("SELECT * FROM brand");
$status1 = $stmt1->execute();
$brand="";
if ($status1 == false) {
    sql_error($status1);
} else {
    while( $r1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
            if ($result['brand']===$r1['id']){
                $brand .='<option value='.h($r1['id']).' selected>'.h($r1['brand_name']).'</option>';
            }else{
                $brand .='<option value='.h($r1['id']).'>'.h($r1['brand_name']).'</option>';
            }
        }
    }

$stmt2 = $pdo->prepare("SELECT * FROM category");
$status2 = $stmt2->execute();
$category="";
    if ($status2 == false) {
        sql_error($status2);
    } else {
        while( $r2 = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
            if ($result['category']===$r2['category_id']){
                $category .='<option value='.h($r2['category_id']).' selected>'.h($r2['category_name']).'</option>';
            }else{    
                $category .='<option value='.h($r2['category_id']).'>'.h($r2['category_name']).'</option>';
            }
        }
    }

$stmt3 = $pdo->prepare("SELECT * FROM season");
$status3 = $stmt3->execute();
$season="";
    if ($status3 == false) {
            sql_error($status3);
    } else {
        while( $r3 = $stmt3->fetch(PDO::FETCH_ASSOC)){ 
            if ($result['season']===$r3['season_id']){
                $season .='<option value='.h($r3['season_id']).' selected>'.h($r3['season_name']).'</option>';
            }else{    
                $season .='<option value='.h($r3['season_id']).'>'.h($r3['season_name']).'</option>';
            }
        }
    }

$stmt4 = $pdo->prepare("SELECT * FROM janre");
$status4 = $stmt4->execute();
$janre="";
    if ($status4 == false) {
        sql_error($status4);
    } else {
        while( $r4 = $stmt4->fetch(PDO::FETCH_ASSOC)){ 
            if ($result['janre']===$r4['janre_id']){
                $janre .='<option value='.h($r4['janre_id']).' selected>'.h($r4['janre_name']).'</option>';
            }else{    
                $janre .='<option value='.h($r4['janre_id']).'>'.h($r4['janre_name']).'</option>';
            }
        }
    }
$stmt5 = $pdo->prepare("SELECT * FROM gender");
$status5 = $stmt5->execute();
$gender="";
    if ($status5 == false) {
        sql_error($status5);
    } else {
        while( $r5 = $stmt5->fetch(PDO::FETCH_ASSOC)){ 
            if ($result['gender']===$r5['id']){
                $gender .='<option value='.h($r5['id']).' selected>'.h($r5['gender_name']).'</option>';
            }else{    
                $gender .='<option value='.h($r5['id']).'>'.h($r5['gender_name']).'</option>';
            }
        }
     }
//画像表示
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
//FILE表示
$stmt7 = $pdo->prepare("SELECT * FROM file WHERE item_no2=:no");
$stmt7->bindValue(':no',$no,PDO::PARAM_STR);
$status7 = $stmt7->execute();     
$file="";
    if ($status7 == false){
        sql_error($status7);
    } else {
        while( $r7 =$stmt7->fetch(PDO::FETCH_ASSOC)){
            $file .= '<a href="./file/'.$r7["file_path"].'"><p>'.$r7["file_path"].'<p></a>';
        }
    }
//サンプル進捗表示
$stmt8 = $pdo->prepare("SELECT * FROM sample_phase WHERE item_no2=:no ORDER BY id");
$stmt8->bindValue(':no',$no,PDO::PARAM_STR);
$status8 = $stmt8->execute();     
$sample="";
    if ($status8 == false){
        sql_error($status8);
    } else {
        while( $r8 =$stmt8->fetch(PDO::FETCH_ASSOC)){
            $sample .= '<tr>';
            $sample .= '<td>'.$r8["sample_phase"].'</td>';
            $sample .= '<td>'.$r8["fabric"].'</td>';
            $sample .= '<td>'.$r8["trim"].'</td>';
            $sample .= '<td>'.$r8["shipped_date"].'</td>';
            $sample .= '<td>'.$r8["shipped_id"].'</td>';
            //input 受領日
            $sample .= '<form method="post" action="./php/sample_up.php">';
            $sample .= '<td><input type="date" name="conf_date" value="'.$r8["conf_date"].'"></td>';
            //input コメント
            $sample .= '<td><textarea name="comment">'.$r8["comment"].'</textarea></td>';
            //input submit
            $sample .= '<td><input type="hidden" name="id" value="'.$r8['id'].'"><input type="hidden" name="item_no2" value="'.$r8['item_no2'].'"><input type="submit" value="更新"></td></form>';
            $sample .= '</tr>';
        }
    } 

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product_detail.css">
    <title>商品詳細ページ</title>
</head>
<body>
<!-- ヘッダー系の対応 -->
<header>
    <h1>Product Management Tool</h1>
    <p>user:  <?= $user_name.'('.$role_flg.')'?></p>
    <a href="./php/logout.php"><p>Log OUT</p></a>
</header>
<a href="./main.php">HOMEに戻る</a><br>
<a href="./product_list.php">商品一覧に戻る</a>

<!-- メインコンテンツ -->
<div class="wrapper">
<div class="left">
    <div class="item_info">
        <form method="POST" action="./php/product_modification.php">
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
                                <?= $gender ?>  
                            </select>
                        </td></tr></label>
                    <label><tr><th>YEAR：</th><td><input type="text" name="year" value="<?=$result['year']?>"></td></tr></label>
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
                    <label><tr><th>ITEM_NAME：</th><td><input type="text" name="item_name" value="<?=$result['item_name'] ?>"></td></tr></label>
                    <label><tr><th>PATTERN NO：</th><td><input type="text" name="pattern_id" value="<?=$result['pattern_id'] ?>"></td></tr></label>
                    <label><tr><th>FACTORY：</th>
                        <td>
                            <select name="factory_id">
                                <option value="1">test1</option>
                                <option value="2">test2</option>
                                <option value="3">test3</option>
                        </select>
                        </td></tr></label>
                    </table>
                    <input type="hidden" name="item_no2" value="<?= $result['item_no2'] ?>">
                    <input type="submit" value="更新">
                </fieldset>
            </div>
        </form>
    </div>
    <div class="file">
        <p>関連資料（仕様書など）を保存</p>
        <div class="upload_area">
            <form action="./php/file_up.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file"><br>
            <input type="hidden" name="item_no2" value="<?= $result['item_no2'] ?>">
            <input type="submit" value="ファイルを保存">
            </form>
        </div>
        <div class="file_area">
            <?=$file?>
        </div>
    </div>
</div>
    <div class="right">
        <div class="img">
        <p>関連画像（サンプル画像など）を保存</p>
            <div class="upload_area">
                <form action="./php/image_up.php" method="post" enctype="multipart/form-data">
                <input type="file" accept="image/*" name="image"><br>
                <select name="type">
                    <option value="sample">サンプル画像</option>
                    <option value="ec">EC画像</option>
                </select><br>
                <input type="hidden" name="item_no2" value="<?= $result['item_no2'] ?>">
                <input type="submit" value="画像を保存">
                </form>
            </div>
            <div class="image_area">
                <?=$image?>    
            </div>
        </div>
    </div>
</div>


    <div class="sample">
        <table class="sample_table">
            <tr>
                <th>サンプル番号</th>
                <th>生地</th>
                <th>付属</th>
                <th>配送日</th>
                <th>配送ID</th>
                <th>確認日</th>
                <th>コメント</th>
                <th>登録・更新ボタン</th>
            </tr>
            <?=$sample?>
            <tr>
                <form action="./php/sample_status.php" method="post">
                    <input type="hidden" name="item_no2" value="<?= $result['item_no2'] ?>">
                        <td><select name="sample_phase">
                            <option value="1st">1stサンプル</option>
                            <option value="2nd">2ndサンプル</option>
                            <option value="3rd">3rdサンプル</option>
                            <option value="4th">4thサンプル</option>
                            <option value="5th">5thサンプル</option>
                        </select></td>
                        <td><input type="text" name="fabric"></td>
                        <td><input type="text" name="trim"></td>
                        <td><input type="date" name="shipped_date"></td>
                        <td><input type="text" name="shipped_id"></td>
                        <td>入力不要（更新時に入力）</td>
                        <td>入力不要（更新時に入力）</td>
                        <td><input type="submit" value="登録"></td>
                </form>
            </tr>
        </table>
    </div>


    
</body>
</html>