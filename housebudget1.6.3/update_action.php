<?php 

/*
 * 1.6.3
 * 
 * 
 * 
 */


session_start();

//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//キーの格納
$key=htmlspecialchars($_POST['key'], ENT_QUOTES);
?>

<?
if ($key == 'pay') {
	//POST で送られてきた情報をpayのカラム格納
	$sql=sprintf('UPDATE pay SET how_much=%d, what="%s", date="%s", user_accounts_id="%d", type="%s" WHERE id=%d',
		mysql_real_escape_string(htmlspecialchars($_POST['how_much'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_POST['what'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_POST['date'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_POST['user_accounts_id'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_POST['type'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_POST['pay_id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}
//収入情報
if ($key == 'income') {
	//POST で送られてきた情報をincomeのカラム格納
	$sql=sprintf('UPDATE income SET amount=%d, content="%s", date="%s", user_accounts_id="%d" WHERE id=%d',
			mysql_real_escape_string(htmlspecialchars($_POST['amount'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['content'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['date'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['account'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['income_id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}

//口座移動情報
if ($key == 'transfer') {
	//POST で送られてきた情報をtransferのカラム格納
	$sql=sprintf('UPDATE transfer SET amount=%d, user_accounts_id_remitter=%d, user_accounts_id_remittee=%d, date="%s", memo="%s" WHERE id=%d',
			mysql_real_escape_string(htmlspecialchars($_POST['amount'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['user_accounts_id_remitter'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['user_accounts_id_remittee'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['date'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['memo'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['transfer_id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}


//口座移動情報
if ($key == 'account_balance') {
	$aaa='aaa';
}
var_dump($_POST);
var_dump($_SESSION);


?>

<!DOCTYPE html PUBLIC>
<html>

<!-- ヘッダーここから -->
<head>
	<meta http-equiv="Content-Type" content="text/thml: charset=UTF-8"/>
	<meta name="description" content="my家計簿">
	<meta name="keywords" content="変更操作">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="./css/common.css" />
	<title>my家計簿</title>
</head>
<!-- ヘッダーここまで -->

<!-- 本文ここから -->
<body>

<div id="wrap">
	<!-- タイトル -->
	<div id="head">
		<h1>変更操作</h1>
	</div>
	<!-- タイトルここまで -->
	
	<!-- 完了表示 -->
	<div id="content">
	<div class = "center">
		<br>
		<br>
		<h3><?php 
			if ($key =='pay') {echo '支払い';}
			elseif ($key =='income'){echo '収入';}
			elseif ($key == 'transfer'){echo '口座移動';}
			elseif ($key == 'account_balance'){echo  '残高';}
		?>
		情報を変更しました
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

	<div id="foot">
	<p></p>
	</div>

</div>

</body>


</html>