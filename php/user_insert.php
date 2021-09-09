<?php
require_once('./funcs.php');

$user_name =$_POST["user_name"];
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];
$hlpw = password_hash($lpw,PASSWORD_DEFAULT);
$user_role = $_POST["user_role"];

//DB connect
$pdo = db_conn();

//SQL
$stmt = $pdo->prepare(
    "INSERT INTO h_user(id, name, lid, lpw, role_flg, life_flg, registerd_date, updated_date)
     VALUES(NULL, :user_name, :lid, :lpw, :user_role, 0, sysdate(), sysdate())"
     );

$stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $hlpw, PDO::PARAM_STR);
$stmt->bindValue(':user_role', $user_role, PDO::PARAM_INT);

$status = $stmt->execute();

if($status==false){
    sql_error($stmt);
    }else{
    echo '<script type="text/javascript">alert("登録完了");</script>';
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録完了画面</title>
</head>
<body>
  <h1>Thank you</h1>
  <div class="registered_conf">
    <table>
        <tr>
            <th>NAME:</th>
            <td><?= h($user_name)?></td>
        </tr>
        <tr>
            <th>Log-in ID:</th>
            <td><?= h($lid)?></td>
        </tr>
        <tr>
            <th>PASSWORD:</th>
            <td><?= h($lpw)?></td>
        </tr>
        <tr>
            <th>ROLE:</th>
            <td>
                <?=h($user_role)?>
            </td>
        </tr>
    </table>
  </div>  
  <div>
  <h2><a href="../login.php">ログイン画面の「登録ユーザーの方はこちら」からログインしてください</a></h2>
  </div>
</body>
</html>