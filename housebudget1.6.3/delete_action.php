<?php

/*
 * バージョン管理
 * 1.6.3
 * 
 */

session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//キーの格納
$key=htmlspecialchars($_POST['key'], ENT_QUOTES);

var_dump($_POST);


//削除要求 支払い
if ($key=="pay") {
	$sql=sprintf("DELETE FROM pay WHERE id=%d AND user_id=%d",
			mysql_real_escape_string(htmlspecialchars($_REQUEST['id'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['user_id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}
//ここまで

//削除要求　収入
if ($key =="income") {
		$sql=sprintf("DELETE FROM income WHERE id=%d AND user_id=%d",
			mysql_real_escape_string(htmlspecialchars($_REQUEST['id'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['user_id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}
//ここまで

//削除要求　口座移動
if ($key =="transfer") {
	$sql=sprintf("DELETE FROM transfer WHERE id=%d AND user_id=%d",
			mysql_real_escape_string(htmlspecialchars($_REQUEST['id'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['user_id'], ENT_QUOTES))
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
			if ($key=='pay') {echo '支払い情報を削除しました';}
			elseif ($key=='income'){echo '収入情報を削除しました';}
			elseif ($key=='transfer'){echo '口座移動情報を削除しました';}
			elseif ($key==NULL){echo 'エラー キーがありません';}
			?>
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
