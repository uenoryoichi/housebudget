<?
session_start();
session_regenerate_id(TRUE);
//データベースへの接続 housebudget
require 'function/connect_pdo_db.php';
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//キーの格納
$key = $_SESSION["key"];
$_SESSION['key']=NULL;

//支払い情報入力
if ($key == "pay") {
	$date = $_SESSION["pay"]["year"]."-".$_SESSION["pay"]["month"]."-".$_SESSION["pay"]["day"]." ".$_SESSION["pay"]["hour"];
	$stmt = $pdo->prepare('INSERT INTO pay SET how_much=:how_much, what=:what, date=:date, user_accounts_id=:user_accounts_id, pay_specification_id=:pay_specification_id, created=NOW(), user_id=:user_id');
	$stmt->bindValue(':how_much', $_SESSION['pay']["how_much"], PDO::PARAM_INT);
	$stmt->bindValue(':what', $_SESSION['pay']["what"], PDO::PARAM_STR);
	$stmt->bindValue(':date', $date, PDO::PARAM_STR);
	$stmt->bindValue(':user_accounts_id', $_SESSION['pay']["user_accounts_id"], PDO::PARAM_INT);
	$stmt->bindValue(':pay_specification_id', $_SESSION['pay']["pay_specification_id"], PDO::PARAM_INT);
	$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
	$stmt->execute();
	/*
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
	*/
	$_SESSION['pay']=NULL;
	$_SESSION['success']='insert';
	header('Location: pay_index.php');
}
    
	//収入情報入力
if ($key == "income") {
	$date = $_SESSION["income"]["year"]."-".$_SESSION["income"]["month"]."-".$_SESSION["income"]["day"]." ".$_SESSION["income"]["hour"];
	$stmt = $pdo->prepare('INSERT INTO income SET amount=:amount, content=:content, date=:date, user_accounts_id=:user_accounts_id, income_specification_id=:income_specification_id, created=NOW(), user_id=:user_id');
	$stmt->bindValue(':amount', $_SESSION['income']["amount"], PDO::PARAM_INT);
	$stmt->bindValue(':content', $_SESSION['income']["content"], PDO::PARAM_STR);
	$stmt->bindValue(':date', $date, PDO::PARAM_STR);
	$stmt->bindValue(':user_accounts_id', $_SESSION['income']["user_accounts_id"], PDO::PARAM_INT);
	$stmt->bindValue(':income_specification_id', $_SESSION['income']["income_specification_id"], PDO::PARAM_INT);
	$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
	$stmt->execute();
		/*
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
		*/
	$_SESSION['income'];
	$_SESSION['success']='insert';
	header('Location: income_index.php');
}
	
	//口座移動情報入力
if ($key == "transfer") {
	$date = $_SESSION["transfer"]["year"]."-".$_SESSION["transfer"]["month"]."-".$_SESSION["transfer"]["day"]." ".$_SESSION["transfer"]["hour"];
	$stmt = $pdo->prepare('INSERT INTO transfer SET amount=:amount, user_accounts_id_remitter=:user_accounts_id_remitter, user_accounts_id_remittee=:user_accounts_id_remittee, date=:date, memo=:memo, created=NOW(), user_id=:user_id');
	$stmt->bindValue(':amount', $_SESSION['transfer']["amount"], PDO::PARAM_INT);
	$stmt->bindValue(':user_accounts_id_remitter', $_SESSION['transfer']["user_accounts_id_remitter"], PDO::PARAM_INT);
	$stmt->bindValue(':user_accounts_id_remittee', $_SESSION['transfer']["user_accounts_id_remittee"], PDO::PARAM_INT);
	$stmt->bindValue(':date', $date, PDO::PARAM_STR);
	$stmt->bindValue(':memo', $_SESSION['transfer']["memo"], PDO::PARAM_STR);
	$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
	$stmt->execute();
		/*
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
		*/
	$_SESSION['transfer']=NULL;
	$_SESSION['success']='insert';
	header('Location: transfer_index.php');
}
	//使用する口座追加
if ($key == "user_accounts_add") {
	$account_id=$_SESSION['user_accounts_add']["account_id"];
	$stmt= $pdo->prepare('INSERT INTO user_accounts SET user_id=:user_id, account_id=:account_id, created=NOW()');
	$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
	for ($i = 0, $count_accounts=count($account_id); $i < $count_accounts; $i++) {
		$stmt->bindValue(':account_id', $account_id[$i], PDO::PARAM_INT);
		$stmt->execute();
	}
	$_SESSION['user_accounts_add']=NULL;
		/*
		//acounts_idを一つづつ抽出
		for ($i = 0, $count_accounts=count($account_id); $i < $count_accounts; $i++) {
			$sql = sprintf('INSERT INTO user_accounts SET user_id=%d, account_id=%d, created=NOW()',
					mysql_real_escape_string($_SESSION['user_id']),
					mysql_real_escape_string($account_id[$i])
			);
			mysql_query($sql, $link) or die(mysql_error());
		}
		unset($_SESSION['user_accounts_add']);
		*/
}
	
	//口座一覧への追加
if ($key == "add_accounts") {
	$stmt = $pdo->prepare('INSERT INTO accounts SET name=:name, kana=:kana, account_classification_id=:account_classification_id, created=NOW()');
	$stmt->bindValue(':name', $_SESSION['add_accounts']["accounts_name"], PDO::PARAM_STR);
	$stmt->bindValue(':kana', $_SESSION['add_accounts']["accounts_kana"], PDO::PARAM_STR);
	$stmt->bindValue(':account_classification_id', $_SESSION['add_accounts']["account_classification_id"], PDO::PARAM_INT);
	$stmt->execute();
	/*
	$sql = sprintf('INSERT INTO accounts SET name="%s", kana="%s", account_classification_id=%d, created=NOW()', 
						mysql_real_escape_string($_SESSION['add_accounts']["accounts_name"]),
						mysql_real_escape_string($_SESSION['add_accounts']["accounts_kana"]),
						mysql_real_escape_string($_SESSION['add_accounts']["account_classification_id"])
	);
	unset($_SESSION['add_accounts']);
	mysql_query($sql, $link) or die(mysql_error());
	*/
	$_SESSION['add_accounts']=null;
	$_SESSION['success']='insert';
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
