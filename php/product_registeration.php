<?php
session_start();

require_once('./funcs.php');

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

$stmt1 = $pdo->prepare(
"SELECT COUNT(id) AS Num FROM product_planning 
WHERE brand = :brand
AND janre = :janre
AND gender = :gender
AND year = :year
AND season = :season
AND category =:category
"
);
$stmt1->bindValue(':brand',$brand,PDO::PARAM_INT);
$stmt1->bindValue(':janre',$janre,PDO::PARAM_INT);
$stmt1->bindValue(':gender',$gender,PDO::PARAM_INT);
$stmt1->bindValue(':year',$year,PDO::PARAM_INT);
$stmt1->bindValue(':season',$season,PDO::PARAM_INT);
$stmt1->bindValue(':category',$category,PDO::PARAM_INT);

$status1 = $stmt1->execute();

$number = "";
if ($status1 == false) {
    sql_error($status1);
} else {
    $r1 = $stmt1->fetch();
    $num = $r1['Num']+1;
    $num2 = sprintf("%02d", $num); //2桁対応

    $fy = $year - 2020;
    $fy2 = sprintf("%02d", $fy);
    $category2 = sprintf("%02d", $category);

    $item_no1 = $brand.$janre.$gender.$fy2.$season.$category2.$num2;
    //echo $item_no1."<br>"; //OK

    $stmt2 = $pdo->prepare("SELECT brand FROM brand WHERE id = $brand");
    $status2 = $stmt2->execute();
    $brand_code = "";
        if($status2==false) {
            sql_error($stmt2);
        }else{
            $r2 = $stmt2->fetch(); 
            $brand_code .=h($r2["brand"]);
        } 
    $stmt3 = $pdo->prepare("SELECT season_code FROM season WHERE season_id = $season");
    $status3 = $stmt3->execute();        
    $season_code = "";
        if($status3==false) {
            sql_error($stmt3);
        }else{
            $r3 = $stmt3->fetch(); 
            $season_code .=h($r3["season_code"]);
        }     
    $stmt4 = $pdo->prepare("SELECT category_code FROM category WHERE category_id = $category");
    $status4 = $stmt4->execute();        
    $category_code = "";
        if($status4==false) {
            sql_error($stmt4);
        }else{
            $r4 = $stmt4->fetch(); 
            $category_code .=h($r4["category_code"]);
        }
    $stmt5 = $pdo->prepare("SELECT janre_code FROM janre WHERE janre_id = $janre");
    $status5 = $stmt5->execute();        
    $janre_code = "";
        if($status5==false) {
            sql_error($stmt5);
        }else{
            $r5 = $stmt5->fetch(); 
            $janre_code .=h($r5["janre_code"]);
        }
    $stmt6 = $pdo->prepare("SELECT gender_code FROM gender WHERE id = $gender");
    $status6 = $stmt6->execute();        
    $gender_code = "";
        if($status6==false) {
            sql_error($stmt6);
        }else{
            $r6 = $stmt6->fetch(); 
            $gender_code .=h($r6["gender_code"]);
        }
    $item_no2 = $brand_code.$janre_code."-".$gender_code.$fy2.$season_code.$category_code.$num2;
    //echo $item_no2;

    $sql = $pdo->prepare(
        "INSERT INTO product_planning 
        (id, brand, janre, gender, year, season, category, item_no1, item_no2, pattern_id, factory_id, flg, created_at, updated_at,item_name) 
        VALUES 
        (NULL, :brand, :janre, :gender, :year, :season, :category, :item_no1, :item_no2, :pattern_id, :factory_id, 1, sysdate(), sysdate(),:item_name)"
        );
    $sql->bindValue(':brand',$brand,PDO::PARAM_INT);
    $sql->bindValue(':janre',$janre,PDO::PARAM_INT);
    $sql->bindValue(':gender',$gender,PDO::PARAM_INT);
    $sql->bindValue(':year',$year,PDO::PARAM_INT);
    $sql->bindValue(':season',$season,PDO::PARAM_INT);
    $sql->bindValue(':category',$category,PDO::PARAM_INT);        
    $sql->bindValue(':item_no1',$item_no1,PDO::PARAM_STR);        
    $sql->bindValue(':item_no2',$item_no2,PDO::PARAM_STR);
    $sql->bindValue(':pattern_id',$pattern_id,PDO::PARAM_STR);
    $sql->bindValue(':factory_id',$factory_id,PDO::PARAM_INT);
    $sql->bindValue(':item_name',$item_name,PDO::PARAM_STR);
    
    $status7 = $sql->execute();

    if($status7==false){
        sql_error($sql);
        }else{
        redirect('../product_detail.php?no='.$item_no2);
        }     
}
?>