<?php
session_start();

require_once('./funcs.php');

$item_no2 = $_POST["item_no2"];
$item_no1 = $_POST["item_no1"];
$category = $_POST["category"];
$color = $_POST["color"];
$size = $_POST["size"];
$a = $_POST["a"];
$b = $_POST["b"];
$c = $_POST["c"];
$d = $_POST["d"];

$pdo = db_conn();

$sku_no = $item_no1.$size.$color;
// echo $sku_no;

$sql = $pdo->prepare(
    "INSERT INTO sku 
    (id, item_no2, sku_no, category, color, size, a, b, c, d, flg, created_at) 
    VALUES 
    (NULL, :item_no2, :sku_no, :category, :color, :size, :a, :b, :c, :d, 1, sysdate())"
    );
$sql->bindValue(':item_no2',$item_no2,PDO::PARAM_STR);        
$sql->bindValue(':sku_no',$sku_no,PDO::PARAM_STR);
$sql->bindValue(':category',$category,PDO::PARAM_INT);        
$sql->bindValue(':color',$color,PDO::PARAM_INT);        
$sql->bindValue(':size',$size,PDO::PARAM_INT);        
$sql->bindValue(':a',$a,PDO::PARAM_INT);
$sql->bindValue(':b',$b,PDO::PARAM_INT);
$sql->bindValue(':c',$c,PDO::PARAM_INT);
$sql->bindValue(':d',$d,PDO::PARAM_INT);

$status7 = $sql->execute();

if($status7==false){
    sql_error($sql);
    }else{
    redirect('../sku.php?no='.$item_no2);
    }     