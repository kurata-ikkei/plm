<?php
//DB接続
//local server
function db_conn(){
    try {
        $db_name = "gs_db"; 
        $db_id   = "root"; 
        $db_pw   = "root"; 
        $db_host = "localhost"; 
        $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
        return $pdo; //これ書かないといけない（処理結果を外だしするため）
    } catch (PDOException $e) {
      exit('DBConnectError:'.$e->getMessage());
      }
}

//sakura
// function db_conn(){
//     try {
//         $db_name = "mil1st08_08ik";
//         $db_id   = "mil1st08"; 
//         $db_pw   = "kurata_1101"; 
//         $db_host = "mysql57.mil1st08.sakura.ne.jp"; 
//         $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
//         return $pdo;
//     } catch (PDOException $e) {
//       exit('DBConnectError:'.$e->getMessage());
//       }
// }

//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:" . print_r($error, true));
}

//リダイレクト関数: redirect($file_name)
function redirect($file_name){
    header("Location: " . $file_name );
    exit();
}

//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

//ログインチェック
function loginCheck(){
    if( $_SESSION["chk_ssid"] != session_id() ){
      exit('LOGIN ERROR');
    }else{
      session_regenerate_id(true);
      $_SESSION['chk_ssid'] = session_id();
    }
  }