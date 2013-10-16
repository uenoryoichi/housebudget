<?php

/*
 * バージョン管理
 * 1.6.3
 * 
 * 
 * 
 */


session_start();

//データベースへの接続 housebudget
require 'connect_housebudget.php';


//ログインチェック
require 'login_check.php';


//キーの格納
$key=htmlspecialchars($_POST['key'], ENT_QUOTES);

//削除要求 支払い
if ($key=="pay") {
	$sql=sprintf("DELETE FROM pay WHERE id=%d",
			mysql_real_escape_string(htmlspecialchars($_REQUEST['id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}
//ここまで

//削除要求　収入
if ($key =="income") {
		$sql=sprintf("DELETE FROM income WHERE id=%d",
			mysql_real_escape_string(htmlspecialchars($_REQUEST['id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}
//ここまで

//削除要求　収入
if ($key =="transfer") {
	$sql=sprintf("DELETE FROM transfer WHERE id=%d",
			mysql_real_escape_string(htmlspecialchars($_REQUEST['id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}
//ここまで

?>




<!DOCTYPE html PUBLIC>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="家計簿">
<meta name="keywords" content="web家計簿">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="./css/common.css" />
<title>my家計簿</title>
</head>

<body>

<div id="wrap">

<!-- 見出し -->
	<div id="head">
		<h1>削除処理</h1>
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
			elseif ($key=='transfer'){echo '口座移動';}
			?>情報を削除しました
		</h3>
		<br>
		<br>
		
		<h2><a href=
			<?php 
			if ($key =='pay') {echo 'pay_index.php';}
			elseif ($key =='income'){echo 'income_index.php';}
			elseif ($key == 'transfer'){echo 'transfer_index.php';}
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
</div>


<!-- foot -->
<div id="foot">
<p></p>
</div>


</body>
</html>
