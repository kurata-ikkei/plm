<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <title>ログイン画面</title>
</head>
<body>
<header>ログイン・ユーザー登録</header>
<div class="login_area">
<h2>登録ユーザーの方はこちら</h2>
<form action="./php/login_act.php" method="POST">
    <fieldset>
        <label for="name">Log-in ID</label>
        <input type="text" name="lid" required><br>
        <label for="password">PASSWORD</label>
        <input type="password" name="lpw" required><br><br>
        <input type="submit" value="ログイン" id="login">
    </fieldset>
</form>
</div>
<!-- <div class="register_area">
<h2>初めての方はこちら</h2>
<form action="./php/user_insert.php" method="POST">
    <fieldset>
        <label for="user_name">NAME</label>
        <input type="text" name="user_name" required><br>
        <label for="lid">Log-in ID</label>
        <input type="text" name="lid" required><br>
        <label for="lpw">PASSWORD</label>
        <input type="password" name="lpw" required><br>
        <label for="user_role">ROLE</label>
        <select name="user_role">
            <option value="0">管理者</option>
            <option value="1">一般ユーザー</option>
            <option value="2">参照ユーザー</option>
        </select><br><br>
        <input type="submit" value="会員登録" id="register">
    </fieldset>
</form>
</div> -->

<div class="nonuser_area">
<h2>ログインせず商品情報を閲覧する場合はこちら<br>（一部閲覧できない情報もございます）</h2>
    <a href="./select2.php">商品情報を確認する</a>
</div>    
</body>
</html>