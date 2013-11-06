<?php
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//キーの格納
$key=htmlspecialchars($_POST['key'], ENT_QUOTES);


//削除要求 支払い
if ($key=="pay") {
	$sql=sprintf("DELETE FROM pay WHERE id=%d AND user_id=%d",
			mysql_real_escape_string(htmlspecialchars($_REQUEST['id'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['user_id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}

//削除要求　収入
if ($key =="income") {
		$sql=sprintf("DELETE FROM income WHERE id=%d AND user_id=%d",
			mysql_real_escape_string(htmlspecialchars($_REQUEST['id'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['user_id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}

//削除要求　口座移動
if ($key =="transfer") {
	$sql=sprintf("DELETE FROM transfer WHERE id=%d AND user_id=%d",
			mysql_real_escape_string(htmlspecialchars($_REQUEST['id'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['user_id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}

//削除要求　ユーザー使用口座
if ($key =="user_accounts") {
	$sql=sprintf("DELETE FROM user_accounts WHERE id=%d AND user_id=%d",
			mysql_real_escape_string(htmlspecialchars($_REQUEST['user_accounts_id'], ENT_QUOTES)),
			mysql_real_escape_string(htmlspecialchars($_SESSION['user_id'], ENT_QUOTES))
	);
	mysql_query($sql) or die(mysql_error());
}

?>
<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>
	
<body>

<!-- 見出し -->
<div id="head">
	<h1>削除処理</h1>
</div>

<!-- メニューバー -->
<?php include 'include/menu.html';?>
	
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
			elseif ($key=='user_accounts'){echo '口座情報を削除しました';}
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
			elseif ($key == 'user_accounts'){echo 'account_choice.php';}
			?>
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
