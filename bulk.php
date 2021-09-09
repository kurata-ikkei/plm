<?php
session_start();

require_once('./php/funcs.php');

loginCheck();
$user_name = $_SESSION['name'];
$role_flg = $_SESSION['role_flg'];

$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM bulk_list");
$status = $stmt->execute();
$list="";
if ($status == false) {
    sql_error($status);
} else {
    while( $r =$stmt->fetch(PDO::FETCH_ASSOC)){
        $list .='<tr>';
        $list .= '<td>'.$r["contract_no"].'</td>';
        $list .= '<td>'.$r["at_date"].'</td>';
        $list .= '<td>'.$r["brand"].'</td>';
        $list .= '<td></td>';
        $list .= '<td><a href="./bulk_mod.php?contract_no='.h($r["contract_no"]).'">更新</a></td></tr>';
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
    <title>バルク管理_TOP</title>
</head>
<body>
    <header>
        <h1>Product Management Tool</h1>
        <p>user:  <?= $user_name.'('.$role_flg.')'?></p>
        <a href="./php/logout.php"><p>Log OUT</p></a>
    </header>
    <a href="./main.php">HOMEに戻る</a><br>
    <a href="./bulk_reg.php">バルク登録</a>
    
    <table>
        <tr>
            <th>契約番号</th>
            <th>輸入予定日</th>
            <th>ブランド</th>
            <th>ステータス</th>
            <th>更新・確認</th>
        </tr>
        <?= $list ?>
    </table>

</body>
</html>