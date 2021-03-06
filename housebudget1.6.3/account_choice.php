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


//口座選択ボタン
if ($_POST['key']=="user_accounts_add"){
	//入力不足チェック
	if (!array_key_exists(0, $_POST['account_id'])){
		$error['account_id']='empty';
	}
	//エラーがなければ次へ
	if (empty($error)){
		$_SESSION['user_accounts_add'] = $_POST;
		$_SESSION['key'] = $_POST['key'];
		header('Location: insert_action.php');
	}
}


if (!empty($_SESSION['success'])) {
	$success=$_SESSION['success'];
	unset($_SESSION['success']);
}


//登録口座追加ボタン
if ($_POST['key']=="add_accounts") {
	if (!isset($_POST['accounts_name'])) {
		$error['accounts_name']='empty';
	}
	if (!isset($_POST["accounts_kana"])) {
		$error['accounts_name']='empty';
	}
	mb_regex_encoding("UTF-8");
	if (!mb_ereg("^[ぁ-ん]+$",$_POST["accounts_kana"])) {
		$error["accounts_kana"]="no_kana";
	}
	$stmt= $pdo->prepare('SELECT COUNT(*) AS cnt FROM accounts WHERE kana=:kana OR name=:name');
	$stmt->bindValue(':kana', mysql_real_escape_string($_POST["accounts_kana"]), PDO::PARAM_STR);
	$stmt->bindValue(':name', mysql_real_escape_string($_POST["accounts_name"]), PDO::PARAM_STR);
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	$table=$row;
	/*
	$sql=sprintf('SELECT COUNT(*) AS cnt FROM accounts 	WHERE kana="%s" OR name="%s" ',
					mysql_real_escape_string($_POST["accounts_kana"]),
					mysql_real_escape_string($_POST["accounts_name"])
		);
	$result=mysql_query($sql) or die(mysql_error());
	$table= mysql_fetch_assoc($result);
	*/
	if ($table['cnt']>0) {
		$error['add_accounts']='duplicate';
	}

	if (empty($error)){
		$_SESSION['add_accounts']=$_POST;
		$_SESSION['key']=$_POST['key'];
		header('Location: insert_action.php');
	} else {
		$rewrite['accounts_name']=$_POST['accounts_name'];
		$rewrite['accounts_kana']=$_POST['accounts_kana'];
		$rewrite['account_classification_id']=$_POST['account_classification_id'];
	}
	unset($_POST);
}
//使用中の口座情報
$stmt= $pdo->prepare('SELECT a.name,a.account_classification_id, u.*  FROM user_accounts u 
			JOIN accounts a ON u.account_id=a.id 
               	WHERE u.user_id=:user_id');
$stmt->bindValue(':user_id', mysql_real_escape_string($_SESSION['user_id']), PDO::PARAM_INT);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$using_accounts[] = $row;
}
/*
$sql = sprintf('SELECT a.name,a.account_classification_id, u.*  FROM user_accounts u 
			JOIN accounts a ON u.account_id=a.id 
               	WHERE u.user_id=%d',
		mysql_real_escape_string($_SESSION['user_id'])
);
$result = mysql_query($sql, $link);
while ($row = mysql_fetch_assoc($result)) {
	$using_accounts[] = $row;
}
*/
//口座情報取得
$stmt=$pdo->query('SELECT * FROM accounts');
while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
	$accounts[] = $row;
}
/*
$sql = sprintf('SELECT *  FROM accounts');
$result = mysql_query($sql, $link);
while ($row = mysql_fetch_assoc($result)) {
	$accounts[] = $row;
}
*/
//使用していない口座を抽出
for ($i= 0, $count_accounts=count($accounts);  $i < $count_accounts; $i++){
	$using=false;
	for ($j= 0, $count_using_accounts=count($using_accounts);  $j < $count_using_accounts; $j++){ //使用中のものとかぶっていないか
		if ($accounts[$i]['id']==$using_accounts[$j]['account_id']){
			$using=true;
			break;
		};
	};
	if ($using==false) {
		$not_using_accounts[]=$accounts[$i];
	}
	$using=false;
};

//口座種別取得
$stmt=$pdo->query('SELECT * FROM account_classifications');
while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
	$account_classifications[] = $row;
}
/*
$sql = sprintf('SELECT *  FROM account_classifications');
$result = mysql_query($sql, $link);
while ($row = mysql_fetch_assoc($result)) {
	$account_classifications[] = $row;
}
*/
?>

<?php //エラー表示?>
<?php include 'library/alert.php';?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

<body>
	<div id="head">
		<h1>口座選択</h1>
	</div>

	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
 
	<?php //使用中の口座一覧?>
	<div class="container">
		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<?php alert_success($success);?>
			</div>
		</div>
		<div class="row"> 		
			<div class="col-md-offset-1 col-md-4">
				<div class = "center">
					<br><br><h2>使用中の口座</h2>
           			<?php if ($_POST['can_delete']=="true"):	?>										<?php //削除アクション有効?>
           				<div class="alert alert-warning alert-dismissable">
							<button type = "button" class="close" data-dismiss="alert" aria-hidden="true" >&times;</button>
							<strong >口座情報を削除すると関連する収入支出情報も削除されます</strong>
						</div>
						<form action="delete_action.php" method="post" class = "form-horizontal well">	<!-- ### -->	           		
					<?php else:?>
						<form action="" method="post" class = "form-horizontal well">								<!-- ### -->				<?php //削除アクション無効?>
					<?php endif;?>
             		
             		<?php for ($i = 0, $count_a_c=count($account_classifications);$i< $count_a_c; $i++):?>
             			<br><h2><?php echo h($account_classifications[$i]['name']);?></h2>
             			<table class="table table-hover table-bordered table-condensed">
							<thead>
								<tr>
								<?php if ($_POST['can_delete']=="true"):?>
									<th scope="col">削除</th>
								<?php endif;?>	<?php //削除アクション有効?>
									<th scope="col">口座名</th>
									<th scope="col">金額</th>
								</tr>
							</thead>
							
							<?php for ($j = 0, $count_using_accounts=count($using_accounts);  $j < $count_using_accounts; $j++): ?>
							<?php if ($using_accounts[$j]['account_classification_id']==$account_classifications[$i]['id']):  //種別が一致しているか?>
							<tbody>
								<tr>
								<?php if ($_POST['can_delete']=="true"):?>
									<td class="center"><input type="radio" name="id" value="<?php echo h($using_accounts[$j]['id']); ?>"/></td>	<?php //削除アクション有効?>
								<?php endif;?>
									<td><?php print (h($using_accounts[$j]['name']));?></td> 	
									<td>	<?php print (h($using_accounts[$j]['balance']));?></td>
								</tr>
							</tbody>
							<?php endif;?>
							<?php endfor;?>
						</table>
					<?php endfor;?>
					<div class="row">
						<div class="center">
							<?php if ($_POST['can_delete']=="true"):?>
								<input type="hidden" name="key" value="user_accounts"/>
								<input type="submit" value="削除" class="btn btn-danger"/>
							<?php else:?>
								<input type="hidden" name="can_delete" value="true"/>
								<input type="submit" value="削除を有効にする" class="btn btn-danger"/>
							<?php endif;?>
						</div>
					</div>
					</form>
				</div>
			</div>
	
	<?php //===========================================================?>
	
	<?php //使用してない口座一覧?>
			<div class="col-md-offset-2 col-md-4">
				<div class = "center">
					<br><br><h2>登録されている口座から選択</h2>
           			<form method= "post" action= "" name ="user" class = "form-horizontal well">
             			<?php if ($error['account_id']=='empty'):?>
								<div class="alert alert-warning">
									<p class="error">* 使用する口座名にチェックを入れてください</p>
                    				</div>	
                    		<?php endif; ?>
             			<?php for ($i = 0, $count_a_c=count($account_classifications);$i< $count_a_c; $i++):?>
             			<br><h2><?php echo $account_classifications[$i]['name']?></h2>
             			<table class="table table-hover table-bordered table-condensed" >
							<thead>
								<tr >
									<th scope="col" class="text-center">使用</th>
									<th scope="col">口座名</th>
								</tr>
							</thead>
							
							<?php for ($j = 0, $count_not_using_accounts=count($not_using_accounts);  $j < $count_not_using_accounts; $j++): ?>
							<?php if ($not_using_accounts[$j]['account_classification_id']==$account_classifications[$i]['id']):?>
							<tbody>
								<tr>
									<td class="center"><input type="checkbox" name="account_id[]" value="<?php echo h($not_using_accounts[$j]['id']);?> " /></td>
									<td><?php print (h($not_using_accounts[$j]['name']));?></td>
								</tr>
							</tbody>
							<?php endif;?>
							<?php endfor;?>
						</table>
						<div class="row">
							<div class="center">
								<input type="hidden" name="key" value="user_accounts_add" />
								<input type="submit" value="選択" class="btn btn-primary "/>
							</div>
						</div>
						<?php endfor;?>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<?php //===========================================================?>
	<?php //口座追加?>
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
				<div class = "center">
					<br><h2>上記にない口座を登録</h2>
					<form action="" method="post" name="add_accounts" class = "form-horizontal well">
						<?php alert_warning($error['add_accounts']); ?>		
						<label>口座種別</label>
							<select name="account_classification_id" class="form-control" >
                           	 <?php require 'include/php/input_account_classifications.php'; ?>
							</select>
						
						<label>名称</label>
							<input type="text" name="accounts_name" class="form-control" value="<?php echo (h($rewrite['accounts_name'])); ?>"/>
							<?php alert_warning($error['accounts_name']); ?>		
						
						<label>かな(全角ひらがな)</label>
							<?php alert_warning($error['accounts_kana']); ?>
						<input type="text" name="accounts_kana" class="form-control" value="<?php echo(h($rewrite['accounts_kana'])); ?>" />
						
						<input type="hidden" name="key" value="add_accounts">
						<input type="submit" value="追加" class="btn btn-success"/>
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
