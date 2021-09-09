<?php

session_start();

require_once('./funcs.php');

// 1. POSTデータ取得
$id = $_POST["id"];
$user_name = $_POST["name"];
$lid = $_POST["lid"];
$user_role = $_POST["user_role"];
$life_flg = $_POST["life_flg"];

$pdo = db_conn();

//SQL
    $stmt = $pdo->prepare(
        "UPDATE h_user 
        SET name = :user_name, lid = :lid, role_flg = :user_role, life_flg = :life_flg, updated_date=sysdate()
        WHERE id = :id;" 
        );

//bind
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);        
    $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $stmt->bindValue(':user_role', $user_role, PDO::PARAM_INT);
    $stmt->bindValue(':life_flg', $life_flg, PDO::PARAM_INT);

//SQL go
    $status = $stmt->execute();

//update
    if($status==false){
    sql_error($stmt);
    }else{
//redirect
    redirect('../user_mgt.php');
    }
?>