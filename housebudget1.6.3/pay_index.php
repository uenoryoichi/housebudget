<?php
session_start();

//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//関数設定
require 'library_all.php';

if (!empty($_POST)){
	//入力不足チェック
	if (empty($_POST['how_much'] )){
		$error['how_much']='empty';
	}
	elseif (!is_numeric($_POST['how_much'] )){
		$error['how_much']='int';
	}
	
	//エラーがなければ次へ
	if (empty($error)){
		$_SESSION['pay'] = $_POST;
		$_SESSION['key'] = $_POST['key'];
		header('Location: insert_action.php');
	}
}

$sql = sprintf('SELECT pay.*, DATE(pay.date) AS date_ymd ,accounts.name AS account_name, pay_specifications.name AS pay_specification_name
 				FROM pay 
 					JOIN user_accounts ON pay.user_accounts_id=user_accounts.id 
 					JOIN accounts ON user_accounts.account_id=accounts.id 
					JOIN pay_specifications ON pay.pay_specification_id=pay_specifications.id
 				WHERE pay.user_id=%d 
 				ORDER BY pay.date DESC',
    				mysql_real_escape_string($_SESSION['user_id'])
);
$result = mysql_query($sql, $link);
while ($row = mysql_fetch_assoc($result)) {
	$pay[] = $row;
}
?>

<?php //エラー表示?>
<?php include 'library/alert.php';?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

<body>


	<div id="head">
		<h1>支出一覧</h1>
	</div>
	
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
	<!-- insert部 -->
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-xs-6">
           		<br><h2>支出情報入力フォーム</h2>
          		<form method = "POST" action = "" class = "form-inline well">
                     	<dl>
                 	<dt>金額</dt>
                    		<dd>
                    			<input type = "text" name = "how_much" class="form-control" >
                    			<?php alert_warning($error['how_much'])?>
                    			</dd>
                    	  	
                    	<dt>口座名</dt>
                    		<dd>
                    			<select  name="user_accounts_id"  class="form-control"  >
								<?php //選択肢にユーザーの口座情報を入れる?>
                     		    		<?php require 'include/php/input_user_account_name.php'; ?>
							</select>
                         	</dd>
                         	
                    	  <dt>分類</dt>
                     		<dd>
                     			<select  name="pay_specification_id"class="form-control" >
							<?php  require_once 'include/php/form_pay_specifications.php';?>
							</select>
                         	</dd>    	
                         	
                     	<dt>メモ</dt>
                     		<dd>
                     			<input type = "text" name = "what" class="form-control" >
						</dd>
						
					<dt>日付</dt>
                   		<dd>
                   		<?php require_once 'include/php/form_date.php';?>	
                   		</dd>
                         	
                    	</dl>
					<div class="center">
							<?php  //支出情報キー ?>
							<input type = "hidden" name = "key" value="pay" >
							<input type = "submit" value = "送信" class="btn btn-primary">
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
					<h2>支出情報</h2>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th scope="col">日付</th>
								<th scope="col">金額</th>
								<th scope="col">口座名</th>
								<th scope="col">分類</th>
								<th scope="col">メモ</th>
								<th scope="col"></th>
								<th scope="col"></th>
							</tr>
						</thead>

						<?php for ($i = 0; $i < count($pay); $i++): ?>
						<tbody>					
							<tr>
								<td><?php print(h($pay[$i]['date_ymd']));?></td>
								<td><?php print(h($pay[$i]['how_much']));?></td>
								<td><?php print(h($pay[$i]['account_name']));?></td>
								<td><?php print(h($pay[$i]['pay_specification_name']));?></td>
								<td><?php print(h($pay[$i]['what']));?></td>
								<td class="center">
									<form method = "POST" action = "pay_update.php" >
                 					<?php  //編集　id送信 ?>
										<input type = "hidden" name = "id" value=<?php print(h($pay[$i]['id']));?> >
										<input type = "submit" value = "編集" class="btn btn-success btn-xs" >
                						</form>
 	           					</td>
    	        						<td class="center">
									<form method = "POST" action = "delete_action.php" >
	    	     					        	<?php  //削除　収入キー送信　id送信 ?>
										<input type = "hidden" name = "key" value="pay" >
										<input type = "hidden" name = "id" value=<?php print(h($pay[$i]['id']));?> >
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

