<?php
session_start();
session_regenerate_id(TRUE);
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//関数設定
require 'library_all.php';


if (!empty($_POST)){
	//金額<-数字チェック
	if (!is_numeric($_POST['amount'] )){
		$error['amount']='int';
	}
	//エラーがなければ次へ
	if (empty($error)){
		$_SESSION['transfer'] = $_POST;
		$_SESSION['key'] = $_POST['key'];
		header('Location: insert_action.php');
	}
}


if (!empty($_SESSION['success'])) {
	$success=$_SESSION['success'];
	unset($_SESSION['success']);
}


    $sql =sprintf('SELECT transfer.*, a_er.name AS remitter_name, a_ee.name AS remittee_name
 				FROM transfer 
 					JOIN user_accounts AS u_er ON transfer.user_accounts_id_remitter=u_er.id 
 					JOIN accounts AS a_er ON u_er.account_id=a_er.id
					JOIN user_accounts AS u_ee ON transfer.user_accounts_id_remittee=u_ee.id 
 					JOIN accounts AS a_ee ON u_ee.account_id=a_ee.id
				WHERE transfer.user_id=%d 
 				ORDER BY DATE DESC',
    				mysql_real_escape_string($_SESSION['user_id'])
	);
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {
		$transfer[] = $row;
	}
?>

<?php //エラー表示?>
<?php include 'library/alert.php';?>

<!DOCTYPE html>
<html lang=ja>
    <?php include 'include/head.html';?>
	
<body>
	<div id="head">
		<h1>口座移動一覧</h1>
	</div>
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-xs-6">
				<?php alert_success($success);?>
              	<br><h2>口座移動情報入力フォーム</h2>
                	<div class="control-group">
                   	<form method = "POST" action = "" class = "form-inline well">
                    		<dl>
                    		<dt>金額</dt>
                       		<dd>
                       			<input type = "text" name = "amount" class="form-control" >
                       			<?php alert_warning($error['amount']);?>
                         		</dd>
                         		
                       	<dt>送り手</dt>
                        		<dd>
                        			<select  name="user_accounts_id_remitter" class="form-control" >
                            		<?php include 'include/php/input_user_account_name.php'; ?>
								</select>
							</dd>
							
						<dt>受け手</dt>
                        		<dd>
                        			<select  name="user_accounts_id_remittee" class="form-control" >
                            		<?php include 'include/php/input_user_account_name.php'; ?>
								</select>
							</dd>
						 
						 <dt>メモ</dt>
                       		<dd>
                       			<input type = "text" name = "memo" class="form-control">
                       		</dd>
                       	</dl>
                       		
						<dt>移動日</dt>
                   			<dd>
                   				<?php require_once 'include/php/form_date.php';?>	
                   			</dd>
                      
						<div class="center">
							<?php  //口座移動情報キー ?>
							<input type="hidden" name="key" value="transfer" >
							<input type = "submit" value = "送信" class="btn btn-primary">
						</div>
                 	</form>
              	</div>
           	</div>
       	</div>
  	</div>
    
   	<!-- 一覧部ここから -->   
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-1 col-xs-10">
				<div class = "center">
					<h2>口座移動情報</h2>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th scope="col">金額</th>
								<th scope="col">送り手➡➡➡</th>
								<th scope="col">　　　受け手</th>
								<th scope="col">移動日</th>
								<th scope="col">メモ</th>
								<th scope="col"></th>
								<th scope="col"></th>
							</tr>
						</thead>
						<?php for ($i = 0, $count_transfer=count($transfer); $i < $count_transfer; $i++): ?>
						<tbody>
							<tr>
								<td><?php print(h($transfer[$i]['amount']));?></td>
								<td><?php print(h($transfer[$i]['remitter_name']));?></td>
								<td><?php print(h($transfer[$i]['remittee_name']));?></td>
								<td><?php print(h($transfer[$i]['date']));?></td>
								<td><?php print(h($transfer[$i]['memo']));?></td>
								<td class="center">
									<form method = "POST" action = "transfer_update.php" >
                 						<?php  //編集　id送信 ?>
										<input type = "hidden" name = "id" value=<?php print(h($transfer[$i]['id']));?> >
										<input type = "submit" value = "編集" class="btn btn-success btn-xs" >
                						</form>
           					 	</td>
            						<td class="center">   
                						<form method = "POST" action = "delete_action.php" >
                 						<?php  //削除　収入キー送信　id送信 ?>
										<input type = "hidden" name = "key" value="transfer" >
										<input type = "hidden" name = "id" value=<?php print(h($transfer[$i]['id']));?> >
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

	<!-- フッター -->
	<?php include 'include/footer.html';?>
	
</body>
</html>

