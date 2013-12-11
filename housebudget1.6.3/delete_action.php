<?php
session_start();
session_regenerate_id(TRUE);
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//関数設定
require 'library_all.php';

//tokenチェック
include 'include/php/check_token.php';

//キーの格納
$key=$_POST['key'];

//削除要求 支払い

if ($key=="pay") {
	if (empty($error)) {
		$sql=sprintf("DELETE FROM pay WHERE id=%d AND user_id=%d",
			mysql_real_escape_string($_POST['id']),
			mysql_real_escape_string($_SESSION['user_id'])
		);
		unset($_POST);
		mysql_query($sql) or die(mysql_error());
		$_SESSION['success']='delete';;
	} else {
		$_SESSION['error']=$error;
	}
	header('Location: pay_index.php');
}

//削除要求　収入
if ($key =="income") {
		$sql=sprintf("DELETE FROM income WHERE id=%d AND user_id=%d",
			mysql_real_escape_string($_POST['id']),
			mysql_real_escape_string($_SESSION['user_id'])
	);
	unset($_POST);
	mysql_query($sql) or die(mysql_error());
	$_SESSION['success']='delete';
	header('Location: income_index.php');}

//削除要求　口座移動
if ($key =="transfer") {
	$sql=sprintf("DELETE FROM transfer WHERE id=%d AND user_id=%d",
			mysql_real_escape_string($_POST['id']),
			mysql_real_escape_string($_SESSION['user_id'])
	);
	unset($_POST);
	mysql_query($sql) or die(mysql_error());
	$_SESSION['success']='delete';
	header('Location: transfer_index.php');
}

//削除要求　ユーザー使用口座
if ($key =="user_accounts") {
	$sql=sprintf("DELETE FROM user_accounts WHERE id=%d AND user_id=%d",
			mysql_real_escape_string($_POST['user_accounts_id']),
			mysql_real_escape_string($_SESSION['user_id'])
	);
	unset($_POST);
	mysql_query($sql) or die(mysql_error());
	$_SESSION['success']='delete';
	header('Location: user_accounts_index.php');}

?>
<!DOCTYPE html>
<html lang=ja>
    <?php include 'include/head.html';?>
	
<body>
<div id="head">
	<h1>削除処理</h1>
</div>
<!-- メニューバー -->
<?php include 'include/menu.html';?>

<div id="content">
	<div class = "center">
		<br>
		<br>
		<h3>
			<?php 
			if ($key==NULL){echo 'エラー 正しいページから入力してください';}
			?>
		</h3>
		<br>
		<br>
		<h2><a href="index.php">Back To TOP</a></h2>
	</div>	
</div>

<?php include 'include/footer.html';?>

</body>
</html>
