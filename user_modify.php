<?php //管理者用ページ
session_start();

require_once('./php/funcs.php');

loginCheck();
$user_name = $_SESSION['name'];
$role_flg = $_SESSION['role_flg'];

$pdo = db_conn();

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM h_user WHERE id=:id;");
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
    <title>ユーザー情報編集</title>
</head>
<body>
<header>編集</header>
<a href="./user_mgt.php">ユーザー管理に戻る</a>
<div class="prd_reg">
    <h3>ユーザー情報編集</h3>
    <form method="POST" action="./php/modify_user.php">
        <div>
            <fieldset>
                <table>
                <label><tr><th>NAME：</th><td><input type="text" name="name" value="<?= $result['name'] ?>"></td></tr></label>
                <label><tr><th>login-id：</th><td><input type="text" name="lid" value="<?= $result['lid'] ?>"></td></tr></label>
                <label><tr><th>login-pw：</th><td>この機能でパスワード変更はできません（ユーザーで対応）</td></tr></label>
                <label><tr><th>role：</th>
                    <td>
                        <select name="user_role">
                            <option value="0"<?php if ( $result['role_flg'] === '0' ) { echo ' selected'; } ?>>管理者</option>
                            <option value="1"<?php if ( $result['role_flg'] === '1' ) { echo ' selected'; } ?>>一般ユーザー</option>
                            <option value="2"<?php if ( $result['role_flg'] === '2' ) { echo ' selected'; } ?>>参照ユーザー</option>    
                        </select>
                    </td></tr></label>
                <label><tr><th>life_flg：</th>
                    <td>
                        <select name="life_flg">
                            <option value="0"<?php if ( $result['life_flg'] === '0' ) { echo ' selected'; } ?>>live</option>
                            <option value="1"<?php if ( $result['life_flg'] === '1' ) { echo ' selected'; } ?>>lock</option>
                        </select>
                    </td></tr></label>
                </table>
                <input type="hidden" name="id" value="<?= $result['id'] ?>">
                <input type="submit" value="編集">
            </fieldset>
        </div>
    </form>
</div>