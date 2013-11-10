<?php
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';

if (!empty($_POST)){
	//入力不足チェック
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
?>

<?php
    $sql =sprintf('SELECT transfer.*, a_er.name AS remitter_name, a_ee.name AS remittee_name
 				FROM transfer 
 					JOIN user_accounts AS u_er ON transfer.user_accounts_id_remitter=u_er.id 
 					JOIN accounts AS a_er ON u_er.account_id=a_er.id
					JOIN user_accounts AS u_ee ON transfer.user_accounts_id_remittee=u_ee.id 
 					JOIN accounts AS a_ee ON u_ee.account_id=a_ee.id
				WHERE transfer.user_id=%d 
 				ORDER BY DATE DESC',
    				$_SESSION['user_id']
	);
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {
		$transfer[] = $row;
	}
?>



<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダー -->
    <?php include 'include/head.html';?>
	
<body>
	<div id="head">
		<h1>口座移動一覧</h1>
	</div>

	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
	<!-- insert部 -->
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-xs-6">
              	<br><h2>口座移動情報入力フォーム</h2>
                	<div class="control-group">
                   	<form method = "POST" action = "" class = "form-inline well">
                    		<dl>
                    		<dt>金額</dt>
                       		<dd>
                       			<input type = "text" name = "amount" class="form-control" >
                       			<?php if ($error['amount']=='int'):?>
									<p class="error">* 数字（半角）を入力してください</p>
                    				<?php endif; ?>
                         		</dd>
                         		
                       	<dt>送り手</dt>
                        		<dd>
                        			<select  name="user_accounts_id_remitter" class="form-control" >
								<?php //選択肢にユーザーの口座情報を入れる user_accounts_id?>
                            		<?php require 'function/input_user_account_name.php'; ?>
								</select>
							</dd>
							
						<dt>受け手</dt>
                        		<dd>
                        			<select  name="user_accounts_id_remittee" class="form-control" >
								<?php //選択肢にユーザーの口座情報を入れる user_accounts_id?>
                            		<?php require  'function/input_user_account_name.php'; ?>
								</select>
							</dd>
							
						<dt>移動日</dt>
                   			<dd>
                   				<?php require_once 'function/form_date.php';?>	
                   			</dd>
                            	
                       	<dt>memo</dt>
                       		<dd>
                       			<input type = "text" name = "memo" class="form-control">
                       		</dd>
                       	</dl>
						<div class="center">
							<?php  //口座移動情報キー ?>
							<input type = "hidden" name = "key" value="transfer" >
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
								<td><?php print(htmlspecialchars($transfer[$i]['amount'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($transfer[$i]['remitter_name'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($transfer[$i]['remittee_name'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($transfer[$i]['date'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($transfer[$i]['memo'], ENT_QUOTES));?></td>
								<td class="center">
									<form method = "POST" action = "transfer_update.php" >
                 						<?php  //編集　id送信 ?>
										<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($transfer[$i]['id'], ENT_QUOTES));?> >
										<input type = "submit" value = "編集" class="btn btn-success btn-xs" >
                						</form>
           					 	</td>
            						<td class="center">   
                						<form method = "POST" action = "delete_action.php" >
                 						<?php  //削除　収入キー送信　id送信 ?>
										<input type = "hidden" name = "key" value="transfer" >
										<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($transfer[$i]['id'], ENT_QUOTES));?> >
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

