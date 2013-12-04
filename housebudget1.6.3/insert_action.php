<?
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//キーの格納
$key = $_SESSION["key"];
unset($_SESSION['key']);
//支払い情報入力
	if ($key == "pay") {
		$sql = sprintf('INSERT INTO pay SET how_much=%d, what="%s", date="%s",user_accounts_id=%d, pay_specification_id=%d, created=NOW(), user_id=%d' ,
				mysql_real_escape_string($_SESSION['pay']["how_much"]),
				mysql_real_escape_string($_SESSION['pay']["what"]),
				mysql_real_escape_string($_SESSION['pay']["year"])."-".mysql_real_escape_string($_SESSION['pay']["month"])."-".mysql_real_escape_string($_SESSION['pay']["day"])." ".mysql_real_escape_string($_SESSION['pay']["hour"]),
				mysql_real_escape_string($_SESSION['pay']["user_accounts_id"]),
				mysql_real_escape_string($_SESSION['pay']["pay_specification_id"]),
				mysql_real_escape_string($_SESSION['user_id'])
		);
		unset($_SESSION['pay']);
		mysql_query($sql, $link) or die(mysql_error());
		header('Location: pay_index.php');
	}
    
	//収入情報入力
	if ($key == "income") {
		
		$sql = sprintf('INSERT INTO income SET amount=%d, content="%s", date="%s",user_accounts_id=%d, income_specification_id=%d, created=NOW(), user_id=%d' ,
				mysql_real_escape_string($_SESSION['income']["amount"]),
				mysql_real_escape_string($_SESSION['income']["content"]),
				mysql_real_escape_string($_SESSION['income']["year"])."-".mysql_real_escape_string($_SESSION['income']["month"])."-".mysql_real_escape_string($_SESSION['income']["day"])." ".mysql_real_escape_string($_SESSION['income']["hour"]),
				mysql_real_escape_string($_SESSION['income']["user_accounts_id"]),
				mysql_real_escape_string($_SESSION['income']['income_specification_id']),
				mysql_real_escape_string($_SESSION['user_id'])
		);
		unset($_SESSION['income']);
		mysql_query($sql, $link) or die(mysql_error());
		header('Location: income_index.php');
	}
	
	//口座移動情報入力
	if ($key == "transfer") {
		$sql = sprintf('INSERT INTO transfer SET amount=%d, user_accounts_id_remitter=%d, user_accounts_id_remittee=%d, date="%s",memo="%s", created=NOW(), user_id=%d' ,
				mysql_real_escape_string($_SESSION['transfer']["amount"]),
				mysql_real_escape_string($_SESSION['transfer']["user_accounts_id_remitter"]),
				mysql_real_escape_string($_SESSION['transfer']["user_accounts_id_remittee"]),
				mysql_real_escape_string($_SESSION['transfer']["year"])."-".mysql_real_escape_string($_SESSION['transfer']["month"])."-".mysql_real_escape_string($_SESSION['transfer']["day"])." ".mysql_real_escape_string($_SESSION['transfer']["hour"]),
				mysql_real_escape_string($_SESSION['transfer']["memo"]),
				mysql_real_escape_string($_SESSION['user_id'])
		);	
		unset($_SESSION['transfer']);
		mysql_query($sql, $link) or die(mysql_error());
		header('Location: transfer_index.php');
	}

	//使用する口座追加
	if ($key == "user_accounts_add") {
		$account_id=$_SESSION['user_accounts_add']["account_id"];
		//acounts_idを一つづつ抽出
		for ($i = 0, $count_accounts=count($account_id); $i < $count_accounts; $i++) {
			$sql = sprintf('INSERT INTO user_accounts SET user_id=%d, account_id=%d, created=NOW()',
					mysql_real_escape_string($_SESSION['user_id']),
					mysql_real_escape_string($account_id[$i])
			);
			mysql_query($sql, $link) or die(mysql_error());
		}
		unset($_SESSION['user_accounts_add']);
	}
	
	//口座一覧への追加
	if ($key == "add_accounts") {
		$sql = sprintf('INSERT INTO accounts SET name="%s", kana="%s", account_classification_id=%d, created=NOW()', 
							mysql_real_escape_string($_SESSION['add_accounts']["accounts_name"]),
							mysql_real_escape_string($_SESSION['add_accounts']["accounts_kana"]),
							mysql_real_escape_string($_SESSION['add_accounts']["account_classification_id"])
		);
		unset($_SESSION['add_accounts']);
		mysql_query($sql, $link) or die(mysql_error());
		header('Location: account_choice.php');
	}
	
	
	
?>	

<!DOCTYPE html>
<html lang=ja>
    <?php include 'include/head.html';?>

<body>
<div id="head">
	<h1>入力完了</h1>
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
			elseif ($key == "user_accounts_add"){echo '使用する口座を追加しました';}
			else {echo'入力できていません';}
			?>
		</h3>
		<br>
		<br>
		<?php if ($key == 'user_accounts_add') :?>
			<h2><a href="account_choice.php" class="btn btn-primary btn-lg">口座の追加削除</a>  <a href="account_index.php" class="btn btn-success btn-lg">残高登録</a></h2>
			<br><br>
		<?php endif;?>
		
		<h2><a href="index.php">Back To TOP</a></h2>
	
	</div>	
</div>

	<!-- トップに戻る 
	<div class = "center">
		<h2><a href="index.php">Back To TOP</a></h2>
	</div>
	トップに戻る　ここまで -->		
	
<?php include 'include/footer.html';?>

</body>
</html>
