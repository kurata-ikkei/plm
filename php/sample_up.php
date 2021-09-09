<?php
session_start();

require_once('./funcs.php');

$id = $_POST["id"];
$item_no2 = $_POST["item_no2"];
$conf_date = $_POST["conf_date"];
$comment = $_POST["comment"];

$pdo = db_conn();

$sql = $pdo->prepare(
    "UPDATE sample_phase 
    SET conf_date=:conf_date,
        comment=:comment,
        updated_at=sysdate() 
    WHERE id =:id
    "
    );
$sql->bindValue(':conf_date',$conf_date,PDO::PARAM_STR);        
$sql->bindValue(':comment',$comment,PDO::PARAM_STR);
$sql->bindValue(':id',$id,PDO::PARAM_INT);

$status = $sql->execute();

if($status==false){
    sql_error($sql);
    }else{
    redirect('../product_detail.php?no='.$item_no2);
    }     

