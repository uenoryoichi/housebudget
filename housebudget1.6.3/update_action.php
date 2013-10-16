<?php 

/*
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
?>


<?
if ($key == 'pay') {
	//POST で送られてきた情報をpayのカラム格納
	$sql=sprintf('UPDATE pay SET how_much=%d, what="%s", date="%s", how="%s", type="%s" WHERE id=%d',
		mysql_real_escape_string(htmlspecialchars($_POST['how_much'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_POST['what'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_POST['date'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_POST['how'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_POST['type'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_POST['pay_id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}
//収入情報
if ($key == 'income') {
	//POST で送られてきた情報をincomeのカラム格納
	$sql=sprintf('UPDATE income SET amount=%d, content="%s", date="%s", account="%s" WHERE id=%d',
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
	$sql=sprintf('UPDATE transfer SET amount=%d, account_remitter="%s", account_remittee="%s", date="%s", memo="%s" WHERE id=%d',
			mysql_real_escape_string(htmlspecialchars($_POST['amount'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['account_remitter'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['account_remittee'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['date'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['memo'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_POST['id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}


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