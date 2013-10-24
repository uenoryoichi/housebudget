<?php
/*
 * バージョン管理
* 1.6.3
*
*/
?>

<?
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//キーの格納
$key = htmlspecialchars($_POST["key"], ENT_QUOTES);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./css/common.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <title>my家計簿</title>
    </head>
    <body>

<?php
//支払い情報入力
	if ($key == "pay") {
		$how_much = htmlspecialchars($_POST["how_much"], ENT_QUOTES);
		$what = htmlspecialchars($_POST["what"], ENT_QUOTES);
		$date = htmlspecialchars($_POST["date"], ENT_QUOTES);
		$user_accounts_id = htmlspecialchars($_POST["user_accounts_id"], ENT_QUOTES);
		$type = htmlspecialchars($_POST["type"], ENT_QUOTES);
		$user_id = $_SESSION['user_id'];
		
		$sql = "INSERT INTO pay (how_much,what,date,user_accounts_id,type,user_id) VALUES ('$how_much','$what','$date','$user_accounts_id','$type','$user_id')";
		mysql_query($sql, $link) or die(mysql_error());
	}
    //ここまで
    
	//収入情報入力
	if ($key == "income") {
		$amount = htmlspecialchars($_POST["amount"], ENT_QUOTES);
		$content = htmlspecialchars($_POST["content"], ENT_QUOTES);
		$date = htmlspecialchars($_POST["date"], ENT_QUOTES);
		$user_accounts_id = htmlspecialchars($_POST["user_accounts_id"], ENT_QUOTES);
		$user_id = $_SESSION['user_id'];
		
		$sql = "INSERT INTO income (amount,content,date,user_accounts_id,created,user_id) VALUES (
			'$amount',
			'$content',
			'$date',
			'$user_accounts_id',
			NOW()),
			'$user_id'";
		mysql_query($sql, $link) or die(mysql_error());
	
	}
	//ここまで
	
	//口座移動情報入力
	if ($key == "transfer") {
		$amount = htmlspecialchars($_POST["amount"], ENT_QUOTES);
		$user_accounts_id_remitter = htmlspecialchars($_POST["user_accounts_id_remitter"], ENT_QUOTES); 
		$user_accounts_id_remittee = htmlspecialchars($_POST["user_accounts_id_remittee"], ENT_QUOTES);
		$date = htmlspecialchars($_POST["date"], ENT_QUOTES);
		$memo = htmlspecialchars($_POST["memo"], ENT_QUOTES);
		$user_id = $_SESSION['user_id'];
		
		$sql = "INSERT INTO transfer (amount,user_accounts_id_remitter,user_accounts_id_remittee,date,memo,user_id,created) VALUES (
			'$amount',
			'$user_accounts_id_remitter',
			'$user_accounts_id_remittee',
			'$date',
			'$memo',
			'$user_id',
			NOW())";
		mysql_query($sql, $link) or die(mysql_error());
	}

?>	

<!-- 見出し -->
	<div id="head">
		<h1>入力完了</h1>
	</div>

<!-- 実行内容表示 -->

	<div id="content">
	<div class = "center">
		<br>
		<br>
		<h3>
			<?php 
			if ($key=='pay') {echo '支払い';}
			elseif ($key=='income'){echo '収入';}
			elseif ($key == 'transfer'){echo '口座移動';}
			?>情報を入力しました
		</h3>
		<br>
		<br>
		
		<h2><a href=
			<?php 
			if ($key =='pay') {echo 'pay_index.php';}
			elseif ($key =='income'){echo 'income_index.php';}
			elseif ($key == 'transfer'){echo'transfer_index.php';}
			?>
		>一覧に戻る</a>
		</h2>
	</div>	
	</div>
	<!-- 完了表示　ここまで -->

	<!-- トップに戻る -->
	<div class = "center">
		<h2><a href="index.php">Back To TOP</a></h2>
	</div>
	<!-- トップに戻る　ここまで -->		
	

</body>
</html>
