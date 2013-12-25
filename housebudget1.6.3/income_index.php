<?
session_start();
//データベースへの接続 housebudget
require 'function/connect_pdo_db.php';
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//関数設定
require 'library_all.php';


if (!empty($_POST)){
	//入力不足チェック
	if (!is_numeric($_POST['amount'])){
		$error['amount']='int';
	}
	//エラーがなければ次へ
	if (empty($error)){
		$_SESSION['income'] = $_POST;
		$_SESSION['key'] = $_POST['key'];
		header('Location: insert_action.php');
	}
}

if (!empty($_SESSION['success'])) {
	$success=$_SESSION['success'];
	$_SESSION['success']=NULL;
}

$stmt = $pdo->prepare('SELECT income.*, accounts.name AS accounts_name, income_specifications.name AS income_specification_name, DATE(income.date) AS date_ymd
 				FROM income 
 					JOIN user_accounts ON income.user_accounts_id=user_accounts.id 
 					JOIN accounts ON user_accounts.account_id=accounts.id
					JOIN income_specifications ON income.income_specification_id=income_specifications.id
 				WHERE income.user_id=:user_id 
 				ORDER BY income.date DESC');
$stmt->bindValue(':user_id', mysql_real_escape_string($_SESSION['user_id']), PDO::PARAM_INT);
$stmt->execute();
while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
	$income[]=$row;
}
/*
$sql = sprintf('SELECT income.*, accounts.name AS accounts_name, income_specifications.name AS income_specification_name, DATE(income.date) AS date_ymd
 				FROM income 
 					JOIN user_accounts ON income.user_accounts_id=user_accounts.id 
 					JOIN accounts ON user_accounts.account_id=accounts.id
					JOIN income_specifications ON income.income_specification_id=income_specifications.id
 				WHERE income.user_id=%d 
 				ORDER BY income.date DESC',
    				mysql_real_escape_string($_SESSION['user_id'])
);
$result = mysql_query($sql, $link) or die(mysql_error());
while ($row = mysql_fetch_assoc($result)) {
	$income[] = $row;
}
*/
?>


<?php //エラー表示?>
<?php include 'library/alert.php';?>

<!DOCTYPE html>
<html lang=ja>
    <?php include 'include/head.html';?>

<body>
	<div id="head">
		<h1>収入一覧</h1>
	</div>

	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
				<?php alert_success($success);?>
           		<br><h2>収入情報入力フォーム</h2>
          		<form method = "POST" action = "" class = "form-inline well">
	             	<dl>
	             	<dt>金額</dt>
	             		<dd>
	             			<input type = "text" name = "amount" class="form-control" >
	             			<?php alert_warning($error['amount']); ?>
	             		</dd>
	             		
	          		<dt>口座名</dt>
                    		<dd>
                    			<select  name="user_accounts_id" class="form-control" >
                    				<?php include_once 'include/php/input_user_account_name.php'; ?>
							</select>
                    		</dd>
                    		
	             	<dt>分類</dt>
                   		<dd>
                   		<select name="income_specification_id" class="form-control">
                   		<?php include_once  'include/php/form_income_specifications.php';?>	
                   		</select>
                   		</dd>
		      	
                   	<dt>メモ</dt>
                   		<dd>
                   			<input type = "text" name = "content" class="form-control" >
                   		</dd>
                   			
					<dt>日付</dt>
                   		<dd>
                   		<?php require_once 'include/php/form_date.php';?>	
                   		</dd>
                   	
               
             		</dl>
                    	<?php  //収入情報キー ?>
                    	<div class="center">
						<input type = "hidden" name = "key" value="income" >
						<input type = "submit" value="送信" class="btn btn-primary">
            			</div>
            		</form>
           	</div>
      	</div>
   	</div>
    
	<!-- 一覧部ここから -->   
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-1 col-xs-10">
				<div class = "center">
					<h2>収入情報</h2>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th scope="col">日付</th>
								<th scope="col">金額</th>
								<th scope="col">分類</th>
								<th scope="col">口座名</th>
								<th scope="col">メモ</th>
								<th scope="col"></th>
								<th scope="col"></th>
							</tr>
						</thead>
						<?php for ($i = 0, $count_income=count($income); $i < $count_income; $i++): ?>
						<tbody>
							<tr>
								<td><?php print(h($income[$i]['date_ymd']));?></td>
								<td><?php print(h($income[$i]['amount']));?></td>
								<td><?php print(h($income[$i]['income_specification_name']));?></td>
							  	<td><?php print(h($income[$i]['accounts_name']));?></td>
								<td><?php print(h($income[$i]['content']));?></td>
								<td class="center">
									<form method = "POST" action = "income_update.php" >
                 						<?php  //編集　id送信 ?>
										<input type = "hidden" name = "id" value=<?php print(h($income[$i]['id']));?> >
										<input type = "submit" value = "編集" class="btn btn-success btn-xs" >
                						</form>
            						</td>
            						<td class="center">   
                						<form method = "POST" action = "delete_action.php" >
                 						<?php  //削除　収入キー送信　id送信 ?>
										<input type = "hidden" name = "key" value="income" >
										<input type = "hidden" name = "id" value=<?php print(h($income[$i]['id']));?> >
										<input type = "submit" value = "削除" class="btn btn-danger btn-xs" onclick="return confirm('削除してよろしいですか');">
                						</form>
								</td>
							</tr>
						</tbody>
						<?php endfor;?>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class = "center">
		<a href="index.php">Back To TOP</a>
	</div>

	<!--一覧表示部終わり-->
	
	<!-- フッター -->
	<?php include 'include/footer.html';?>

</body>
</html>

