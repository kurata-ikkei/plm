<?php //ログインユーザー用ページ
session_start();

require_once('./php/funcs.php');

//login chk
loginCheck();
$user_name = $_SESSION['name'];
$role_flg = $_SESSION['role_flg'];


//DB
$pdo = db_conn();

//グラフ１
$stmt = $pdo->prepare("SELECT category, COUNT(id) FROM product_planning GROUP BY category");
$status = $stmt->execute();

//4．データ表示＆配列に加工
$graph1="";
$category ="";
$count ="";

if($status==false) {
  sql_error($stmt);
}else{
  while( $result1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $graph1 .="<tr>";
    $graph1 .= "<td>".h($result1['category']).'</td><td>'.h($result1['COUNT(id)']);
    $graph1 .="</tr>";
    $category = $category. '"'. $result1['category'].'",';
    $count = $count. '"'. $result1['COUNT(id)'].'",';
    }
    $category = trim($category,",");
    $count = trim($count,",");
}

//グラフ２
$pdo = db_conn();
$stmt2 = $pdo->prepare("SELECT category, ROUND(AVG(item_price),0) AS average FROM product GROUP BY category");
$status2 = $stmt2->execute();
$graph2="";
$category2="";
$avg="";
if($status2==false) {
    sql_error($stmt2);
  }else{
    while( $result2 = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
      $graph2 .="<tr>";
      $graph2 .= "<td>".h($result2['category']).'</td><td>'.h($result2['average']);
      $graph2 .="</tr>";
      $category2 = $category2. '"'. $result2['category'].'",';
      $avg = $avg. '"'. $result2['average'].'",';
      }
      $category2 = trim($category2,",");
      $avg = trim($avg,",");
  }
  


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js" integrity="sha512-VCHVc5miKoln972iJPvkQrUYYq7XpxXzvqNfiul1H4aZDwGBGC0lq373KNleaB2LpnC2a/iNfE5zoRYmB4TRDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="./css/main.css">
    <title>管理画面</title>
</head>
<body>
<header>
    <h1>Product Management Tool</h1>
    <p>user:  <?= $user_name.'('.$role_flg.')'?></p>
    <a href="./php/logout.php"><p>Log OUT</p></a>
</header>

<div class="wrapper">
    <div class="menu">
        <h2>メニュー</h2>    
            <li><a href="./product_list.php">商品管理</a></li>
            <li><a href="./bulk.php">バルク管理</a></li>
            <!-- <li><a href="#">BIツール（未）</a></li> -->
            <?php //管理者権限（0)以外の人はアクセスできない
            if($role_flg === '0'){ 
            echo '<li><a href="#">マスター管理（未）</a></li>';
            echo '<li><a href="./user_mgt.php">ユーザー管理</a></li>';
            }
            ?>
        
    </div>

    <div class="content">
        <h2>ダッシュボード</h2>
        <div class="item">
            <h3>アイテム構成比（2021年）</h3>
            <div class="graph1">
                <table class="data_table">
                    <tr>
                        <th>アイテムカテゴリー</th>
                        <th>展開品番数</th>
                    </tr>
                    <?= $graph1 ?>
                </table>
                <div class="grapharea">
                    <canvas id="myChart1" style="position: relative; height:100; width:150"></canvas>
                </div>
            </div>
        </div>
        <div class="item">
            <h3>カテゴリー別平均売価</h3>
            <div class="graph2">
                    <div class="grapharea">
                    <canvas id="myChart2"></canvas>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
    //pie chartを作成する
    var ctx = document.getElementById("myChart1");
    var myChart = new Chart(ctx, {
    type: 'pie',
        data: {
            labels: [<?php echo $category ?>],
            datasets: [{
                backgroundColor: [
                    'rgba(255, 50, 50, 0.2)',
                    'rgba(255, 100, 50, 0.2)',
                    'rgba(255, 153, 50, 0.2)',
                    'rgba(255, 255, 50, 0.2)',
                    'rgba(153, 255, 50, 0.2)',
                    'rgba(50, 255, 204, 0.2)',
                    'rgba(50, 204, 255, 0.2)',
                    'rgba(50, 50, 255, 0.2)',
                    'rgba(153, 50, 255, 0.2)',
                    'rgba(255, 50, 255, 0.2)',
                    'rgba(255, 50, 153, 0.2)',
                    'rgba(255, 255, 255, 0.2)',
                    'rgba(0, 0, 0, 0.2)'
                ],
                data: [<?php echo $count ?>]
            }]
        }
    }
    );
    //棒グラフ
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php echo $category2?>],
            datasets: [{
                label: 'average price by item category',
                data: [<?php echo $avg?>],
                backgroundColor: [
                    'rgba(255, 50, 50, 0.2)',
                    'rgba(255, 100, 50, 0.2)',
                    'rgba(255, 153, 50, 0.2)',
                    'rgba(255, 255, 50, 0.2)',
                    'rgba(153, 255, 50, 0.2)',
                    'rgba(50, 255, 204, 0.2)',
                    'rgba(50, 204, 255, 0.2)',
                    'rgba(50, 50, 255, 0.2)',
                    'rgba(153, 50, 255, 0.2)',
                    'rgba(255, 50, 255, 0.2)',
                    'rgba(255, 50, 153, 0.2)',
                    'rgba(255, 255, 255, 0.2)',
                    'rgba(0, 0, 0, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 50, 50, 0.2)',
                    'rgba(255, 100, 50, 0.2)',
                    'rgba(255, 153, 50, 0.2)',
                    'rgba(255, 255, 50, 0.2)',
                    'rgba(153, 255, 50, 0.2)',
                    'rgba(50, 255, 204, 0.2)',
                    'rgba(50, 204, 255, 0.2)',
                    'rgba(50, 50, 255, 0.2)',
                    'rgba(153, 50, 255, 0.2)',
                    'rgba(255, 50, 255, 0.2)',
                    'rgba(255, 50, 153, 0.2)',
                    'rgba(255, 255, 255, 0.2)',
                    'rgba(0, 0, 0, 0.2)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });



    </script>
</body>
</html>