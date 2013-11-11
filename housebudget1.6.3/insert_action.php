<?
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//キーの格納
$key = htmlspecialchars($_SESSION["key"], ENT_QUOTES);
unset($_SESSION['key']);
//配列をエスケープするための関数
function array_htmlspecialchars($string) {
	if (is_array($string)) {
		return array_map("array_htmlspecialchars", $string);
	} else {
		return htmlspecialchars($string, ENT_QUOTES);
	}
}


//支払い情報入力
	if ($key == "pay") {
		$sql = sprintf('INSERT INTO pay SET how_much=%d, what="%s", date="%s",user_accounts_id=%d, type="%s", created=NOW(), user_id=%d' ,
				htmlspecialchars($_SESSION['pay']["how_much"], ENT_QUOTES),
				htmlspecialchars($_SESSION['pay']["what"], ENT_QUOTES),
				htmlspecialchars($_SESSION['pay']["year"], ENT_QUOTES)."-".htmlspecialchars($_SESSION['pay']["month"], ENT_QUOTES)."-".htmlspecialchars($_SESSION['pay']["day"], ENT_QUOTES)." ".htmlspecialchars($_SESSION['pay']["hour"], ENT_QUOTES),
				htmlspecialchars($_SESSION['pay']["user_accounts_id"], ENT_QUOTES),
				htmlspecialchars($_SESSION['pay']["type"], ENT_QUOTES),
				$_SESSION['user_id']
		);
		mysql_query($sql, $link) or die(mysql_error());
		unset($_SESSION['pay']);
	}
    //ここまで
    
	//収入情報入力
	if ($key == "income") {
		
		$sql = sprintf('INSERT INTO income SET amount=%d, content="%s", date="%s",user_accounts_id=%d, created=NOW(), user_id=%d' ,
				htmlspecialchars($_SESSION['income']["amount"], ENT_QUOTES),
				htmlspecialchars($_SESSION['income']["content"], ENT_QUOTES),
				htmlspecialchars($_SESSION['income']["year"], ENT_QUOTES)."-".htmlspecialchars($_SESSION['income']["month"], ENT_QUOTES)."-".htmlspecialchars($_SESSION['income']["day"], ENT_QUOTES)." ".htmlspecialchars($_SESSION['income']["hour"], ENT_QUOTES),
				htmlspecialchars($_SESSION['income']["user_accounts_id"], ENT_QUOTES),
				$user_id = $_SESSION['user_id']
		);
		mysql_query($sql, $link) or die(mysql_error());
		unset($_SESSION['income']);
	}
	
	//口座移動情報入力
	if ($key == "transfer") {
		$sql = sprintf('INSERT INTO transfer SET amount=%d, user_accounts_id_remitter=%d, user_accounts_id_remittee=%d, date="%s",memo="%s", created=NOW(), user_id=%d' ,
				htmlspecialchars($_SESSION['transfer']["amount"], ENT_QUOTES),
				htmlspecialchars($_SESSION['transfer']["user_accounts_id_remitter"], ENT_QUOTES),
				htmlspecialchars($_SESSION['transfer']["user_accounts_id_remittee"], ENT_QUOTES),
				htmlspecialchars($_SESSION['transfer']["year"], ENT_QUOTES)."-".htmlspecialchars($_SESSION['transfer']["month"], ENT_QUOTES)."-".htmlspecialchars($_SESSION['transfer']["day"], ENT_QUOTES)." ".htmlspecialchars($_SESSION['transfer']["hour"], ENT_QUOTES),
				htmlspecialchars($_SESSION['transfer']["memo"], ENT_QUOTES),
				$_SESSION['user_id']
		);	
		mysql_query($sql, $link) or die(mysql_error());
		unset($_SESSION['transfer']);
	}

	//使用する口座追加
	if ($key == "user_accounts_add") {
		$account_id=array_htmlspecialchars($_SESSION['user_accounts_add']["account_id"]);
		//acounts_idを一つづつ抽出
		for ($i = 0, $count_accounts=count($account_id); $i < $count_accounts; $i++) {
			$sql = sprintf('INSERT INTO user_accounts SET user_id=%d, account_id=%d, created=NOW()',
					$_SESSION['user_id'],
					$account_id[$i]
			);
			mysql_query($sql, $link) or die(mysql_error());
		}
		unset($_SESSION['user_accounts_add']);
	}
	
?>	

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

<body>
<!-- 見出し -->
<div id="head">
	<h1>入力完了</h1>
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
			if ($key=='pay') {echo '支払い情報を入力しました';}
			elseif ($key=='income'){echo '収入情報を入力しました';}
			elseif ($key == 'transfer'){echo '口座移動情報を入力しました';}
			elseif ($key== 'user_accounts_add'){echo '新規口座を登録しました';}
			elseif ($key==NULL){echo 'エラー キーがありません';}
			?>
		</h3>
		<br>
		<br>
		<?php if ($key == 'user_accounts_add') :?>
			<h2><a href="account_index.php" class="btn btn-primary btn-lg">残高登録</a></h2>
			<br><br>
		<?php endif;?>
		
		<h2><a href=
			<?php 
			if ($key =='pay') {echo 'pay_index.php';}
			elseif ($key =='income'){echo 'income_index.php';}
			elseif ($key == 'transfer'){echo'transfer_index.php';}
			elseif ($key == 'user_accounts_add'){echo'account_choice.php';}
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
	
	<!-- フッター -->
<?php include 'include/footer.html';?>

</body>
</html>
