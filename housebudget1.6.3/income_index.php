<?
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
?>

<?php
    $sql = sprintf('SELECT income.*, accounts.name 
 				FROM income 
 					JOIN user_accounts ON income.user_accounts_id=user_accounts.id 
 					JOIN accounts ON user_accounts.account_id=accounts.id 
 				WHERE income.user_id=%d 
 				ORDER BY DATE DESC',
    				$_SESSION['user_id']
	);
	$result = mysql_query($sql, $link) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$income[] = $row;
	}
?>


<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

<body>

    <!-- 見出し ここから　-->
	<div id="head">
		<h1>収入一覧</h1>
	</div>

	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
   	<!-- insert部ここから -->
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
           		<br><h2>収入情報入力フォーム</h2>
          		<form method = "POST" action = "insert_action.php" class = "form-horizontal well">
	                 
	                 <label>金額</label>
                     	<input type = "text" name = "amount" class="form-control" >
                   	
                   	<label>内容</label>
             		<input type = "text" name = "content" class="form-control" placeholder= "">
							
					<label>日付</label>
                   	<input type = "text" name = "date" class="form-control" value=<?php echo date("Y-m-d H:i:s");?>>
                   	
                   	<label>口座名</label>
                    	<select  name="user_accounts_id" id="user_accounts_id" class="form-control" >
                   		<?php //選択肢にユーザーの口座情報を入れる?>
                    		<?php require 'function/input_user_account_name.php'; ?>
					</select>
                    	
                    	<?php  //収入情報キー ?>
                    	<div class="center">
						<input type = "hidden" name = "key" value="income" >
						<input type = "submit" value = "送信" class="btn btn-primary">
            			</div>
            		</form>
           	</div>
      	</div>
   	</div>
    <!-- insert部ここまで -->
       	
	<div class = "center">
		<a href="index.php">Back To TOP </a>
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
								<th scope="col">金額</th>
								<th scope="col">内容</th>
								<th scope="col">日付</th>
								<th scope="col">口座名</th>
								<th scope="col">編集</th>
								<th scope="col">削除</th>
							</tr>
						</thead>
						<?php for ($i = 0, $count_income=count($income); $i < $count_income; $i++): ?>
						<tbody>
							<tr>
								<td><?php print(htmlspecialchars($income[$i]['amount'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($income[$i]['content'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($income[$i]['date'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($income[$i]['name'], ENT_QUOTES));?></td>
								<td>
									<form method = "POST" action = "income_update.php" >
                 						<?php  //編集　id送信 ?>
										<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($income[$i]['id'], ENT_QUOTES));?> >
										<input type = "submit" value = "編集" class="btn btn-primary" >
                						</form>
            						</td>
            						<td>   
                						<form method = "POST" action = "delete_action.php" >
                 						<?php  //削除　収入キー送信　id送信 ?>
										<input type = "hidden" name = "key" value="income" >
										<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($income[$i]['id'], ENT_QUOTES));?> >
										<input type = "submit" value = "削除" class="btn btn-primary" onclick="return confirm('削除してよろしいですか');">
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

