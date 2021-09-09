<?php
session_start();
require_once("./funcs.php");

$item_no2 = $_POST["item_no2"];
$type = $_POST["type"];


 if (isset($_FILES["image"] ) && $_FILES["image"]["error"] ==0 ) {
     $file_name = $_FILES["image"]["name"];
     $tmp_path  = $_FILES["image"]["tmp_name"];
     $extension = pathinfo($file_name, PATHINFO_EXTENSION);
     $file_name = date("YmdHis").md5(session_id()) . "." . $extension;

     $img="";
     $file_dir_path = "../image/".$file_name;

     //echo $item_no2.$file_dir_path;//ok

    if ( is_uploaded_file( $tmp_path ) ) {
        if ( move_uploaded_file( $tmp_path, $file_dir_path ) ) {
            chmod( $file_dir_path, 0644 );
                $pdo = db_conn();
                $sql = "INSERT INTO image(id,item_no2, img_path, type, uploaded_at) VALUES(null, :item_no2, :img, :type, sysdate())";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':item_no2', $item_no2, PDO::PARAM_STR);
                $stmt->bindValue(':img', $file_name, PDO::PARAM_STR);
                $stmt->bindValue(':type', $type, PDO::PARAM_STR);
                $status = $stmt->execute();
                //データ登録処理後
                if ($status == false) {
                    sql_error($stmt);
                } else {
                    redirect('../product_detail.php?no='.$item_no2);
                    //$img = '<img src=../"'.$file_dir_path.'">';
                }
        } else {
        }
     }


}else{
    $img = "画像が送信されていません";
}

?>