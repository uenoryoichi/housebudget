<?php
session_start();
//データベースへの接続 housebudget
require 'function/connect_pdo_db.php';
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//関数取得
require 'library_all.php';
//口座の現在残高取得
require 'include/php/calculate_account_balance.php';


if (!empty($_POST['key'])){
	//金額<-数字チェック
	for ($i = 0, $count=count($_POST['balance']); $i < $count; $i++)
	if (!is_numeric($_POST['balance'][$i] )){
		$error['balance']='int';
	}
	//エラーがなければ次へ
	if (empty($error)){
		$_SESSION['account_balance'] = $_POST;
		$_SESSION['key'] = $_POST['key'];
		header('Location: update_action.php');
	}
}

if (!empty($_SESSION['success'])) {
	$success=$_SESSION['success'];
	unset($_SESSION['success']);
}

?>
<?php //エラー表示?>
<?php include 'library/alert.php';?>


<!DOCTYPE html>
<html lang=ja>
    <?php include 'include/head.html';?>

<body>
	<div id="head">
		<h1>口座情報更新</h1>
	</div>
	
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
				<?php alert_success($success);?>
				<div class = "center">
					<br>
					<h2>口座残高情報更新</h2>
           			<form method="POST" action='' class="form-horizontal well">
	           			<?php alert_warning($error['balance']); ?>
	           			<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th scope="col">口座名</th>
									<th scope="col">金額</th>
								</tr>
							</thead>
							<?php for ($i = 0, $count_accounts=count($account); $i < $count_accounts;  $i++): ?>
							<tbody>
								<tr>
									<td><?php print(h($account[$i]['name']));?></td>
									<td>
										<input type = "hidden" name = "user_accounts_id[]"  value="<?php print (h($account[$i]['id']));?>"/>
										<input type = "text" name = "balance[]" class="form-control input-sm text-right" value="<?php print (h($account[$i]['balance']));?>"/>
									</td>
								</tr>
							</tbody>
							<?php endfor;?>
						</table>
						<input type="hidden" name="key" value="account_balance"/>
             			<input type="submit" value="更新" class="btn btn-primary"/>	
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="center">
		<a href="index.php">Back To TOP</a>
	</div>
		
	<?php include 'include/footer.html';?>
	
</body>
</html>

