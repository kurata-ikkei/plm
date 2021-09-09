<?php
session_start();

require_once('./funcs.php');

$item_no2 = $_POST["item_no2"];
$sample_phase = $_POST["sample_phase"];
$fabric = $_POST["fabric"];
$trim = $_POST["trim"];
$shipped_date = $_POST["shipped_date"];
$shipped_id = $_POST["shipped_id"];

$pdo = db_conn();

$sql = $pdo->prepare(
    "INSERT INTO sample_phase
    (id,item_no2,sample_phase,fabric,trim,shipped_date,shipped_id,conf_date,comment,created_at,updated_at) 
    VALUES 
    (NULL,:item_no2,:sample_phase,:fabric,:trim,:shipped_date,:shipped_id,null,null,sysdate(),sysdate()) 
    ");
$sql->bindValue(':item_no2',$item_no2,PDO::PARAM_STR);
$sql->bindValue(':sample_phase',$sample_phase,PDO::PARAM_STR);
$sql->bindValue(':fabric',$fabric,PDO::PARAM_STR);
$sql->bindValue(':trim',$trim,PDO::PARAM_STR);
$sql->bindValue(':shipped_date',$shipped_date,PDO::PARAM_STR);
$sql->bindValue(':shipped_id',$shipped_id,PDO::PARAM_STR);        

$status = $sql->execute();

if($status==false){
    sql_error($sql);
    }else{
    redirect('../product_detail.php?no='.$item_no2);
    }     



