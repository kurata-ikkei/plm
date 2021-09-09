<?php
session_start();
require_once("./funcs.php");

$item_no2 = $_POST["item_no2"];

if (isset($_FILES["file"] ) && $_FILES["file"]["error"] ==0 ) {
    $file_name = $_FILES["file"]["name"];
    $tmp_path  = $_FILES["file"]["tmp_name"];
    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name = date("YmdHis").md5(session_id()) . "." . $extension;

    $file="";
    $file_dir_path = "../file/".$file_name;

    if ( is_uploaded_file( $tmp_path ) ) {
        if ( move_uploaded_file( $tmp_path, $file_dir_path ) ) {
            chmod( $file_dir_path, 0644 );
                $pdo = db_conn();
                $sql = "INSERT INTO file(id,item_no2, file_path, upload_date) VALUES(null, :item_no2, :file, sysdate())";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':item_no2', $item_no2, PDO::PARAM_STR);
                $stmt->bindValue(':file', $file_name, PDO::PARAM_STR);
                $status = $stmt->execute();

                if ($status == false) {
                    sql_error($stmt);
                } else {
                    redirect('../product_detail.php?no='.$item_no2);
                }
//        } else {
//        }
     }


 }else{
    $file = "ファイルが送信されていません";
 }
}