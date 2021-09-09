<?php
session_start();

$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

require_once('funcs.php');
$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM h_user WHERE lid=:lid");
$stmt->bindValue(':lid',$lid, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false){
    sql_error($stmt);
}

$val = $stmt->fetch();
if( password_verify($lpw, $val["lpw"]) ){
  //Login成功時
  $_SESSION['chk_ssid']  = session_id();
  $_SESSION['role_flg'] = $val['role_flg'];
  $_SESSION['name']      = $val['name'];
  redirect('../main.php');
}else{
  //Login失敗時(Logout経由)
  redirect('../login.php');
}

exit();


