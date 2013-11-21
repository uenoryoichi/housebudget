<?php 
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//関数設定
require 'library_all.php';


//キーの格納
$key=h($_SESSION['key']);
unset($_SESSION['key']);

if ($key == 'pay') {
	//POST で送られてきた情報をpayのカラム格納
	$sql=sprintf('UPDATE pay SET how_much=%d, what="%s", date="%s", user_accounts_id="%d", type="%s" WHERE id=%d',
		mysql_real_escape_string($_SESSION['pay']['how_much']),
		mysql_real_escape_string($_SESSION['pay']['what']),
		mysql_real_escape_string($_SESSION['pay']['date']),
		mysql_real_escape_string($_SESSION['pay']['user_accounts_id']),
		mysql_real_escape_string($_SESSION['pay']['type']),
		mysql_real_escape_string($_SESSION['pay']['id'])
	);
	mysql_query($sql) or die(mysql_error());
	unset($_SESSION['pay']);
}
//収入情報
if ($key == 'income') {
	//POST で送られてきた情報をincomeのカラム格納
	$sql=sprintf('UPDATE income SET amount=%d, content="%s", date="%s", user_accounts_id="%d" WHERE id=%d',
			mysql_real_escape_string($_SESSION['income']['amount']),
			mysql_real_escape_string($_SESSION['income']['content']),
			mysql_real_escape_string($_SESSION['income']['date']),
			mysql_real_escape_string($_SESSION['income']['user_accounts_id']),
			mysql_real_escape_string($_SESSION['income']['id'])
	);
	mysql_query($sql) or die(mysql_error());
	unset($_SESSION['income']);
}

//口座移動情報
if ($key == 'transfer') {
	//POST で送られてきた情報をtransferのカラム格納
	$sql=sprintf('UPDATE transfer SET amount=%d, user_accounts_id_remitter=%d, user_accounts_id_remittee=%d, date="%s", memo="%s" WHERE id=%d',
			mysql_real_escape_string($_SESSION['transfer']['amount']),
			mysql_real_escape_string($_SESSION['transfer']['user_accounts_id_remitter']),
			mysql_real_escape_string($_SESSION['transfer']['user_accounts_id_remittee']),
			mysql_real_escape_string($_SESSION['transfer']['date']),
			mysql_real_escape_string($_SESSION['transfer']['memo']),
			mysql_real_escape_string($_SESSION['transfer']['id'])
	);
	mysql_query($sql) or die(mysql_error());
	unset($_SESSION['transfer']);
}

//口座更新情報
if ($key == 'account_balance') {
	//POST で送られてきた情報をtransferのカラム格納
	for ($i = 0, $count=count($_SESSION['account_balance']['user_accounts_id']); $i < $count; $i++) {
		$sql=sprintf('UPDATE user_accounts SET balance=%d, checked=cast(now() as datetime) WHERE id=%d AND user_id=%d ',
						mysql_real_escape_string($_SESSION['account_balance']['balance'][$i]),
						mysql_real_escape_string($_SESSION['account_balance']['user_accounts_id'][$i]),
						mysql_real_escape_string($_SESSION['user_id'])
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