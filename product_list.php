<?php
session_start();

require_once('./php/funcs.php');

loginCheck();
$user_name = $_SESSION['name'];
$role_flg = $_SESSION['role_flg'];

$pdo = db_conn();

$stmt = $pdo->prepare(
    "SELECT 
    brand.brand_name AS brand, 
    janre.janre_name AS janre, 
    product_planning.item_no2 AS no, 
    product_planning.year AS year, 
    season.season_code AS season, 
    gender.gender_name AS gender,
    category.category_name AS category, 
    product_planning.item_name AS name 
    FROM product_planning 
    LEFT JOIN brand ON product_planning.brand = brand.id 
    JOIN janre ON product_planning.janre = janre.janre_id 
    JOIN season ON product_planning.season = season.season_id 
    JOIN gender ON product_planning.gender = gender.id 
    JOIN category ON product_planning.category =category.category_id");
$status = $stmt->execute();

$view="";
if($status==false) {
    sql_error($stmt);
}else{
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $view .="<tr>";
    $view .= "<td>".h($result['brand']).'</td><td>'.h($result['janre']).'</td><td>'.h($result['no']).'</td><td>'.h($result['year']).'</td><td>'.h($result['season']).'</td><td>'.h($result['gender']).'</td><td>'.h($result['category']).'</td><td>'.h($result['name']).'</td>';
    $view .='<td><a href="./product_detail.php?no='.h($result['no']).'">確認・更新</a></td>';
    $view .='<td><a href="./sku.php?no='.h($result['no']).'">SKU確認・登録</a></td>';
    $view .="</tr>";
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product_list.css">
    <title>商品一覧</title>
</head>
<body>
<!-- ヘッダー系の対応 -->
<header>
    <h1>Product Management Tool</h1>
    <p>user:  <?= $user_name.'('.$role_flg.')'?></p>
    <a href="./php/logout.php"><p>Log OUT</p></a>
</header>
<a href="./main.php">HOMEに戻る</a><br>
<!-- メインコンテンツ -->
<div class="new">
    <a href="./product_planning.php" class="new_item">新規商品登録</a>
</div>

<div class="list">
    <h3>商品一覧ページ</h3>
    <input type="search" class="filter" data-table="list_table" placeholder="検索" />
    <table class="list_table">
        <thead>
            <tr>
                <th>BRAND</th>
                <th>GENRE</th>
                <th>ITEM NO</th>
                <th>YEAR</th>
                <th>SEASON</th>
                <th>GENDER</th>
                <th>CATEGORY</th>
                <th>ITEM NAME</th>
                <th>確認・更新</th>
                <th>SKU登録・確認</th>
            </tr>
        </thead>
        <tbody>
            <?= $view ?>
        </tbody>
    </table>
</div>

</body>

<script>
    //検索窓対応
    (function(document) {
  'use strict';

  var LightTableFilter = (function(Arr) {

    var _input;

    function _onInputEvent(e) {
      _input = e.target;
      var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
      Arr.forEach.call(tables, function(table) {
        Arr.forEach.call(table.tBodies, function(tbody) {
          Arr.forEach.call(tbody.rows, _filter);
        });
      });
    }

    function _filter(row) {
      var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
      row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
    }

    return {
      init: function() {
        var inputs = document.getElementsByClassName('filter');
        Arr.forEach.call(inputs, function(input) {
          input.oninput = _onInputEvent;
        });
      }
    };
  })(Array.prototype);

  document.addEventListener('readystatechange', function() {
    if (document.readyState === 'complete') {
      LightTableFilter.init();
    }
  });

})(document);
</script>

</html>