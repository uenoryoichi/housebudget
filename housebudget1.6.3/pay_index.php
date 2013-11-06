<?php
session_start();

//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
?>

<?php //支払情報をDBから取得
    $sql = sprintf('SELECT pay.*, DATE(pay.date) AS date_ymd,accounts.name 
 				FROM pay 
 					JOIN user_accounts ON pay.user_accounts_id=user_accounts.id 
 					JOIN accounts ON user_accounts.account_id=accounts.id 
 				WHERE pay.user_id=%d 
 				ORDER BY DATE DESC',
    				$_SESSION['user_id']
	);
	$result = mysql_query($sql, $link);

	while ($row = mysql_fetch_assoc($result)) {
		$pay[] = $row;
	}
	
?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

	<!-- 本文　ここから -->	
<body>
    <!-- 見出し ここから　-->
	<div id="head">
		<h1>支出一覧</h1>
	</div>
	
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
	<!-- insert部ここから -->

	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-xs-6">
           		<br><h2>支出情報入力フォーム</h2>
          		<form method = "POST" action = "insert_action.php" class = "form-horizontal well">
                     		
                 	<label>金額</label>
                    	<input type = "text" name = "how_much" class="form-control" >
                        	
                     	<label>内容</label>
                     	<input type = "text" name = "what" class="form-control" >
						
					<label>日付</label>
					<?php $today = date("Y-m-d");?>
                     	<input type = "text" name = "date" class="form-control"  value=<?php echo $today?>>
                         
                    	<label>支払い</label>
                    	<select  name="user_accounts_id" id="user_accounts_id" class="form-control"  >
						<?php //選択肢にユーザーの口座情報を入れる?>
                         	<?php require 'function/input_user_account_name.php'; ?>
					</select>
                         	
                     	<label>分類</label>
                     	<select  name="type" id="type" class="form-control" >
						<?php 
							$bunrui_array = array("交通費","食費","消耗品","交際費","HUCC","研究室","その他");
							for ($i=0; $i<count($bunrui_array); $i++){
								print('<option value="'.$bunrui_array[$i].'">'.$bunrui_array[$i].'</option>');
							}
						?>
					</select>
                         	
                     	<?php  //支出情報キー ?>
					<input type = "hidden" name = "key" value="pay" >
						
					<div class="form-group">	
						<div class="center">
							<input type = "submit" value = "送信" class="btn btn-primary">
                     		</div>
                     	</div>
                	</form>
            	</div>
        	</div>
     </div>
  	

     <!-- insert部ここまで -->
     
	<div class = "center">
		<a href="index.php">Back To TOP</a>
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
								<th scope="col">値段</th>
								<th scope="col">支払内容</th>
								<th scope="col">支払口座</th>
								<th scope="col">種別</th>
								<th scope="col">編集</th>
								<th scope="col">削除</th>
							</tr>
						</thead>

						<?php for ($i = 0; $i < count($pay); $i++): ?>
						<tbody>					
							<tr>
								<td><?php print(htmlspecialchars($pay[$i]['date_ymd'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($pay[$i]['how_much'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($pay[$i]['what'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($pay[$i]['name'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($pay[$i]['type'], ENT_QUOTES));?></td>
								<td>
									<form method = "POST" action = "pay_update.php" >
                 					<?php  //編集　id送信 ?>
										<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($pay[$i]['id'], ENT_QUOTES));?> >
										<input type = "submit" value = "編集" class="btn btn-primary" >
                						</form>
 	           					</td>
    	        						<td>   
    	         				  		<form method = "POST" action = "delete_action.php" >
	    	     					        	<?php  //削除　収入キー送信　id送信 ?>
										<input type = "hidden" name = "key" value="pay" >
										<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($pay[$i]['id'], ENT_QUOTES));?> >
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

