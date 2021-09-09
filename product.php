<?php
require_once('./php/funcs.php');

$pdo = db_conn();

$item_no = $_GET['no'];

$stmt = $pdo->prepare("SELECT * FROM product WHERE item_no=:item_no;");
$stmt->bindValue(':item_no',$item_no,PDO::PARAM_STR);
$status = $stmt->execute();


$view = "";
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();

    $prod_no = $result["item_no"];
    $stmt2 = $pdo->prepare("SELECT * FROM img_table WHERE prod_no=:prod_no");
    $stmt2->bindValue(':prod_no',$prod_no,PDO::PARAM_STR);
    $status = $stmt2->execute();

    $image="";
    if($status==false) {
        sql_error();
    }else{
        while( $r = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
        $image .= '<p><img src="img/'.$r["img_path"].'"></p>';
  }

}
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js" integrity="sha512-VCHVc5miKoln972iJPvkQrUYYq7XpxXzvqNfiul1H4aZDwGBGC0lq373KNleaB2LpnC2a/iNfE5zoRYmB4TRDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>商品詳細ページ</title>
</head>
<body>
<a href="./select2.php"><p>商品一覧に戻る</p></a>
<h1>商品詳細ページ</h1>
<div class="wrapper">
    <div class="image">
        <?= $image ?>
    </div>
    <div class="info">
        <h3>商品番号：<br><?= $result['item_no']?></h3>
        <h3>商品名：<br><?= $result['item_name']?></h3>
        <h3>価格（税込）<br><?= $result['item_price']?>JPY</h3>
        <h3>商品説明：<br><?= $result['memo']?></h3>
        <select name="amount" id="amount">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <button>カートに追加（見た目だけ）</button>
        <div class="chart">
            <p>とりあえず、見た目の構成だけでデータはベタ打ち</p>
            <canvas id="myRadarChart"></canvas>
        </div>
    </div>
</div>

<script>
var ctx = document.getElementById("myRadarChart");
var myRadarChart = new Chart(ctx, {
  //グラフの種類
  type: 'radar',
  //データの設定
  data: {
      //データ項目のラベル
      labels: ["重さ", "厚さ", "吸水性", "ビジネス", "細さ"],
      //データセット
      datasets: [
          {
              label: "こちらの商品",
              //背景色
              backgroundColor: "rgba(200,112,126,0.5)",
              //枠線の色
              borderColor: "rgba(200,112,126,1)",
              //結合点の背景色
              pointBackgroundColor: "rgba(200,112,126,1)",
              //結合点の枠線の色
              pointBorderColor: "#fff",
              //結合点の背景色（ホバ時）
              pointHoverBackgroundColor: "#fff",
              //結合点の枠線の色（ホバー時）
              pointHoverBorderColor: "rgba(200,112,126,1)",
              //結合点より外でマウスホバーを認識する範囲（ピクセル単位）
              hitRadius: 5,
              //グラフのデータ
              data: [3,3,2,5,3]
          }
      ]
  },
 options: {
    // レスポンシブ指定
    responsive: true,
    scale: {
      ticks: {
        // 最小値の値を0指定
        beginAtZero:true,
        min: 0,
        // 最大値を指定
        max: 5,
      }
    }
  }
});
</script>
</body>
</html>