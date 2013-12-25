<?php 
session_start();
session_regenerate_id(TRUE);
//データベースへの接続 housebudget
require 'function/connect_pdo_db.php';
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
	$stmt = $pdo->prepare('UPDATE pay SET how_much=:h, what=:w, date=:d, user_accounts_id=:u_a_id, pay_specification_id=:p_s_id
							WHERE id=:id AND user_id=:user_id');
	$stmt->bindValue(':h', $_SESSION['pay']['how_much'], PDO::PARAM_INT);
	$stmt->bindValue(':w', $_SESSION['pay']['what'], PDO::PARAM_STR);
	$stmt->bindValue(':d', $_SESSION['pay']['date'], PDO::PARAM_STR);
	$stmt->bindValue(':u_a_id', $_SESSION['pay']['user_accounts_id'], PDO::PARAM_INT);
	$stmt->bindValue(':p_s_id', $_SESSION['pay']['pay_specification_id'], PDO::PARAM_INT);
	$stmt->bindValue(':id', $_SESSION['pay']['id'], PDO::PARAM_INT);
	$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
	$stmt->execute();
	$_SESSION['pay']=NULL;
	$_SESSION['success']='update';
	header('Location: pay_index.php');
}
//収入情報
if ($key == 'income') {
	//POST で送られてきた情報をincomeのカラム格納
	$stmt = $pdo->prepare('UPDATE income SET amount=:a, content=:c, date=:d, user_accounts_id=:u_a_id, income_specification_id=:i_s_id
				WHERE id=:id AND user_id=:user_id');
	$stmt->bindValue(':a', $_SESSION['income']['amount'], PDO::PARAM_INT);
	$stmt->bindValue(':c', $_SESSION['income']['content'], PDO::PARAM_STR);
	$stmt->bindValue(':d', $_SESSION['income']['date'], PDO::PARAM_STR);
	$stmt->bindValue(':u_a_id', $_SESSION['income']['user_accounts_id'], PDO::PARAM_INT);
	$stmt->bindValue(':i_s_id', $_SESSION['income']['income_specification_id'], PDO::PARAM_INT);
	$stmt->bindValue(':id', $_SESSION['income']['id'], PDO::PARAM_INT);
	$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
	$stmt->execute();
	$_SESSION['income']=NULL;
	$_SESSION['success']='update';
	header('Location: income_index.php');
}

//口座移動情報
if ($key == 'transfer') {
	//POST で送られてきた情報をtransferのカラム格納
	$stmt = $pdo->prepare('UPDATE transfer SET amount=:a, 
																		user_accounts_id_remitter=:remitter, 
																		user_accounts_id_remittee=:remittee, 
																		date=:d, 
																		memo=:m, 
								WHERE id=:id AND user_id=:user_id');
	$stmt->bindValue(':a', $_SESSION['transfer']['amount'], PDO::PARAM_INT);
	$stmt->bindValue(':remitter', $_SESSION['transfer']['user_accounts_id_remitter'], PDO::PARAM_INT);
	$stmt->bindValue(':remittee', $_SESSION['transfer']['user_accounts_id_remittee'], PDO::PARAM_INT);
	$stmt->bindValue(':d', $_SESSION['transfer']['date'], PDO::PARAM_STR);
	$stmt->bindValue(':m', $_SESSION['transfer']['memo'], PDO::PARAM_STR);
	$stmt->bindValue(':id', $_SESSION['transfer']['id'], PDO::PARAM_INT);
	$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
	$stmt->execute();
	$_SESSION['transfer']=NULL;
	$_SESSION['success']='update';
	header('Location: transfer_index.php');
}

//口座更新情報
if ($key == 'account_balance') {
	//POST で送られてきた情報をtransferのカラム格納
	for ($i = 0, $count=count($_SESSION['account_balance']['user_accounts_id']); $i < $count; $i++) {
		$stmt = $pdo->prepare('UPDATE user_accounts SET balance=:b, checked=cast(now() as datetime) WHERE id=:id AND user_id=:iser_id ');
		$stmt->bindValue(':b', $_SESSION['account_balance']['balance'][$i], PDO::PARAM_INT);
		$stmt->bindValue(':id', $_SESSION['account_balance']['user_accounts_id'], PDO::PARAM_INT);
		$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
	$stmt->execute();
	}
	$_SESSION['account_balance']=NULL;
	$_SESSION['success']='update';
	header('Location: account_index.php');
}


?>

<!DOCTYPE html>
<html lang=ja>
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
			if ($key==NULL){echo 'エラー キーがありません';}
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
