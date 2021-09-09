<?php
session_start();

require_once('./funcs.php');

$contract_no = $_POST["contract_no"];
$at_date = $_POST["at_date"];
$brand = $_POST["brand"];
$item_no = $_POST["item_no"];
$color = $_POST["color"];
$SS = $_POST["SS"];
$S = $_POST["S"];
$M = $_POST["M"];
$L = $_POST["L"];
$LL = $_POST["LL"];

$pdo = db_conn();


$sql = $pdo->prepare(
    "INSERT INTO bulk_list
    (id, contract_no, at_date, brand, item_no, color, SS, S, M, L, LL, updated_at, created_at)
    VALUES
    (NULL, :contract_no, :at_date, :brand, :item_no, :color, :SS, :S, :M, :L, :LL, sysdate(), sysdate())
    "
);
$sql->bindValue(':contract_no',$contract_no,PDO::PARAM_STR);
$sql->bindValue(':at_date',$at_date,PDO::PARAM_STR);
$sql->bindValue(':brand',$brand,PDO::PARAM_INT);
$sql->bindValue(':item_no',$item_no,PDO::PARAM_STR);
$sql->bindValue(':color',$color,PDO::PARAM_STR);
$sql->bindValue(':SS',$SS,PDO::PARAM_INT);
$sql->bindValue(':S',$S,PDO::PARAM_INT);
$sql->bindValue(':M',$M,PDO::PARAM_INT);
$sql->bindValue(':L',$L,PDO::PARAM_INT);
$sql->bindValue(':LL',$LL,PDO::PARAM_INT);

$status = $sql->execute();

if($status==false){
    sql_error($sql);
    }else{
    redirect('../bulk_mod.php?contract_no='.$contract_no);
    }     
?>