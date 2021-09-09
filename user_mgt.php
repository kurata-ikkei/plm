<?php //管理者用ページ
session_start();

require_once('./php/funcs.php');

loginCheck();
$user_name = $_SESSION['name'];
$role_flg = $_SESSION['role_flg'];

$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM h_user");

$status = $stmt->execute();

//4．データ表示
$view="";
if($status==false) {
    sql_error($stmt);
}else{
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $view .="<tr>";
    $view .= "<td>".h($result['id']).'</td><td>'.h($result['name']).'</td><td>'.h($result['lid']).'</td><td>'.h($result['lpw']).'</td><td>'.h($result['role_flg']).'</td><td>'.h($result['life_flg']).'</td>';
    $view .='<td><a href="./user_modify.php?id='.h($result['id']).'">編集</a></td>';
    $view .='<td><a href="./php/delete_user.php?id='.h($result['id']).'">削除</a></td>';
    $view .="</tr>";
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/user_mgt.css">
    <title>ユーザー管理画面</title>
</head>
<body>
<header>
<h1>Product Management Tool</h1>
    <p>user:  <?= $user_name.'('.$role_flg.')'?></p>
    <a href="./php/logout.php"><p>Log OUT</p></a>
</header>
    <h1>ログイン・登録画面</h1>
    <a href="./main.php">管理画面に戻る</a><br>
    <a href="./login.php">ログイン・ユーザー追加</a>

<div>
    <h2>ユーザー一覧</h2>
    <table class="list_table">
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>login-id</th>
                <th>login-pw</th>
                <th>role</th>
                <th>life_flg</th>
                <th>編集ボタン</th>
                <th>削除ボタン</th>
                </tr>
                <?= $view ?>
        </table>
</div>
</body>
</html>