<?php 
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//キーの格納
$key=htmlspecialchars($_SESSION['key'], ENT_QUOTES);
unset($_SESSION['key']);
?>

<?
if ($key == 'pay') {
	//POST で送られてきた情報をpayのカラム格納
	$sql=sprintf('UPDATE pay SET how_much=%d, what="%s", date="%s", user_accounts_id="%d", type="%s" WHERE id=%d',
		mysql_real_escape_string(htmlspecialchars($_SESSION['pay']['how_much'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_SESSION['pay']['what'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_SESSION['pay']['date'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_SESSION['pay']['user_accounts_id'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_SESSION['pay']['type'], ENT_QUOTES)),
		mysql_real_escape_string(htmlspecialchars($_SESSION['pay']['id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
	unset($_SESSION['pay']);
}
//収入情報
if ($key == 'income') {
	//POST で送られてきた情報をincomeのカラム格納
	$sql=sprintf('UPDATE income SET amount=%d, content="%s", date="%s", user_accounts_id="%d" WHERE id=%d',
			mysql_real_escape_string(htmlspecialchars($_SESSION['income']['amount'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['income']['content'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['income']['date'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['income']['user_accounts_id'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['income']['id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
	unset($_SESSION[['income']]);
}

//口座移動情報
if ($key == 'transfer') {
	//POST で送られてきた情報をtransferのカラム格納
	$sql=sprintf('UPDATE transfer SET amount=%d, user_accounts_id_remitter=%d, user_accounts_id_remittee=%d, date="%s", memo="%s" WHERE id=%d',
			mysql_real_escape_string(htmlspecialchars($_SESSION['transfer']['amount'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['transfer']['user_accounts_id_remitter'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['transfer']['user_accounts_id_remittee'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['transfer']['date'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['transfer']['memo'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['transfer']['id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
	unset($_SESSION['transfer']);
}

//口座更新情報
if ($key == 'account_balance') {
	//POST で送られてきた情報をtransferのカラム格納
	for ($i = 0, $count=count($_SESSION['account_balance']['user_accounts_id']); $i < $count; $i++) {
		$sql=sprintf('UPDATE user_accounts SET balance="%s", checked=cast(now() as datetime) WHERE id=%d AND user_id=%d',
						htmlspecialchars($_SESSION['account_balance']['balance'][$i], ENT_QUOTES),
						htmlspecialchars($_SESSION['account_balance']['user_accounts_id'][$i], ENT_QUOTES),
						htmlspecialchars($_SESSION['user_id'], ENT_QUOTES)
		);
		mysql_query($sql) or die(mysql_error());
	}
	unset($_SESSION['account_balance']);
}

?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダー -->
    <?php include 'include/head.html';?>

<body>
<div id="head">
	<h1>変更操作</h1>
</div>
	
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>

<div id="content">
	<div class = "center">
		<br>
		<br>
		<h3>
			<?php 
			if ($key =='pay') {echo '支払い情報を変更しました';}
			elseif ($key =='income'){echo '収入情報を変更しました';}
			elseif ($key == 'transfer'){echo '口座移動情報を変更しました';}
			elseif ($key == 'account_balance'){echo  '残高情報を変更しました';}
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
			elseif ($key == 'account_balance'){echo  'account_index.php';}?>
		>一覧に戻る</a>
		</h2>
	</div>	
</div>
	
<!-- トップに戻る -->
<div class = "center">
	<h2><a href="index.php">Back To TOP</a></h2>
</div>

<!-- フッター -->
<?php include 'include/footer.html';?>

</body>


</html>