<?php
session_start();

require_once('./funcs.php');

$item_no2 = $_POST["item_no2"];
$brand = $_POST["brand"];
$janre = $_POST["janre"];
$gender = $_POST["gender"];
$year = $_POST["year"];
$season = $_POST["season"];
$category = $_POST["category"];
$item_name = $_POST["item_name"];
$pattern_id = $_POST["pattern_id"];
$factory_id = $_POST["factory_id"];

$pdo = db_conn();

$sql = $pdo->prepare(
    "UPDATE product_planning 
    SET brand=:brand,
        janre=:janre,
        gender=:gender,
        year=:year,
        season=:season,
        category=:category,
        pattern_id =:pattern_id,
        factory_id=:factory_id,
        item_name=:item_name,
        updated_at=sysdate() 
    WHERE item_no2=:item_no2
    "
    );
$sql->bindValue(':brand',$brand,PDO::PARAM_INT);
$sql->bindValue(':janre',$janre,PDO::PARAM_INT);
$sql->bindValue(':gender',$gender,PDO::PARAM_INT);
$sql->bindValue(':year',$year,PDO::PARAM_INT);
$sql->bindValue(':season',$season,PDO::PARAM_INT);
$sql->bindValue(':category',$category,PDO::PARAM_INT);        
$sql->bindValue(':item_no2',$item_no2,PDO::PARAM_STR);
$sql->bindValue(':pattern_id',$pattern_id,PDO::PARAM_STR);
$sql->bindValue(':factory_id',$factory_id,PDO::PARAM_INT);
$sql->bindValue(':item_name',$item_name,PDO::PARAM_STR);

$status = $sql->execute();

if($status==false){
    sql_error($sql);
    }else{
    redirect('../product_detail.php?no='.$item_no2);
    }     